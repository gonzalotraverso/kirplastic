<?php
/**
 * Template Name: Portfolio 3 Column
 *
 * A custom page template for showing the most popular posts based on number of reader comments
 *
 * @package Squash
 * @subpackage Template
 */
get_header();
?>

<div id="portfolio-template">

    <?php
    $args = array(
        'number_of_columns' => 3,
		'image_size' => 'large-thumb',
        'posts_per_page' => 6,
        'filterable' => false
    );

    mo_display_portfolio_content($args);
    ?>

</div> <!-- portfolio-template -->

<?php mo_display_sidebars(); ?>

<?php
get_footer(); // Loads the footer.php template. ?>