<?php
/**
 * Top Header hooks and functions
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
use Digital_Newspaper\CustomizerDefault as DN;
   if( ! function_exists( 'digital_newspaper_top_header_date_time_part' ) ) :
      /**
       * Top header menu element
      * 
      * @since 1.0.0
      */
      function digital_newspaper_top_header_date_time_part() {
      if( ! DN\digital_newspaper_get_customizer_option( 'top_header_date_time_option' ) ) return;
      ?>
         <div class="top-date-time">
            <div class="top-date-time-inner">
              <span class="time"></span>
              <span class="date"><?php echo date_i18n(get_option('date_format'), current_time('timestamp')); ?></span>
              
            </div>
         </div>
      <?php
      }
      add_action( 'digital_newspaper_top_header_hook', 'digital_newspaper_top_header_date_time_part', 10 );
   endif;

 if( ! function_exists( 'digital_newspaper_top_header_ticker_news_part' ) ) :
    /**
     * Top header menu element
     * 
     * @since 1.0.0
     */
    function digital_newspaper_top_header_ticker_news_part() {
      if( ! DN\digital_newspaper_get_customizer_option( 'top_header_ticker_news_option' ) || DN\digital_newspaper_get_customizer_option('top_header_right_content_type') != 'ticker-news' ) return;
      $top_header_ticker_news_post_filter = DN\digital_newspaper_get_customizer_option( 'top_header_ticker_news_post_filter' );
      if( $top_header_ticker_news_post_filter == 'category' ) {
            $ticker_args['posts_per_page'] = 4;
            $top_header_ticker_news_categories = json_decode( DN\digital_newspaper_get_customizer_option( 'top_header_ticker_news_categories' ) );
            if( DN\digital_newspaper_get_customizer_option( 'top_header_ticker_news_date_filter' ) != 'all' ) $ticker_args['date_query'] = digital_newspaper_get_date_format_array_args(DN\digital_newspaper_get_customizer_option( 'top_header_ticker_news_date_filter' ));
            if( $top_header_ticker_news_categories ) $ticker_args['category_name'] = digital_newspaper_get_categories_for_args($top_header_ticker_news_categories);
      } else if( $top_header_ticker_news_post_filter == 'title' ) {
            $top_header_ticker_news_posts = json_decode(DN\digital_newspaper_get_customizer_option( 'top_header_ticker_news_posts' ));
            if( $top_header_ticker_news_posts ) {
               $ticker_args['post_name__in'] = digital_newspaper_get_post_slugs_for_args($top_header_ticker_news_posts);
            }
      }
      ?>
         <div class="top-ticker-news">
            <ul class="ticker-item-wrap">
               <?php
               if( isset( $ticker_args ) ) :
                     $ticker_args['ignore_sticky_posts'] = true;
                     $ticker_query = new WP_Query( $ticker_args );
                     if( $ticker_query->have_posts() ) :
                        while( $ticker_query->have_posts() ) : $ticker_query->the_post();
                        ?>
                           <li class="ticker-item"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2></li>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                     endif;
                  endif;
               ?>
            </ul>
			</div>
      <?php
    }
    add_action( 'digital_newspaper_top_header_hook', 'digital_newspaper_top_header_ticker_news_part', 10 );
 endif;

 if( ! function_exists( 'digital_newspaper_top_header_menu_part' ) ) :
   /**
    * Top header menu element
    * 
    * @since 1.0.0
    */
   function digital_newspaper_top_header_menu_part() {
     if( ! DN\digital_newspaper_get_customizer_option( 'top_header_menu_option' ) || DN\digital_newspaper_get_customizer_option('top_header_right_content_type') != 'nav-menu' ) return;
     ?>
        <div class="top-nav-menu">
            <?php
               wp_nav_menu(
                     array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'top-menu',
                        'depth'  => 1
                     )
               );
            ?>
        </div>
     <?php
   }
   add_action( 'digital_newspaper_top_header_hook', 'digital_newspaper_top_header_menu_part', 10 );
endif;

 if( ! function_exists( 'digital_newspaper_top_header_social_part' ) ) :
   /**
    * Top header social element
    * 
    * @since 1.0.0
    */
   function digital_newspaper_top_header_social_part() {
     if( ! DN\digital_newspaper_get_customizer_option( 'top_header_social_option' ) ) return;
     ?>
        <div class="social-icons-wrap">
           <?php digital_newspaper_customizer_social_icons(); ?>
        </div>
     <?php
   }
   add_action( 'digital_newspaper_top_header_hook', 'digital_newspaper_top_header_social_part', 15 );
