<?php
/*
* Various utility functions required by theme defined here
*
* @package Livemesh Framework
*/

/*
* Obtain the prefix for my theme
*/
function mo_get_prefix() {
    return 'mo';
}

function mo_exec_action($hook, $arg = '') {
    $prefix = mo_get_prefix();

    do_action("{$prefix}_{$hook}", $arg);
}

function mo_site_title() {
    $heading_tag = (is_home() || is_front_page()) ? 'h1' : 'div';

    $blog_name = esc_attr(get_bloginfo('name'));

    $output = '<' . $heading_tag . ' id="site-title"><a href="' . home_url('/') . '" title="' . $blog_name . '" rel="home">';

    $use_text_logo = mo_get_theme_option('mo_use_text_logo') ? true : false;
    $logo_url = mo_get_theme_option('mo_site_logo');

    // If no logo image is specified, use text logo
    if ($use_text_logo || empty ($logo_url)) {
        $output .= '<span>' . $blog_name . '</span>';
    }
    else {
        $output .= '<img src="' . $logo_url . '" alt="' . $blog_name . '"/>';
    }

    $output .= '</a></' . $heading_tag . '>';

    echo $output;

}


function mo_get_sticky_site_title() {

    $blog_name = esc_attr(get_bloginfo('name'));

    $output = '<div id="sticky-site-title"><a href="' . home_url('/') . '" title="' . $blog_name . '" rel="home">';

    $logo_url = mo_get_theme_option('mo_sticky_logo');
    // If no logo image is specified, use text logo
    if (empty ($logo_url)) {
        $output .= '<span>' . $blog_name . '</span>';
    }
    else {
        $output .= '<img src="' . $logo_url . '" alt="' . $blog_name . '"/>';
    }

    $output .= '</a></div>';

    return $output;

}

function mo_browser_supports_css3_animations() {
    //check for ie7-9
    if (preg_match('/MSIE\s([\d.]+)/', $_SERVER['HTTP_USER_AGENT'], $matches)) {
        return false;
    }

    //Disable animations in Safari for now - some problems reported but not reproducible
    global $is_safari;
    if ($is_safari)
        return false;

    //Disable all animations for mobile devices
    if (mo_is_mobile()) {
        return false;
    }

    return true;
}

function mo_is_mobile() {

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strstr($user_agent, 'iPhone') || strstr($user_agent, 'iPod') || strstr($user_agent, 'iPad') || strstr($user_agent, 'Android') || strstr($user_agent, 'IEMobile') || strstr($user_agent, 'blackberry'))
        return true;
    return false;
}

/* TODO: Support for site description */
function mo_site_description() {
    $display_desc = mo_get_theme_option('mo_display_site_desc') ? true : false;
    $display_desc = false; // no support for description now
    if ($display_desc) {
        echo '<div id="site-description"><span>' . bloginfo('description') . '</span></div>';
    }
}

function mo_get_content_class() {
    $classes = array();
    $classes = apply_filters('mo_content_class', $classes);
    $style = '';
    foreach ($classes as $class) {
        $style .= $class . ' ';
    }
    return $style;
}

function mo_get_cached_value($key) {
    global $theme_cache;

    if (array_key_exists($key, $theme_cache))
        return $theme_cache[$key];

    return null;
}

function mo_set_cached_value($key, $value) {
    global $theme_cache;

    $theme_cache[$key] = $value;
    return $value;
}

function mo_get_theme_option($option_id, $default = null, $single = true) {
    global $mo_theme;
    global $options_cache;

    if (array_key_exists($option_id, $options_cache))
        return $options_cache[$option_id];

    $option_value = $mo_theme->get_theme_option($option_id, $default, $single);
    $options_cache[$option_id] = $option_value; //store in cache for further use
    return $option_value;
}

