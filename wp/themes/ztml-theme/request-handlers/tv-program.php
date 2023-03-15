<?php
function delete_files($path)
{
    $files = glob($path); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file)) {
            unlink($file); // delete file
        }
    }
}

function save_post_action($id, $post)
{
    if (get_page_template_slug($post) === 'tv-programme.php') {

        $zip_url = get_attached_file(carbon_get_post_meta($id, "crb_tv_programms"));
        $dir_tmp = get_template_directory() . '/tmp/*';
        $dir_output = get_template_directory() . '/output/*';
        delete_files($dir_tmp);
        delete_files($dir_output);

        if (strlen($zip_url)) {
            parse_tv_programm_file($zip_url);
        }
    }
}

add_action('post_updated', 'save_post_action', 10, 3);