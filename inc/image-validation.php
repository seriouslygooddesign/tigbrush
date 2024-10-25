<?php
function core_image_size_validation($file)
{
    // Check if the uploaded file is an image
    $file_info = wp_check_filetype($file['name']);
    if (strpos($file_info['type'], 'image') === 0) {

        $max_file_size = 750; // kilobytes
        $max_width = 2048; // pixels
        $max_height = 1536; // pixels

        // Check if image exceeds maximum dimensions and it is not SVG
        if ($file_info['type'] !== 'image/svg+xml') {
            $img_size = getimagesize($file['tmp_name']);
            $img_width = $img_size[0];
            $img_height = $img_size[1];

            if ($img_width > $max_width || $img_height > $max_height) {
                $file['error'] = 'Image dimensions exceed the allowed maximum (' . $max_width . 'px width and ' . $max_height . 'px height). Please optimize the image for better site performance.';
            }
        }

        // If GIF image
        if ($file_info['ext'] === 'gif') {
            $max_file_size = 2000;
        }

        // Check if file size exceeds maximum size
        $max_file_size_bytes = $max_file_size * 1024; // kilobytes to bytes
        if ($file['size'] > $max_file_size_bytes) {
            $file_size_unit = 'KB';
            if ($max_file_size >= 1000) {
                $file_size_unit = 'MB';
                $max_file_size = $max_file_size / 1000;
            }
            $file['error'] = "Image size exceeds the allowed maximum ($max_file_size $file_size_unit). Please optimize image for better site performance.";
        }
    }

    return $file;
}
add_filter('wp_handle_upload_prefilter', 'core_image_size_validation');