function mo_get_image_size($size_name) {
    global $mo_theme;

    $image_size_key = 'current_image_size';
    $image_size_attr_key = 'current_image_size_attr';

    if (mo_get_cached_value($image_size_key) == $size_name)
        return mo_get_cached_value($image_size_attr_key);

    mo_set_cached_value($image_size_key, $size_name); // set current image size
    mo_set_cached_value($image_size_attr_key, array()); // reset the old value

    $image_sizes = $mo_theme->get_image_sizes();
    if (array_key_exists($size_name, $image_sizes)) {
        $image_size = $image_sizes[$size_name];
        $current_image_size_attr = array('width' => $image_size[0], 'height' => $image_size[1]);
        mo_set_cached_value($image_size_attr_key, $current_image_size_attr);
        return $current_image_size_attr;
    }
    return null;
}

function mo_get_wp_image_name($easy_name, $default = null) {
    global $mo_theme;

    $image_size = null;

    $easy_name_map = $mo_theme->get_easy_image_name_map();

    if (array_key_exists($easy_name, $easy_name_map)) {
        $image_size = $easy_name_map [$easy_name];
    }
    elseif ($default != null)
        $image_size = $easy_name_map [$default];
    return $image_size;
}

function mo_get_wp_image_size($size, $default = null) {
    $image_name = mo_get_wp_image_name($size, $default);

    $image_size = mo_get_image_size($image_name);

    return $image_size;
}

function mo_footer_content() {

    // Default footer text
    $site_link = '<a class="site-link" href="' . home_url() . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home"><span>' . get_bloginfo('name') . '</span></a>';
    $wp_link = '<a class="wp-link" href="http://wordpress.org" title="' . esc_attr__('Powered by WordPress', 'mo_theme') . '"><span>' . __('WordPress', 'mo_theme') . '</span></a>';
    if (function_exists('wp_get_theme')) {
        $my_theme = wp_get_theme();
        $theme_link = '<a class="theme-link" href="' . esc_url($my_theme->ThemeURI) . '" title="' . esc_attr($my_theme->Name) . '"><span>' . esc_attr($my_theme->Name) . '</span></a>';
    }
    else {
        $theme_data = get_theme_data(trailingslashit(get_template_directory()) . 'style.css');
        $theme_link = '<a class="theme-link" href="' . esc_url($theme_data['URI']) . '" title="' . esc_attr($theme_data['Name']) . '"><span>' . esc_attr($theme_data['Name']) . '</span></a>';
    }

    $footer_text = __('Copyright &#169; ', 'mo_theme') . date(__('Y', 'mo_theme')) . ' ' . $site_link . __('. Powered by ', 'mo_theme') . $wp_link . __(' and ', 'mo_theme') . $theme_link;
    $footer_text = '<div id="footer-text">' . mo_get_theme_option('mo_footer_insert', $footer_text) . '</div>';
    echo do_shortcode($footer_text);
}

/* Return the css class name to help achieve the number of columns specified */

function mo_get_column_style($column_count = 2) {
    $style_class = '';
    switch ($column_count) {
        case 2:
            $style_class = "sixcol";
            break;
        case 3:
            $style_class = "fourcol";
            break;
        case 4;
            $style_class = "threecol";
    }
    return $style_class;
}

function mo_is_wide_page_layout() {
    return (is_page_template('template-advanced-home.php') || is_page_template('template-full-width.php'));
}

/* Original PHP code by Chirp Internet: www.chirp.com.au
http://www.the-art-of-web.com/php/truncate/ */

function mo_truncate_string($string, $limit, $strip_tags = true, $strip_shortcodes = true, $break = " ", $pad = "...") {
    if ($strip_shortcodes)
        $string = strip_shortcodes($string);

    if ($strip_tags)
        $string = strip_tags($string, '<p>'); // retain the p tag for formatting


    // return with no change if string is shorter than $limit
    if (strlen($string) <= $limit)
        return $string;
    elseif ($limit === 0 || $limit == '0')
        return '';


    // is $break present between $limit and the end of the string?
    if (false !== ($breakpoint = strpos($string, $break, $limit))) {
        if ($breakpoint < strlen($string) - 1) {
            $string = substr($string, 0, $breakpoint) . $pad;
        }
    }

    return $string;
}

