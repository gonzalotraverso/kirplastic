<?php

/**
 * The functions file to initialize everything - add features, extensions, override hooks and filters.
 *
 *
 * @package Squash
 * @subpackage Functions
 * @version 1.0
 * @author LiveMesh
 * @copyright Copyright (c) 2012, LiveMesh
 * @link http://portfoliotheme.org/
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

$theme_cache = array();
$options_cache = array();

/* Load the Livemesh theme framework. */
require_once( get_template_directory() . '/framework/framework.php' );
$mo_theme = new MO_Framework();


function category_custom(){
	$sincat = get_term_by('name', 'sin categoría', 'catablog-terms');

	global $wpdb; 
	



	$args = array(
	'type'                     => 'post',
	'exclude'                  => $sincat->name,
	'taxonomy'                 => 'catablog-terms',
	'pad_counts'               => false );
	$categories = get_categories( $args );
	foreach ($categories as $category) {

		$wpdb->show_errors(); 
		$random_prod = $wpdb->get_var("
		select object_id from wp_term_relationships
		where term_taxonomy_id = '".$category->cat_ID."'
		order by RAND()
		LIMIT 1;
		");
		

		$data = get_post_meta($random_prod, 'catablog-post-meta', true);


		$sub_images = $data['image'];
		$path = $wp_plugin_catablog_class->urls['originals'] . "/";
		var_dump($wp_plugin_catablog_class->urls);
		 ?>
		 <?php $item = catablog_get_item($random_prod); 
		 var_dump($item->urls);
		 ?>
			<img src="<?php echo $path; ?><?php echo $sub_images; ?>" class="catablog-image catablog-subimage" />
		<?php	
		/*
		if( $my_query->have_posts() ) {
			while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<?php the_title(); ?>
			<?php var_dump($my_query->the_post()); ?>
			<?php  ?>
			<?php $sub_images = $data['sub-images']; ?>
			<?php $path = $wp_plugin_catablog_class->urls['thumbnails'] . "/"; ?>

			<?php foreach ($sub_images as $sub_image): ?>
			<img src="<?php echo $path; ?><?php echo $sub_image; ?>" class="catablog-image catablog-subimage" />
		<?php endforeach ?>
		<?php		endwhile;
	}*/
	wp_reset_query();
	echo $category->cat_name;
	
}
}

add_shortcode('category_cust', 'category_custom');

function has_sub_cat($id){
	return get_categories('parent='.intval($id));
}

function get_sub_cat($id, $lvl){
	$subcat = has_sub_cat($id);
	if (!empty($subcat)) { 
		?>
	<ul class="sub-ul">
	<?php	foreach ($subcat as $sub) { ?>
			<li class="sub-ul-li" id="cat_<?php echo $sub->cat_ID; ?>">
				<a href="<?php echo get_category_link($sub->cat_ID); ?>" style="padding-left: <?php echo $lvl; ?>px"><?php echo $sub->cat_name; ?></a>
				<?php get_sub_cat($sub->cat_ID, $lvl+20); ?>
			</li>
			
	<?php	} ?>
	</ul>
	<?php 
	}
	
}

function categories_sidebar(){ ?>
<div class="sidebar-nav">
	<h3>Productos por categoría</h3>
	<?php
	$args = array('hide_empty' => '0', 'order'=>'DESC');
	$categories = get_categories(); ?>
	<ul class="root-ul">
	<?php foreach ($categories as $cat):?>
	<?php if ($cat->parent == '0'): ?>
		<li class="root-ul-li" id="cat_<?php echo $cat->cat_ID; ?>">
			<a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->cat_name; ?></a>
			<?php 
			$cat_check = has_sub_cat($cat->cat_ID);
			if(!empty($cat_check)){ ?>
			<img class="sidebar-arrow" src="<?php bloginfo('template_directory'); ?>/images/icons/sidebar-arrow.png">
			<?php get_sub_cat($cat->cat_ID, 20); ?>
			<?php } ?>
			<div class="sidebar-divider"></div>
		</li>

	<?php endif ;
	endforeach ; ?>
	</ul>
</div>
<?php } 

add_shortcode('cat_side', 'categories_sidebar');


//the_field( "imagen", 'category_'.$cat->cat_ID );  ESTO ES PARA IMAGENES DE LAS CATEGORIAS



function the_breadcrumb() {
        echo '<ul id="breadcrumbs">';
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo "</a></li>";
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li> ');
            if (is_single()) {
                echo "</li><li>";
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            echo '<li>';
            echo the_title();
            echo '</li>';
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
    elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
    echo '</ul>';
}





/* Change menu items */

function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Productos';
	$submenu['edit.php'][5][0] = 'Productos';
	$submenu['edit.php'][10][0] = 'Añadir Nuevo';
	$submenu['edit.php'][16][0] = 'Etiquetas';
	echo '';
}

function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Productos';
	$labels->singular_name = 'Producto';
	$labels->add_new = 'Agregar';
	$labels->add_new_item = 'Agregar Producto';
	$labels->edit_item = 'Editar Producto';
	$labels->new_item = 'Producto';
	$labels->view_item = 'Ver Productos';
	$labels->search_items = 'Buscar Producto';
	$labels->not_found = 'No se encontró ningun producto';
	$labels->not_found_in_trash = 'No se encontró ningun producto en la papelera';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );


//allow redirection, even if my theme starts to send output to the browser
add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}


?>


	



	

