<?php

/* ---------------- New 1140px flexible grid layout from cssgrid.net ------------------------- */

function mo_column_shortcode($atts, $content = null, $shortcode_name = "") {
    extract(shortcode_atts(array(
        'id' => null,
        'class' => null,
        'style' => ''
    ), $atts));
    $output = '<div' . ($id ? ' id="' . $id . '"' : '') . ' class="' . str_replace("_", "", $shortcode_name) . ($class ? ' ' . $class : '') . '"' . ($style ? ' style="' . $style . '"' : '') . '>' . do_shortcode(trim($content)) . '</div>';

    return $output;
}

function mo_column_shortcode_last($atts, $content = null, $shortcode_name = "") {
    extract(shortcode_atts(array(
        'id' => null,
        'class' => null,
        'style' => ''
    ), $atts));
    $output = '<div' . ($id ? ' id="' . $id . '"' : '') . ' class="' . str_replace("_", "", str_replace('_last', ' last', $shortcode_name)) . ($class ? ' ' . $class : '') . '"' . ($style ? ' style="' . $style . '"' : '') . '>' . do_shortcode(trim($content)) . '</div><div class="clear"></div>';

    return $output;
}


add_shortcode('one_col', 'mo_column_shortcode');
add_shortcode('two_col', 'mo_column_shortcode');
add_shortcode('three_col', 'mo_column_shortcode');
add_shortcode('four_col', 'mo_column_shortcode');
add_shortcode('five_col', 'mo_column_shortcode');

add_shortcode('six_col', 'mo_column_shortcode');
add_shortcode('seven_col', 'mo_column_shortcode');
add_shortcode('eight_col', 'mo_column_shortcode');
add_shortcode('nine_col', 'mo_column_shortcode');
add_shortcode('ten_col', 'mo_column_shortcode');
add_shortcode('eleven_col', 'mo_column_shortcode');
add_shortcode('twelve_col', 'mo_column_shortcode');

add_shortcode('one_col_last', 'mo_column_shortcode_last');
add_shortcode('two_col_last', 'mo_column_shortcode_last');
add_shortcode('three_col_last', 'mo_column_shortcode_last');
add_shortcode('four_col_last', 'mo_column_shortcode_last');
add_shortcode('five_col_last', 'mo_column_shortcode_last');

add_shortcode('six_col_last', 'mo_column_shortcode_last');
add_shortcode('seven_col_last', 'mo_column_shortcode_last');
add_shortcode('eight_col_last', 'mo_column_shortcode_last');
add_shortcode('nine_col_last', 'mo_column_shortcode_last');
add_shortcode('ten_col_last', 'mo_column_shortcode_last');
add_shortcode('eleven_col_last', 'mo_column_shortcode_last');


/* ------------ Legacy column shortcodes - connects better with users ------------------------ */

function mo_get_column_name_map() {
    $column_name_map = array(
        'mini_column' => 'mini-column',
        'maxi_column' => 'maxi-column',
        'one_half' => 'sixcol',
        'one_third' => 'fourcol',
        'one_fourth' => 'threecol',
        'one_sixth' => 'twocol',
        'two_third' => 'eightcol',
        'three_fourth' => 'ninecol',
        'one_half_last' => 'sixcol last',
        'one_third_last' => 'fourcol last',
        'one_fourth_last' => 'threecol last',
        'one_sixth_last' => 'twocol last',
        'two_third_last' => 'eightcol last',
        'three_fourth_last' => 'ninecol last');
    return $column_name_map;
}


function mo_col_shortcode($atts, $content = null, $shortcode_name = "") {

    $column_map = mo_get_column_name_map();
    $class_name = $column_map[$shortcode_name];
    $output = '<div class="' . $class_name . '">' . do_shortcode(trim($content)) . '</div>';

    return $output;
}

function mo_col_shortcode_last($atts, $content = null, $shortcode_name = "") {

    $column_map = mo_get_column_name_map();
    $class_name = $column_map[$shortcode_name];
    $output = '<div class="' . $class_name . '">' . do_shortcode(trim($content)) . '</div><div class="clear"></div>';

    return $output;
}

add_shortcode('one_half', 'mo_col_shortcode');
add_shortcode('one_third', 'mo_col_shortcode');
add_shortcode('one_fourth', 'mo_col_shortcode');
add_shortcode('one_sixth', 'mo_col_shortcode');

add_shortcode('two_third', 'mo_col_shortcode');
add_shortcode('three_fourth', 'mo_col_shortcode');

add_shortcode('one_half_last', 'mo_col_shortcode_last');
add_shortcode('one_third_last', 'mo_col_shortcode_last');
add_shortcode('one_fourth_last', 'mo_col_shortcode_last');
add_shortcode('one_sixth_last', 'mo_col_shortcode_last');

add_shortcode('two_third_last', 'mo_col_shortcode_last');
add_shortcode('three_fourth_last', 'mo_col_shortcode_last');


add_shortcode('mini_column', 'mo_col_shortcode');
add_shortcode('maxi_column', 'mo_col_shortcode');


