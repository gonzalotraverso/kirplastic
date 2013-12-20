<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins.
 *
 * @package Squash
 * @subpackage Template
 */
?>

<?php mo_exec_action('end_main'); ?>

</div><!-- #main -->

<?php mo_exec_action('after_main'); ?>

</div><!-- #box-wrap -->

</div><!-- #container -->

<?php
$sidebar_manager = MO_SidebarManager::getInstance();

if ($sidebar_manager->is_footer_area_active()):
    ?>
<?php mo_exec_action('before_bottom_area'); ?>

<div id="bottom-area-wrap">

    <div id="bottom-area">

        <?php mo_exec_action('start_bottom_area'); ?>

        <div id="sidebars-footer" class="clearfix">

            <?php
            mo_exec_action('start_sidebar_footer');

            $sidebar_manager->populate_footer_sidebars();

            mo_exec_action('end_sidebar_footer');
            ?>

        </div>
        <!--end sidebars-footer -->

        <?php mo_exec_action('end_bottom_area'); ?>

    </div> <!--end bottom-area-->

</div>  <!--end bottom-area-wrap-->

<?php endif; ?>

<?php mo_exec_action('before_footer'); ?>

<div id="footer">

    <?php mo_exec_action('start_footer'); ?>

    <div id="footer-inner">

        <?php mo_populate_social_icons(); ?>

        <?php mo_footer_content(); ?>

        <?php mo_exec_action('footer'); // WP hook ?>

    </div>
    <!-- .wrap -->

    <?php mo_exec_action('end_footer'); ?>

</div><!-- #footer -->

<?php mo_exec_action('after_footer'); ?>

</div><!-- #container-wrap -->

<?php mo_exec_action('end_body'); ?>


<?php wp_footer(); // wp_footer    ?>
<?php if(is_category() || is_single()): ?>
    <script type="text/javascript">
        jQuery(function() {
            displaySidebar(this_id);
        });
    </script>
<?php endif ?>
</body>
</html>