<?php


function mo_enable_dev_features() {

    add_action('after_setup_theme', 'mo_define_dev_constants', 13);

    add_action('after_setup_theme', 'mo_init_dev_features', 14);

    add_action('after_setup_theme', 'mo_init_dev_widgets', 15);

}

function mo_define_dev_constants() {
    /* Sets the path to the theme third party library scripts directory. */
    define('MO_DEV_URL', MO_THEME_URL . '/dev');
}

function mo_init_dev_features() {

    add_action('wp_head', 'mo_add_style_switcher_css', 8);

    add_action("wp_head", 'mo_add_embed_css_field', 9);

    /* Load specific scripts for the framework. */
    add_action('wp_enqueue_scripts', 'mo_enqueue_scripts');

    add_action('wp_footer', 'mo_load_dev_functions');

    add_action('init', 'mo_init_dev_features');

    add_action('widgets_init', 'mo_register_dev_widgets');

    require_once(MO_THEME_DIR . '/dev/extensions/mo-twitter-widget-dev.php');
}

function mo_init_dev_widgets() {

    require_once(MO_THEME_DIR . '/dev/extensions/mo-twitter-widget-dev.php');
}

function mo_register_dev_widgets() {
    register_widget('MO_Twitter_Widget_Dev');
}

function mo_load_dev_functions() {
    /* TODO: Remove before shipping */
    include_once(MO_THEME_DIR . '/dev/dBug.php');
    include_once(MO_THEME_DIR . '/dev/style-switcher.php');
}


function mo_add_embed_css_field() {
    global $post;
    if (is_singular()) {
        $css = get_post_meta($post->ID, 'embed-css', true);
        if (!empty($css)) {
            echo '<style type="text/css">';
            echo $css;
            echo '</style>';
        }
    }
}

function mo_enqueue_scripts() {

    wp_enqueue_script('webfont', MO_DEV_URL . '/js/lib/webfont.js');
    wp_enqueue_script('jquery-colorpicker', MO_DEV_URL . '/js/lib/colorpicker.js', array('jquery'));
    wp_enqueue_script('jquery-cookie', MO_DEV_URL . '/js/lib/jquery.cookie.js', array('jquery'));
    wp_enqueue_script('mo-styleswitcher', MO_DEV_URL . '/js/style-switcher.js', array('jquery'));
}

function mo_add_style_switcher_css() {
    wp_enqueue_style('color-picker', MO_DEV_URL . '/css/colorpicker.css', array('style-theme'));
    wp_enqueue_style('style-switcher', MO_DEV_URL . '/css/style-switcher.css', array('style-theme'));
}