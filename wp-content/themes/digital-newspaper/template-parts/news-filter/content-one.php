<?php
/**
 * Template part for displaying block content in filter block
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Digital Newspaper
 */
?>
<article class="filter-item <?php if(!has_post_thumbnail()) { echo esc_attr('no-feat-img');} ?>">
    <div class="blaze_box_wrap">
        <figure class="post-thumb-wrap">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php
                    if( has_post_thumbnail() ) { 
                        the_post_thumbnail('digital-newspaper-featured', array(
                            'title' => the_title_attribute(array(
                                'echo'  => false
                            ))
                        ));
                    }
                ?>
            </a>
            <?php if( $args->categoryOption ) digital_newspaper_get_post_categories( get_the_ID(), 2 ); ?>
        </figure>
        <div class="post-element">
            <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <div class="post-meta">
                <?php if( $args->authorOption ) digital_newspaper_posted_by(); ?>
                <?php if( $args->dateOption ) digital_newspaper_posted_on(); ?>
                <?php if( $args->commentOption ) echo '<span class="post-comment">' .absint( get_comments_number() ). '</span>'; ?>
            </div>
            
            <?php
                if( $args->excerptOption ):
                    $excerptLength = isset( $options->excerptLength ) ? $options->excerptLength: 10; 
                    echo '<div class="post-excerpt">' .esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), $args->excerptLength ) ). '</div>';
                endif;
                do_action( 'digital_newspaper_section_block_view_all_hook', array(
                    'option'    => isset( $args->buttonOption ) ? $args->buttonOption : false
                ));
            ?>
        </div>
    </div>
</article>