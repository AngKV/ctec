jQuery(document).ready(function ($) {
	/**
	 * Presets Settings
	 * @param  {[type]} ) {               checkbox_values [checkbox value]
	 * @return {[type]}   [description]
	 * @since 1.0.9
	 * @version 1.1.3
	 */
	jQuery('.customize-control-checkbox-multiple input[type="radio"]').on('change', function () {

		checkbox_values = jQuery(this)
			.parents('.customize-control')
			.find('input[type="radio"]:checked')
			.val();

		style_values = jQuery(this)
			.parents('.customize-control')
			.find('input[type="radio"]:checked')
			.data('style');

		var val = [];
		val.push(checkbox_values);
		val.push(style_values);
		// console.log(val);
		jQuery(this)
			.parents('.customize-control')
			.find('input[type="hidden"]')
			.val(checkbox_values)
			.delay(500)
			.trigger('change');

	});

	jQuery.fn.removeCss = (function(){
		var rootStyle = document.documentElement.style;
		var remover = 
			rootStyle.removeProperty    // modern browser
			|| rootStyle.removeAttribute   // old browser (ie 6-8)
		return function removeCss(properties){
			if(properties == null)
				return this.removeAttr('style');
			proporties = properties.split(/\s+/);
			return this.each(function(){
				for(var i = 0 ; i < proporties.length ; i++)
					remover.call(this.style, proporties[i]);
			});
		};
	})();
}); // jQuery( document ).ready

