<?php
/**
 * Header Template
 *
 * This template is loaded for displaying header information for the website. Called from every page of the website.
 *
 * @package Squash
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>

    <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php wp_title('|', true, 'right');
        bloginfo('name'); ?></title>

    <!-- For use in JS files -->
    <script type="text/javascript">
        var template_dir = "<?php echo get_template_directory_uri(); ?>";
    </script>

    <link rel="profile" href="http://gmpg.org/xfn/11"/>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <?php mo_setup_theme_options_for_scripts(); ?>

    <?php wp_head(); // wp_head  ?>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jQueryRotateCompressed.js"></script>

    <script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js/jquery.fancybox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/css/jquery.fancybox.css">
</head>

<body <?php body_class(); ?>>

<?php mo_exec_action('start_body'); ?>

<div id="container-wrap">

    <div id="container">

        <?php mo_exec_action('before_header'); ?>

        <div id="header-area-wrap">

            <div class="custom-header-top-line"></div>

            <div id="header-area" class="clearfix">

                <div id="header" class="clearfix">

                    <?php mo_exec_action('start_header'); ?>

                    <div id="header-logo" class="clearfix">

                        <?php mo_site_title(); ?>
                        <?php mo_site_description(); ?>

                    </div>
                    <!-- #header-logo -->

                    <?php mo_exec_action('header'); ?>

                    <?php //mo_populate_social_icons(); ?>
                    <?php get_template_part('menu', 'primary'); // Loads the menu-primary.php template.    ?>

                    <?php echo '<a id="mobile-menu-toggle" href="#"><i class="icon-list-3"></i>&nbsp;</a>'; ?>

                    <?php mo_exec_action('end_header'); ?>

                </div>
            </div>
            <div class="custom-header-bottom-line"></div>
        </div>

        <?php get_template_part('menu', 'mobile'); // Loads the menu-mobile.php template.    ?>

        

        <?php mo_exec_action('after_header'); ?>

        <?php mo_populate_top_area(); ?>

        <div id="box-wrap" class="clearfix">

            <?php mo_exec_action('before_main'); ?>

            <div id="main" class="clearfix">

                <?php mo_exec_action('start_main'); ?>
