<?php

/* Recent Posts Shortcode */

function mo_recent_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'author' => '',
        'image_size' => 'small'
    ), $atts);
    extract($args);

    $args['loop'] = new WP_Query(array('posts_per_page' => $post_count, 'author' => $author, 'ignore_sticky_posts' => 1));

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('recent_posts', 'mo_recent_posts_shortcode');


/* Popular Posts Shortcode */

function mo_popular_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'small'
    ), $atts);
    extract($args);

    $args['loop'] = new WP_Query(array('orderby' => 'comment_count', 'posts_per_page' => $post_count, 'ignore_sticky_posts' => 1));

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('popular_posts', 'mo_popular_posts_shortcode');

function mo_category_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'category_slugs' => '',
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'small'
    ), $atts);
    extract($args);

    $args['loop'] = new WP_Query(array('category_name' => $category_slugs, 'posts_per_page' => $post_count, 'ignore_sticky_posts' => 1));

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('category_posts', 'mo_category_posts_shortcode');

function mo_tag_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'tag_slugs' => '',
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'small'
    ), $atts);
    extract($args);

    $args['loop'] = new WP_Query(array('tag' => $tag_slugs, 'posts_per_page' => $post_count, 'ignore_sticky_posts' => 1));

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('tag_posts', 'mo_tag_posts_shortcode');

/* Display Posts from the custom taxonomy specified */
/* TODO: Support for multiple custom taxonomies using string matching */

function mo_custom_taxonomy_posts_shortcode($atts) {
    $args = shortcode_atts(array(
        'taxonomy_slug' => '',
        'taxonomy_term' => '',
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'small'
    ), $atts);
    extract($args);


    $taxonomy_map = array($taxonomy_slug => $taxonomy_term);

    $args['loop'] = new WP_Query(array('tax' => $taxonomy_wrap, 'posts_per_page' => $post_count, 'ignore_sticky_posts' => 1));

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('custom_taxonomy_posts', 'mo_custom_taxonomy_posts_shortcode');

/* Display content of one or more custom post types */

function mo_show_custom_post_types_shortcode($atts) {
    $args = shortcode_atts(array(
        'post_types' => 'post',
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'small'
    ), $atts);
    extract($args);

    $custom_post_types = explode(",", $post_types); // return me an array of post types

    $args['loop'] = new WP_Query(array('post_type' => $custom_post_types, 'posts_per_page' => $post_count, 'ignore_sticky_posts' => 1));

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('show_custom_post_types', 'mo_show_custom_post_types_shortcode');

function mo_show_post_snippets_shortcode($atts) {
    $args = shortcode_atts(array(
        'post_type' => null,
        'post_count' => 4,
        'image_size' => 'small',
        'title' => null,
        'layout_class' => 'post-snippets full-width-snippets',
        'excerpt_count' => 100,
        'number_of_columns' => 4,
        'show_meta' => false,
        'display_title' => false,
        'display_summary' => false,
        'show_excerpt' => true,
        'hide_thumbnail' => false,
        'row_line_break' => true,
        'terms' => '',
        'taxonamy' => 'category'
    ), $atts);

    $output = mo_get_post_snippets($args);

    return $output;

}

add_shortcode('show_post_snippets', 'mo_show_post_snippets_shortcode');

function mo_project_showcase_shortcode($atts, $content = null, $shortcode_name = "") {
    extract(shortcode_atts(array(
        'portfolio_tab_text' => "Recent Work",
        'twitter_tab_text' => "Recent Tweets",
        'blog_tab_text' => "Latest Posts"
    ), $atts));

    $output = '<div id="project-showcase">';

    $output .= '<div>';
    $output .= '<ul class="fancy-tab" >';
    $output .= '<li class="current-tab" id ="blog-tab" ><a ><i class="icon-pencil-3"></i> ' . $blog_tab_text . '</a ></li > ';
    $output .= '<li id="project-tab"><a><i class="icon-picture"></i>' . $portfolio_tab_text . '</a></li>';
    //$output .= '<li id="twitter-tab"><i class="icon-twitter"></i><a>' . $portfolio_tab_text . '</a></i></li>';
    $output .= '</ul>';
    $output .= '</div>';

    $output .= '<div id="portfolio-showcase">';
    $output .= '<div>';

    $post_snippets = '[show_post_snippets post_type="portfolio" number_of_columns=4 post_count=4 image_size="medium" show_meta=false layout_class="post-snippets full-width-snippets" taxonamy="portfolio_category" display_summary=false]';
    $output .= do_shortcode($post_snippets);

    $output .= '</div></div><!--portfolio-showcase-->';
    $output .= '<div id="blog-showcase"><div>';

    $post_snippets = '[show_post_snippets post_type="post" number_of_columns=4 post_count=4 image_size="medium" show_meta=true excerpt_count=50 layout_class="post-snippets full-width-snippets" display_summary=false]';

    $output .= do_shortcode($post_snippets);

    $output .= '</div>';
    $output .= '</div><!--blog-showcase-->';
    $output .= '</div><!--project-showcase-->';

    return $output;
}

add_shortcode('project_showcase', 'mo_project_showcase_shortcode');


