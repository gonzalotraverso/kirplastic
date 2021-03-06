<?php

/**
 * Slider Manager - Single handedly manages the various types of sliders in Livemesh Framework
 *
 * @package Livemesh_Framework
 */
class MO_Slider_Manager {

    private static $instance;

    /**
     * Constructor method for the MO_Slider_Manager class.
     *

     */
    private function __construct() {
    }

    /**
     * Constructor method for the MO_Slider_Manager class.
     *

     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     * Prevent cloning of this singleton
     *

     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * Init method for the MO_Slider_Manager class.
     * Called during theme setup.
     *

     */
    function initialize() {

    }

    function display_slider_area() {

        $layout_type = '1c';

        $slider_type = mo_get_theme_option('mo_slider_choice', 'Nivo');

        /* TODO - Check if this is useful. Some corporate websites do have two column slider layouts. Ex. Microsoft.
        It's no surprise if someone hates a big huge slider above the fold  */
        if ($slider_type == 'Box')
            $layout_type = '2c';

        echo '<div id="slider-area" class="slider-layout-' . $layout_type . ' clearfix">';

        echo '<div id="slider-wrap">';

        $disable_sliders = mo_get_theme_option('mo_disable_sliders');

        // Show the slider area widget area if sliders are disabled
        if ($disable_sliders)
            mo_display_sidebar('slider-area-home');
        else
            $this->display_slider($slider_type);

        echo '</div>';

        echo '</div> <!-- #slider-area -->';
    }

    function display_slider($slider_type) {

        switch ($slider_type) {
            case 'Nivo':
                $this->display_nivo_slider();
                break;
            case 'FlexSlider':
                $this->display_flex_slider();
                break;
            default:
                $this->display_nivo_slider(); // Go ahead and populate Nivo anyway
        }
    }

    function display_nivo_slider() {
        global $mo_theme;

        $post_count = mo_get_theme_option('mo_nivo_slider_post_count', 8);

        $query = array('post_type' => 'showcase_slide', 'posts_per_page' => $post_count, 'orderby' => 'menu_order', 'order' => 'ASC');

        $loop = new WP_Query($query);

        $slide_image_array = array();
        $nivo_caption_array = array();

        if ($loop->have_posts()) :

            $count = 0;

            $disable_caption = mo_get_theme_option('mo_disable_nivo_slider_caption');

            while ($loop->have_posts()) : $loop->the_post();

                $title = get_the_title();

                $slide_link = get_post_meta(get_the_ID(), '_slide_link_field', true);

                $slide_caption_index = 'slide-caption' . ++$count;

                $slide_info = get_post_meta(get_the_ID(), '_slide_info_field', true);

                $before_html = '<a title="' . $title . '" href="' . $slide_link . '">';
                $after_html = '</a>';

                $slider_size = array('width' => 1920, 'height' => 600);

                $slider_height = mo_get_theme_option('mo_nivo_slider_height');
                if ($slider_height)
                    $slider_size = array('width' => 1920, 'height' => intval($slider_height));

                $args = array('image_size' => $slider_size,
                    'size' => 'full',
                    'before_html' => $before_html,
                    'after_html' => $after_html,
                    'image_alt' => $title,
                    'image_title' => ('#' . $slide_caption_index),
                    'image_class' => 'slider-image',
                    'shadow' => false /* Do not generate unwanted wrappers around images - spoils the nivo effects */
                );

                // Make sure you use the slide caption as image alt attribute 
                $thumbnail_url = mo_get_thumbnail($args);

                $nivo_caption = '<div id="' . $slide_caption_index . '" class="nivo-html-caption"><h3><a href="' . $slide_link . '" title="' . $title . '">' . $title . '</a></h3><div class="nivo-summary">' . $slide_info . '</div></div>';

                // In sliders, always skip the post if it does not have a thumbnail 
                if (!empty($thumbnail_url)) {
                    $slide_image_array[] = $thumbnail_url;

                    if (!$disable_caption) {
                        $nivo_caption_array[] = $nivo_caption;
                    }
                }

            endwhile;

        endif;

        wp_reset_postdata();


        if (!empty($slide_image_array)) :

            echo '<div id="nivo-slider-wrapper">';

            echo '<div id="nivo-slider">';

            foreach ($slide_image_array as $slider_image_url):

                echo $slider_image_url . "\n";

            endforeach;

            echo '</div> <!--end #nivo-silder -->';

            foreach ($nivo_caption_array as $nivo_rich_caption):

                echo $nivo_rich_caption . "\n";

            endforeach;

            echo '</div> <!--end #nivo-silder-wrapper -->';

        endif;
    }

    function display_flex_slider() {

        $post_count = mo_get_theme_option('mo_flex_slider_post_count', 8);

        $query = array('post_type' => 'showcase_slide', 'posts_per_page' => $post_count, 'orderby' => 'menu_order', 'order' => 'ASC');

        $loop = new WP_Query($query);
        ?>

    <?php
        if ($loop->have_posts()) :

            $count = 1;
            ?>

        <div id="flex-slider-wrapper">

            <div class="flexslider">

                <ul class="slides">

                    <?php
                    while ($loop->have_posts()) : $loop->the_post();

                        $title = get_the_title();

                        $slide_link = get_post_meta(get_the_ID(), '_slide_link_field', true);

                        $slide_info = get_post_meta(get_the_ID(), '_slide_info_field', true);

                        $disable_caption = mo_get_theme_option('mo_disable_flex_slider_caption');

                        $slider_caption = '';

                        if (!$disable_caption) {
                            $slider_caption = '<div class="flex-caption"><a href="' . $slide_link . '" title="' . $title . '">' . $title . '</a><div class="flex-summary">' . $slide_info . '</div></div>';
                        }

                        $before_html = '<a title="' . $title . '" href="' . $slide_link . '">';
                        $after_html = '</a>';

                        $slider_size = array('width' => 1920, 'height' => 600);

                        $slider_height = mo_get_theme_option('mo_flex_slider_height');
                        if ($slider_height)
                            $slider_size = array('width' => 1920, 'height' => intval($slider_height));

                        // Make sure you use the slide caption as image alt attribute (in this case post title).
                        // Also, let the image size be same as that of Nivo, helps when WP generates thumbnails
                        $args = array('image_size' => $slider_size,
                            'size' => 'full',
                            'before_html' => $before_html,
                            'after_html' => $after_html,
                            'image_alt' => $title,
                            'image_title' => $title,
                            'image_class' => 'slider-image',
                            'shadow' => false
                        );

                        $thumbnail_url = mo_get_thumbnail($args);

                        // In sliders, always skip the post if it does not have a thumbnail
                        if (!empty($thumbnail_url)) {
                            echo '<li>';
                            echo $thumbnail_url;
                            echo $slider_caption;
                            echo '</li>';
                        }

                    endwhile;

                    ?>

                </ul>
                <!--end #flex-slider -->

            </div>

        </div>

        <?php
        endif;

        wp_reset_postdata();
    }

}