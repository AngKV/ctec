jQuery(function ($) {
    //test on focus
    // Set global counter variable to verify event instances
    var nCounter = 0;

    // Set up event handler to produce text for the window focus event
    window.addEventListener("focus", function (event) {
        //console.log('Focus: ' + nCounter);
        nCounter = nCounter + 1;
    }, false);
    //This JS controls thickbox interactivity
    $(document).ready(function () {
        clearDataFilters();
        $('button#dxo_saas').click(function () {
            //we add a class to the body in order to manage the styles of
            //the thickbox popup without messing up with other plugin or themes
            $('body').addClass('DXO');
            tb_show(trans_DXO.selectTemplate, DXO.remoteLogin);
        });

        $('button#selectTemplateFromCategory').click(function () {
            //we add a class to the body in order to manage the styles of
            //the thickbox popup without messing up with other plugin or themes
            $('body').addClass('DXO');
            tb_show(trans_DXO.selectTemplate, DXO.selectTemplate);
        });

        $(document).on("mouseup", ".DXO button#TB_closeWindowButton", function (event) {
            //when the popup closes we remove the DXO class
            if (event.which == 1) {
                //we only listen to left mouse button events
                if (DXO.closeConnection == 1) {
                    $.ajax({
                        url: DXO.installation + '/users/remote_logout?url=' + encodeURIComponent('/documents/plugin/tree'),
                        cache: false,
                        crossDomain: true,
                        dataType: "jsonp",
                        //jsonpCallback: "logout",
                        // parse response
                        success: function (data) {
                            DXO.remoteLogin = data.accessByToken.replace('&amp;', '&') + '&TB_iframe=true';
                            //console.log(DXO.remoteLogin);
                        },
                        error: function (xhr, status, errorThrown) {
                            //console.log("Error: " + errorThrown);
                            //console.log("Status: " + status);
                            //console.dir(xhr);
                        }
                    });
                }
                setTimeout(function () {
                    $('body').removeClass('DXO');
                }, 500);
            }
        });

        //JSONPCall(DXO.lastUsages, 'parseLastUsages');
        //JSONPCall(DXO.templateList, 'parseTemplateList');
        JSONPCall(DXO.lastUsedTemplates, 'parseLastUsedTemplates');
        JSONPCall(DXO.latestTemplates, 'parseLatestTemplates');
    });

    var methods = {
        parseLastUsages: function (data) {
            parseLastUsages(data);
        },
        parseTemplateList: function (data) {
            parseTemplateList(data);
        },
        parseUsageData: function (data) {
            parseUsageData(data);
        },
        parseUsageDataGD: function (data) {
            parseUsageDataGD(data);
        },
        parseLastUsedTemplates: function (data) {
            parseLastUsedTemplates(data);
        },
        parseLatestTemplates: function (data) {
            parseLatestTemplates(data);
        }
    }

    window.addEventListener("message", DXOMessage, false);

    function DXOMessage(event) {
        //here we shoud make sure that the message comes from the docxpresso instance
        if (event.origin !== DXO.installation) {
            return;
        }
        if (typeof event.data == 'string') {
            var sentData = JSON.parse(event.data);
            //console.log(sentData);
            if (sentData.type == 'logout') {
                LogOutDXO();
            } else if (sentData.type == 'refreshToken') {
                //refresh the tokens so we can log in again
                DXO.remoteLogin = sentData.accessByToken.replace('&amp;', '&') + '&TB_iframe=true';
                //console.log(DXO.remoteLogin);
            } else if (sentData.type == 'selectTemplate') {
                DXO.selectTemplate = sentData.accessByToken.replace('&amp;', '&') + '&TB_iframe=true';
                //console.log(DXO.selectTemplate);
                var id = sentData.id;
                var name = sentData.name;
                //manage global template actions
                DXO.templateSelected = id;
                $('#noTemplate').hide();
                $('#yesTemplate').show();
                $('#templateDataFilter').show();
                $('#filterDataTemplateValue').text(name);
                //clean data filters on click
                clearDataFilters();
                $('#tab_2').click();
                //Build the URL to request data for that template
                var baseURL = DXO.installation + '/RESTservices/predefined/data_by_template_paginated/' + id + '/1?options=';
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
                var dateOptions = {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                var mydate = usedate.toLocaleDateString(navigator.language, dateOptions);
                //redefine the corresponding data row
                var myrow = $('table.widefat button.editDoc[data-token="' + oldToken + '"]').parents('tr:first');
                $(myrow).find('td.rowUsageID').text(usageId);
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
    $('button#jsonp_test').click(function () {
        JSONPCall(DXO.templateList, 'parseLastUsages');
    });

    function JSONPCall(jsonurl, callFunction) {
        //console.log('llamando a: ' + callFunction);
        //console.log(jsonurl);
        $.ajax({
            url: jsonurl,
            crossDomain: true,
            dataType: "jsonp",
            timeout: 10000,
            //jsonpCallback: "callback",//let jQuery create an automatic name
            cache: false,
            // parse response
            success: function (data) {
                methods[callFunction].call(null, data);
            },
            error: function (xhr, status, errorThrown) {
                //console.log("Error: " + errorThrown);
                //console.log("Status: " + status);
                console.dir(xhr);
            }
        }).fail(function () {
            $('#errorDXO').show();
        });
    }

    function parseLastUsages(data) {
        //we reload the accessByToken url
        //console.log(data);
        var dateOptions = {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var container = $('#dataLoaderDXO');
        container.empty();
        paginator(container, data);
        var table = $('<table class="widefat"></table>').appendTo(container);
        $('<thead><tr><th></th><th><i class="fa fa-file"> </i> ' + trans_DXO.name + '</th><th>' + trans_DXO.actions + '</th><th>% ' + trans_DXO.comp + '</th></tr></thead>').appendTo(table);
        var tbody = $('<tbody></tbody>').appendTo(table);
        var length = data.length;
        for (var j = 0; j < length; j++) {
            var usedate = new Date(data[j].timestamp * 1000);
            $('<tr><td>' + data[j].id + '</td><td>' + usedate.toLocaleDateString(navigator.language, dateOptions) + '</td><td><span class="donut">' + data[j].percentageCompleted + '/100</span></td></tr>').appendTo(tbody);

        }
        paginator(container, data);
        $("span.donut").peity("donut", {
            fill: ['#1a7bb9', '#d7d7d7', '#ffffff']
        });
    }

    function parseLastUsedTemplates(data) {
        //we reload the accessByToken url
        //console.log(data);
        var dateOptions = {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var container = $('#templateLoaderDXO');
        container.empty();
        //paginator(container, data);
        var table = $('<table class="widefat"></table>').appendTo(container);
        $('<thead><tr><th> </th><th><i class="fa fa-file"> </i> ' + trans_DXO.name + '</th><th><i class="fa fa-clock-o"> </i> ' + trans_DXO.last + '</th><th>' + trans_DXO.uses + '</th><th><i class="fa fa-gear"> </i> ' + trans_DXO.actions + '</th></tr></thead>').appendTo(table);
        var tbody = $('<tbody></tbody>').appendTo(table);
        var length = data.length;
        for (var j = 0; j < length; j++) {
            var usedate = new Date(data[j].timestamp * 1000);
            var classname = '';
            if (j % 2 == 0) {
                classname = 'alternate';
            }
            var row = '<tr class="' + classname + '">';
            row += '<td>' + data[j].templateId + '</td>';
            row += '<td>' + data[j].name + '</td>';
            row += '<td>' + usedate.toLocaleDateString(navigator.language, dateOptions) + '</td>';
            row += '<td>' + data[j].usageCount + '</td>';
            row += '<td><button class="button viewData" data-name="' + data[j].name + '" data-id="' + data[j].templateId + '"><i class="fa fa-database"> </i> ' + trans_DXO.data + '</button></td>';
            row += '</tr>';
            $(row).appendTo(tbody);

        }
        //paginator(container, data);
    }

    function parseLatestTemplates(data) {
        var container = $('#latestTemplatesDXO');
        container.empty();
        var length = data.length;
        for (var j = 0; j < length; j++) {
            var templateBox = '<div class="DXOTemplateBox" data-id="' + data[j].id + '" data-name="' + data[j].name + '">';
            templateBox += '<div class="DXOTemplateBoxName"><p>' + data[j].name + '</p></div>';
            templateBox += '<img src="' + data[j].thumbnail + '" width="100%" />';
            templateBox += '</div>';
            $(templateBox).appendTo(container);

        }
    }

    function parseTemplateList(data) {
        //we reload the accessByToken url
        //console.log(data);
        var dateOptions = {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var container = $('#templateLoaderDXO');
        container.empty();
        paginator(container, data);
        var table = $('<table class="widefat"></table>').appendTo(container);
        $('<thead><tr><th>Id</th><th><i class="fa fa-file-o"> </i> ' + trans_DXO.name + '</th><th><i class="fa fa-clock-o"> </i> ' + trans_DXO.created + '</th><th><i class="fa fa-gear"> </i> ' + trans_DXO.actions + '</th></tr></thead>').appendTo(table);
        var tbody = $('<tbody></tbody>').appendTo(table);
        var length = data.data.length;
        for (var j = 0; j < length; j++) {
            var usedate = new Date(data.data[j].timestamp * 1000);
            var classname = '';
            if (j % 2 == 0) {
                classname = 'alternate';
            }
            var row = '<tr class="' + classname + '">';
            row += '<td>' + data.data[j].id + '</td>';
            row += '<td>' + data.data[j].name + '</td>';
            row += '<td>' + usedate.toLocaleDateString(navigator.language, dateOptions) + '</td>';
            row += '<td><button class="button viewData" data-name="' + data.data[j].name + '" data-id="' + data.data[j].id + '"><i class="fa fa-database"> </i> ' + trans_DXO.data + '</button></td>';
            row += '</tr>';
            $(row).appendTo(tbody);

        }
        paginator(container, data);
    }

    function parseUsageData(data) {
        //we reload the accessByToken url
        //console.log(data);
        var dateOptions = {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var container = $('#dataLoaderDXO');
        container.empty();
        paginator(container, data);
        var table = $('<table class="widefat"></table>').appendTo(container);
        $('<thead><tr><th>Id</th><th><i class="fa fa-user"> </i> ' + trans_DXO.user + '</th><th><i class="fa fa-tag"> </i> ' + trans_DXO.identifier + '</th><th><i class="fa fa-tag"> </i> ' + trans_DXO.reference + '</th><th><i class="fa fa-clock-o"> </i> ' + trans_DXO.created + '</th><th><span class="donut">100/100</span> % ' + trans_DXO.comp + '</th><th><i class="fa fa-gear"> </i> ' + trans_DXO.actions + '</th></tr></thead>').appendTo(table);
        var tbody = $('<tbody></tbody>').appendTo(table);
        var length = data.data.length;
        for (var j = 0; j < length; j++) {
            var usedate = new Date(data.data[j].timestamp * 1000);
            var classname = '';
            if (j % 2 == 0) {
                classname = 'alternate';
            }
            var domainUsage = cleanDomainData(data.data[j].domain);

            var row = '<tr class="' + classname + '">';
            row += '<td class="rowUsageID">' + data.data[j].id + '</td>';
            row += '<td class="rowIdentifier">' + domainUsage + '</td>';
            row += '<td class="rowIdentifier">' + decodeDXO(data.data[j].identifier) + '</td>';
            row += '<td class="rowReference">' + decodeDXO(data.data[j].reference) + '</td>';
            row += '<td class="rowDate">' + usedate.toLocaleDateString(navigator.language, dateOptions) + '</td>';
            row += '<td><span class="donut">' + data.data[j].percentageCompleted + '/100</span></td>';
            row += '<td><button class="button downloadDoc" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-download"> </i> ' + trans_DXO.document + '</button>';
            row += ' <button class="button infoDoc" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-info-circle"> </i> ' + trans_DXO.data + '</button>';
            row += ' <button class="button editDoc" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-edit"> </i> ' + trans_DXO.edit + '</button></td>';
            row += '</tr>';
            $(row).appendTo(tbody);

        }
        paginator(container, data);
        //chart completed data
        $("span.donut").peity("donut", {
            fill: ['#1a7bb9', '#d7d7d7', '#ffffff']
        });
    }
	
	function cleanDomainData(domain){
		console.log('predomain:' + domain);
		var res = "";
		//domain names coming form the plugin sholud start as get_site_url() + '/me/'
		var prefix = DXO.siteURL + '/me/';
		if(domain.indexOf(prefix) == 0){
			res = domain.replace(prefix, "");
		}
		console.log('domain:' + res);
		return res;
	}

    function parseUsageDataGD(data) {
        //we reload the accessByToken url
        //console.log(data);
        var dateOptions = {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        var container = $('#dataLoaderDXOGD');
        container.empty();
        paginator(container, data);
        var table = $('<table class="widefat"></table>').appendTo(container);
        $('<thead><tr><th>Id</th><th><i class="fa fa-file"> </i> ' + trans_DXO.template + '</th><th><i class="fa fa-user"> </i> ' + trans_DXO.user + '</th><th><i class="fa fa-tag"> </i> ' + trans_DXO.identifier + '</th><th><i class="fa fa-tag"> </i> ' + trans_DXO.reference + '</th><th><i class="fa fa-clock-o"> </i> ' + trans_DXO.created + '</th><th><span class="donut">100/100</span> % ' + trans_DXO.comp + '</th><th><i class="fa fa-gear"> </i> ' + trans_DXO.actions + '</th></tr></thead>').appendTo(table);
        var tbody = $('<tbody></tbody>').appendTo(table);
        var length = data.data.length;
        for (var j = 0; j < length; j++) {
            var usedate = new Date(data.data[j].timestamp * 1000);
            var classname = '';
            if (j % 2 == 0) {
                classname = 'alternate';
            }

            var domainUsage = cleanDomainData(data.data[j].domain);
			
            var row = '<tr class="' + classname + '">';
            row += '<td class="rowUsageID">' + data.data[j].id + '</td>';
            row += '<td class="rowIdentifier">' + data.data[j].templateName + '</td>';
            row += '<td class="rowIdentifier">' + domainUsage + '</td>';
            row += '<td class="rowIdentifier">' + decodeDXO(data.data[j].identifier) + '</td>';
            row += '<td class="rowReference">' + decodeDXO(data.data[j].reference) + '</td>';
            row += '<td class="rowDate">' + usedate.toLocaleDateString(navigator.language, dateOptions) + '</td>';
            row += '<td><span class="donut">' + data.data[j].percentageCompleted + '/100</span></td>';
            row += '<td><button class="button downloadDoc" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-download"> </i> ' + trans_DXO.document + '</button>';
            row += ' <button class="button infoDoc" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-info-circle"> </i> ' + trans_DXO.data + '</button>';
            row += ' <button class="button editDoc" data-template="' + data.data[j].templateId + '" data-token="' + data.data[j].token + '" data-id="' + data.data[j].id + '"><i class="fa fa-edit"> </i> ' + trans_DXO.edit + '</button></td>';
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

    function paginator(container, data) {
        paginatorObj = data;
        var currentPage = data.page;
        var numPages = data.numPages;
        var tablenav = $('<div class="tablenav"></div>').appendTo(container);
        var tablenavpages = $('<div class="tablenav-pages"></div>').appendTo(tablenav);

        //$('<span class="displaying-num">Example markup for <em>n</em> items</span>').appendTo(tablenavpages);
        //tablenavpages.append(" ");
        if (currentPage > 1) {
            $('<a class="first-page paging-dxo" title="Go to first page" href="#" data-page="1" onclick="return false">«</a>').appendTo(tablenavpages);
            tablenavpages.append(" ");
            $('<a class="prev-page paging-dxo" title="Go to previous page" href="#" data-page="' + (currentPage - 1) + '" onclick="return false">‹</a>').appendTo(tablenavpages);
            tablenavpages.append(" ");
        } else {
            $('<span class="tablenav-pages-navspan">«</span>').appendTo(tablenavpages);
            tablenavpages.append(" ");
            $('<span class="tablenav-pages-navspan">‹</span>').appendTo(tablenavpages);
            tablenavpages.append(" ");
        }
        $('<span class="paging-input"><input class="current-page" title="Current page" type="text" name="paged" value="' + currentPage + '" size="' + currentPage.toString().length + '"> ' + trans_DXO.of + ' <span class="total-pages">' + numPages + '</span></span>').appendTo(tablenavpages);
        tablenavpages.append(" ");
        if (currentPage < numPages) {
            $('<a class="next-page paging-dxo" title="Go to next page" href="#"  data-page="' + (parseInt(currentPage) + 1) + '" onclick="return false">›</a>').appendTo(tablenavpages);
            tablenavpages.append(" ");
            $('<a class="last-page paging-dxo" title="Go to last page" href="#" data-page="' + numPages + '" onclick="return false">»</a>').appendTo(tablenavpages);
        } else {
            $('<span class="tablenav-pages-navspan">›</span>').appendTo(tablenavpages);
            tablenavpages.append(" ");
            $('<span class="tablenav-pages-navspan">»</span>').appendTo(tablenavpages);
            tablenavpages.append(" ");
        }
    }

    $('#templateLoaderDXO').on('click', 'a.paging-dxo', function () {
        var pageToGo = $(this).attr('data-page');
        requestPage(pageToGo, 'parseTemplateList');
    });

    $('#dataLoaderDXO').on('click', 'a.paging-dxo', function () {
        var pageToGo = $(this).attr('data-page');
        requestPage(pageToGo, 'parseUsageData');
    });
    $('#dataLoaderDXOGD').on('click', 'a.paging-dxo', function () {
        var pageToGo = $(this).attr('data-page');
        requestPage(pageToGo, 'parseUsageDataGD');
    });

    $('#templateLoaderDXO').on('keyup', 'input.current-page', function (e) {
        if (e.keyCode == 13) {
            var pageToGo = $(this).val();
            requestPage(pageToGo, 'parseTemplateList');
        }
    });

    $('#dataLoaderDXO').on('keyup', 'input.current-page', function (e) {
        if (e.keyCode == 13) {
            var pageToGo = $(this).val();
            requestPage(pageToGo, 'parseUsageData');
        }
    });

    $('#dataLoaderDXOGD').on('keyup', 'input.current-page', function (e) {
        if (e.keyCode == 13) {
            var pageToGo = $(this).val();
            requestPage(pageToGo, 'parseUsageDataGD');
        }
    });

    function requestPage(pageToGo, method) {
        if(method == 'parseUsageDataGD'){
            // Especial
            url = DXO.installation + paginatorObj.path +"/"+ pageToGo;
        }else{
            url = DXO.installation + paginatorObj.path + pageToGo;
        }
        var query = '?timestamp=' + paginatorObj.timestamp + '&uniqid=' + paginatorObj.uniqid + '&APIKEY=' + paginatorObj.APIKEY + '&options=' + paginatorObj.options;
        url += query;
        //console.log('dataURL:');
        //console.log(url);
        if (method == 'parseTemplateList') {
            loader('templateLoaderDXO');
        } else if (method == 'parseUsageData') {
            loader('dataLoaderDXO');
        }else if (method == 'parseUsageDataGD') {
            loader('dataLoaderDXOGD');
        }
        JSONPCall(url, method);
    }

    function loader(id) {
        var waiting = '<div class="spinner is-active" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 10px;">' + trans_DXO.loading + '</div>';
        $('#' + id).empty();
        $('#' + id).append(waiting);
    }

    //TABS
    $('#tab_1').click(function () {
        $(this).addClass('nav-tab-active');
        $('#tab_2').removeClass('nav-tab-active');
        $('#tab_3').removeClass('nav-tab-active');
        $('#selectionTemplateDXO').show();
        $('#selectionDataDXO').hide();
        $('#selectionDataDXOGD').hide();
    });
    $('#tab_2').click(function () {
        $(this).addClass('nav-tab-active');
        $('#tab_1').removeClass('nav-tab-active');
        $('#tab_3').removeClass('nav-tab-active');
        $('#selectionDataDXO').show();
        $('#selectionTemplateDXO').hide();
        $('#selectionDataDXOGD').hide();
    });
    $('#tab_3').click(function () {
        $(this).addClass('nav-tab-active');
        $('#tab_1').removeClass('nav-tab-active');
        $('#tab_2').removeClass('nav-tab-active');
        $('#selectionDataDXOGD').show();
        $('#selectionDataDXO').hide();
        $('#selectionTemplateDXO').hide();

        /*
         * Get all use
         */
        $('#dxo_search_general_data').trigger("click");

    });
    $('#templateTabButton').click(function () {
        $('#tab_1').click();
    });

    //SEARCH TEMPLATES

    $('#dxo_search_templates').click(function () {
        var baseURL = DXO.installation + '/RESTservices/predefined/list_templates_paginated/1?options=';
        var name = $('#filterName').val();
        if (name == '') {
            $('#templateFilters').hide();
            name = 'q';
            $('#listTemplates').text('List of templates');
        } else {
            $('#templateFilters').show();
            $('#filterTemplateValue').text(name);
            $('#listTemplates').text('List of templates');
        }
        var opts = btoa('{"name":"' + name + '","sort":"name","order":"ASC"}');
        var url = baseURL + opts;
        JSONPCall(url, 'parseTemplateList');
        loader('templateLoaderDXO');
    });

    //SELECT DATA
    $('#templateLoaderDXO').on('click', 'button.viewData', function () {
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        //manage global template actions
        DXO.templateSelected = id;
        $('#noTemplate').hide();
        $('#yesTemplate').show();
        $('#templateDataFilter').show();
        $('#filterDataTemplateValue').text(name);
        //clean data filters on click
        clearDataFilters();
        $('#tab_2').click();
        //Build the URL to request data for that template
        var baseURL = DXO.installation + '/RESTservices/predefined/data_by_template_paginated/' + id + '/1?options=';
        var opts = btoa('{}');
        var url = baseURL + opts;
        JSONPCall(url, 'parseUsageData');
        loader('dataLoaderDXO');
    });
    $('#latestTemplatesDXO').on('click', '.DXOTemplateBox', function () {
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        //manage global template actions
        DXO.templateSelected = id;
        $('#noTemplate').hide();
        $('#yesTemplate').show();
        $('#templateDataFilter').show();
        $('#filterDataTemplateValue').text(name);
        //clean data filters on click
        clearDataFilters();
        $('#tab_2').click();
        //Build the URL to request data for that template
        var baseURL = DXO.installation + '/RESTservices/predefined/data_by_template_paginated/' + id + '/1?options=';
        var opts = btoa('{}');
        var url = baseURL + opts;
        JSONPCall(url, 'parseUsageData');
        loader('dataLoaderDXO');
    });

    $('#dxo_search_data').click(function () {
        var baseURL = DXO.installation + '/RESTservices/predefined/data_by_template_paginated/' + DXO.templateSelected + '/1?options=';
        var filters = {};
        var reference = $('#filterReference').val();
        filters.reference = reference;
        var identifier = $('#filterIdentifier').val();
        filters.identifier = identifier;
        var period = $('#filterPeriod').val();
        filters.period = period;
        if (period == 'range') {
            var startDate = $('#afterYear').val() + '-' + $('#afterMonth').val() + '-' + $('#afterDay').val();
            var endDate = $('#beforeYear').val() + '-' + $('#beforeMonth').val() + '-' + $('#beforeDay').val();
        } else {
            var startDate = '';
            var endDate = '';
        }
        filters.startDate = startDate;
        filters.endDate = endDate;
        var opts = btoa(JSON.stringify(filters));
        var url = baseURL + opts;
        JSONPCall(url, 'parseUsageData');
        loader('dataLoaderDXO');
    })

    //SEARCH TEMPLATES

    $('#dxo_search_general_data').click(function () {
        //console.log("Click on dxo_search_general_data");
        var baseURL = DXO.installation + '/RESTservices/predefined/get_usage_data_paginated/1?options=';
        var filters = {};
        var reference = $('#filterReferenceGD').val();
        filters.reference = reference;
        var identifier = $('#filterIdentifierGD').val();
        filters.identifier = identifier;
        var userLoginFilter = $('#filterUserGD').val();
		if (userLoginFilter != '' && userLoginFilter != '0' && typeof(userLoginFilter) != 'undefined'){
			filters.domain = DXO.siteURL + '/me/' + userLoginFilter;
		} else {
			filters.domain = userLoginFilter;
		}
        var period = $('#filterPeriodGD').val();
        filters.period = period;
        if (period == 'range') {
            var startDate = $('#afterYearGD').val() + '-' + $('#afterMonthGD').val() + '-' + $('#afterDayGD').val();
            var endDate = $('#beforeYearGD').val() + '-' + $('#beforeMonthGD').val() + '-' + $('#beforeDayGD').val();
        } else {
            var startDate = '';
            var endDate = '';
        }
        filters.startDate = startDate;
        filters.endDate = endDate;
        var opts = btoa(JSON.stringify(filters));
        var url = baseURL + opts;
        JSONPCall(url, 'parseUsageDataGD');
        loader('dataLoaderDXOGD');

    })

    $('#downloadExcel').click(function () {
        var baseURL = DXO.installation + '/data/digest/' + DXO.templateSelected + '?';
        var query = 'format=csv';
        if ($('#filterIdentifier').val() != '') {
            query += '&identifier=' + $('#filterIdentifier').val();
        }
        if ($('#filterReference').val() != '') {
            query += '&reference=' + $('#filterReference').val();
        }
        if ($('#filterPeriod').val() != '') {
            query += '&period=' + $('#filterPeriod').val();
        }
        if ($('#filterPeriod').val() == 'range') {
            query += '&after=' + $('#afterYear').val() + '-' + $('#afterMonth').val() + '-' + $('#afterDay').val();
            query += '&before=' + $('#beforeYear').val() + '-' + $('#beforeMonth').val() + '-' + $('#beforeDay').val();
        }
        var url = baseURL + query;
        window.location.href = url;
    })

    $('#dataLoaderDXO').on('click', 'button.downloadDoc', function () {
        var token = $(this).attr('data-token');
        var baseURL = DXO.installation + '/documents/getFullDocumentation/' + DXO.templateSelected + '?options=';
        var opt = btoa('{"token":"' + token + '"}');
        var url = baseURL + opt;
        window.location.href = url;
    })

    $('#dataLoaderDXO').on('click', 'button.infoDoc', function () {
        var id = $(this).attr('data-id');
        var url = DXO.installation + '/data/plugin/show_data/' + id + '?TB_iframe=true';
        $('body').addClass('DXO');
        var name = $('#filterDataTemplateValue').text()
        tb_show(trans_DXO.template + ': ' + name + ' - ' + trans_DXO.usage + ': ' + id, url);
    })

    $('#dataLoaderDXO').on('click', 'button.editDoc', function () {
        var id = $(this).attr('data-id');
        var template = $(this).attr('data-template');
        var token = $(this).attr('data-token');
        var url = DXO.installation + '/documents/plugin/edit/document/' + template + '/' + token + '?TB_iframe=true';
        $('body').addClass('DXO');
        var name = $('#filterDataTemplateValue').text()
        tb_show(trans_DXO.template + ': ' + name + ' - ' + trans_DXO.usage + ': ' + id, url);
        //setTimeout(dressIframe, 10);
        $('#TB_iframeContent').attr("allow", "geolocation; microphone; camera");
    })

    $('#dataLoaderDXOGD').on('click', 'button.downloadDoc', function () {
        var token = $(this).attr('data-token');
        var template = $(this).attr('data-template');
        var baseURL = DXO.installation + '/documents/getFullDocumentation/' + template + '?options=';
        var opt = btoa('{"token":"' + token + '"}');
        var url = baseURL + opt;
        window.location.href = url;
    })

    $('#dataLoaderDXOGD').on('click', 'button.infoDoc', function () {
        var id = $(this).attr('data-id');
        var url = DXO.installation + '/data/plugin/show_data/' + id + '?TB_iframe=true';
        $('body').addClass('DXO');
        var name = $('#filterDataTemplateValue').text()
        tb_show(trans_DXO.template + ': ' + name + ' - ' + trans_DXO.usage + ': ' + id, url);
    })

    $('#dataLoaderDXOGD').on('click', 'button.editDoc', function () {
        var id = $(this).attr('data-id');
        var template = $(this).attr('data-template');
        var token = $(this).attr('data-token');
        var url = DXO.installation + '/documents/plugin/edit/document/' + template + '/' + token + '?TB_iframe=true';
        $('body').addClass('DXO');
        var name = $('#filterDataTemplateValue').text()
        tb_show(trans_DXO.template + ': ' + name + ' - ' + trans_DXO.usage + ': ' + id, url);
        //setTimeout(dressIframe, 10);
        $('#TB_iframeContent').attr("allow", "geolocation; microphone; camera");
    })

    function dressIframe() {
        $('#TB_iframeContent').attr("allow", "geolocation; microphone; camera");
    }

    $('#filterPeriod').change(function () {
        var period = $(this).val();
        if (period == 'range') {
            $('#dateRange').show();
        } else {
            $('#dateRange').hide();
        }
    });


    function clearDataFilters() {
        $('#filterReference').val('');
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
        //GD
        $('#filterReferenceGD').val('');
        $('#filterIdentifierGD').val('');
        $('#filterPeriodGD').val('');
        $('#dateRangeGD').hide();
        //load current date
        $('#beforeDayGD').val(befday);
        $('#beforeMonthGD').val(befmonth);
        $('#beforeYearGD').val(befyear);
    }
    
    $('#filterPeriodGD').change(function () {
        var period = $(this).val();
        if (period == 'range') {
            $('#dateRangeGD').show();
        } else {
            $('#dateRangeGD').hide();
        }
    });

    //AUX FUNCTIONS
    function decodeDXO(str) {
        if (str == 'null' || str === null) {
            return '';
        } else {
            return decodeURIComponent(str);
        }
    }

});

