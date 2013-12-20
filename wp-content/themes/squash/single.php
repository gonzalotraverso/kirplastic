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

        <div class="hfeed single-content">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>
                    <?php $curr_id = get_the_ID(); ?>
                    <div class="single-item-top">
                        <div class="breadcrumbs-wrapper">
                            <img src="<?php echo get_bloginfo('template_directory'); ?>/images/squares.gif">
                            <?php /* ?>
                            <p>&nbsp; Volver a Categor&iacute;as</p>
                            <p>&nbsp; ||&nbsp; </p>
                            <?php */ ?>
                            <div class="breadcrumbs-cont">  
                            &nbsp; 
                                <?php $cat = get_the_category(); ?>
                                <?php $bread = get_category_parents( $cat[0]->cat_ID, true, ' &gt; ' ); ?>
                                <?php echo substr($bread, 0, -5); ?>
                                <script type="text/javascript">
                                    var this_id = <?php echo $cat[0]->cat_ID ?>;
                                </script>
                            </div>
                        </div>
                        <div class="posts-nav">
                            <?php next_post_link('<div class="next-link">%link</div>', '', TRUE); ?>
                            <?php previous_post_link('<div class="prev-link">%link</div>', '', TRUE); ?>
                        </div>
                    </div>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="clear: both">
                        <div class="entry-content clearfix">

                            <div class="single-img-wrap">
                                <?php $img = get_field('imagen'); ?>
                                <?php if($img != null): ?>
                                    <a id="single_image_prod" href="<?php the_field('imagen'); ?>"><img src="<?php the_field('imagen'); ?>" alt=""/></a>
                                <?php else: ?>
                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/images/no-img.gif" alt="" />  
                                <?php endif ?>
                            </div>
                            <div class="single-side-info">
                                <div class="single-info-wrap">
                                        <h3><?php the_title(); ?></h3>
                                        <?php the_field('descripcion'); ?>
                                        <?php the_content(); ?>
                                </div>
                            </div>
                            <div style="clear: both"></div>
                            <div class="same_cat_prods">
                                <ul>
                                    <?php 
                                    $nested_args = array('cat' => $cat[0]->cat_ID, 'posts_per_page' => -1);
                                    $my_query = new WP_Query( $nested_args );
                                    if ( $my_query->have_posts() ) { 
                                       while ( $my_query->have_posts() ) { 
                                           $my_query->the_post(); ?>
                                           <?php $related_id = $my_query->post->ID; ?>
                                           <?php if ($curr_id != $related_id): ?>
                                        <li>
                                            <a href="<?php the_permalink() ?>">
                                                <?php if(get_field('imagen') != null): ?>
                                                    <span class="img-helper"></span><img src="<?php the_field('imagen'); ?>" title="<?php the_title(); ?>"> 
                                                <?php else: ?>
                                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/images/no-img.gif" alt="<?php the_title(); ?>" />  
                                                <?php endif ?>
                                            </a>
                                        </li>
                                           <?php endif ?>
                                        <?php  }
                                    }
                                    wp_reset_postdata();
                                    ?>
                                 </ul>
                                 <div style="clear: both"></div>
                            </div>
                            

                        </div>
                        <!-- .entry-content -->

                    </div><!-- .hentry -->
                    <div class="categories-thumbs">
                        <?php $cat_p = get_cat_name ($cat[0]->category_parent); ?>
                        <h3>Otras categorías en <?php echo $cat_p ?></h3>
                        <ul>
                            <?php $cats_thumbs_args  = array('parent' => $cat[0]->parent); 
                              $cats_thumbs = get_categories($cats_thumbs_args); ?>
                              <?php foreach ($cats_thumbs as $ct => $v): ?>
                                  <li>
                                    <a href="<?php echo get_category_link($v->cat_ID); ?>"><img src="<?php the_field('imagen', 'category_'.$v->cat_ID); ?>"></a>
                                    <div class="cats-thumbs-text">
                                        <a href="<?php echo get_category_link($v->cat_ID); ?>"><?php echo strtoupper($v->name); ?></a>
                                    </div>
                                  </li>
                              <?php endforeach ?>
                        </ul>
                    </div>
                <?php endwhile; ?>

            <?php endif; ?>

        </div>
        
        <!-- .hfeed -->

        <?php mo_exec_action('end_content'); ?>

        <?php //get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php mo_exec_action('after_content'); ?>

<?php mo_display_sidebars(); ?>
</div>

<?php get_footer(); ?>