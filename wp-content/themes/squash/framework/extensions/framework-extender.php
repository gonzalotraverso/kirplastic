<?php

/**
 * Framework Extender - Extends theme functions, handles customizations
 *
 *
 * @package Livemesh_Framework
 */
class MO_Framework_Extender {

    private static $instance;

    /**
     * Construct method for the MO_Framework_Extender class.
     */
    private function __construct() {

    }

    /**
     * Constructor method for the MO_Framework_Extender class.
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
     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * Init method for the MO_Framework_Extender class.
     */
    function initialize() {

        /* Get action/filter hook prefix. */
        $prefix = mo_get_prefix();

        /* Add the breadcrumb trail just after the container is open. */
        $show_breadcrumbs = mo_get_theme_option('mo_hide_breadcrumbs') ? false : true;
        if ($show_breadcrumbs) {
            add_action("{$prefix}_start_content", array(&$this, 'display_breadcrumbs'), 15); // Display after the start content
        }

        $display_sticky_menu = mo_get_theme_option('mo_disable_sticky_menu') ? false : true;
        if ($display_sticky_menu) {
            add_action("{$prefix}_before_header", array(&$this, 'display_sticky_menu'), 15); // Display before header starts
        }

        add_action('wp_footer', array(&$this, 'enable_google_analytics'));

        $this->handle_social_fields_for_users();

        add_action('tgmpa_register', array(&$this, 'my_theme_register_required_plugins'));

        /* Embed width/height defaults. Sets dynamically the width and height for videos based on current column width */
        add_filter('embed_defaults', array(&$this, 'set_defaults_for_embeds'));

        /* Filter the comment form defaults. */
        add_filter('comment_form_defaults', array(&$this, 'set_comment_form_args'), 11);

        add_filter('the_content_more_link', array(&$this, 'remove_more_link'));

        add_filter('body_class', array(&$this, 'mo_browser_body_class'));

    }

