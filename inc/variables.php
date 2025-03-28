<?php
define('FOOTER_SIDEBAR_QUANTITY', 4);
define('CONTENT_BLOCK_CLASS', 'content-block');
define('CONTENT_BLOCK_CONTENT', CONTENT_BLOCK_CLASS . '__container');
define('CONTENT_BLOCK_MODIFIER', CONTENT_BLOCK_CLASS . '--');

define('IMG_SIZE_XS', 'thumbnail');
define('IMG_SIZE_SM', 'small');
define('IMG_SIZE_MD', 'medium');
define('IMG_SIZE_LG', 'medium_large');
define('IMG_SIZE_XL', 'large');
define('IMG_SIZE_2XL', '1536x1536');
define('IMG_SIZE_3XL', '2048x2048');

define('MAIN_MENU', ['main-menu-1' => 'Primary Menu', 'main-menu-2' => 'Secondary Menu', 'portal-menu' => 'Portal Menu']); //Add more in array for more main menus


define('IS_CURRENT_USER_ROLE_ADMINISTRATOR', current_user_can('manage_options'));
define('IS_CURRENT_USER_ROLE_INTERMEDIARY', in_array('intermediary', (array) $current_user->roles));
define('CAN_SHOW_ELEMENT', IS_CURRENT_USER_ROLE_ADMINISTRATOR ? true : IS_CURRENT_USER_ROLE_INTERMEDIARY);


function is_wppb_private_website()
{
    $wppb_private_website_settings = get_option('wppb_private_website_settings', 'not_found');
    return ($wppb_private_website_settings != 'not_found' && !empty($wppb_private_website_settings['private_website']) && $wppb_private_website_settings['private_website'] == 'yes');
}
