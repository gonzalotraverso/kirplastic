<?php


function mo_responsive_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(
        array('type' => 'flex',
            'slideshow_speed' => 5000,
            'animation_speed' => 600,
            'animation' => 'fade',
            'pause_on_action' => 'false',
            'pause_on_hover' => 'true',
            'direction_nav' => 'true',
            'control_nav' => 'true',
            'easing' => 'swing',
            'style' => ''),
        $atts));

    $output = '';

    $controls_container = $type . '-slider-container';
    $namespace = 'flex';

    $output .= '<script type="text/javascript">' . "\n";
    $output .= 'jQuery(document).ready(function($) {';
    $output .= 'jQuery(\'.' . $controls_container . ' .flexslider\'). flexslider({';
    $output .= 'animation: "' . $animation . '",';
    $output .= 'controlsContainer: "' . $controls_container . '",';
    $output .= 'slideshowSpeed: ' . $slideshow_speed . ',';
    $output .= 'animationSpeed: ' . $animation_speed . ',';
    $output .= 'namespace: "' . $namespace . '-",';
    $output .= 'pauseOnAction:' . $pause_on_action . ',';
    $output .= 'pauseOnHover: ' . $pause_on_hover . ',';
    $output .= 'controlNav: ' . $control_nav . ',';
    $output .= 'directionNav: ' . $direction_nav . ',';
    $output .= 'prevText: ' . '"Previous' . '<span></span>",';
    $output .= 'nextText: ' . '"Next' . '<span></span>",';
    $output .= 'smoothHeight: false,';
    $output .= 'easing: "' . $easing . '"';
    $output .= '})';
    $output .= '});' . "\n";
    $output .= '</script>' . "\n";

    if (!empty($style))
        $style .= ' style="' . $style . '"';

    $output .= '<div class="' . $controls_container . '"' . $style . '>';

    $output .= '<div class="flexslider">';

    $styled_list = '<ul class="slides">';

    $slider_content = do_shortcode($content);

    $output .= str_replace('<ul>', $styled_list, $slider_content);

    $output .= '</div><!-- flexslider -->';
    $output .= '</div><!-- ' . $controls_container . ' -->';

    return $output;
}

add_shortcode('responsive_slider', 'mo_responsive_slider_shortcode');

function mo_responsive_carousel_shortcode($atts, $content = null) {
    $args = shortcode_atts(
        array('slideshow_speed' => 3000,
            'animation_speed' => 600,
            'pauseOnHover' => 'true',
            'easing' => 'swing',
            'item_width' => 210,
            'item_margin' => 30,
            'max_items' => 5,
            'min_items' => 2,
            'post_type' => null,
            'post_count' => 4,
            'layout_class' => 'post-snippets',
            'display_title' => false,
            'display_summary' => false,
            'show_excerpt' => true,
            'excerpt_count' => 100,
            'show_meta' => false,
            'hide_thumbnail' => false,
            'image_size' => 'medium',
            'terms' => '',
            'taxonamy' => ''),
        $atts);

    extract($args);

    $output = '';

    $controls_container = 'carousel-container';

    $output .= '<script type="text/javascript">' . "\n";
    $output .= 'jQuery(document).ready(function($) {';
    $output .= 'jQuery(\'.' . $controls_container . ' .slides\').bxSlider({';
    $output .= 'mode: "horizontal",';
    $output .= 'infiniteLoop: false,';
    $output .= 'slideWidth: ' . $item_width . ',';
    $output .= 'slideMargin: ' . $item_margin . ',';
    $output .= 'maxSlides: ' . $max_items . ',';
    $output .= 'minSlides: ' . $min_items . ',';
    $output .= 'autoStart: false,';
    $output .= 'moveSlides: ' . $min_items . ',';
    $output .= 'pause: ' . $slideshow_speed . ',';
    $output .= 'speed: ' . $animation_speed . ',';
    $output .= 'easing: "' . $easing . '"';
    $output .= '})';
    $output .= '});' . "\n";
    $output .= '</script>' . "\n";

    $output .= '<div class="' . $controls_container . '">';

    $styled_list = '<ul class="slides image-grid ' . $layout_class . '">';

    $slider_content = mo_get_post_snippets_list($args);

    $output .= str_replace('<ul>', $styled_list, $slider_content);

    $output .= '</div><!-- ' . $controls_container . ' -->';

    return $output;
}

add_shortcode('responsive_carousel', 'mo_responsive_carousel_shortcode');