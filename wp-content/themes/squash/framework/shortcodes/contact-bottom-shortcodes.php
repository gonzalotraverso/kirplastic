<?php
/*
* Contact bottom shortcodes
*/

function mo_contact_bottom_form_shortcode($atts, $content = null, $code) {
    extract(shortcode_atts(array(
        'class' => '',
        'mail_to' => '',
        'web_url' => true,
        'phone' => true,
        'subject' => true,
        'human_check' => false,
        'button_color' => 'squash'
    ), $atts));

    if (empty($mail_to))
        $mail_to = get_bloginfo('admin_email');
    $mail_script_url = MO_THEME_URL . '/framework/scripts/sendmail.php';

    $output = '<div class="feedback"></div>';

    $output .= '<form class="contact-form '. $class .'" action="' . $mail_script_url . '" method="post">';

    $output .= '<fieldset>';
    $output .= '<div class="bottom-form-left-cont">';

    $output .= '<p><label>' . __('Name *', 'mo_theme') . '</label><input type="text" name="contact_name" placeholder="'. __("NOMBRE", 'mo_theme').'" class="text-input" required></p>';

    $output .= '<p><label>' . __('Email *', 'mo_theme') . '</label><input type="email" name="contact_email" placeholder="'. __("EMAIL", 'mo_theme').'" class="text-input" required></p>';
    $output .= '<p><label>' . __('Company *', 'mo_theme') . '</label><input type="text" name="contact_company" placeholder="'. __("COMPAÑIA", 'mo_theme').'" class="text-input" required></p>';

    $output .= '</div>';

    $output .= '<p class="text-area"><label>' . __('Message *', 'mo_theme') . '</label><textarea name="message" placeholder="'. __("MENSAJE", 'mo_theme').'"  rows="6" cols="40"></textarea></p>';

    if (mo_to_boolean($human_check))
        $output .= '<p class="human-check"><label>' . __('* I am a human and 4 + 9 = ', 'mo_theme') . '</label><input type="text" name="human_check" class="text-input" size="5" style="width: 50px;"></p>';

    $output .= '<button type="submit" class="button large '. $button_color .'">' . __('Enviar', 'mo_theme') . '<div class="mi-icon"></div></button>';

    $output .= '<input type="hidden" name="mail_to" value="' . $mail_to . '"/>';

    $output .= '</fieldset>';

    $output .= '</form>';

    return $output;

}

add_shortcode('contact_bottom_form', 'mo_contact_bottom_form_shortcode');