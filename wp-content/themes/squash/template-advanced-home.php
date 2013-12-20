<?php
/**
 * Template Name: Advanced Home Page
 *
 * A page template for advanced home page layout involving sliders, featured stories and categories.
 * @link http://www.portfoliotheme.org/
 *
 * @package Squash
 * @subpackage Template
 */
get_header(); // displays slider content if so chosen by user 
?>

<div id="homepage-wrap" class="clearfix">

    <?php
    /* Let's start the content here for consistency and keep the sliders lonely in header area */
    get_template_part("page-content-lite");
    ?>

</div><!-- homepage-wrap -->

<?php get_footer(); ?>