function mo_display_portfolio_content($args) {
    global $mo_theme;

    $mo_theme->set_context('loop', 'portfolio'); // tells the thumbnail functions to prepare lightbox constructs for the image

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 0; // Do NOT paginate

    $args['query_args'] = array('post_type' => 'portfolio', 'posts_per_page' => $args['posts_per_page'], 'filterable' => $args['filterable'], 'paged' => $paged);

    mo_display_portfolio_content_grid_style($args);

    $mo_theme->set_context('loop', null); //reset it
}


function mo_display_home_portfolio_content($args) {
    global $mo_theme;

    $mo_theme->set_context('loop', 'portfolio'); // tells the thumbnail functions to prepare lightbox constructs for the image

    /* Extract the array to allow easy use of variables. */
    extract($args);

    $style_class = mo_get_column_style($number_of_columns);
    ?>

    <div class="hfeed">

        <?php

        $loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => $posts_per_page));

        if ($loop->have_posts()) :

            mo_display_portfolio_categories_filter();

            echo '<ul id="portfolio-items" class="image-grid">';

            while ($loop->have_posts()) : $loop->the_post();

                $style = $style_class . ' portfolio-item clearfix'; // no margin or spacing between portfolio items
                $terms = get_the_terms(get_the_ID(), 'portfolio_category');
                foreach ($terms as $term) {
                    $style .= ' term-' . $term->term_id;
                }
                ?>
                <li data-id="id-<?php the_ID(); ?>" class="<?php echo $style; ?>">

                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php $thumbnail_exists = mo_thumbnail(array('image_size' => $image_size, 'shadow' => true, 'size' => 'full', 'taxonamy' => 'portfolio_category')); ?>

                    </div>
                    <!-- .hentry -->

                </li> <!--isotope element -->

            <?php endwhile; ?>

            </ul> <!-- Isotope items -->

        <?php else : ?>

            <?php get_template_part('loop-error'); // Loads the loop-error.php template.                  ?>

        <?php endif; ?>

    </div> <!-- .hfeed -->

    <?php wp_reset_postdata(); ?>

    <?php

    $mo_theme->set_context('loop', null); //reset it
}

/*
* Converting string to boolean is a big one in PHP
*/

function mo_to_boolean($value) {
    if (!isset($value))
        return false;
    if ($value == 'true' || $value == '1')
        $value = true;
    elseif ($value == 'false' || $value == '0')
        $value = false;
    return (bool)$value; // Make sure you do not touch the value if the value is not a string
}

function mo_populate_top_area($post_id = NULL) {
    $slider_manager = MO_Slider_Manager::getInstance();
    if (is_page_template('template-advanced-home.php')) {
        echo '<div id="showcase-area">';
        $slider_manager->display_slider_area();
        echo '</div> <!-- #showcase-area -->';
        return;
    }

    if (is_home() && mo_get_theme_option('mo_remove_homepage_tagline'))
        return;

    if (is_singular(array('post', 'page', 'portfolio'))) {
        $custom_heading = mo_get_custom_heading();
        if (!empty($custom_heading)) {
            echo '<div id="custom-before-content-area-wrap">';
            $wide_heading_layout = get_post_meta(get_queried_object_id(), 'mo_wide_heading_layout', true);
            if (empty($wide_heading_layout))
                echo '<div id="custom-before-content-area" class="boxed">';
            else
                echo '<div id="custom-before-content-area" class="wide">';
            echo do_shortcode($custom_heading);
            echo '</div> <!-- custom-before-content-area -->';
            echo '</div>';
            return;
        }
    }

    echo '<div id="before-content-wrap" class="title-area clearfix">';
    echo '<div id="before-content-area">';
    //mo_populate_tagline();
    echo ' <div class="loop-meta">

        <h1 class="loop-title">Somos una amplia gama de productos.</h1>

        <div class="loop-description">
            Ofrecemos una gran variedad de productos de todo tipo para hacer que su marca sea<br>
recordada de la manera más efectiva.
        </div><!-- .loop-description -->

    </div><!-- .loop-meta -->';
    echo '</div>';
    echo '</div>';
}

