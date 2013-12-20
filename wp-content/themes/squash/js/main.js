/* jshint undef: true, unused: false */
/* global jQuery, mo_options, mo_theme, template_dir  */

jQuery(document).ready(function ($) {

    "use strict";


    /************************************************* MI SCRIPT *************************************************/
    $('.my-primary-menu li:last').children('p').remove();
    $('.my-primary-menu li:first a').css({'padding-left': '0'});
    $('.my-primary-menu li:last a').css({'padding-right': '0'});

    $('.my-primary-menu .sub-menu li p').remove();

    $.each($('.my-primary-menu li a'), function(i,v){
        var w = $(this).width();
        $(this).children('div').width(w+20);
    })

    $(".my-primary-menu li:not(.current-menu-item)").children('a').children('div').children().animate({'width':8}, function(){
        $(this).fadeOut('fast')
    });

    $(".my-primary-menu li:not(.current-menu-item)").children('a').hover(function(){
        $(this).children('div').children().fadeIn('fast',function(){
            $(this).animate({'width':'100%'})
        })
    },function(){
        $(this).children('div').children().animate({'width':8}, function(){
            $(this).fadeOut('fast')
        })
    });





    

    $('.sub-ul').slideUp('slow');

    var up = false;
    $(".sidebar-arrow").click(function(){
        up = !up;
        if(up){
            $(".sidebar-arrow").rotate({angle: 0, animateTo:180});
            $(this).next().slideDown();
        }else{
            $(".sidebar-arrow").rotate({angle: 180, animateTo:0});
            $(this).next().slideUp();
        }
    });


    function displaySidebar (id) {
        if ($('#cat_'+id).parent().hasClass('root-ul')) {
            $('#cat_'+id).children('a').addClass('active-class');
        }else{
            $(".sidebar-arrow").click();
            $('#cat_'+id).parent().slideDown();
            $('#cat_'+id).children('a').addClass('active-class');
            $('#cat_'+id).parent().siblings('a').addClass('active-class');

        }
    }

    window.displaySidebar = displaySidebar;

/*
    if($('.single-info-wrap-wrap').height() > 148){
        var height = $('.single-info-wrap').height();
        $('.single-info-wrap').height(148);
    }
*/  



    jQuery('.single-side-info').mCustomScrollbar({
        mouseWheel:true,
        scrollButtons:{
                        enable:true
                    },
        theme: "dark-thin"

    });

    $("a#single_image_prod").fancybox();
    
   

    /* ---------------------------------- Drop-down Menu.-------------------------- */


    /* For sticky and primary menu navigation */
    $('.dropdown-menu-wrap ul.menu').superfish({
        delay: 100, // one second delay on mouseout
        animation: {height: 'show'}, // fade-in and slide-down animation
        speed: 'fast', // faster animation speed
        autoArrows: false // disable generation of arrow mark-up
    });

    /* Hide all first and open only the top parent next */
    $('#mobile-menu-toggle').click(function () {
        $("#mobile-menu > ul").slideToggle(500);
        return false;
    });

    $("#mobile-menu ul li").each(function () {
        var sub_menu = $(this).find("> ul");
        if (sub_menu.length > 0 && $(this).addClass("has-ul")) {
            $(this).find("> a").append('<span class="sf-sub-indicator"><i class="icon-arrow-down-3"></i></span>');
        }
    });
    $('#mobile-menu ul li:has(">ul") > a').click(function () {
        $(this).parent().toggleClass("open");
        $(this).parent().find("> ul").stop(true, true).slideToggle();
        return false;
    });


    $(window).scroll(function () {
        var width = $(window).width();
        var yPos = $(window).scrollTop();
        /* show sticky menu after screen has scrolled down 200px from the top in desktop and big size tablets only */
        if (width > 768 && (yPos > 200)) {
            $("#sticky-menu-container").fadeIn();
        } else {
            $("#sticky-menu-container").fadeOut();
        }
    });

    /* -------------------------------- Image Preloader and Image Overlay ------------------------------ */

    function mo_imageOverlay() {

        $("#content .image-info").hide();

        $(".hfeed .post .image-frame, .image-grid .image-frame").hover(function () {
            $(this).find(".image-info").fadeTo(400, 1);
        }, function () {
            $(this).find(".image-info").fadeTo(400, 0);
        });
    }


    $.fn.preloader = function (prefs) {

        var defaults = {
            delayBetweenLoads: 200,
            parentWrapper: 'a',
            imageSelector: 'img',
            checkTimer: 300,
            onComplete: function () {
            },
            onImageLoad: function (image) {
            },
            fadeIn: 500,
            refresh: false
        };

        // variables declaration and precaching images and parent container
        var options = $.extend(defaults, prefs);

        var images = $(this).find(options.imageSelector);

        // If just refreshing the images without reload page (e.g., while quicksanding in sorted/filtered portfolio pages)
        if (options.refresh) {
            images.each(function () {
                $(this).css({ 'visibility': 'visible'}).animate(
                    { opacity: 1},
                    100,
                    function () {
                        $(this).closest(options.parentWrapper).removeClass("preloader");
                    });
                options.onImageLoad($(this));
            });
            options.onComplete(); // Callback function to be executed after loading all images
            return; // Done with preload once refresh is complete
        }
        // If refresh is not the chosen option
        var timer, imageChecked = [], delayBeforeLoad = options.delayBetweenLoads;
        var counter = 0, i = 0;

        var preloadInit = function () {

            // Call the function every timer duration specified
            timer = setInterval(function () {

                if (counter >= imageChecked.length) // if done with all images
                {
                    clearInterval(timer);
                    options.onComplete(); // Callback function to be executed after loading all images
                    return;
                }

                var remove_preloader = function (image) {
                    image.closest(options.parentWrapper).removeClass("preloader");
                };

                for (i = 0; i < images.length; i++) {
                    if (images[i].complete === true) {
                        if (imageChecked[i] === false) {
                            imageChecked[i] = true;
                            options.onImageLoad(images[i]); // Callback function to be executed after each image load
                            counter++;

                            delayBeforeLoad = delayBeforeLoad + options.delayBetweenLoads; //Make the image wait for this much time before load
                        }

                        $(images[i]).css("visibility", "visible").delay(delayBeforeLoad).animate(
                            { opacity: 1},
                            options.fadeIn,
                            remove_preloader($(this)));
                    }
                }
            }, options.checkTimer);
        };

        images.each(function () {
            imageChecked[i++] = false;
        });
        images = $.makeArray(images);

        preloadInit();

    };


    /* -------------------------------- Image Preloader ------------------------------ */

    function mo_imagePreload(refresh) {
        // Works in IE but a bit unpredictable and hence disabling it
        if (jQuery.browser.msie && parseInt(jQuery.browser.version, 10) < 8) {
            $('#content').find('.image-frame img').css({ visibility: 'visible' });
            mo_imageOverlay();
            return;
        } else {
            $("#content").preloader({
                delayBetweenLoads: 300,
                fadeIn: 300,
                checkTimer: 300,
                parentWrapper: '.image-area',
                imageSelector: '.image-frame img',
                onComplete: function () {
                    mo_imageOverlay();
                },
                refresh: refresh
            });
        }
    }

    mo_imagePreload(false);

    /* ------------------- Scroll Effects ----------------------------- */

    /* TODO: Check for any meaningful animations */
    function mo_scroll_effects() {
        if (typeof $().waypoint === 'undefined') {
            return;
        }
    }

    if (!mo_options.disable_animations_on_page) {
        mo_scroll_effects();
    }

    function mo_smooth_page_load_effect() {
        $('#before-content-area, #custom-before-content-area, #content, .first-segment .heading2, .first-segment .heading1').css({opacity: 1});
        $('.sidebar-right-nav, .sidebar-left-nav').css({opacity: 1});
    }

    if (!mo_options.disable_smooth_page_load) {
        mo_smooth_page_load_effect();
    }

    /* -------------------------------- PrettyPhoto Lightbox --------------------------*/

    function mo_prettyPhoto() {

        if (typeof $().prettyPhoto === 'undefined') {
            return;
        }

        var theme_selected = 'pp_default';

        $("a[rel^='prettyPhoto']").prettyPhoto({
            "theme": theme_selected, /* light_rounded / dark_rounded / light_square / dark_square / facebook */
            social_tools: false
        });

    }

    mo_prettyPhoto();

    /* ------------------- Tabs and Accordions ------------------------ */

    $("ul.tabs").tabs(".pane");

    $(".accordion").tabs("div.pane", {
        tabs: 'div.tab',
        effect: 'slide',
        initialIndex: 0
    });

    /* ------------------- Back to Top and Close ------------------------ */

    $(".back-to-top").click(function (e) {
        $('html,body').animate({
            scrollTop: 0
        }, 600);
        e.preventDefault();
    });

    $('a.close').click(function (e) {
        e.preventDefault();
        $(this).closest('.message-box').fadeOut();
    });


    /* ------------------- Toggle ------------------------ */

    function toggle_state(toggle_element) {
        var active_class;
        var current_content;

        active_class = 'active-toggle';

        // close all others first
        toggle_element.siblings().removeClass(active_class);
        toggle_element.siblings().find('.toggle-content').slideUp("fast");

        current_content = toggle_element.find('.toggle-content');

        if (toggle_element.hasClass(active_class)) {
            toggle_element.removeClass(active_class);
            current_content.slideUp("fast");
        }
        else {
            toggle_element.addClass(active_class);
            current_content.slideDown("fast");
        }
    }

    $(".toggle-label").toggle(
        function () {
            toggle_state($(this).parent());
        },
        function () {
            toggle_state($(this).parent());
        }
    );

    /* ------------------- Contact Form Validation ------------------------ */

    var rules = {
        contact_name: {
            required: true,
            minlength: 5
        },
        contact_email: {
            required: true,
            email: true
        },
        contact_phone: {
            required: false,
            minlength: 5
        },
        contact_company: {
            required: false,
        },
        contact_url: {
            required: false,
            url: true
        },
        human_check: {
            required: true,
            range: [13, 13]
        },
        message: {
            required: true,
            minlength: 15
        }
    };
    var messages = {
        contact_name: {
            required: mo_theme.name_required,
            minlength: mo_theme.name_format
        },
        contact_email: mo_theme.email_required,
        contact_url: mo_theme.url_required,
        contact_phone: {
            minlength: mo_theme.phone_required
        },
        human_check: mo_theme.human_check_failed,
        message: {
            required: mo_theme.message_required,
            minlength: mo_theme.message_format
        }
    };
    $("#content .contact-form").validate({
        rules: rules,
        messages: messages,
        errorClass: 'form-error',
        submitHandler: function (theForm) {
            $.post(
                theForm.action,
                $(theForm).serialize(),
                function (response) {
                    $("#content .feedback").html('<div class="success-msg">' + mo_theme.success_message + '</div>');
                });

        }

    });

    $(".widget .contact-form").validate({
        rules: rules,
        messages: messages,
        errorClass: 'form-error',
        submitHandler: function (theForm) {
            $.post(
                theForm.action,
                $(theForm).serialize(),
                function (response) {
                    $(".widget .feedback").html('<div class="success-msg">' + mo_theme.success_message + '</div>');
                });

        }

    });

    /*-----------------------------------------------------------------------------------*/
    /*	jQuery isotope functions and Infinite Scroll
     /*-----------------------------------------------------------------------------------*/

    $(function () {

        if (typeof $().isotope === 'undefined') {
            return;
        }

        var post_snippets = $('.post-snippets.full-width-snippets');

        post_snippets.imagesLoaded(function () {
            $(this).isotope({
                // options
                itemSelector: '.entry-item',
                layoutMode: 'fitRows'
            });
        });

        var container = $('#portfolio-items');

        container.imagesLoaded(function () {
            $(this).isotope({
                // options
                itemSelector: '.portfolio-item',
                layoutMode: 'fitRows'
            });

            $('#portfolio-filter a').click(function (e) {
                e.preventDefault();

                var selector = $(this).attr('data-value');
                container.isotope({ filter: selector });
                return false;
            });
        });

        if (mo_options.ajax_portfolio) {
            container.infinitescroll({
                    navSelector: '.pagination', // selector for the paged navigation
                    nextSelector: '.pagination .next', // selector for the NEXT link (to page 2)
                    itemSelector: '.portfolio-item', // selector for all items you'll retrieve
                    loading: {
                        finishedMsg: 'No more items  to load.',
                        img: template_dir + '/images/loader.gif'
                    }
                },
                // call Isotope as a callback
                function (newElements) {
                    mo_imagePreload(true);
                    var $newElems = $(newElements);
                    $newElems.imagesLoaded(function () {
                        container.isotope('appended', $newElems);
                    });
                    mo_prettyPhoto();
                });
        }
    });

    /*-----------------------------------------------------------------------------------*/
    /*	Handle videos in responsive layout - Credit - http://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php
     /*-----------------------------------------------------------------------------------*/

    $("#container").fitVids();

// Take care of maps too - https://github.com/davatron5000/FitVids.js - customSelector option
    $("#content").fitVids({ customSelector: "iframe[src^='http://maps.google.com/']"});

    /*var mo_twitter_id = mo_twitter_id || 'twitter';
     var mo_tweet_count = mo_tweet_count || 3;*/
    if (typeof mo_options.mo_twitter_id !== 'undefined') {
        jQuery('#twitter').jtwt({
            username: mo_options.mo_twitter_id,
            count: mo_options.mo_tweet_count,
            image_size: 32,
            loader_text: 'Loading Tweets'
        });
    }

})
;

