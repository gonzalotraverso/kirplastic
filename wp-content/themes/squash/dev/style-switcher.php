<?php
/**
 * A style switcher component for showcasing in marketplace only. Not for customer
 *
 * @package Squash
 * @subpackage Template
 */
$dev_dir = get_template_directory_uri() . '/dev';
?>
<div id="styleswitcher" class="styleswitcher-open">

    <div id="styleswitcher-wrapper">

        <div id="styleswitcher-section-appearance">

            <div class="styleswitcher-section" id="styleswitcher-theme-skin">

                <span class="styleswitcher-section-title">Skins</span>

                <ul class="styleswitcher-list">
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/colors/default.png"
                             alt="Default" title="Default"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/colors/green.png"
                             alt="Green" title="Green"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/colors/orange.png"
                             alt="Orange" title="Orange"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/colors/teal.png"
                             alt="Teal" title="Teal"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/colors/pink.png"
                             alt="Pink" title="Pink"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/colors/cyan.png"
                             alt="Cyan" title="Cyan"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/colors/red.png"
                             alt="Red" title="Red"/></li>
                </ul>

            </div>


            <div class="styleswitcher-section" id="styleswitcher-boxed-bg">

                <!-- .styleswitcher-section -->

                <span class="styleswitcher-section-title">Boxed BG</span>

                <div class="checkbox-holder">
                    <input name="boxedLayout" id="boxed-layout" type="checkbox" value="Boxed">
                    <label for="boxed-layout">Boxed</label>
                </div>


                <span class="styleswitcher-title">BG Images</span>

                <ul class="styleswitcher-list">
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background1-thumb.png"
                             alt="pattern-opaque-1"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background2-thumb.png"
                             alt="pattern-opaque-2"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background3-thumb.png"
                             alt="pattern-opaque-3"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background4-thumb.png"
                             alt="pattern-opaque-4"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background5-thumb.png"
                             alt="pattern-opaque-5"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background6-thumb.png"
                             alt="pattern-opaque-6"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background7-thumb.png"
                             alt="pattern-opaque-7"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background8-thumb.png"
                             alt="pattern-opaque-8"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background9-thumb.png"
                             alt="pattern-opaque-9"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/bg-images/thumbs/background10-thumb.png"
                             alt="pattern-opaque-10"/></li>

                </ul>


                <span class="styleswitcher-colorpicker-title">BG Color</span>

                <div class="colorpicker-wrapper">
                    <div class="colorSelector" id="colorSelector-bg-color">
                        <div style="background-color: #fff"></div>
                    </div>
                    <div class="colorpickerHolder" id="colorpickerHolder-bg-color"></div>
                    <input type="hidden" class="real-value" name="bg-color" value="#fff"/>
                </div>


                <span class="styleswitcher-title">BG Pattern</span>

                <ul class="styleswitcher-list">
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-1-thumb.png"
                             alt="pattern-1"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-2-thumb.png"
                             alt="pattern-2"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-3-thumb.png"
                             alt="pattern-3"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-4-thumb.png"
                             alt="pattern-4"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-5-thumb.png"
                             alt="pattern-5"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-6-thumb.png"
                             alt="pattern-6"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-7-thumb.png"
                             alt="pattern-7"/></li>
                    <li><img src="<?php echo $dev_dir; ?>/images/styleswitcher/patterns/thumbs/pattern-8-thumb.png"
                             alt="pattern-8"/></li>
                </ul>


            </div>
            <!-- .styleswitcher-section -->

        </div>
        <!-- #styleswitcher-section-appearance -->

        <a href="#" id="styleswitcher-reset-button" class="button squash small">Reset All</a>

    </div>
    <!-- #styleswitcher-wrapper -->

    <a href="#" id="styleswitcher-button"><i class="icon-cogs-2"></i></a>

</div><!-- #styleswitcher -->		
