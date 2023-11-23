jQuery(window).load(function() {
	var simplesp = jQuery.noConflict();
	var active_ssp;
	var rmdni = false;
	simplesp(function() {
	simplesp("#simple_subscription_popup_tabs").tabs();
	simplesp('.open-tab').click(function (event) {
		simplesp( "#simple_subscription_popup_tabs" ).tabs( "option", "active", 0 );
    });
	simplesp("#ssp_name").focus();
	 simplesp(function() {
    simplesp( "#simple_subscription_popup_accordion" ).accordion({
      collapsible: true,
	  heightStyle: "content"
    });
  });
	})
	//define presets
	var presets = new Array();
	presets['default'] = { 
		customfieldsmargin:"7px", bgcolor:"rgb(254, 254, 254)",lockbgcolor:"rgb(0, 0, 0)",buttonbgcolor:"rgb(199, 28, 9)",buttoncolor:"rgb(247, 247, 247)",closecolor:"rgb(0, 0, 0)",closefontsize:"16px",color:"rgb(0, 0, 0)",contentcolor:"rgb(93, 93, 93)",fontfamily:"Trade Winds",contentfontfamily:"Quattrocento Sans",contentfontsize:"12px",	borderradius:"12px",inputborderradius:"0px",fontsize:"20px"
	  };
	  //customize start	
		initialize_sliders();

		function initialize_sliders()
	{
	initialize_tooltips();
	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_animation_speed").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_animation_speed_value" ).val().replace("Animation Speed: ","").replace("sec","");
	  	//initialize the animation speed property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_animation_speed" ).slider({
			range: "min",
			step: 0.1,
			value: thisvalue,
			min: 0.1,
			max: 5,
			slide: function( event, ui ) {
			simplesp( "#"+ssp_id+" .simple_subscription_popup_animation_speed_value" ).val( "Animation Speed: "+ui.value + "sec" );
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_font_size").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_font_size_value" ).val().replace("Font Size: ","").replace("px","");
	  	//initialize the font-size property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_font_size" ).slider({
			range: "min",
			value: thisvalue,
			min: 6,
			max: 40,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_font_size_value" ).val( "Font Size: "+ui.value + "px" );
				if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner h2").css("font-size",ui.value + "px");
			reset_preset(ssp_id);
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_content_font_size").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_content_font_size_value" ).val().replace("Content Font Size: ","").replace("px","");
	  	//initialize the content font-size property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_content_font_size" ).slider({
			range: "min",
			value: thisvalue,
			min: 6,
			max: 40,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_content_font_size_value" ).val( "Content Font Size: "+ui.value + "px" );
				if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner p").css("font-size",ui.value + "px");
			reset_preset(ssp_id);
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_border_radius").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_border_radius_value" ).val().replace("Border Radius: ","").replace("px","");
	  	//initialize the border-radius property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_border_radius" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			max: 100,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_border_radius_value" ).val( "Border Radius: "+ui.value + "px" );
				if (simplesp("#mc_embed_signup #mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup #mc_embed_signup_inner").css("border-radius",ui.value+"px "+ui.value+"px "+ui.value+"px "+ui.value+"px");
			reset_preset(ssp_id);
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_close_button_size").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_close_button_size_value" ).val().replace("Close Button Size: ","").replace("px","");
	  	//initialize the close button size property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_close_button_size" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			max: 40,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_close_button_size_value" ).val( "Close Button Size: "+ui.value + "px" );
				if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_close").css("font-size",ui.value + "px");
			reset_preset(ssp_id);
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_vertical_space").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_vertical_space_value" ).val().replace("Vertical Space: ","").replace("px","");
	  	//initialize the vertical space property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_vertical_space" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			max: 200,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_vertical_space_value" ).val( "Vertical Space: "+ui.value + "px" );
				if (simplesp("#mc_embed_signup_inner").length!=0) 
				{
					if (simplesp("#"+ssp_id+" .display_style").val()=="lefttop"||simplesp("#"+ssp_id+" .display_style").val()=="righttop"||simplesp("#"+ssp_id+" .display_style").val()=="centertop") simplesp("#mc_embed_signup").css("top",ui.value + "px");
					if (simplesp("#"+ssp_id+" .display_style").val()=="leftbottom"||simplesp("#"+ssp_id+" .display_style").val()=="rightbottom"||simplesp("#"+ssp_id+" .display_style").val()=="centerbottom") simplesp("#mc_embed_signup").css("bottom",ui.value + "px");
				}
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_horizontal_space").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_horizontal_space_value" ).val().replace("Horizontal Space: ","").replace("px","");
	  	//initialize the horizontal space property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_horizontal_space" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			max: 200,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_horizontal_space_value" ).val( "Horizontal Space: "+ui.value + "px" );
				if (simplesp("#mc_embed_signup_inner").length!=0) 
				{
					if (simplesp("#"+ssp_id+" .display_style").val()=="lefttop"||simplesp("#"+ssp_id+" .display_style").val()=="leftbottom"||simplesp("#"+ssp_id+" .display_style").val()=="leftcenter") simplesp("#mc_embed_signup").css("left",ui.value + "px");
					if (simplesp("#"+ssp_id+" .display_style").val()=="righttop"||simplesp("#"+ssp_id+" .display_style").val()=="rightbottom"||simplesp("#"+ssp_id+" .display_style").val()=="rightcenter") simplesp("#mc_embed_signup").css("right",ui.value + "px");
				}
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_cmargin").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_cmargin_value" ).val().replace("Fields Margin: ","").replace("px","");
	  	//initialize the opacity property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_cmargin" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			step: 1,
			max: 100,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_cmargin_value" ).val( "Fields Margin: "+ui.value+"px" );
				if (simplesp(".customfields").length!=0) simplesp(".customfields").css("marginBottom",ui.value+"px");
			reset_preset(ssp_id);
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_iborderradius").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_iborderradius_value" ).val().replace("Input Border Radius: ","").replace("px","");
	  	//initialize the opacity property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_iborderradius" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			step: 1,
			max: 100,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_iborderradius_value" ).val( "Input Border Radius: "+ui.value+"px" );
				if (simplesp(".customfields").length!=0) {
					simplesp(".customfields").css("borderRadius",ui.value+"px");
				}
				simplesp("#ssp_email").css({"border-top-left-radius":ui.value+"px","border-bottom-left-radius":ui.value+"px"});
				simplesp("#subscribe").css({"border-top-right-radius":ui.value+"px","border-bottom-right-radius":ui.value+"px"});
			reset_preset(ssp_id);
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_fcookie_days").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_fcookie_days_value" ).val().replace("Filled Cookie Days: ","");
	  	//initialize the opacity property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_fcookie_days" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			step: 1,
			max: 999,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_fcookie_days_value" ).val( "Filled Cookie Days: "+ui.value );
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_display_timer").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_display_timer_value" ).val().replace("Display Timer: ","").replace("sec","");
	  	//initialize the display timer property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_display_timer" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			step: 0.1,
			max: 360,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_display_timer_value" ).val( "Display Timer: "+ui.value + "sec" );
			}
			});
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_cookie_days").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().parent().attr("id");
	var thisvalue = simplesp( "#"+ssp_id+" .simple_subscription_popup_cookie_days_value" ).val().replace("Cookie Days: ","");
	  	//initialize the cookie days property slider
			simplesp( "#"+ssp_id+" .simple_subscription_popup_cookie_days" ).slider({
			range: "min",
			value: thisvalue,
			min: 0,
			max: 200,
			slide: function( event, ui ) {
				simplesp( "#"+ssp_id+" .simple_subscription_popup_cookie_days_value" ).val( "Cookie Days: "+ui.value );
			}
			});
	})

	
	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_preview1001").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().attr("id");
		simplesp("#"+ssp_id+" .simple_subscription_popup_preview1001").spectrum({
                move: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1001").css('background-color', rgba);
					if (simplesp("#mc_embed_signup #mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup #mc_embed_signup_inner form").css("background",rgba);
					reset_preset(ssp_id);
                },
                change: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1001").css('background-color', rgba);
					if (simplesp("#mc_embed_signup #mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup #mc_embed_signup_inner form").css("background",rgba);
					reset_preset(ssp_id);
                },
                showAlpha: true,
                color: simplesp(this).css("background-color"),
                clickoutFiresChange: true,
                showInput: true,
                showButtons: false
            });	
	})

	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_preview1002").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().attr("id");
		simplesp("#"+ssp_id+" .simple_subscription_popup_preview1002").spectrum({
                move: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1002").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner h2").css("color",rgba);
					reset_preset(ssp_id);
                },
                change: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1002").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner h2").css("color",rgba);
					reset_preset(ssp_id);
                },
                showAlpha: true,
                color: simplesp(this).css("background-color"),
                clickoutFiresChange: true,
                showInput: true,
                showButtons: false
            });	
	})
	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_preview1003").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().attr("id");
	simplesp("#"+ssp_id+" .simple_subscription_popup_preview1003").spectrum({
                move: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1003").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner p").css("color",rgba);
					reset_preset(ssp_id);
                },
                change: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1003").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner p").css("color",rgba);
					reset_preset(ssp_id);
                },
                showAlpha: true,
                color: simplesp(this).css("background-color"),
                clickoutFiresChange: true,
                showInput: true,
                showButtons: false
            });	
	})
	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_preview1004").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().attr("id");
	simplesp("#"+ssp_id+" .simple_subscription_popup_preview1004").spectrum({
                move: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1004").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner #subscribe").css("background",rgba);
					reset_preset(ssp_id);
                },
                change: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1004").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner #subscribe").css("background",rgba);
					reset_preset(ssp_id);
                },
                showAlpha: true,
                color: simplesp(this).css("background-color"),
                clickoutFiresChange: true,
                showInput: true,
                showButtons: false
            });	
	})
	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_preview1005").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().attr("id");
	simplesp("#"+ssp_id+" .simple_subscription_popup_preview1005").spectrum({
                move: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1005").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner #subscribe").css("color",rgba);
					reset_preset(ssp_id);
                },
                change: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1005").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner #subscribe").css("color",rgba);
					reset_preset(ssp_id);
                },
                showAlpha: true,
                color: simplesp(this).css("background-color"),
                clickoutFiresChange: true,
                showInput: true,
                showButtons: false
            });	
	})
	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_preview1006").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().attr("id");
	simplesp("#"+ssp_id+" .simple_subscription_popup_preview1006").spectrum({
                move: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1006").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_close").css("color",rgba);
					reset_preset(ssp_id);
                },
                change: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1006").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_close").css("color",rgba);
					reset_preset(ssp_id);
                },
                showAlpha: true,
                color: simplesp(this).css("background-color"),
                clickoutFiresChange: true,
                showInput: true,
                showButtons: false
            });	
	})
	simplesp("#simple_subscription_popup_accordion .simple_subscription_popup_preview1007").each(function( index ) {
	var ssp_id = simplesp(this).parent().parent().attr("id");
	simplesp("#"+ssp_id+" .simple_subscription_popup_preview1007").spectrum({
                move: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1007").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_close").css("color",rgba);
					reset_preset(ssp_id);
                },
                change: function(color) {
					var rgba = color.toRgbString();
					simplesp("#"+ssp_id+" .simple_subscription_popup_preview1007").css('background-color', rgba);
					if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_close").css("color",rgba);
					reset_preset(ssp_id);
                },
                showAlpha: true,
                color: simplesp(this).css("background-color"),
                clickoutFiresChange: true,
                showInput: true,
                showButtons: false
            });	
	})
			//bind event to change font family
		simplesp(".font_family").on("change", function(){
			if (simplesp(this).val()=="") simplesp("#ssp").css("font-family","");
			else
			{
				if (!simplesp("link[href='http://fonts.googleapis.com/css?family="+simplesp(this).val()+":400,700']").length) simplesp('head').append('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family='+simplesp(this).val()+':400,700" type="text/css" />');
				if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner h2").css("font-family",simplesp(this).val()+", serif");
			}
					reset_preset(simplesp(this).parent().parent().attr("id"));
		});
			//bind event to change content font family
		simplesp(".content_font_family").on("change", function(){
			if (simplesp(this).val()=="") simplesp("#ssp").css("font-family","");
			else
			{
				if (!simplesp("link[href='http://fonts.googleapis.com/css?family="+simplesp(this).val()+":400,700']").length) simplesp('head').append('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family='+simplesp(this).val()+':400,700" type="text/css" />');
				if (simplesp("#mc_embed_signup_inner").length!=0) simplesp("#mc_embed_signup_inner p, #mc_embed_signup_inner input").css("font-family",simplesp(this).val()+", serif");
			}
					reset_preset(simplesp(this).parent().parent().attr("id"));
		});
			//bind event to change preset
		simplesp(".preset").on("change", function(){
		var assp = simplesp(this).parent().parent().attr("id");
			set_preset(simplesp(this).val(),assp);
		});
	}
	
	function set_preset(prs,active_ssp)
	{
		if (prs=='custom') prs='current';
		if (typeof presets[prs] !== 'undefined') 
		{
			simplesp( "#"+active_ssp+" .simple_subscription_popup_font_size_value" ).val( "Font Size: "+presets[prs]['fontsize'] );
			simplesp( "#"+active_ssp+" .simple_subscription_popup_content_font_size_value" ).val( "Content Font Size: "+presets[prs]['contentfontsize'] );
			simplesp( "#"+active_ssp+" .simple_subscription_popup_border_radius_value" ).val( "Border Radius: "+presets[prs]['borderradius'] );
			simplesp( "#"+active_ssp+" .simple_subscription_popup_close_button_size_value" ).val( "Close Button Size: "+presets[prs]['closefontsize'] );
			simplesp( "#"+active_ssp+" .simple_subscription_popup_cmargin_value" ).val( "Fields Margin: "+presets[prs]['customfieldsmargin'] );
			simplesp( "#"+active_ssp+" .simple_subscription_popup_iborderradius_value" ).val( "Input Border Radius: "+presets[prs]['inputborderradius'] );
			simplesp("#"+active_ssp+" .simple_subscription_popup_preview1001").css('background-color', presets[prs]['bgcolor']);
			simplesp("#"+active_ssp+" .simple_subscription_popup_preview1007").css('background-color', presets[prs]['lockbgcolor']);
			simplesp("#"+active_ssp+" .simple_subscription_popup_preview1002").css('background-color', presets[prs]['color']);
			simplesp("#"+active_ssp+" .simple_subscription_popup_preview1003").css('background-color', presets[prs]['contentcolor']);
			simplesp("#"+active_ssp+" .simple_subscription_popup_preview1004").css('background-color', presets[prs]['buttonbgcolor']);
			simplesp("#"+active_ssp+" .simple_subscription_popup_preview1005").css('background-color', presets[prs]['buttoncolor']);
			simplesp("#"+active_ssp+" .simple_subscription_popup_preview1006").css('background-color', presets[prs]['closecolor']);
			simplesp("#"+active_ssp+" .font_family").val(presets[prs]['fontfamily']);
			simplesp("#"+active_ssp+" .content_font_family").val(presets[prs]['contentfontfamily']);
			initialize_sliders();			
		}
	}

	function reset_preset(active_ssp)
	{
		simplesp("#"+active_ssp+" .preset").val("custom");
	}
	
	function play_ssp()
	{
	if (simplesp( "#"+active_ssp+" .preset").val()=="custom")
	{
		presets['current'] = {
			customfieldsmargin:			''+simplesp( "#"+active_ssp+" .simple_subscription_popup_cmargin_value" ).val().replace("Fields Margin: ","")+'',
			bgcolor:					''+simplesp("#"+active_ssp+" .simple_subscription_popup_preview1001").css('background-color')+'',
			lockbgcolor:				''+simplesp("#"+active_ssp+" .simple_subscription_popup_preview1007").css('background-color')+'',
			buttonbgcolor:				''+simplesp("#"+active_ssp+" .simple_subscription_popup_preview1004").css('background-color')+'',
			buttoncolor:				''+simplesp("#"+active_ssp+" .simple_subscription_popup_preview1005").css('background-color')+'',
			closecolor:					''+simplesp("#"+active_ssp+" .simple_subscription_popup_preview1006").css('background-color')+'',
			closefontsize:				''+simplesp( "#"+active_ssp+" .simple_subscription_popup_close_button_size_value" ).val().replace("Close Button Size: ","")+'',
			color:						''+simplesp("#"+active_ssp+" .simple_subscription_popup_preview1002").css('background-color')+'',
			contentcolor:				''+simplesp("#"+active_ssp+" .simple_subscription_popup_preview1003").css('background-color')+'',
			fontfamily:					''+simplesp("#"+active_ssp+" .font_family").val()+'',
			contentfontfamily:			''+simplesp("#"+active_ssp+" .content_font_family").val()+'',
			contentfontsize:			''+simplesp( "#"+active_ssp+" .simple_subscription_popup_content_font_size_value" ).val().replace("Content Font Size: ","")+'',
			borderradius:				''+simplesp( "#"+active_ssp+" .simple_subscription_popup_border_radius_value" ).val().replace("Border Radius: ","")+'',
			inputborderradius:			''+simplesp( "#"+active_ssp+" .simple_subscription_popup_iborderradius_value" ).val().replace("Input Border Radius: ","")+'',
			fontsize:					''+simplesp( "#"+active_ssp+" .simple_subscription_popup_font_size_value" ).val().replace("Font Size: ","")+''
		}
	}
	simplesp("body").ssform('destroy');
	var ff, cff;
	if (simplesp("#"+active_ssp+" .font_family").val()!='') ff = simplesp("#"+active_ssp+" .font_family").val();
	else ff = '';
	if (simplesp("#"+active_ssp+" .content_font_family").val()!='') cff = simplesp("#"+active_ssp+" .content_font_family").val();
	else cff = '';
	if (simplesp( "#"+active_ssp+" .autoopen" ).val()==1) {var autoopen = true;}
	else {var autoopen = false;}
	if (simplesp( "#"+active_ssp+" .boldcontent" ).val()==1) {var boldcontent = 'bold';}
	else {var boldcontent = 'normal';}
	if (simplesp( "#"+active_ssp+" .atbottom" ).val()==1) {var atbottom = true;}
	else {var atbottom = false;}
	if (simplesp( "#"+active_ssp+" .boldtitle" ).val()==1) {var boldtitle = 'bold';}
	else {var boldtitle = 'normal';}
	if (simplesp( "#"+active_ssp+" .doubleoptin" ).val()==1) {var doubleoptin = true;}
	else {var doubleoptin = false;}
	if (simplesp( "#"+active_ssp+" .updateexisting" ).val()==1) {var updateexisting = true;}
	else {var updateexisting = false;}
	if (simplesp( "#"+active_ssp+" .replaceinterests" ).val()==1) {var replaceinterests = true;}
	else {var replaceinterests = false;}
	if (simplesp( "#"+active_ssp+" .sendwelcome" ).val()==1) {var sendwelcome = true;}
	else {var sendwelcome = false;}
	if (simplesp( "#"+active_ssp+" .onceperuser" ).val()==1) {var onceperuser = true;}
	else {var onceperuser = false;}
	if (simplesp( "#"+active_ssp+" .lock" ).val()==1) {var lock = true;}
	else {var lock = false;}
	if (simplesp( "#"+active_ssp+" .hidebutton" ).val()==1) {var hidebutton = true;}
	else {var hidebutton = false;}
	if (simplesp( "#"+active_ssp+" .closewithlayer" ).val()==1) {var closewithlayer = true;}
	else {var closewithlayer = false;}
		var customfsarray = new Array();
		var customfs = {};
		simplesp("#"+active_ssp+" .one-custom-field").each(function( index ) {
			if (simplesp(this).children(".cfid").val()!=''&&simplesp(this).children(".cfname").val())
			{
			customfs = {};
			if (simplesp(this).children(".cfrequired").val()=='1') {var thisreq = 'true';}
			else {var thisreq = 'false';}
			customfs.id = simplesp(this).children(".cfid").val();
			customfs.name = simplesp(this).children(".cfname").val();
			customfs.required = thisreq;
			customfs.warning = simplesp(this).children(".cfwarning").val();
			customfs.minlength = simplesp(this).children(".cfminlength").val();
				customfsarray.push(customfs);
			}
		});
		var formid = simplesp("#"+active_ssp+" .notemail").val();
	simplesp("body").ssform({
		animtime:					simplesp( "#"+active_ssp+" .simple_subscription_popup_animation_speed_value" ).val().replace("Animation Speed: ","").replace("sec",""),
		animation:					simplesp( "#"+active_ssp+" .animation" ).val(),
		customfields:				customfsarray,
		autoopen:					autoopen,
		facebook_appid:				simplesp( "#"+active_ssp+" .facebookappid" ).val(),
		googleplus_clientid:		simplesp( "#"+active_ssp+" .gplusclientid" ).val(),
		googleplus_apikey:			simplesp( "#"+active_ssp+" .gplusapikey" ).val(),
		inputborderradius:			simplesp( "#"+active_ssp+" .simple_subscription_popup_iborderradius_value" ).val().replace("Input Border Radius: ",""),
		customfieldsmargin:			simplesp( "#"+active_ssp+" .simple_subscription_popup_cmargin_value" ).val().replace("Fields Margin: ",""),
		mode:						simplesp("#"+active_ssp+" .mode").val(), 
		bgcolor:					simplesp("#"+active_ssp+" .simple_subscription_popup_preview1001").css("background-color"),
		buttonbgcolor:				simplesp("#"+active_ssp+" .simple_subscription_popup_preview1004").css("background-color"),
		buttoncolor:				simplesp("#"+active_ssp+" .simple_subscription_popup_preview1005").css("background-color"),	
		closecolor:					simplesp("#"+active_ssp+" .simple_subscription_popup_preview1006").css("background-color"),	
		closefontsize:				simplesp( "#"+active_ssp+" .simple_subscription_popup_close_button_size_value" ).val().replace("Close Button Size: ",""),
		color:						simplesp("#"+active_ssp+" .simple_subscription_popup_preview1002").css("background-color"),	
		contentcolor:				simplesp("#"+active_ssp+" .simple_subscription_popup_preview1003").css("background-color"),	
		fontfamily:					ff,
		bottomtitle:		  		simplesp("#"+active_ssp+" .bottomline").val(),
		closewithlayer:				closewithlayer,
		contentfontfamily:			cff,
		contentfontsize:			simplesp( "#"+active_ssp+" .simple_subscription_popup_content_font_size_value" ).val().replace("Content Font Size: ",""),
		contentweight:				boldcontent,
		title:			    		simplesp("#"+active_ssp+" .formtitle").val(),
		text:						simplesp("#"+active_ssp+" .formtext").val(),
		vspace:						simplesp( "#"+active_ssp+" .simple_subscription_popup_vertical_space_value" ).val().replace("Vertical Space: ",""),
		hspace:						simplesp( "#"+active_ssp+" .simple_subscription_popup_horizontal_space_value" ).val().replace("Horizontal Space: ",""),
		timer:						1000,
		position:					simplesp("#"+active_ssp+" .display_style").val(),
		invalid_address:			simplesp("#"+active_ssp+" .invalidemail").val(),
		signup_success:				simplesp("#"+active_ssp+" .successsignup").val(),
		borderradius:				simplesp( "#"+active_ssp+" .simple_subscription_popup_border_radius_value" ).val().replace("Border Radius: ",""),
		openbottom:					atbottom,
		fontsize:					simplesp( "#"+active_ssp+" .simple_subscription_popup_font_size_value" ).val().replace("Font Size: ",""),
		fontweight:					boldtitle,
		double_optin:				doubleoptin,
        update_existing:			updateexisting,
        replace_interests:			replaceinterests,
        send_welcome:				sendwelcome,
        mailchimp_listid:			simplesp( "#"+active_ssp+" .listid").val(),
		once_per_user:				onceperuser,
		cookie_days:				0,
		opacity:					simplesp( "#"+active_ssp+" .simple_subscription_popup_cmargin_value" ).val().replace("Fields Margin: ",""),
		subscribe_text:				simplesp( "#"+active_ssp+" .subscribe_text").val(),
		placeholder_text:			simplesp( "#"+active_ssp+" .placeholder_text").val(),
		path:						sspa_params.admin_url,
		lock:						lock,
		hideclose:					hidebutton,
		lockbgcolor:				simplesp("#"+active_ssp+" .simple_subscription_popup_preview1007").css("background-color"),
		preset:						simplesp("#"+active_ssp+" .preset").val(),
		formid:						formid
		});
	}
	
	simplesp("body").on( "click", ".play_button",function() {
	var s_id = simplesp(this).parent().parent().attr("id");
	active_ssp = s_id;
	play_ssp();
	})
	
	function add_signup_form()
{
		var error = "0";
		var ssp_id = Math.abs(simplesp("#ssp_name").val().split("").reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0));
		if (simplesp("#ssp_name").val()=="") error = "The form name can't be empty!";
		if (simplesp("#"+ssp_id).length>0) error = "This form name is already exist";
		if (error=="0")
		{
		simplesp("#new_form_content div:first").attr("id",ssp_id);
		simplesp("#new_form_content").find("span").attr("id","answers_"+ssp_id);
		simplesp("#error_log").text("");
		simplesp("#new_form_content").children("h3").text(simplesp("#ssp_name").val());
		simplesp(".accordion_ssp_header").attr("class","header_"+ssp_id);
		simplesp("#simple_subscription_popup_accordion").prepend(simplesp("#new_form_content").html());
		simplesp("#new_form_content .header_"+ssp_id).attr("class","accordion_ssp_header");
		simplesp( "#simple_subscription_popup_accordion" ).accordion("refresh" );
		simplesp("#new_form_content>div").attr("id","");
		simplesp( "#simple_subscription_popup_accordion" ).accordion({ active: 0 });
		simplesp("#"+ssp_id).prepend('<a>Shortcode: [ssf id='+ssp_id+']</a>');
		simplesp("#"+ssp_id).addClass('main_form_container');
		simplesp("#new_form_content").find("span").attr("id","");
		simplesp("#ssp_name").val("");
		initialize_sliders();
	
}
}
		simplesp( "#ssp_name" ).keypress(function( event ) {
	if ( event.which == 13 ) {
	event.preventDefault();
	add_signup_form();
	}
	});
  
  	simplesp('#add_new_ssp').click(function (event) {
	add_signup_form();
	});
	
  	simplesp(document).on("click", ".add_custom_fields", function () {
	var s_id = simplesp(this).parent().parent().attr("id");
	simplesp("#"+s_id+" .custom_field_section").append("<div class='one-custom-field'><input type='text' class='cfid simple_subscription_popup_tooltip' title='ID of input field, eg.: FNAME' value='' placeholder='ID'><input type='text' class='cfname simple_subscription_popup_tooltip' value='' title='Name of custom field, eg.: First Name' placeholder='Name'><input type='text' class='cfwarning simple_subscription_popup_tooltip' title='Warning text for the field if it is required, eg.: Firstname field is mandatory' value='' placeholder='Warning'><input type='text' class='cfminlength simple_subscription_popup_tooltip' title='Minimum character length for required field' value='' placeholder='0'><input type='checkbox' class='cfrequired simple_subscription_popup_tooltip' title='Check this if the field is mandatory' value='0'><img class='remove_cfield simple_subscription_popup_tooltip' title='Remove Custom Field' src='"+sspa_params.plugin_url+"/templates/assets/img/delete.png'></div>");
			initialize_tooltips();
	});
  	simplesp(document).on("click", ".remove_cfield", function () {
		simplesp(this).parent().remove();
	})
	 	simplesp("body").on( "click", ".global_signup, .autoopen, .atbottom, .boldcontent, .doubleoptin, .updateexisting, .replaceinterests, .onceperuser, .lock, .hidebutton, .boldtitle, .sendwelcome, .openwithlink, .once_per_filled, .closewithlayer, .cfrequired",function() {
		if (simplesp(this).val()==0) {simplesp(this).val("1");simplesp(this).attr("checked","checked");}
		else {simplesp(this).val("0");simplesp(this).removeAttr("checked","");}
	})
	
		simplesp("body").on( "click", ".save_form",function() {
		if (rmdni==false)
			{
			var ssp_id = simplesp(this).parent().parent().parent().attr("id");
			var buttonspan = simplesp(this).parent();
			var error = false;
			var checker;
			var answers_array = [];
			simplesp("#"+ssp_id+" .signup_error_span").html('');
			if (simplesp("#"+ssp_id+" .font_family").val()!='') {var ff = simplesp("#"+ssp_id+" .font_family").val();}
			else {var ff = '';}
			if (simplesp("#"+ssp_id+" .content_font_family").val()!='') {var cff = simplesp("#"+ssp_id+" .content_font_family").val();}
			else {var cff = '';}
			if (simplesp( "#"+ssp_id+" .autoopen" ).val()==1) {var autoopen = true;}
			else {var autoopen = false;}
			if (simplesp( "#"+ssp_id+" .boldcontent" ).val()==1) {var boldcontent = 'bold';}
			else {var boldcontent = 'normal';}
			if (simplesp( "#"+ssp_id+" .atbottom" ).val()==1) {var atbottom = true;}
			else {var atbottom = false;}
			if (simplesp( "#"+ssp_id+" .boldtitle" ).val()==1) {var boldtitle = 'bold';}
			else {var boldtitle = 'normal';}
			if (simplesp( "#"+ssp_id+" .doubleoptin" ).val()==1) {var doubleoptin = true;}
			else {var doubleoptin = false;}
			if (simplesp( "#"+ssp_id+" .updateexisting" ).val()==1) {var updateexisting = true;}
			else {var updateexisting = false;}
			if (simplesp( "#"+ssp_id+" .replaceinterests" ).val()==1) {var replaceinterests = true;}
			else {var replaceinterests = false;}
			if (simplesp( "#"+ssp_id+" .sendwelcome" ).val()==1) {var sendwelcome = true;}
			else {var sendwelcome = false;}
			if (simplesp( "#"+ssp_id+" .onceperuser" ).val()==1) {var onceperuser = true;}
			else {var onceperuser = false;}
			if (simplesp( "#"+ssp_id+" .lock" ).val()==1) {var lock = true;}
			else {var lock = false;}
			if (simplesp( "#"+ssp_id+" .hidebutton" ).val()==1) {var hidebutton = true;}
			else {var hidebutton = false;}
			if (simplesp( "#"+ssp_id+" .openwithlink" ).val()==1) {var openwithlink = true;}
			else {var openwithlink = false;}
			if (simplesp( "#"+ssp_id+" .once_per_filled" ).val()==1) {var once_per_filled = true;}
			else {var once_per_filled = false;}
			if (simplesp( "#"+ssp_id+" .closewithlayer" ).val()==1) {var closewithlayer = true;}
			else {var closewithlayer = false;}
					var customfsarray = new Array();
					var customfs = {};
					simplesp("#"+ssp_id+" .one-custom-field").each(function( index ) {
						if (simplesp(this).children(".cfid").val()!=''&&simplesp(this).children(".cfname").val())
						{
						customfs = {};
						if (simplesp(this).children(".cfrequired").val()=='1') {var thisreq = 'true';}
						else {var thisreq = 'false';}
						customfs.id = simplesp(this).children(".cfid").val();
						customfs.name = simplesp(this).children(".cfname").val();
						customfs.required = thisreq;
						customfs.warning = simplesp(this).children(".cfwarning").val();
						customfs.minlength = simplesp(this).children(".cfminlength").val();
							customfsarray.push(customfs);
						}
					});

			var options = [
			simplesp( "#"+ssp_id+" .simple_subscription_popup_animation_speed_value" ).val().replace("Animation Speed: ","").replace("sec",""),
			autoopen,
			simplesp("#"+ssp_id+" .mode").val(),
			simplesp("#"+ssp_id+" .simple_subscription_popup_preview1001").css("background-color"),
			simplesp("#"+ssp_id+" .simple_subscription_popup_preview1004").css("background-color"),
			simplesp("#"+ssp_id+" .simple_subscription_popup_preview1005").css("background-color"),
			simplesp("#"+ssp_id+" .simple_subscription_popup_preview1006").css("background-color"),
			simplesp( "#"+ssp_id+" .simple_subscription_popup_close_button_size_value" ).val().replace("Close Button Size: ",""),
			simplesp("#"+ssp_id+" .simple_subscription_popup_preview1002").css("background-color"),
			simplesp("#"+ssp_id+" .simple_subscription_popup_preview1003").css("background-color"),
			ff,
			cff,
			simplesp( "#"+ssp_id+" .simple_subscription_popup_content_font_size_value" ).val().replace("Content Font Size: ",""),
			boldcontent,
			simplesp("#"+ssp_id+" .formtitle").val(),
			simplesp("#"+ssp_id+" .formtext").val(),
			simplesp( "#"+ssp_id+" .simple_subscription_popup_vertical_space_value" ).val().replace("Vertical Space: ",""),
			simplesp( "#"+ssp_id+" .simple_subscription_popup_horizontal_space_value" ).val().replace("Horizontal Space: ",""),
			parseInt(simplesp( "#"+ssp_id+" .simple_subscription_popup_display_timer_value" ).val().replace("Display Timer: ","").replace("sec")),
			simplesp("#"+ssp_id+" .display_style").val(),
			simplesp("#"+ssp_id+" .invalidemail").val(),
			simplesp("#"+ssp_id+" .successsignup").val(),
			simplesp( "#"+ssp_id+" .simple_subscription_popup_border_radius_value" ).val().replace("Border Radius: ",""),
			atbottom,
			simplesp( "#"+ssp_id+" .simple_subscription_popup_font_size_value" ).val().replace("Font Size: ",""),
			boldtitle,
			doubleoptin,
			updateexisting,
			replaceinterests,
			sendwelcome,
			simplesp( "#"+ssp_id+" .listid").val(),
			onceperuser,
			simplesp( "#"+ssp_id+" .simple_subscription_popup_cookie_days_value" ).val().replace("Cookie Days: ",""),
			simplesp( "#"+ssp_id+" .simple_subscription_popup_cmargin_value" ).val().replace("Fields Margin: ",""),
			simplesp("#"+ssp_id+" .mailchimpapikey").val(),
			simplesp("#"+ssp_id+" .notemail").val(),
			simplesp( "#"+ssp_id+" .subscribe_text").val(),
			simplesp( "#"+ssp_id+" .placeholder_text").val(),
			lock,
			hidebutton,
			simplesp("#"+ssp_id+" .animation").val(),
			simplesp( "#"+ssp_id+" .simple_subscription_popup_fcookie_days_value" ).val().replace("Filled Cookie Days: ",""),
			simplesp( "#"+ssp_id+" .simple_subscription_popup_iborderradius_value" ).val().replace("Input Border Radius: ",""),
			simplesp("#"+ssp_id+" .facebookappid").val(),
			simplesp("#"+ssp_id+" .gplusclientid").val(),
			simplesp("#"+ssp_id+" .gplusapikey").val(),
			simplesp("#"+ssp_id+" .bottomline").val(),
			openwithlink,
			once_per_filled,
			closewithlayer,
			customfsarray,
			simplesp("#"+ssp_id+" .simple_subscription_popup_preview1007").css("background-color"),
			simplesp("#"+ssp_id+" .preset").val()
			];
			if (error==false)
			{
			rmdni = true;
		simplesp(buttonspan).html('<img width="20" style="margin-left:20px;" src="'+sspa_params.plugin_url+'/templates/assets/img/preloader.gif">');
		var data = {
				action: 'ajax_ssp',
				sspcmd: 'save',
				signup_form_id: ssp_id,
				form_name: simplesp(".header_"+ssp_id).text(),
				global_use: simplesp("#"+ssp_id+" .global_signup").val(),
				options: JSON.stringify( options )
				};
				checker = setTimeout(function(){if (simplesp(buttonspan).html()!='<input type="submit" name="save_form" class="save_form button button-primary button-small" value="SAVE">'||simplesp(buttonspan).html()!='<input type="submit" name="save_form" class="save_form button button-primary button-small" value="UPDATE">')
			{
			simplesp(buttonspan).html('<input type="submit" name="save_form" class="save_form button button-primary button-small" value="TRY AGAIN"><span style="margin-left: 35px;line-height:25px;color: #FC0303;">Error during the save process</span>')
			}
			},15000);
				simplesp.post(sspa_params.admin_url, data, function(response) {
				if (response=="success"||response=="updated") 
				{
				clearTimeout(checker);
				if (response=="success") var buttontext = "SAVE";
				else var buttontext = "UPDATE";
				if (simplesp("#"+ssp_id+" .notemail").val()=="") {simplesp("#"+ssp_id+" .signup_error_span").html("<small>Your Email Address is not specified yet!</small>");}
				simplesp(buttonspan).html('<span class="resp_text"><strong>'+buttontext+'D</strong></span>');
				setTimeout(function(){simplesp(buttonspan).html('<input type="submit" name="save_form" class="save_form button button-primary button-small" value="'+buttontext+'">')},2000);
				}
					rmdni = false;
				});
			
			};
			}
		});
	//customize end
    simplesp( "#dialog-confirm" ).dialog({
      resizable: false,
      height:220,
	  autoOpen: false,
      modal: true,
      buttons: {
        "Delete Form": function() {
		remove_form();
          simplesp( this ).dialog( "close" );
        },
        Cancel: function() {
          simplesp( this ).dialog( "close" );
        }
      }
    });
 		
	simplesp("body").on( "click", ".delete_form",function() {
		buttonspan_global = simplesp(this).parent();
		simplesp( "#dialog-confirm" ).dialog( "open" );
	})
	
	function remove_form()
{
		var ssp_id = simplesp(buttonspan_global).parent().parent().attr("id");
		var parent = simplesp("#"+ssp_id);
		var head = parent.prev('h3');
					rmdni = true;
			var data = {
				action: 'ajax_ssp',
				sspcmd: 'delete',
				signup_form_id: ssp_id
				};
				simplesp.post(sspa_params.admin_url, data, function(response) {
					rmdni = false;
				});

		parent.add(head).fadeOut('slow',function(){
		simplesp(this).remove();
		simplesp('html, body').animate({scrollTop: "0px"}, 1000, 'easeOutCirc',function(){simplesp("#ssp_name").focus();});
		});
}
	
		function initialize_tooltips()
	{
		simplesp(".simple_subscription_popup_tooltip").tooltip({
			  content: function () {
				  return simplesp(this).prop('title');
			  }
		  });	
	}
	simplesp("#wpbody-content .wrap").css("visibility","visible");
	simplesp("#screen_preloader").fadeOut("slow",function(){simplesp(this).remove();});
	simplesp('html, body').animate({scrollTop: "0px"}, 1000, 'easeOutCirc',function(){simplesp("#ssp_name").focus();});
})