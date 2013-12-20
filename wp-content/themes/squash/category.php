<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Squash
 * @subpackage Template
 */



get_header();
?>
<div class="single-uber-wrapper">
<?php mo_exec_action('before_content'); ?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_exec_action('start_content'); ?>
        
        <div class="hfeed" id="<?php echo $cat->cat_ID; ?>">
            <?php $cat = get_category( get_query_var( 'cat' ) ); ?>
            <?php $cat_check = has_sub_cat($cat->cat_ID); ?>
            <script type="text/javascript">
                var this_id = <?php echo $cat->cat_ID ?>;
            </script>
            <?php if (!empty($cat_check)): ?>
            	<?php $cats = get_categories('parent='.intval($cat->cat_ID)); ?>
            	<ul id="category-listing">
            	<?php foreach ($cats as $c => $v): ?>
            		<li>
                        <div class="cat-img-wrapper">
                            <a href="<?php echo get_category_link($v->cat_ID); ?>"><img src="<?php the_field('imagen', 'category_'.$v->cat_ID); ?>"></a>
                        </div>
            			<a href="<?php echo get_category_link($v->cat_ID); ?>"><?php echo strtoupper($v->name); ?></a>
            		</li>
            	<?php endforeach ?>
            	</ul>
            <?php else: ?>
            	<?php
            	if(have_posts()) :
            		while (have_posts()) : the_post();
            	wp_redirect(get_permalink($post->ID));
            	endwhile;
            	endif;
            	?>
            <?php endif ?>
        </div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>


    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php mo_display_sidebars(); ?>
</div>
<?php get_footer(); ?>