(function ($) {
	function gs_login_find( finder = '#customize-preview iframe' ) {

		var customizer_finder = $('#customize-preview iframe').contents().find( finder );
		return customizer_finder;
	}

	 // function for change  CSS in real time...
	 function gs_login_new_css_property( setting, target, property, suffix ) {
		
		wp.customize( setting, function( value ) {
		  value.bind( function( newval ) {
	
			if ( newval == '' ) {
			  gs_login_find( target ).css( property, '' );
			} else {
			  gs_login_find( target ).css( property, newval + suffix );
			}
		  } );
		} );
	  } 

	  gs_login_new_css_property( 'gs_logo_padding', '#login h1 a', 'margin-bottom', 'px' );
	  gs_login_new_css_property( 'gs_form_height', '#loginform', 'min-height', 'px' );
	
	$(window).on('load', function() {
		// Overflow issue fixed in Customizer area
		$('#customize-preview iframe').contents().find('body').css('overflow', 'hidden');
		if ( gs_script.autoFocusPanel ) { 
			wp.customize.panel("gs_panel").focus();
		}
	});

	wp.customize('gs_logo', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find(' div#login h1 a').css( "background-image", 'url(' + newval + ')' );
		});
	});

	wp.customize('gs_logo_width', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find(' div#login h1 a').css("width", newval);
		});
	});

	wp.customize('gs_logo_height', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find(' div#login h1 a').css( "height", newval );
		});
	});

	// wp.customize( 'gs_logo_padding', function( value ) {
	// 	value.bind( function( newval ) {
	// 	
	// 		$('#customize-preview iframe').contents().find(' .login h1 a').css(
    //           "margin-bottom", newval);
	// 	} );
	// } );

	wp.customize('gs_logo_hide', function (value) {
		value.bind(function (newval) {
			if (newval == 1) {
				$('#customize-preview iframe').contents().find(' body.login div#login h1 a').css( "display", 'none' );
			} else {
				$('#customize-preview iframe').contents().find(' body.login div#login h1 a').css( "display", 'block' );
			}
		});
	});


	// Background

	wp.customize('gs_bg_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('body.login').css( "background-color", newval );
		});
	});

	wp.customize( 'gs_bg_image', function( value ) {
		value.bind( function( newval ) {
			if( newval == '' ){
				$('#customize-preview iframe').contents().find('body.login').css(
              "background-image", 'none');
				
			}else{
				$('#customize-preview iframe').contents().find('body.login').css(
              "background-image", 'url('+newval+')');
			}
		} );
	} );
	wp.customize( 'gs_back_hide', function( value ) {
		value.bind( function( newval ) {
			if( newval == 1 ){
				$('#customize-preview iframe').contents().find('body.login').css(
              "background-image", 'none');
			}else{
				if(gs_script.bgBack){
					$('#customize-preview iframe').contents().find('body.login').css(
						"background-image", 'url('+gs_script.bgBack+')');
				}else{
					$('#customize-preview iframe').contents().find('body.login').css(
						"background-image", 'url('+gs_script.tm1bg+')');
				}
				
			}
		} );
	} );

	wp.customize('gs_bg_repeat', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('body.login').css( "background-repeat", newval );
		});
	});

	wp.customize('gs_background_position', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('body.login').css( "background-position", newval );
		});
	});

	wp.customize('gs_bg_size', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('body.login').css( "background-size", newval );
		});
	});

	//form bg

	wp.customize('gs_form_bg_image', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "background-image", 'url(' + newval + ')' );
		});
	});

	wp.customize('gs_form_bg_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "background-color", newval );
		});
	});

	wp.customize('gs_form_bg_repeat', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "background-repeat", newval );
		});
	});

	wp.customize('gs_form_bg_position', function (value) {
		value.bind(function (newval) {

			$('#customize-preview iframe').contents().find('#loginform').css(
				"background-position", newval);
		});
	});
	wp.customize('gs_form_bg_size', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "background-size", newval );
		});
	});


	//form style

	wp.customize('gs_form_width', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "width", newval );
		});
	});

	wp.customize('gs_form_padding', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "padding", newval );
		});
	});

	wp.customize('gs_form_border_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "border-color", newval );
		});
	});

	wp.customize('gs_form_border_thick', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "border-width", newval + 'px' );
		});
	});

	wp.customize('gs_form_border_style', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "border-style", newval );
		});
	});

	wp.customize('gs_form_border_radius', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('#loginform').css( "border-radius", newval + 'px' );
		});
	});
	wp.customize( 'gs_form_font_sizes', function( value ) {
		value.bind( function( newval ) {

			$('#customize-preview iframe').contents().find('.login #loginform label,.login #login #backtoblog a, .login #login #nav a').css(
              "font-size", newval+'px');
		} );
	} );


	// form field style

	wp.customize('gs_field_width', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login form#loginform .input, .login #loginform input[type="text"]').css( "width", newval + '%' );
		});
	});

	wp.customize('gs_field_margin', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login form#loginform .input, .login #loginform input[type="text"]').css( "margin", newval );
		});
	});

	wp.customize('gs_field_bg', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login form#loginform .input, .login #loginform input[type="text"]').css( "background", newval );
		});
	});

	wp.customize('gs_field_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find(' .login form#loginform .input,  .login #loginform input[type="text"]').css( "color", newval );
		});
	});

	wp.customize('gs_field_label', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login #loginform label').css( "color", newval );
		});
	});

	wp.customize('gs_field_border_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login form#loginform .input, .login form#loginform input[type="text"], .login form#loginform input[type="password"]').css( "border-color", newval );
		});
	});

	wp.customize('gs_form_field_border_style', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login form#loginform .input, .login form#loginform input[type="text"], .login form#loginform input[type="password"]').css( "border-style", newval );
		});
	});
	wp.customize('gs_form_field_border_thick', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login form#loginform .input, .login form#loginform input[type="text"], .login form#loginform input[type="password"]').css( "border-width", newval + 'px' );
		});
	});

	// button
	wp.customize('gs_button_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find(' .wp-core-ui #loginform .button-primary').css( "color", newval );
		});
	});

	wp.customize('gs_button_bg', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find(' .wp-core-ui #loginform .button-primary').css( "background", newval );
		});
	});

	wp.customize('gs_button_border', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find(' .wp-core-ui #loginform .button-primary').css( "border-color", newval );
		});
	});
	
	wp.customize('gs_button_hover_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.wp-core-ui #loginform .button-primary').hover(function () {
				$(this).css('color', newval);
			}, function () {
				$(this).css('color', '');
			});
		});
	});

	wp.customize('gs_button_hover_bg', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.wp-core-ui #loginform .button-primary').hover(function () {
				$(this).css('background', newval);
			}, function () {
				$(this).css('background', '');
			});
		});
	});

	wp.customize('gs_button_hover_border', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.wp-core-ui #loginform .button-primary').hover(function () {
				$(this).css('border-color', newval);
			}, function () {
				$(this).css('border-color', '');
			});
		});
	});



	// footer 
	// 

	wp.customize( 'gs_footer_display_text', function( value ) {
		value.bind( function( newval ) {

			$('#customize-preview iframe').contents().find('.login #nav').css(
              "display", newval);
		} );
	} );
	wp.customize( 'gs_back_display_text', function( value ) {
		value.bind( function( newval ) {

			$('#customize-preview iframe').contents().find('.login #backtoblog').css(
              "display", newval);
		} );
	} );

	wp.customize( 'gs_login_footer_text', function( value ) {
		value.bind( function( newval ) {
		
			$('#customize-preview iframe').contents().find('#nav a').html( newval );
			// $( '#nav a' ).html( newval );
		} );
	} );


	wp.customize('gs_other_color', function (value) {
		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('.login #login #backtoblog a, .login #login #nav a').css( "color", newval );
		});
	});

	wp.customize('gs_other_color_hover', function (value) {

		value.bind(function (newval) {

			$('#customize-preview iframe').contents().find('.login #nav a, .login #backtoblog a, .login .gs-body-login h1 a').hover(function () {
				$(this).css('color', newval);
			}, function () {
				$(this).css('color', '');
			});

		});

	});

	// other section

	wp.customize( 'gscusl-login-icons', function( value ) {
		value.bind( function( newval ) {
		
			$('#customize-preview iframe').contents().find('.gs-icons').css(
              "display", newval);
		} );
	} );

	wp.customize('gscusl-form-position', function (value) {

		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('body').removeClass (function (index, className) {
				return (className.match (/(^|\s)gscusl-formpos__gscusl_\S+/g) || []).join(' ');
			}).addClass( 'gscusl-formpos__' + newval );
		});

	});

	wp.customize('gs_other_css', function (value) {

		value.bind(function (newval) {
			$('#customize-preview iframe').contents().find('style#gs-login--custom-style').remove().end().find('head').append('<style type="text/css" id="gs-login--custom-style">'+newval+'</style>');
		});

	});

})(jQuery);