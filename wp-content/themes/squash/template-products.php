


<?php

/**
* Template Name: Products
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

        <div class="hfeed">
           <?php $cats = get_categories('parent=0'); ?>
                <ul class="products">
                <?php foreach ($cats as $c => $v): ?>
                    <li>
                        <div class="prod-img-wrapper">
                            <a href="<?php echo get_category_link($v->cat_ID); ?>">
                                <img src="<?php the_field('imagen', 'category_'.$v->cat_ID); ?>">
                            </a>
                        </div>
                        <div class="prods-link-wrapper">
                            <a href="<?php echo get_category_link($v->cat_ID); ?>">
                                <?php echo strtoupper($v->name); ?>
                            </a>
                        </div>
                    </li>
                <?php endforeach ?>
                </ul>
            


            <p><?php the_content(); ?></p>

       
    <?php wp_reset_query(); ?>
</div>
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>


    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php mo_display_sidebars(); ?>
</div>
<?php get_footer(); ?>

