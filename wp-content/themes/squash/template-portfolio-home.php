<?php
/**
 * Template Name: Portfolio Home
 *
 * A page template for home page layout featuring portfolio items.
 * @link http://www.portfoliotheme.org/
 *
 * @package Squash
 * @subpackage Template
 */

get_header(); // displays slider content if so chosen by user
?>


<div id="homepage-wrap" class="clearfix">

    <div id="content" class="<?php echo mo_get_content_class();?>">

        <div id="portfolio-full-width">

            <?php
            $args = array(
                'number_of_columns' => 3,
                'image_size' => 'large-thumb',
                'posts_per_page' => 9,
                'filterable' => true
            );

            mo_display_home_portfolio_content($args);
            ?>

        </div>
        <!-- portfolio-full-width -->


        <?php while (have_posts()) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="entry-content clearfix">
                <?php the_content(); ?>
            </div>
            <!-- .entry-content -->

        </div><!-- .hentry -->

        <?php endwhile; ?>

    </div>
    <!-- #content -->

</div><!-- homepage-wrap -->

<?php get_footer(); ?>