function mo_populate_tagline() {

    /* Default tagline for blog */
    $tagline = mo_get_theme_option('mo_blog_tagline', __('Blog', 'mo_theme'));

    $default_homepage_title = get_bloginfo('name') . __(' Home', 'mo_theme');
    $homepage_tagline = mo_get_theme_option('mo_homepage_tagline', $default_homepage_title);

    if (is_attachment()) {
        echo '<h1>' . __('Media', 'mo_theme') . '</h1>';
    }
    elseif (is_home()) {
        echo '<h2 class="tagline">' . $homepage_tagline . '</h2>';
    }
    elseif (is_singular('post')) {
        echo '<h2 class="tagline">' . $tagline . '</h2>';
    }
    elseif (is_archive() || is_search()) {
        get_template_part('loop-meta'); // Loads the loop-meta.php template.
    }
    elseif (is_404()) {
        echo '<h1>' . __('404 Not Found', 'mo_theme') . '<h1>';
    }
    else {
        echo mo_get_entry_title(); // populate entry title for page and custom post types like portfolio type
    }
    $description = get_post_meta(get_queried_object_id(), 'mo_description', true);
    if (!empty ($description)) {
        echo '<div class="post-description">';
        echo '<p>' . $description . '</p>';
        echo '</div>';
    }
}

function mo_get_custom_heading() {
    $output = '';
    $custom_heading = __(get_post_meta(get_queried_object_id(), 'mo_custom_heading_content', true), 'mo_theme'); // For qtranslate
    if (!empty ($custom_heading)) {
        $output .= $custom_heading;
    }
    return $output;
}

/**
 * Check if this is a portfolio page
 *

 */
function mo_portfolio_page() {

    if (is_page_template('template-portfolio-2c-full-width.php')
        || is_page_template('template-portfolio-2c.php')
        || is_page_template('template-portfolio-3c-full-width.php')
        || is_page_template('template-portfolio-3c.php')
        || is_page_template('template-portfolio-4c-full-width.php')
        || is_page_template('template-portfolio-4c.php')
    )
        return true;

    return false;
}

/**
 * Check if this is a portfolio page
 *
 */
function mo_is_portfolio_context() {

    global $mo_theme;

    $context = $mo_theme->get_context('loop');

    if ($context == 'portfolio')
        return true;

    return false;
}

function mo_display_contact_info() {
    $phone_number = mo_get_theme_option('mo_phone_number', '');
    $email = mo_get_theme_option('mo_email_address', '');

    if (!empty ($phone_number) || !empty($email)) {
        $output = '<div id="contact-header">';
        $output .= '<ul>';
        if (!empty($phone_number)) {
            $output .= '<li><span class="icon-iphone"></span>' . $phone_number . '</li>';
        }
        if (!empty($email)) {
            $output .= '<li><span class="icon-email"></span>' . $email . '</li>';
        }
        $output .= '</ul>';
        $output .= '</div>';
        echo $output;
    }

}

/**
 * Populate top social icons in header
.1
 */
