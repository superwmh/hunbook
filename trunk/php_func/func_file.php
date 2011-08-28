<?php
function prepare_dir($save_file) {
    if (file_exists(dirname($save_file))) {
        return;
    } else {
        prepare_dir(dirname($save_file));
        mkdir(dirname($save_file));
    }
}
?>