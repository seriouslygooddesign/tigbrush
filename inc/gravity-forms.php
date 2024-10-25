<?php
//Disabling automatic scrolling on form submit
add_filter('gform_confirmation_anchor', '__return_false');

//Remove legend
add_filter('gform_required_legend', '__return_empty_string');

//Change button text after clicking it
function gf_change_submit_button_text($button, $form)
{
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $button);
    $input = $dom->getElementsByTagName('input')->item(0);
    if ($input instanceof DOMElement) {
        $onclick = $input->getAttribute('onclick');
        $onclick .= " this.value='Sending...'";
        $input->setAttribute('onclick', $onclick);
        return $dom->saveHtml($input);
    }
    return $button;
}
add_filter('gform_submit_button', 'gf_change_submit_button_text', 10, 2);

//Enable "Anti-spam honeypot" by default on form creation
add_action('gform_after_save_form', 'enable_honeypot_on_new_form_creation', 10, 2);
function enable_honeypot_on_new_form_creation($form, $is_new)
{
    if ($is_new && class_exists('GFAPI')) {
        $form['enableHoneypot'] = true;
        GFAPI::update_form($form);
    }
}
