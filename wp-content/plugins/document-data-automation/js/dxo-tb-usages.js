jQuery(function($) {
	//test on focus
	// Set global counter variable to verify event instances
	var nCounter = 0;

	// Set up event handler to produce text for the window focus event
	window.addEventListener("focus", function(event) 
	{ 
		//console.log('Focus: ' + nCounter);
		nCounter = nCounter + 1; 
	}, false);
    //This JS controls thickbox interactivity
    $(document).ready(function(){
		//clearDataFilters();
		$('button#dxo_saas').click(function(){
			//we add a class to the body in order to manage the styles of
			//the thickbox popup without messing up with other plugin or themes
			$('body').addClass('DXO');
			//tb_show(trans_DXO.selectTemplate, DXO.remoteLogin);
		});

        var name = $(this).attr('data-name');
        //manage global template actions

        $('#noTemplate').hide();
        $('#yesTemplate').show();
        $('#filterDataTemplateValue').text(name);


        //Build the URL to request data for that template
        var baseURL = DXO.usages;

        JSONPCall(baseURL, 'parseUsageData');
        loader('dataLoaderDXO');

		/*
		 * Fin gus
		 */
	});
	
	var methods = {
	  parseLastUsages: function(data) {
		parseLastUsages(data);
	  },
	  parseTemplateList: function(data) {
		parseTemplateList(data);
	  },
	  parseUsageData: function(data) {
		parseUsageData(data);
	  },
	  parseLastUsedTemplates: function(data) {
		parseLastUsedTemplates(data);
	  },
	  parseLatestTemplates: function(data) {
		parseLatestTemplates(data);
	  }
	}
	
	window.addEventListener("message", DXOMessage, false);

	function DXOMessage(event){
		//here we shoud make sure that the message comes from the docxpresso instance
		if (event.origin !== DXO.installation){
			return;
		}
		if (typeof event.data == 'string'){
			var sentData = JSON.parse(event.data);
			//console.log(sentData);
			if (sentData.type == 'logout'){
				LogOutDXO();
			} else if (sentData.type == 'refreshToken'){
				//refresh the tokens so we can log in again
				//console.log("Remote login, aqui no hace falta");
			} else if (sentData.type == 'selectTemplate') {
				//console.log("Creo que esto no se utiliza");
				DXO.selectTemplate = sentData.accessByToken.replace('&amp;', '&') + '&TB_iframe=true';
				//console.log(DXO.selectTemplate);
				var id = sentData.id;
				var name = sentData.name;
				//manage global template actions
				DXO.templateSelected = id;
				$('#noTemplate').hide();
				$('#yesTemplate').show();
				$('#filterDataTemplateValue').text(name);
				//clean data filters on click
				//clearDataFilters();
				$('#tab_2').click();
				//Build the URL to request data for that template
				var baseURL = DXO.installation + '/RESTservices/predefined/get_usage_data_paginated/1?options=';
				var opts = btoa('{}');
				var url = baseURL + opts;
				JSONPCall(url, 'parseUsageData');
				loader('dataLoaderDXO');
				//close the popup
				$("#TB_overlay").remove();
				$("#TB_window").remove();
				$("body").removeClass('modal-open');
			} else if (sentData.type == 'shortcode') {
				//do all the shortcode stuff here
				//close the popup
				$("#TB_overlay").remove();
				$("#TB_window").remove();
				$("body").removeClass('modal-open');
			} else if (sentData.type == 'editResponse') {
				var oldToken = sentData.oldToken;
				var newToken = sentData.newToken;
				var identifier = sentData.identifier;
				var reference = sentData.reference;
				var usageId = sentData.usageId;
				var percentage = sentData.percentage;
				var timestamp = sentData.timestamp;
				var usedate = new Date(timestamp * 1000);
				var dateOptions = { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
				var mydate = usedate.toLocaleDateString(navigator.language, dateOptions);
				//redefine the corresponding data row
				var myrow = $('table.widefat button.editDoc[data-token="' + oldToken + '"]').parents('tr:first');
				//$(myrow).find('td.rowUsageID').text(usageId);
				$(myrow).find('td.rowIdentifier').text(identifier);
				$(myrow).find('td.rowReference').text(reference);
				$(myrow).find('td.rowDate').text(mydate);
				$(myrow).find('button.downloadDoc').attr('data-token', newToken).attr('data-id', usageId);
				$(myrow).find('button.infoDoc').attr('data-token', newToken).attr('data-id', usageId);
				$(myrow).find('button.editDoc').attr('data-token', newToken).attr('data-id', usageId);
				$(myrow).find('span.donut').text(percentage + '/100');
				$(myrow).find("span.donut").peity("donut", {
					fill: ['#1a7bb9', '#d7d7d7', '#ffffff']
				});
				//close the popup
				$("#TB_overlay").remove();
				$("#TB_window").remove();
				$("body").removeClass('modal-open');
			}
		}
	}
	
	//request JSONP
	$('button#jsonp_test').click(function(){
		JSONPCall(DXO.templateList, 'parseLastUsages');
	});
	
	function JSONPCall(jsonurl, callFunction){
		//console.log('llamando a: ' + callFunction );
		//console.log(jsonurl);
		$.ajax({
			url: jsonurl,
			crossDomain: true,
			dataType: "jsonp",
			timeout: 10000,
			//jsonpCallback: "callback",//let jQuery create an automatic name
			cache: false,
			// parse response
			success: function( data ) {
				methods[callFunction].call(null, data);
			},
			error: function( xhr, status, errorThrown ) {
				//console.log( "Error: " + errorThrown );
				//console.log( "Status: " + status );
				console.dir( xhr );
			}
		}).fail(function() {
			$('#errorDXO').show();
		  });
	}
	
	function parseLastUsages(data){
		//we reload the accessByToken url
		//console.log(data);
		var dateOptions = { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
		var container = $('#dataLoaderDXO');
		container.empty();
		paginator(container, data);
		var table = $('<table class="widefat"></table>').appendTo(container);
		$('<thead><tr><th></th><th><i class="fa fa-file"> </i> ' + trans_DXO.name + '</th><th>' + trans_DXO.actions + '</th><th>% ' + trans_DXO.comp + '</th></tr></thead>').appendTo(table);
		var tbody = $('<tbody></tbody>').appendTo(table);
		var length = data.length;
		for(var j = 0 ; j < length; j++){
			var usedate = new Date(data[j].timestamp * 1000);
			$('<tr><td>' + data[j].id + '</td><td>' + usedate.toLocaleDateString(navigator.language, dateOptions) + '</td><td><span class="donut">' + data[j].percentageCompleted + '/100</span></td></tr>').appendTo(tbody);
			
		}
		paginator(container, data);
		$("span.donut").peity("donut", {
			fill: ['#1a7bb9', '#d7d7d7', '#ffffff']
		});
	}
	

	

	

	
	function parseUsageData(data){
		//we reload the accessByToken url
		//console.log(data);
		var dateOptions = { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
		var container = $('#dataLoaderDXO');
		container.empty();
		paginator(container, data);
		var table = $('<table class="widefat  DXDashdoard-table"></table>').appendTo(container);
		$('<thead><tr><th><i class="fa fa-file DXDashdoard-fa"> </i> ' + trans_DXO.templateName + '</th><th><i class="fa fa-tag DXDashdoard-fa"> </i> ' + trans_DXO.identifier + '</th><th><i class="fa fa-tag DXDashdoard-fa"> </i> ' + trans_DXO.reference + '</th><th><i class="fa fa-clock-o DXDashdoard-fa"> </i> ' + trans_DXO.created + '</th><th><span class="donut">100/100</span> % ' + trans_DXO.comp + '</th><th><i class="fa fa-gear DXDashdoard-fa"> </i> ' + trans_DXO.actions + '</th></tr></thead>').appendTo(table);
		var tbody = $('<tbody></tbody>').appendTo(table);
		var length = data.data.length;
		for(var j = 0 ; j < length; j++){
			var usedate = new Date(data.data[j].timestamp * 1000);
			var classname = '';
			if (j % 2 == 0){
				classname = 'alternate';
			}
			var row = '<tr class="' + classname + '">';
			//row += '<td class="rowUsageID">' + data.data[j].id + '</td>';
            row += '<td class="rowIdentifier DXDashdoard-row">' + decodeDXO(data.data[j].templateName) + '</td>';
			row += '<td class="rowIdentifier DXDashdoard-row">' + decodeDXO(data.data[j].identifier) + '</td>';
			row += '<td class="rowReference DXDashdoard-row">' + decodeDXO(data.data[j].reference) + '</td>';
			row += '<td class="rowDate DXDashdoard-row">' + usedate.toLocaleDateString(navigator.language, dateOptions) + '</td>';
			row += '<td><span class="donut">' + data.data[j].percentageCompleted + '/100</span></td>';
            row += '<td>';

            var canEdit = true;
            var canDownload = true;
            if (typeof data.data[j].wfId  !== 'undefined' && data.data[j].wfId  !== null) {
                // not edit
                canEdit = false;
                if(data.data[j].WFStatus !== 'Completed'){
					// not download
                    canDownload = false;
				}
            }

			if(DXO.user_download == 1){
            	if(canDownload){
                    row += '<button class="button downloadDoc  DXDashdoard-button" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-download"> </i> ' + trans_DXO.document + '</button>';

                }else{
            		row += '<button class="button isWf  DXDashdoard-button" style="cursor: not-allowed; pointer-events: all !important; opacity: 0.7 "><i class="fa fa-download"> </i> '+ trans_DXO.document + '</button>';
				}
            }

			//row += ' <button class="button infoDoc" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-info-circle"> </i> ' + trans_DXO.data + '</button>';
			if(DXO.user_edit == 1  ) {
				if(canEdit){
					/*
					 * Put metadata
					 */
                    var res = "";
					if(typeof data.data[j].metadata  !== 'undefined' && data.data[j].metadata  !== null){
                        res = data.data[j].metadata.replace(/"/g, "'");
					}

                    row += ' <button class="button editDoc  DXDashdoard-button" data-usage="'+res+'" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-edit"> </i> ' + trans_DXO.edit + '</button>';

                }else{
					row += ' <button class="button isWf  DXDashdoard-button" style="cursor: not-allowed; pointer-events: all !important; opacity: 0.7 "><i class="fa fa-edit"> </i> '+ trans_DXO.edit + '</button>';
				}
            }
            row += '</td>';
			row += '</tr>';
			$(row).appendTo(tbody);
			
		}
		paginator(container, data);
		//chart completed data
		$("span.donut").peity("donut", {
			fill: ['#1a7bb9', '#d7d7d7', '#ffffff']
		});
	}
	
	//PAGINATION
	var paginatorObj;
	function paginator (container, data){
		paginatorObj = data;
		var currentPage = data.page;
		var numPages = data.numPages;
		var tablenav = $('<div class="tablenav  DXDashdoard-tablenav"></div>').appendTo(container);
		var tablenavpages = $('<div class="tablenav-pages DXDashdoard-tablenav-pages"></div>').appendTo(tablenav);
		
		//$('<span class="displaying-num">Example markup for <em>n</em> items</span>').appendTo(tablenavpages);
		//tablenavpages.append(" ");
		if (currentPage > 1 ){
			$('<a class="first-page paging-dxo DXDashdoard-paging-dxo" title="Go to first page" href="#" data-page="1" onclick="return false">«</a>').appendTo(tablenavpages);
			tablenavpages.append(" ");
			$('<a class="prev-page paging-dxo DXDashdoard-paging-dxo" title="Go to previous page" href="#" data-page="' + (currentPage - 1) + '" onclick="return false">‹</a>').appendTo(tablenavpages);
			tablenavpages.append(" ");
		} else {
			$('<span class="tablenav-pages-navspan DXDashdoard-pages-navspan">«</span>').appendTo(tablenavpages);
			tablenavpages.append(" ");
			$('<span class="tablenav-pages-navspan DXDashdoard-pages-navspan">‹</span>').appendTo(tablenavpages);
			tablenavpages.append(" ");
		}
		$('<span class="paging-input DXDashdoard-paging-input"><input class="current-page DXDashdoard-current-page" title="Current page" type="text" name="paged" value="' + currentPage + '" size="' + currentPage.toString().length + '"> ' + trans_DXO.of + ' <span class="total-pages DXDashdoard-total-pages">' + numPages + '</span></span>').appendTo(tablenavpages);
		tablenavpages.append(" ");
		if (currentPage < numPages ){
			$('<a class="next-page paging-dxo DXDashdoard-paging-dxo" title="Go to next page" href="#"  data-page="' + (parseInt(currentPage) + 1) + '" onclick="return false">›</a>').appendTo(tablenavpages);
			tablenavpages.append(" ");
			$('<a class="last-page paging-dxo DXDashdoard-paging-dxo" title="Go to last page" href="#" data-page="' + numPages + '" onclick="return false">»</a>').appendTo(tablenavpages);		
		} else {
			$('<span class="tablenav-pages-navspan DXDashdoard-pages-navspan">›</span>').appendTo(tablenavpages);
			tablenavpages.append(" ");
			$('<span class="tablenav-pages-navspan DXDashdoard-pages-navspan">»</span>').appendTo(tablenavpages);
			tablenavpages.append(" ");
		}
	}
	

	
	$('#dataLoaderDXO').on('click', 'a.paging-dxo', function(){
		var pageToGo = $(this).attr('data-page');
		requestPage(pageToGo, 'parseUsageData');
	});
	

	
	$('#dataLoaderDXO').on('keyup', 'input.current-page', function(e){
		if (e.keyCode == 13) {
			var pageToGo = $(this).val();
			requestPage(pageToGo, 'parseUsageData');
		}
	});
	
	function requestPage(pageToGo, method){
		url = DXO.installation + paginatorObj.path +'/'+ pageToGo;
		var query = '?timestamp=' + paginatorObj.timestamp + '&uniqid=' + paginatorObj.uniqid + '&APIKEY=' + paginatorObj.APIKEY + '&options=' + paginatorObj.options;
		url += query;
		//console.log('dataURL:');
		//console.log(url);
		if (method == 'parseTemplateList'){

		} else if (method == 'parseUsageData') {
			loader('dataLoaderDXO');
		}
		JSONPCall(url, method);
	}
	
	function loader(id){
		var waiting = '<div class="spinner is-active" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 10px;">' + trans_DXO.loading + '</div>';
		$('#' + id).empty();
		$('#' + id).append(waiting);
	}
	

	$('#tab_2').click(function(){
		$(this).addClass('nav-tab-active');
		$('#tab_1').removeClass('nav-tab-active');
		$('#selectionDataDXO').show();

	});

	
	//SEARCH TEMPLATES

	$('#dxo_search_data').click(function(){

        var period = $('#filterPeriod').val();

		if (period == 'range'){
			var startDate = $('#afterYear').val() + '-' + $('#afterMonth').val() + '-' + $('#afterDay').val();
			var endDate = $('#beforeYear').val() + '-' + $('#beforeMonth').val() + '-' + $('#beforeDay').val();
		} else {
			var startDate = '';
			var endDate = '';
		}
		$('#startDate').val(startDate);
        $('#endDate').val(endDate);

		$('#filterUsages').submit();

	})


	$('#dataLoaderDXO').on('click', 'button.downloadDoc', function(){
        var template = $(this).attr('data-template');
		var token = $(this).attr('data-token');

        var urlName = LocationVars.urlDXODownload;
		var preaction = '';
		if (window.location.href.indexOf("/wp-admin/") < 0) {
			preaction = 'wp-admin/';
		}
		var action = DXO.siteURL + "/wp-admin/admin.php?page="+urlName+"&template="+template+"&token="+token
		var myFrame = $('#box4iframe iframe').clone();
		$('#box4iframe iframe').remove();
        $(myFrame).attr("src",action);
		$('#box4iframe').append(myFrame);

	});

    //
    $('#dataLoaderDXO').on('click', 'button.isWf', function(){
    	//alert(trans_DXO.workflowactions);
    	$("#alert-not-button").show();

        $([document.documentElement, document.body]).animate({
            scrollTop: $("#selectionDataDXO").offset().top
        }, 1000);

    });
    //dismiss-alert
    $('#selectionDataDXO').on('click', 'button.dismiss-alert', function(){
        $("#alert-not-button").hide();
    });




	$('#dataLoaderDXO').on('click', 'button.editDoc', function(){
		/*
		 * Send metadata
		 */
		var id = $(this).attr('data-id');
		var template = $(this).attr('data-template');
		var token = $(this).attr('data-token');
		var metaData = $(this).attr('data-usage');
        var res = metaData.replace(/'/g, '"');

        var urlName = LocationVars.urlDXOEdit;
        //window.location.href = "admin.php?page="+urlName+"&template="+template+"&token="+token+"&usage="+id+"&metadata="+metaData;

        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2 = document.createElement("input");
        var element3 = document.createElement("input");
        var element4 = document.createElement("input");

        form.method = "POST";
		var action = DXO.siteURL + "/wp-admin/admin.php?page="+urlName;
        form.action = action;
		

        element1.value=id;
        element1.name="id";
        form.appendChild(element1);

        element2.value=template;
        element2.name="template";
        form.appendChild(element2);

        element3.value=token;
        element3.name="token";
        form.appendChild(element3);

        element4.value=res;
        element4.name="metaData";
        form.appendChild(element4);

        document.body.appendChild(form);

        form.submit();
	})
	
	function dressIframe(){
            $('#TB_iframeContent').attr("allow", "geolocation; microphone; camera");
	}
	
	$('#filterPeriod').change(function(){
		var period = $(this).val();
		if(period == 'range'){
			$('#dateRange').show();
		} else {
			$('#dateRange').hide();
		}
	});
	

	
	function clearDataFilters(){
		//$('#filterReference').val('');
		$('#filterIdentifier').val('');
		$('#filterPeriod').val('');
		$('#dateRange').hide();
		//load current date
		var beftoday = new Date();
		var befday = ("0" + beftoday.getDate()).slice(-2);
		var befmonth = ("0" + (beftoday.getMonth() + 1)).slice(-2);
		var befyear = beftoday.getFullYear();
		$('#beforeDay').val(befday);
		$('#beforeMonth').val(befmonth);
		$('#beforeYear').val(befyear);
	}
	
	//AUX FUNCTIONS
	function decodeDXO(str){
		if(str == 'null' || str === null){
			return '';
		} else {
			return decodeURIComponent(str);
		}
	}
	
});

