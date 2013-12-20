<?php
/**
 * Mobile Menu Template
 *
 * Displays the Mobile Menu if it has active menu items.
 *
 * @package Squash
 * @subpackage Template
 */

if (has_nav_menu('primary')) : ?>

    <div id="mobile-menu" class="menu-container clearfix">

        <?php wp_nav_menu(array('theme_location' => 'primary',
            'container' => false,
            'menu_class' => 'menu',
            'menu_id' => '',
            'fallback_cb' => false
        )); ?>

    </div><!-- #mobile-menu -->

<?php endif; ?>