jQuery.noConflict(); // Let go of $ to other libraries

/* Remove a class */
function remove_class_from_body(class_excerpt) {

    var classList = jQuery('body').attr('class').split(/\s+/);
    jQuery.each(classList, function (index, item) {

        if (item.indexOf(class_excerpt) != -1) {
            jQuery('body').removeClass(item);
        }

    });

}

jQuery(document).ready(function ($) {

    jQuery('.colorpicker-wrapper').each(function () {

        /* --------------------- Switch to either Stretched or Boxed Layout ---------------------- */

        $('input#boxed-layout').click(function () {

            var boxed = $(this)[0].checked;
            /* Set cookie */
            if (boxed)
                $.cookie('mo_boxed_layout', true, { path: '/' });
            else
                $.cookie('mo_boxed_layout', null, { path: '/' });
            location.reload(true);

        });

        if ($.cookie('mo_boxed_layout')) {
            $('input#boxed-layout')[0].checked = true;
        }

        /* --------------------- Switch to either Stretched or Boxed Layout ---------------------- */
        var colorpicker = $(this);
        var colorpickerHolder = $(this).find('.colorpickerHolder');
        var colorSelector = $(this).find('.colorSelector');

        var saved_color_value = $.cookie('mo_boxed_bg_color');
        if (saved_color_value != null)
            colorpicker.find('.real-value').val(saved_color_value);

        var color_value = colorpicker.find('.real-value').val();
        var field_container = colorpicker.parents('.jw-field-content');

        colorpickerHolder.ColorPicker({
            flat: true,
            color: color_value,
            onSubmit: function (hsb, hex, rgb) {
                colorpicker.find('.colorSelector div').css('backgroundColor', '#' + hex);
                colorpicker.find('.real-value').val('#' + hex);
                var new_color = '#' + hex;
                /* Set cookie */
                $.cookie('mo_boxed_bg_color', new_color, { path: '/' });
                $('body.boxed').css('background-color', new_color);
            }
        });

        colorpicker.find('.colorSelector div').css('background-color', color_value);
        if (color_value != "#fff")
            $('body.boxed').css('background-color', color_value);
        else
            $('body.boxed').css('background-color', "#eee");


        colorpicker.find('.colorpickerHolder>div').css('position', 'absolute');
        var widt = false;
        colorSelector.bind('click', function () {
            colorpickerHolder.stop().animate({height: widt ? 0 : 173}, 500);
            widt = !widt;
        });

    });

    /* Open Styleswitcher Appearance */
    $('#styleswitcher-button').click(function () {
        if ($('#styleswitcher-wrapper').css('left') != '0px') {
            $('#styleswitcher-wrapper').animate({"left": "0px"}, { duration: 300 });
            $(this).animate({"left": "114px"}, { duration: 300 });
            $.cookie('mo_styleswitcher_open', "true", { path: '/' });
        }
        else {
            $('#styleswitcher-wrapper').animate({"left": "-116px"}, { duration: 300 });
            $('#styleswitcher-button').animate({"left": "0px"}, { duration: 300 });
            $.cookie('mo_styleswitcher_open', "false", { path: '/' });
        }
    });

    if ($.cookie('mo_styleswitcher_open') == "false") {
        $('#styleswitcher-wrapper').css({"left": "-146px"});
        $('#styleswitcher-button').css({"left": "0px"});
    }


    /* ----------------------- BG Color change ----------------------- */

    jQuery('#styleswitcher-theme-skin ul li').click(function () {

        var skin_name, current_url, new_url;

        skin_name = $(this).find('img').attr('alt');
        current_url = window.location.href;
        current_url = current_url.split('?')[0]; // remove any existing skin
        new_url = current_url + '?skin=' + skin_name;
        window.open(new_url, '_self');

    });

    /* --------------------- BG Pattern change ---------------------- */

    jQuery('#styleswitcher-boxed-bg ul li').click(function () {

        var existing_class = $.cookie('mo_boxed_bg');
        if (existing_class)
            remove_class_from_body(existing_class);

        var new_class = $(this).find('img').attr('alt');
        $('body.boxed').addClass(new_class);

        /* Set cookie */
        $.cookie('mo_boxed_bg', new_class, { path: '/' });

    });

    if ($.cookie('mo_boxed_bg')) {

        var pattern_class = $.cookie('mo_boxed_bg');
        $('body.boxed').addClass(pattern_class);

    }

    /* --------------------- Reset all styles ---------------------- */

    jQuery('#styleswitcher-reset-button').click(function () {

        $.cookie('mo_theme_skin', null, { path: '/' });
        $.cookie('mo_boxed_bg_color', null, { path: '/' });
        $.cookie('mo_boxed_bg', null, { path: '/' });
        $.cookie('mo_boxed_layout', null, { path: '/' });
        $.cookie('mo_styleswitcher_open', null, { path: '/' });

        location.reload(true);

    });

});
