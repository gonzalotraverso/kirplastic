<?php

/**
 * Template Name: Blog
 *
 * This is the blog template. 
 *
 * @package Squash
 * @subpackage Template
 */
get_header(); 

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$query = array('posts_per_page' => intval(get_option('posts_per_page')), 'ignore_sticky_posts' => 0, 'paged' => $paged);

mo_display_starter_content($query);

mo_display_sidebars();

get_footer();  
?>