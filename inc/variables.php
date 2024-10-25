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

define('IS_PRIVATE_MODE_ENABLED', get_field('private_mode', 'options'));
define('CAN_SHOW_PRIVATE_ELEMENT', IS_PRIVATE_MODE_ENABLED);

define('MAIN_MENU', ['main-menu-1' => 'Primary Menu', 'main-menu-2' => 'Secondary Menu']); //Add more in array for more main menus
