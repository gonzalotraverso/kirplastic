<?php
/**
 * Home Template
 *
 * This template is loaded as the home page. Can be overridden by user by specifying a static
 * page as home page in the Wordpress admin panel, under 'Reading' admin page. 
 * 
 * @package Squash
 * @subpackage Template
 */

get_header(); 

mo_display_starter_content(); 

mo_display_sidebars();

get_footer(); 

?>