function mo_populate_social_icons() {

    $hide_socials = mo_get_theme_option('mo_hide_socials');

    if ($hide_socials)
        return;

    $facebook_url = mo_get_theme_option('mo_facebook_url', '');
    $twitter_url = mo_get_theme_option('mo_twitter_url', '');
    $linkedin_url = mo_get_theme_option('mo_linkedin_url', '');
    $flickr_url = mo_get_theme_option('mo_flickr_url', '');
    $googleplus_url = mo_get_theme_option('mo_googleplus_url', '');
    $dribbble_url = mo_get_theme_option('mo_dribbble_url', '');
    $behance_url = mo_get_theme_option('mo_behance_url', '');
    $youtube_url = mo_get_theme_option('mo_youtube_url', '');
    $vimeo_url = mo_get_theme_option('mo_vimeo_url', '');
    $pinterest_url = mo_get_theme_option('mo_pinterest_url', '');
    $rss_feed_url = get_bloginfo('rss2_url');
    ?>
    <div class="social-container">
        <ul>
            <?php
            if (!empty($facebook_url))
                echo '<li class="facebook"><a title="Follow us on Facebook" href="' . $facebook_url . '">Facebook</a></li>';
            if (!empty($googleplus_url))
                echo '<li class="googleplus"><a title="Follow us on Google Plus" href="' . $googleplus_url . '">Google Plus</a></li>';
            if (!empty($flickr_url))
                echo '<li class="flickr"><a title="Flickr Profile" href="' . $flickr_url . '">Flickr</a></li>';
            if (!empty($twitter_url))
                echo '<li class="twitter"><a title="Subscribe to our Twitter feed" href="' . $twitter_url . '">Twitter</a></li>';
            if (!empty($linkedin_url))
                echo '<li class="linkedin"><a title="Connect with us on LinkedIn" href="' . $linkedin_url . '">LinkedIn</a></li>';
            if (!empty($behance_url))
                echo '<li class="behance"><a title="Check out our posts on Behance" href="' . $behance_url . '">Behance</a></li>';
            if (!empty($vimeo_url))
                echo '<li class="vimeo"><a title="Check out our videos on Vimeo" href="' . $vimeo_url . '">Vimeo</a></li>';
            if (!empty($youtube_url))
                echo '<li class="youtube"><a title="Subscribe to our YouTube channel" href="' . $youtube_url . '">YouTube</a></li>';
            if (!empty($pinterest_url))
                echo '<li class="pinterest"><a title="Subscribe to our Pinterest feed" href="' . $pinterest_url . '">Pinterest</a></li>';
            if (!empty($dribbble_url))
                echo '<li class="dribbble"><a title="Check out our Dribbble shots" href="' . $dribbble_url . '">Dribbble</a></li>';

            echo '<li class="rss-feed"><a class="rssfeed" title="Subscribe to our RSS Feed" href="' . $rss_feed_url . '">RSS</a></li>';
            ?>
        </ul>
    </div>
<?php
}

function mo_get_thumbnail_args_for_singular() {
    $layout_manager = MO_LayoutManager::getInstance();

    /* Set the default arguments. */
    $args = array('shadow' => true,
        'size' => 'full',
        'before_html' => '<span>',
        'after_html' => '</span>',
        'image_scan' => false, /* Do not scan content for images - do not want to duplicate the image in content. Use featured image only */
        'attachment' => false /* Show only featured images as post image on the top */
    );

    $retain_image_height = mo_get_theme_option('mo_retain_image_height');

    if ($layout_manager->is_full_width_layout()) {
        $args['image_size'] = 'slider-thumb';
        $args['image_class'] = 'featured thumbnail full-1c';
        $args['shadow_class'] = 'full-1c';
    }
    else {
        $args['image_size'] = 'list-thumb';
        $args['image_class'] = 'featured thumbnail full';
        $args['shadow_class'] = 'full';
    }

    if ($retain_image_height) {
        if ($layout_manager->is_full_width_layout())
            $args['image_size'] = array('width' => 1140, 'height' => 0);
        else
            $args['image_size'] = array('width' => 820, 'height' => 0);
    }

    return $args;
}

function mo_is_youtube($video_url) {
    if (strpos($video_url, "youtube.com") || strpos($video_url, "youtu.be"))
        return true;
    else return false;
}

function mo_is_vimeo($video_url) {
    if (strpos($video_url, "vimeo.com"))
        return true;
    else
        return false;
}

function mo_get_youtube_id($video_url) {
    preg_match('#(?:https?(?:a|vh?)?://)?youtu\.be/([A-Za-z0-9\-_]+)#', $video_url, $matches);
    return $matches[1];
}

function mo_get_vimeo_id($video_url) {
    preg_match('#(?:http://)?(?:www\.)?vimeo\.com/([A-Za-z0-9\-_]+)#', $video_url, $matches);
    return $matches[1];
}