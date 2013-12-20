<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Squash
 * @subpackage Template
 */

function mo_display_post_thumbnail() {

    $post_id = get_the_ID();

    $args = mo_get_thumbnail_args_for_singular();

    $use_video_thumbnail = get_post_meta($post_id, 'mo_use_video_thumbnail', true);
    $use_slider_thumbnail = get_post_meta($post_id, 'mo_use_slider_thumbnail', true);

    if ($use_video_thumbnail) {
        $video_url = get_post_meta($post_id, 'mo_video_thumbnail_url', true);

        if (!empty($video_url)) {
            echo '<div class="video-box">';
            if (mo_is_vimeo($video_url) || mo_is_youtube($video_url)) {
                if (mo_is_vimeo($video_url)) {
                    $video_url = "http://player.vimeo.com/video/" . mo_get_vimeo_id($video_url);
                }
                if (mo_is_youtube($video_url)) {
                    $video_url = "http://www.youtube.com/embed/" . mo_get_youtube_id($video_url);
                }

                echo '<iframe src="' . $video_url . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

            }
            echo '</div>'; // video-box

            return;
        }
    } elseif ($use_slider_thumbnail) {

        $slides = get_post_meta($post_id, 'post_slider', true);

        if (!empty($slides)) {
            $image_size = $args['image_size'];

            $output = '[responsive_slider type="featured"]';
            $output .= '<ul>';
            foreach ($slides as $slide) {
                $output .= '<li>' . mo_get_custom_sized_image($slide['slider_image'], $image_size, 'thumbnail-slide', $slide['title']) . '</li>';
            }
            $output .= '</ul>';
            $output .= '[/responsive_slider]';

            echo do_shortcode($output);

            return;
        }
    } else {

        /* Place image outside the content area for thumbnail lists to avoid going for css circus */
        mo_thumbnail($args);
    }
}

get_header();
?>

<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>

        <div class="hfeed">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <?php mo_exec_action('before_entry'); ?>

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php mo_exec_action('start_entry'); ?>

                        <?php echo mo_get_entry_title(); ?>


                        <?php
                        echo '<div class="entry-meta">' . mo_entry_published("M d") . mo_entry_author() . mo_entry_terms_list('category') . mo_entry_comments_link() . '</div>';
                        ?>

                        <div class="entry-content clearfix">

                            <?php
                            mo_display_post_thumbnail();
                            ?>

                            <?php the_content(); ?>

                            <?php wp_link_pages(array('link_before' => '<span class="page-number">', 'link_after' => '</span>', 'before' => '<p class="page-links">' . __('Pages:', 'mo_theme'), 'after' => '</p>')); ?>

                        </div>
                        <!-- .entry-content -->

                        <?php $post_tags = wp_get_post_tags($post->ID);

                        if (!empty($post_tags)) : ?>

                            <div class="entry-meta">

                                <div class="taglist">

                                    <?php echo mo_entry_terms_list('post_tag'); ?>

                                </div>

                            </div>

                        <?php endif; ?>

                        <?php mo_exec_action('end_entry'); ?>

                    </div><!-- .hentry -->

                    <?php mo_exec_action('after_entry'); ?>

                    <?php mo_display_sidebar('after-singular-post'); ?>

                    <?php mo_exec_action('after_singular'); ?>

                    <?php comments_template('/comments.php', true); // Loads the comments.php template.   ?>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php mo_display_sidebars(); ?>

<?php get_footer(); ?>