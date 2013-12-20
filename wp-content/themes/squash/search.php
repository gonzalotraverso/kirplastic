<?php
/**
 * Search Template
 *
 * This template is loaded when viewing search results and replaces the default template.
 * 
 * @package Squash
 * @subpackage Template
 */



get_header(); ?>
<?php mo_exec_action('before_content'); ?>
<div id="left_nav_2c_template" class="layout-2c-r">
<div id="content" class="<?php echo mo_get_content_class(); ?> ">
	<?php mo_exec_action('start_content'); ?>
 <?php if ( have_posts() ) : ?>

                
 			<ul>
                

                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
                <li>
                	<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                    
                </li>
                <?php endwhile; ?>

                
            </ul>
            <?php else : ?>

                <?php get_template_part( 'no-results', 'search' ); ?>

            <?php endif; ?>
            <?php mo_exec_action('end_content'); ?>
</div><!-- #content -->
<?php mo_exec_action('after_content'); ?>
<?php mo_display_sidebars(); ?>
</div>
<?php

get_footer(); 

?>