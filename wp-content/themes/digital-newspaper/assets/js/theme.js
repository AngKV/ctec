/**
 * Handles theme general events
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
jQuery(document).ready(function($) {
    "use strict"
    var ajaxUrl = digitalNewspaperObject.ajaxUrl, _wpnonce = digitalNewspaperObject._wpnonce, sttOption = digitalNewspaperObject.stt, query_vars = digitalNewspaperObject.query_vars, paged = digitalNewspaperObject.paged, stickeyHeader = digitalNewspaperObject.sticky_header;

    setTimeout(function() {
        $('body .digital_newspaper_loading_box').hide();
    }, 3000);

    var nrtl = false
    var ndir = "left"
    if ($('body').hasClass("rtl")) {
        nrtl = true;
        ndir = "right";
    };
    
    // theme trigger modal close
    function digitalNewspaperclosemodal( elm, callback ) {
        $(document).mouseup(function (e) {
            var container = $(elm);
            if (!container.is(e.target) && container.has(e.target).length === 0) callback();
        });
    }

    // ticker news slider events
    var tc = $( ".ticker-news-wrap" );
    if( tc.length ) {
        var tcM = tc.find( ".ticker-item-wrap" ).marquee({
            duration: 40000,
            gap: 0,
            delayBeforeStart: 0,
            direction: ndir,
            duplicated: true,
            startVisible: true,
            pauseOnHover: true,
        });
        tc.on( "click", ".digital-newspaper-ticker-pause", function() {
            $(this).find( "i" ).toggleClass( "fa-pause fa-play" )
            tcM.marquee( "toggle" );
        })
    }

    // top date time
    var timeElement = $( ".top-date-time .time" )
    if( timeElement.length > 0 ) {
        setInterval(function() {
            timeElement.html(new Date().toLocaleTimeString())
        },1000);
    }
    
    // search form and sidebar toggle trigger
    $( "#masthead" ).on( "click", ".sidebar-toggle-trigger", function() {
        $(this).addClass('slideshow');
        $('body').addClass('body_show_sidetoggle');
    });
    $( "#masthead" ).on( "click", ".sidebar-toggle-trigger.slideshow, .sidebar-toggle .sidebar-toggle-close, .search_close_btn", function() {
        $('.sidebar-toggle-trigger').removeClass('slideshow');
        $('body').removeClass('body_show_sidetoggle');
    });

     // search form 
    $( "#masthead" ).on( "click", ".search-trigger", function() {
        $(this).next().slideDown();
        $(this).addClass('slideshow');
        $('body').addClass('bodynoscroll');
    });
    
    $( "#masthead" ).on( "click", ".search-trigger.slideshow", function() {
        $(this).next().slideUp();
        $(this).removeClass('slideshow');
        $('body').removeClass('bodynoscroll');
    });

    $( ".search-popup--style-three #masthead" ).on( "click", ".search-trigger", function() {
        $(this).next().slideDown();
        $(this).addClass('slideshow');
        $('body').addClass('bodynoscroll');
        $('.search-popup--style-three #masthead .search-form-wrap form input[type="search"]').focus()
    });

    $( ".search-popup--style-three #masthead" ).on( "click", ".search_close_btn", function() {
        $(this).prev().slideUp();
        $(this).prev().prev().removeClass('slideshow');
        $('body').removeClass('bodynoscroll');
        $("#masthead .search-wrap").find(".search-results-wrap").remove()
        $("#masthead .search-wrap").removeClass( 'results-loaded' )
    });

    $( "#masthead" ).on( "click", ".search_close_btn", function() {
        $(this).prev().fadeOut();
        $(this).prev().prev().removeClass('slideshow');
        $('body').removeClass('bodynoscroll');
        $("#masthead .search-wrap").find(".search-results-wrap").remove()
        $("#masthead .search-wrap").removeClass( 'results-loaded' )
    });

    // live search
    if( digitalNewspaperObject.livesearch ) {
        var searchContainer = $("#masthead .search-wrap")
        if( searchContainer.length > 0 ) {
            var searchFormContainer = searchContainer.find("form")
            searchContainer.on( 'change, keyup', 'input[type="search"]', function() {
                var searchKey = $(this).val()
                if(searchKey) {
                    $.ajax({
                        method: 'post',
                        url: ajaxUrl,
                        data: {
                            action: 'digital_newspaper_search_posts_content',
                            search_key : searchKey.trim(),
                            _wpnonce: _wpnonce
                        },
                        beforeSend: function() {
                            searchFormContainer.addClass( 'retrieving-posts' );
                            searchFormContainer.removeClass( 'results-loaded' )
                        },
                        success : function(res) {
                            var parsedRes = JSON.parse(res)
                                searchContainer.find(".search-results-wrap").remove()
                                searchFormContainer.after(parsedRes.posts)
                                searchFormContainer.removeClass( 'retrieving-posts' );
                                searchFormContainer.removeClass( 'retrieving-posts' ).addClass( 'results-loaded' );
                        },
                        complete: function() {
                            // render search content here
                        }
                    })
                } else {
                    searchContainer.find(".search-results-wrap").remove()
                    searchFormContainer.removeClass( 'results-loaded' )
                }
            })
        }
    }

    digitalNewspaperclosemodal( $( ".search-wrap" ), function () {
        $( ".search-wrap .search-trigger" ).removeClass( "slideshow" );
        $( ".search-form-wrap" ).slideUp();
        $('body').removeClass('bodynoscroll');
    }); // trigger search close


    digitalNewspaperclosemodal( $( ".sidebar-toggle-wrap" ), function () {
        $( ".sidebar-toggle-wrap .sidebar-toggle-trigger" ).removeClass( "slideshow" );
        $('body').removeClass('body_show_sidetoggle');
    }); // trigger htsidebar close

    digitalNewspaperclosemodal( $( ".newsletter-popup-modal" ), function () {
        $( ".newsletter-popup-modal" ).removeClass( "open" );
        $("body").removeClass("newsletter-popup-active")
    }); // trigger header newsletter popup close

    // header newsletter popup handler
    var nPopup = $( ".newsletter-element" )
    if( nPopup.length > 0 ) {
        var nPopupType = nPopup.find( "a" ).data("popup")
        if( nPopupType == 'popup' ) {
            nPopup.on( "click", "a", function(e) {
                e.preventDefault()
                var _this = $(this)
                $("body").addClass("newsletter-popup-active")
                _this.next(".newsletter-popup-modal").addClass("open")
            })
        }
        $(document).on( "click", ".newsletter-popup-modal.open .modal-close", function () {
            $( ".newsletter-popup-modal" ).removeClass( "open" );
            $("body").removeClass("newsletter-popup-active")
        }); // trigger header newsletter popup close
    }

    // top header ticker news slider events
    var thtn = $( ".top-ticker-news" );
    if( thtn.length ) {
        var thtnitems = thtn.find(".ticker-item-wrap")
        thtnitems.slick({
            dots: false,
            infinite: true,
            rtl: nrtl,
            vertical: true,
            arrows: true,
            autoplay: true,
            nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
            prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
        });
    }

    // main banner slider events
    var bc = $( "#main-banner-section" );
    if( bc.length ) {
        var bic = bc.find( ".main-banner-slider" )
        bic.slick({
            dots: true,
            infinite: true,
            rtl: nrtl,
            arrows: true,
            autoplay: true,
            nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
            prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
        });
    }

    // banner-tabs
    var bptc = bc.find( ".main-banner-tabs" )
    bptc.on( "click", ".banner-tabs li.banner-tab", function() {
        var _this = $(this), tabItem = _this.attr( "tab-item" );
        _this.addClass( "active" ).siblings().removeClass( "active" );
        bptc.find( '.banner-tabs-content div[tab-content="' + tabItem + '"]' ).addClass( "active" ).siblings().removeClass( "active" );
    })

    // main banner popular posts slider events
    var bpc = bc.find( ".popular-posts-wrap" );
    if( bpc.length ) {
        var bpcAuto = bpc.data( "auto" )
        var bpcArrows = bpc.data( "arrows" )
        var bpcVertical = bpc.data( "vertical" );
        if( bpcVertical) {
            bpc.slick({
                vertical: bpcVertical,
                slidesToShow: 4,
                dots: false,
                infinite: true,
                arrows: bpcArrows,
                autoplay: bpcAuto,
                nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
            })
        } else {
            bpc.slick({
                dots: false,
                infinite: true,
                arrows: bpcArrows,
                rtl: nrtl,
                draggable: true,
                autoplay: bpcAuto,
                nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
            })
        }  
    }

    // main banner layout five grid posts slider events
    var bpc = bc.find( ".main-banner-grid-posts .grid-posts-wrap" );
    if( bpc.length ) {
        var bpcVertical = bpc.data( "vertical" );
        if( bpcVertical) {
            bpc.slick({
                vertical: bpcVertical,
                slidesToShow: 3,
                dots: false,
                infinite: true,
                arrows: true,
                autoplay: true,
                nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
            })
        } else {
            bpc.slick({
                dots: false,
                infinite: true,
                arrows: bpcArrows,
                rtl: nrtl,
                draggable: true,
                autoplay: bpcAuto,
                nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
            })
        }  
    }

    // news carousel events
    var nc = $( ".digital-newspaper-section .news-carousel .news-carousel-post-wrap" );
    if( nc.length ) {
        nc.each(function() {
            var _this = $(this)
            var ncDots= _this.data("dots") == '1'
            var ncLoop= _this.data("loop") == '1'
            var ncArrows= _this.data("arrows") == '1'
            var ncAuto  = _this.data("auto") == '1'
            var ncColumns  = _this.data("columns")
            _this.slick({
                dots: ncDots,
                infinite: ncLoop,
                arrows: ncArrows,
                autoplay: ncAuto,
                rtl: nrtl,
                slidesToShow: ncColumns,
                nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
                responsive: [
                  {
                    breakpoint: 1100,
                    settings: {
                      slidesToShow: 3,
                    },
                  },
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 2,
                    },
                  },
                  {
                    breakpoint: 640,
                    settings: {
                      slidesToShow: 1,
                    },
                  }
                ]
            });
        })
    }
    
    // Filter posts
     $( ".digital-newspaper-section .news-filter" ).each(function() {
        var $scope = $(this), $scopeOptions = $scope.data("args"), newTabs = $scope.find( ".filter-tab-wrapper" ), newTabsContent = $scope.find( ".filter-tab-content-wrapper" );
        newTabs.on( "click", ".tab-title", function() {
          var a = $(this), aT = a.data("tab")
          a.addClass( "isActive" ).siblings().removeClass( "isActive" );
          if( newTabsContent.find( ".tab-content.content-" + aT ).length < 1 ) {
            $scopeOptions.category_name = aT
            $.ajax({
                method: 'get',
                url: ajaxUrl,
                data: {
                    action: 'digital_newspaper_filter_posts_load_tab_content',
                    options : JSON.stringify( $scopeOptions ),
                    _wpnonce: _wpnonce
                },
                beforeSend: function() {
                    $scope.addClass( 'retrieving-posts' );
                },
                success : function(res) {
                    var parsedRes = JSON.parse(res)
                    if( parsedRes.loaded ) {
                        newTabsContent.append(parsedRes.posts)
                        $scope.removeClass( 'retrieving-posts' );
                    }
                },
                complete: function() {
                    newTabsContent.find( ".tab-content.content-" + aT ).show().siblings().hide()
                }
            })
          } else {
            newTabsContent.find( ".tab-content.content-" + aT ).show().siblings().hide()
          }
        })
    })

    // popular posts widgets
    var ppWidgets = $( ".digital-newspaper-widget-popular-posts" )
    ppWidgets.each(function() {
        var _this = $(this), parentWidgetContainerId = _this.parents( ".widget.widget_digital_newspaper_popular_posts_widget" ).attr( "id" ), parentWidgetContainer = $( "#" + parentWidgetContainerId )
        var ppWidget = parentWidgetContainer.find( ".popular-posts-wrap" );
        if( ppWidget.length > 0 ) {
            var ppWidgetAuto = ppWidget.data( "auto" )
            var ppWidgetArrows = ppWidget.data( "arrows" )
            var ppWidgetLoop = ppWidget.data( "loop" )
            var ppWidgetVertical = ppWidget.data( "vertical" )
            if( ppWidgetVertical == 'vertical' ) {
                ppWidget.slick({
                    vertical: true,
                    slidesToShow: 4,
                    dots: false,
                    infinite: ppWidgetLoop,
                    arrows: ppWidgetArrows,
                    autoplay: ppWidgetAuto,
                    nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                    prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`
                })
            } else {
                ppWidget.slick({
                    dots: false,
                    infinite: ppWidgetLoop,
                    rtl: nrtl,
                    arrows: ppWidgetArrows,
                    autoplay: ppWidgetAuto,
                    nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                    prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`
                })
            }  
        }
    })

    // carousel posts widgets
    var cpWidgets = $( ".digital-newspaper-widget-carousel-posts" )
    cpWidgets.each(function() {
        var _this = $(this), parentWidgetContainerId = _this.parents( ".widget.widget_digital_newspaper_carousel_widget" ).attr( "id" ), parentWidgetContainer
        if( typeof parentWidgetContainerId != 'undefined' ) {
            parentWidgetContainer = $( "#" + parentWidgetContainerId )
            var ppWidget = parentWidgetContainer.find( ".carousel-posts-wrap" );
        } else {
            var ppWidget = _this;
        }
        if( ppWidget.length > 0 ) {
            ppWidget.slick({
                dots: false,
                infinite: false,
                rtl: nrtl,
                arrows: true,
                autoplay: true,
                nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`
            })
        }
    })

    // stickey related posts
    if( '.single-related-posts-section-wrap' ) {
      $('.single .entry-footer').waypoint(function(direction) {  
            $('.single-related-posts-section-wrap.related_posts_popup').addClass('related_posts_popup_sidebar');
        }, { offset: + 50 });
    }
    $('.related_post_close').on('click',function(){
      $('.single .single-related-posts-section-wrap.related_posts_popup').removeClass('related_posts_popup_sidebar related_posts_popup');
    });

    // check for dark mode drafts
    if(localStorage.getItem("themeMode") != null ) {
        if( localStorage.getItem("themeMode") == "dark" ) {
            $( ".blaze-switcher-button" ).addClass( "active" );
            if( ! $( "body" ).hasClass( "digital_newspaper_dark_mode" ) ) {
                $( "body" ).addClass( "digital_newspaper_dark_mode" );
                $( "body" ).removeClass( "digital_newspaper_main_body" );
            }
        } else {
            $( ".blaze-switcher-button" ).removeClass( "active" );
            if( $( "body" ).hasClass( "digital_newspaper_dark_mode" ) ) {
                $( "body" ).addClass( "digital_newspaper_main_body" );
                $( "body" ).removeClass( "digital_newspaper_dark_mode" );
            }
        }
    }
    // toggle theme mode
    $( ".blaze-switcher-button" ).on( "click", function() {
        var _this = $(this)
        $( "body" ).toggleClass( "digital_newspaper_dark_mode" )
        if( ! _this.hasClass( "active" ) && $( "body" ).hasClass( "digital_newspaper_dark_mode" ) ) {
            localStorage.setItem("themeMode", "dark");
            _this.addClass("active")
            $("body").removeClass("digital_newspaper_main_body");
        } else {
            localStorage.setItem( "themeMode", "light" );
            _this.removeClass("active")
            $("body").addClass("digital_newspaper_main_body");
        }
    });
    
    // header sticky
    if( stickeyHeader ) {
        var lastScroll = 0;
        $(window).on('scroll',function() {  
            var scroll = $(window).scrollTop();
            if(scroll > 50) {
                if( lastScroll - scroll > 0 && stickeyHeader ) {
                    $(".main-header").addClass("fixed_header");
                } else {
                    $(".main-header").removeClass("fixed_header");
                }
                lastScroll = scroll;
            } else {
                $(".main-header").removeClass("fixed_header");
            }
        });
    }

    // back to top script
    if( sttOption && $( "#digital-newspaper-scroll-to-top" ).length ) {
        var scrollContainer = $( "#digital-newspaper-scroll-to-top" );
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 800 ) {
                scrollContainer.addClass('show');
            } else {
                scrollContainer.removeClass('show');
            }
        });
        scrollContainer.click(function(event) {
            event.preventDefault();
            // Animate the scrolling motion.
            $("html, body").animate({scrollTop:0},"slow");
        });
    }

    // category archive hide featured post in list
    var featuredPost = $( ".archive.category .featured-post.is-sticky" )
    if( featuredPost.length > 0 ) {
        var postHide = "#post-" + featuredPost.data("id")
        $(postHide).addClass( "sticky-hide" );
    }
})