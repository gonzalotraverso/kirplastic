<?php
/**
 * Sticky Menu Template
 *
 * Displays the Sticky Menu if it has active menu items.
 *
 * @package Squash
 * @subpackage Template
 */

if ( has_nav_menu( 'sticky' ) ) : ?>

	<div id="sticky-menu" class="dropdown-menu-wrap">

			<?php wp_nav_menu( array( 'theme_location' => 'sticky', 'container' => false, 'menu_class' => 'menu', 'menu_id' => '', 'depth' => 3, 'fallback_cb' => false ) ); ?>

	</div><!-- #menu-sticky .menu-container -->

<?php endif; ?>