endif;

if( ! function_exists( 'digital_newspaper_top_header_newsletter_part' ) ) :
   /**
    * Header newsletter element
    * 
    * @since 1.0.0
    */
    function digital_newspaper_top_header_newsletter_part() {
       if( ! DN\digital_newspaper_get_customizer_option( 'header_newsletter_option' ) ) return;
       $header_newsletter_label = DN\digital_newspaper_get_customizer_option( 'header_newsletter_label' );
       $header_newsletter_redirect_href_link = DN\digital_newspaper_get_customizer_option( 'header_newsletter_redirect_href_link' );
       ?>
           <div class="newsletter-element" <?php if( isset($header_newsletter_label['text']) && !empty($header_newsletter_label['text']) ) echo 'title="' . esc_attr( $header_newsletter_label['text'] ) . '"'; ?>>
               <a href="<?php echo esc_url( $header_newsletter_redirect_href_link ); ?>" target="_blank" data-popup="redirect">
                   <?php
                       if( isset($header_newsletter_label['icon']) && !empty($header_newsletter_label['icon']) ) echo '<span class="title-icon"><i class="' .esc_attr($header_newsletter_label['icon']). '"></i></span>';
                       if( isset($header_newsletter_label['text']) && !empty(isset($header_newsletter_label['text'])) ) echo '<span class="title-text">' .esc_html($header_newsletter_label['text']). '</span>';
                   ?>
               </a>
           </div><!-- .newsletter-element -->
       <?php
    }
    add_action( 'digital_newspaper_top_header_hook', 'digital_newspaper_top_header_newsletter_part', 20 );
endif;

if( ! function_exists( 'digital_newspaper_top_header_random_news_part' ) ) :
   /**
    * Header random news element
    * 
    * @since 1.0.0
    */
    function digital_newspaper_top_header_random_news_part() {
       if( ! DN\digital_newspaper_get_customizer_option( 'header_random_news_option' ) ) return;
       $header_random_news_label = DN\digital_newspaper_get_customizer_option( 'header_random_news_label' );
       $header_random_news_link_to_single_news_option = DN\digital_newspaper_get_customizer_option( 'header_random_news_link_to_single_news_option' );
       if( $header_random_news_link_to_single_news_option ) {
            $button_url = digital_newspaper_get_random_news_url();
       } else {
            $header_random_news_filter = DN\digital_newspaper_get_customizer_option( 'header_random_news_filter' );
            $button_url = add_query_arg( array( 'digitalNewspaperargs' => 'custom', 'posts'  => esc_attr( $header_random_news_filter ) ), home_url() );
       }
       ?>
           <div class="random-news-element" <?php if( isset($header_random_news_label['text']) && !empty($header_random_news_label['text']) ) echo 'title="' . esc_attr( $header_random_news_label['text'] ) . '"'; ?>>
               <a href="<?php echo esc_url($button_url); ?>" target="_blank">
                   <?php
                       if( isset($header_random_news_label['icon']) && !empty($header_random_news_label['icon']) ) echo '<span class="title-icon"><i class="' .esc_attr($header_random_news_label['icon']). '"></i></span>';
                       if( isset($header_random_news_label['text']) && !empty($header_random_news_label['text']) ) echo '<span class="title-text">' .esc_html($header_random_news_label['text']). '</span>';
                   ?>
               </a>
           </div><!-- .random-news-element -->
       <?php
    }
    add_action( 'digital_newspaper_top_header_hook', 'digital_newspaper_top_header_random_news_part', 20 );
endif;

add_action( 'digital_newspaper_top_header_hook', function() {
   if( ! DN\digital_newspaper_get_customizer_option( 'header_newsletter_option' ) && ! DN\digital_newspaper_get_customizer_option( 'header_random_news_option' ) ) return;
   echo '<div class="top-header-nrn-button-wrap">';
}, 18 ); // newsletter wrapper open
add_action( 'digital_newspaper_top_header_hook', function() {
   if( ! DN\digital_newspaper_get_customizer_option( 'header_newsletter_option' ) && ! DN\digital_newspaper_get_customizer_option( 'header_random_news_option' ) ) return;
   echo '</div><!-- .top-header-nrn-button-wrap -->';
}, 22 ); // newsletter wrapper end