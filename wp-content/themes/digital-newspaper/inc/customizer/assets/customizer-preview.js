/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

 ( function( $ ) {
	const themeContstants = {
		prefix: 'digital_newspaper_'
	}
	const themeCalls = {
		digitalNewspaperAjaxCall: function( action, id ) {
			$.ajax({
				method: "GET",
				url: digitalNewspaperPreviewObject.ajaxUrl,
				data: ({
					action: action,
					_wpnonce: digitalNewspaperPreviewObject._wpnonce
				}),
				success: function(response) {
					if( response ) {
						if( $( "head #" + id ).length > 0 ) {
							$( "head #" + id ).html( response )
						} else {
							$( "head" ).append( '<style id="' + id + '">' + response + '</style>' )
						}
					}
				}
			})
		},
		digitalNewspaperGenerateStyleTag: function( code, id ) {
			if( code ) {
				if( $( "head #" + id ).length > 0 ) {
					$( "head #" + id ).html( code )
				} else {
					$( "head" ).append( '<style id="' + id + '">' + code + '</style>' )
				}
			}
		},
		digitalNewspaperGenerateLinkTag: function( action, id ) {
			$.ajax({
				method: "GET",
				url: digitalNewspaperPreviewObject.ajaxUrl,
				data: ({
					action: action,
					_wpnonce: digitalNewspaperPreviewObject._wpnonce
				}),
				success: function(response) {
					if( response ) {
						if( $( "head #" + id ).length > 0 ) {
							$( "head #" + id ).attr( "href", response )
						} else {
							$( "head" ).append( '<link rel="stylesheet" id="' + id + '" href="' + response + '"></link>' )
						}
					}
				}
			})
		}
	}

	// site block border top
	wp.customize( 'website_block_border_top_option', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$( "body" ).removeClass( "digital_newspaper_site_block_border_top" )
				$( "body" ).addClass( "digital_newspaper_site_block_border_top" )
			} else {
				$( "body" ).removeClass( "digital_newspaper_site_block_border_top" )
			}
		});
	});

	// post title hover class
	wp.customize( 'post_title_hover_effects', function( value ) {
		value.bind( function(to) {
				$( "body" ).removeClass( "digital-newspaper-title-none digital-newspaper-title-one digital-newspaper-title-four" )
				$( "body" ).addClass( "digital-newspaper-title-" + to )
		});
	});

	// website layout class
	wp.customize( 'website_layout', function( value ) {
		value.bind( function(to) {
				$( "body" ).removeClass( "site-boxed--layout site-full-width--layout" )
				$( "body" ).addClass( "site-" + to )
		});
	});

	// block title layouts class
	wp.customize( 'website_block_title_layout', function( value ) {
		value.bind( function(to) {
				$( "body" ).removeClass( "block-title--layout-one block-title--layout-two block-title--layout-three block-title--layout-four block-title--layout-five" )
				$( "body" ).addClass( "block-title--" + to )
		});
	});

	// image hover class
	wp.customize( 'site_image_hover_effects', function( value ) {
		value.bind( function(to) {
				$( "body" ).removeClass( "digital-newspaper-image-hover--effect-six" )
				$( "body" ).addClass( "digital-newspaper-image-hover--effect-" + to )
		});
	});
	
	// site block border top changes
	wp.customize( 'website_block_border_top_color', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.blockBorderStyles()
		});
	});
	
	// theme color bind changes
	wp.customize( 'theme_color', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-color-style', '--theme-color-red')
		});
	});

	// preset 1 bind changes
	wp.customize( 'preset_color_1', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-1-style', '--digital-newspaper-global-preset-color-1')
		});
	});

	// preset 2 bind changes
	wp.customize( 'preset_color_2', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-2-style', '--digital-newspaper-global-preset-color-2')
		});
	});

	// preset 3 bind changes
	wp.customize( 'preset_color_3', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-3-style', '--digital-newspaper-global-preset-color-3')
		});
	});

	// preset 4 bind changes
	wp.customize( 'preset_color_4', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-4-style', '--digital-newspaper-global-preset-color-4')
		});
	});

	// preset 5 bind changes
	wp.customize( 'preset_color_5', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-5-style', '--digital-newspaper-global-preset-color-5')
		});
	});

	// preset 6 bind changes
	wp.customize( 'preset_color_6', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-6-style', '--digital-newspaper-global-preset-color-6')
		});
	});

	// preset gradient 1 bind changes
	wp.customize( 'preset_gradient_1', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-1-style', '--digital-newspaper-global-preset-gradient-color-1')
		});
	});

	// preset gradient 2 bind changes
	wp.customize( 'preset_gradient_2', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-2-style', '--digital-newspaper-global-preset-gradient-color-2')
		});
	});

	// preset gradient 3 bind changes
	wp.customize( 'preset_gradient_3', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-3-style', '--digital-newspaper-global-preset-gradient-color-3')
		});
	});

	// preset gradient 4 bind changes
	wp.customize( 'preset_gradient_4', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-4-style', '--digital-newspaper-global-preset-gradient-color-4')
		});
	});

	// preset gradient 5 bind changes
	wp.customize( 'preset_gradient_5', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-5-style', '--digital-newspaper-global-preset-gradient-color-5')
		});
	});

	// preset gradient 6 bind changes
	wp.customize( 'preset_gradient_6', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-6-style', '--digital-newspaper-global-preset-gradient-color-6')
		});
	});

	// top header styles
	wp.customize( 'top_header_background_color_group', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.topHeaderStyles()
		});
	});

	// header styles
	wp.customize( 'header_vertical_padding', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerStyles()
		});
	});
	wp.customize( 'header_background_color_group', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerStyles()
		});
	});
	
	// header menu typography
	wp.customize( 'header_menu_typo', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerMenuTypoStyles()
		});
	});
	wp.customize( 'header_sub_menu_typo', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.headerMenuTypoStyles()
		});
	});

	// header menu hover effect 
	wp.customize( 'header_menu_hover_effect', function( value ) {
		value.bind( function(to) {
			$( "#site-navigation" ).removeClass( "hover-effect--one hover-effect--none" )
			$( "#site-navigation" ).addClass( "hover-effect--" + to )
		});
	});

	// logo width
	wp.customize( 'digital_newspaper_site_logo_width', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.siteLogoStyles()
		});
	});
	
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	});
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	});
	// blog description
	wp.customize( 'blogdescription_option', function( value ) {
		value.bind(function(to) {
			if( to ) {
				$( '.site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
			} else {
				$( '.site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			}
		})
	});

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a' ).css( {
					color: to,
				} );
			}
		} );
	});

	// site description color
	wp.customize( 'site_description_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css( {
				color: to,
			});
		} );
	});

	// site title typo
	wp.customize( 'site_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.siteTitleTypo()
		})
	})
	
	// bottom footer menu option
	wp.customize( 'bottom_footer_menu_option', function( value ) {
		value.bind( function( to ) {
			if( to ) {
				$( '.bottom-footer .bottom-menu' ).show()
			} else {
				$( '.bottom-footer .bottom-menu' ).hide()
			}
		});
	});

	// single post related posts title
	wp.customize( 'single_post_related_posts_title', function( value ) {
		value.bind( function( to ) {
			$( '.single-related-posts-section .digital-newspaper-block-title span' ).text( to );
		} );
	});

	// footer width option
	wp.customize( 'footer_section_width', function( value ) {
		value.bind( function( to ) {
			if( to == 'boxed-width' ) {
				$( 'footer .main-footer' ).removeClass( 'full-width' ).addClass( 'boxed-width' );
				$( 'footer .main-footer .footer-inner' ).removeClass( 'digital-newspaper-container-fluid' ).addClass( 'digital-newspaper-container' );
			} else {
				$( 'footer .main-footer' ).removeClass( 'boxed-width' ).addClass( 'full-width' );
				$( 'footer .main-footer .footer-inner' ).removeClass( 'digital-newspaper-container' ).addClass( 'digital-newspaper-container-fluid' );
			}
		});
	});

	// single post page typo styles
	wp.customize( 'single_post_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.singlePostTypo()
		});
	});
	wp.customize( 'single_post_meta_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.singlePostTypo()
		});
	});
	wp.customize( 'single_post_content_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.singlePostTypo()
		});
	});

	// typography 
	wp.customize( 'site_section_block_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.siteArchiveTypo()
		});
	});
	wp.customize( 'site_archive_post_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.siteArchiveTypo()
		});
	});
	wp.customize( 'site_archive_post_meta_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.siteArchiveTypo()
		});
	});
	wp.customize( 'site_archive_post_content_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.siteArchiveTypo()
		});
	});

	// check if string is variable and formats 
	function digital_newspaper_get_color_format(color) {
		if( color.indexOf( '--digital-newspaper-global-preset' ) >= 0 ) {
			return( 'var( ' + color + ' )' );
		} else {
			return color;
		}
	}

	// constants
	const ajaxFunctions = {
		typoFontsEnqueue: function() {
			var action = themeContstants.prefix + "typography_fonts_url",id ="digital-newspaper-customizer-typo-fonts-css"
			themeCalls.digitalNewspaperGenerateLinkTag( action, id )
		},
		blockBorderStyles : function() {
			var action = themeContstants.prefix + "customizer_site_block_border_top",id ="digital-newspaper-site-block-border-top-styles"
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
		siteLogoStyles : function() {
			var action = themeContstants.prefix + "site_logo_styles",id ="digital-newspaper-site-logo-styles"
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
		siteTitleTypo : function() {
			var action = themeContstants.prefix + "site_title_typo",id ="digital-newspaper-site-title-typo"
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
		singlePostTypo : function() {
			var action = themeContstants.prefix + "single_typo__styles",id ="digital-newspaper-single-post-typo"
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
		siteArchiveTypo : function() {
			var action = themeContstants.prefix + "site_archive_typo__styles",id ="digital-newspaper-site-archive-post-typo"
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
		topHeaderStyles : function() {
			var action = themeContstants.prefix + "top_header_styles",id ="digital-newspaper-top-header-styles"
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
		headerStyles : function() {
			var action = themeContstants.prefix + "header_styles",id ="digital-newspaper-header-styles"
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
		headerMenuTypoStyles : function() {
			var action = themeContstants.prefix + "header_menu_typo",id ="digital-newspaper-header-menu-typo"
			ajaxFunctions.typoFontsEnqueue()
			themeCalls.digitalNewspaperAjaxCall( action, id )
		},
	}

	// constants
	const helperFunctions = {
		generateStyle: function(color, id, variable) {
			if(color) {
				if( id == 'theme-color-style' ) {
					var styleText = 'body.digital_newspaper_main_body, body.digital_newspaper_dark_mode { ' + variable + ': ' + helperFunctions.getFormatedColor(color) + '}';
				} else {
					var styleText = 'body.digital_newspaper_main_body { ' + variable + ': ' + helperFunctions.getFormatedColor(color) + '}';
				}
				if( $( "head #" + id ).length > 0 ) {
					$( "head #" + id).text( styleText )
				} else {
					$( "head" ).append( '<style id="' + id + '">' + styleText + '</style>' )
				}
			}
		},
		getFormatedColor: function(color) {
			if( color == null ) return
			if( color.includes('preset') ) {
				return 'var(' + color + ')'
			} else {
				return color
			}
		}
	}
}( jQuery ) );