    /**
     * Register the required plugins for this theme.
     *
     * In this example, we register two plugins - one included with the TGMPA library
     * and one from the .org repo.
     *
     * The variable passed to tgmpa_register_plugins() should be an array of plugin
     * arrays.
     *
     * This function is hooked into tgmpa_init, which is fired within the
     * TGM_Plugin_Activation class constructor.
     */
    function my_theme_register_required_plugins() {

        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(

            // This is an example of how to include a plugin pre-packaged with a theme
            array(
                'name' => 'Revolution Slider', // The plugin name
                'slug' => 'revslider', // The plugin slug (typically the folder name)
                'source' => get_template_directory() . '/framework/plugins/revslider.zip', // The plugin source
                'required' => true, // If false, the plugin is only 'recommended' instead of required
                'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url' => '', // If set, overrides default API URL and points to an external URL
            )

        );

        // Change this to your theme text domain, used for internationalising strings
        $theme_text_domain = 'mo_theme';

        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
            'domain' => $theme_text_domain, // Text domain - likely want to be the same as your theme.
            'default_path' => '', // Default absolute path to pre-packaged plugins
            'parent_menu_slug' => 'themes.php', // Default parent menu slug
            'parent_url_slug' => 'themes.php', // Default parent URL slug
            'menu' => 'install-required-plugins', // Menu slug
            'has_notices' => true, // Show admin notices or not
            'is_automatic' => false, // Automatically activate plugins after installation or not
            'message' => '', // Message to output right before the plugins table
            'strings' => array(
                'page_title' => __('Install Required Plugins', $theme_text_domain),
                'menu_title' => __('Install Plugins', $theme_text_domain),
                'installing' => __('Installing Plugin: %s', $theme_text_domain), // %1$s = plugin name
                'oops' => __('Something went wrong with the plugin API.', $theme_text_domain),
                'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.'), // %1$s = plugin name(s)
                'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'), // %1$s = plugin name(s)
                'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'), // %1$s = plugin name(s)
                'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'), // %1$s = plugin name(s)
                'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins'),
                'activate_link' => _n_noop('Visit plugins page to activate installed plugin', 'Activate installed plugins'),
                'return' => __('Return to Required Plugins Installer', $theme_text_domain),
                'plugin_activated' => __('Plugin activated successfully.', $theme_text_domain),
                'complete' => __('All plugins installed and activated successfully. %s', $theme_text_domain), // %1$s = dashboard link
                'nag_type' => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )
        );

        tgmpa($plugins, $config);
    }

    function mo_browser_body_class($classes) {
        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

        if ($is_lynx)
            $classes[] = 'lynx';
        elseif ($is_gecko)
            $classes[] = 'gecko';
        elseif ($is_opera)
            $classes[] = 'opera';
        elseif ($is_NS4)
            $classes[] = 'ns4';
        elseif ($is_safari)
            $classes[] = 'safari';
        elseif ($is_chrome)
            $classes[] = 'chrome';
        elseif ($is_IE) {
            $classes[] = 'ie';
            if (preg_match('/MSIE ( [0-9]+ )( [a-zA-Z0-9.]+ )/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
                $classes[] = 'ie' . $browser_version[1];
        }
        else $classes[] = 'unknown';
        if ($is_iphone)
            $classes[] = 'iphone';
        return $classes;
    }

    function register_required_plugins() {

    }

    function display_breadcrumbs() {
        $disable_breadcrumbs_for_entry = get_post_meta(get_queried_object_id(), 'mo_disable_breadcrumbs_for_entry', true);
        if (empty($disable_breadcrumbs_for_entry)) {
            mo_breadcrumb();
        }
    }

    function display_sticky_menu() {
        echo '<div id="sticky-menu-container">';
        echo '<div class="inner">';
        echo mo_get_sticky_site_title();
        get_template_part('menu', 'sticky'); // Loads the menu-sticky.php template.
        echo '</div>';
        echo '</div>';
    }

    function remove_more_jump_link($link) {
        $offset = strpos($link, '#more-');
        if ($offset) {
            $end = strpos($link, '"', $offset);
        }
        if ($end) {
            $link = substr_replace($link, '', $offset, $end - $offset);
        }
        return $link;
    }

    function remove_more_link() {
        $html = "&nbsp;[&middot;&middot;&middot;]";
        return $html;
    }

    /**
     * Extend the user profile page to handle social network information for individual authors
     * Credit - http://wpsplash.com/how-to-create-a-wordpress-authors-page/
     * @param
     * @return
     */
    function handle_social_fields_for_users() {
        add_action('show_user_profile', array(&$this, 'insert_extra_profile_fields'));
        add_action('edit_user_profile', array(&$this, 'insert_extra_profile_fields'));
        add_action('personal_options_update', array(&$this, 'save_extra_profile_fields'));
        add_action('edit_user_profile_update', array(&$this, 'save_extra_profile_fields'));
    }

    function save_extra_profile_fields($userID) {

        if (!current_user_can('edit_user', $userID)) {
            return false;
        }

        update_user_meta($userID, 'twitter', $_POST['twitter']);
        update_user_meta($userID, 'facebook', $_POST['facebook']);
        update_user_meta($userID, 'linkedin', $_POST['linkedin']);
        update_user_meta($userID, 'googleplus', $_POST['googleplus']);
        update_user_meta($userID, 'flickr', $_POST['flickr']);
    }

    function insert_extra_profile_fields($user) {
        ?>
        <h3>Connect Information</h3>

        <table class='form-table'>
            <tr>
                <th><label for='twitter'>Twitter</label></th>
                <td>
                    <input type='text' name='twitter' id='twitter'
                           value='<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>'
                           class='input-social regular-text'/>
                    <span class='description'>Please enter your Twitter username. http://www.twitter.com/<strong>username</strong></span>
                </td>
            </tr>
            <tr>
                <th><label for='facebook'>Facebook</label></th>
                <td>
                    <input type='text' name='facebook' id='facebook'
                           value='<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>'
                           class='input-social regular-text'/>
                    <span
                        class='description'>Please enter your Facebook username/alias. http://www.facebook.com/<strong>username</strong></span>
                </td>
            </tr>
            <tr>
                <th><label for='linkedin'>LinkedIn</label></th>
                <td>
                    <input type='text' name='linkedin' id='linkedin'
                           value='<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>'
                           class='input-social regular-text'/>
                    <span class='description'>Please enter your LinkedIn username. http://www.linkedin.com/in/<strong>username</strong></span>
                </td>
            </tr>
            <tr>
                <th><label for='googleplus'>Google Plus</label></th>
                <td>
                    <input type='text' name='googleplus' id='googleplus'
                           value='<?php echo esc_attr(get_the_author_meta('googleplus', $user->ID)); ?>'
                           class='input-social regular-text'/>
                    <span class='description'>Please enter your Google Plus username. http://plus.google.com/<strong>username</strong></span>
                </td>
            </tr>
            <tr>
                <th><label for='flickr'>Flickr</label></th>
                <td>
                    <input type='text' name='flickr' id='flickr'
                           value='<?php echo esc_attr(get_the_author_meta('flickr', $user->ID)); ?>'
                           class='input-social regular-text'/>
                    <span class='description'>Please enter your flickr username. http://www.flickr.com/photos/<strong>username</strong>/</span>
                </td>
            </tr>
        </table>

    <?php
    }


    /**
     * Creates custom settings for the WordPress comment form.
     */
    function set_comment_form_args($args) {
        $args['label_submit'] = __('Post Comment', 'mo_theme');
        return $args;
    }

    /**
     * Overwrites the default widths for embeds.This is especially useful for making sure videos properly
     * expand the full width on video pages.This function overwrites what the $content_width variable handles
     * with context-based widths.
     *
     */
    function set_defaults_for_embeds($args) {

        $layout_manager = MO_LayoutManager::getInstance();

        if ($layout_manager->is_full_width_layout())
            $args['width'] = 1140;
        else
            $args['width'] = 820;

        return $args;
    }

    /* Enable Google Analytics for every post/page */

    function enable_google_analytics() {

        $analytics_code = mo_get_theme_option('mo_google_analytics_code');

        if (isset($analytics_code))
            echo '<div class="hidden">' . $analytics_code . '</div>';
    }

}