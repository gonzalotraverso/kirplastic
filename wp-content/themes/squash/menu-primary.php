<?php
/**
 * Primary Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 * @package Squash
 * @subpackage Template
 */

if (has_nav_menu('primary')) : ?>

<div class="pimary-menu-wrapper">
	<div id="primary-menu" class="dropdown-menu-wrap clearfix">
	
	    <?php wp_nav_menu(array('theme_location' => 'primary',
	    'container' => false,
	    'menu_class' => 'menu my-primary-menu',
	    'menu_id' => '',
	    'fallback_cb' => false,
	    'after' => '<p>/</p>',
	    'link_after' => '<div class="menu-hover-wrap"><div class="menu-hover-anim"></div></div>'
	)); ?>
	
	</div>
</div><!-- #menu-primary .menu-container -->

<?php endif; ?>