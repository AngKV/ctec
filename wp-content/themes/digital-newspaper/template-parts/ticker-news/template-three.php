<?php
/**
 * Ticker news template three
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
use Digital_Newspaper\CustomizerDefault as DN;
$ticker_query = new WP_Query( $args );
if( $ticker_query->have_posts() ) :
    while( $ticker_query->have_posts() ) : $ticker_query->the_post();
    ?>
        <li class="ticker-item">
            <figure class="feature_image">
                <?php
                    if( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php
                                the_post_thumbnail('digital-newspaper-thumb', array(
                                            'title' => the_title_attribute(array(
                                                'echo'  => false
                                            ))
                                        ));
                                    ?>
                        </a>
                <?php 
                    endif;
                ?>
            </figure>
            <div class="title-wrap">
                <?php digital_newspaper_posted_on(); ?>
                <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            </div>
        </li>
    <?php
    endwhile;
    wp_reset_postdata();
endif;