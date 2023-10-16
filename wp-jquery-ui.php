<?php

/*
    Plugin Name: jQuery UI With WP
    Plugin URI:   https://www.wpbeginner.com 
    Description: jQuery plugin test.
    Version: 1.0
    Author: Yik
    Author URI:   https://www.wpbeginner.com
*/

// Definition section for a constant. This constant contains the plugin path.
define("JQUERY_PATH", plugin_dir_path(__FILE__));
define("JQUERY_URL", plugin_dir_url(__FILE__));

// Call to bind action hook to implement menu section to our plugin. Use developer handbook wp_enque_scripts() on handles section corresponding with script name. Use jQuery developer resource.
add_action("admin_menu",  "jquery_ui_menus");

function jquery_ui_menus() {
    // First parameter passes page title. Second passes menu title. Third passes a capability manager. Fourth passes the slug of the plugin. Fifth passes callback function.
    add_menu_page("Jquery UI WP", "Jquery UI WP", "manage_options", "wp-jquery-ui", "wp_jquery_ui_callback");
}

function  wp_jquery_ui_callback() {
    // WP plugin data and security. Not call the file directly but instead use the buffers in PHP.
    ob_start();
    include_once JQUERY_PATH . "/views/accordion.php";
    // PHP function that read all content in file below and store inside buffer.
    $template = ob_get_contents();
    ob_end_clean();

    echo $template;
}

function jquery_ui_js_files(){

    // First parameter pass handle name; has to be unique. Second pass source.
    wp_enqueue_style("jquery-wp-css", JQUERY_URL . "assets/jquery-ui.min.css");

    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-accordion");
    wp_enqueue_script("custom-script", JQUERY_URL . "assets/script.js", array("jquery"), "1.0", true);
}

add_action("admin_enqueue_scripts", "jquery_ui_js_files");

// Views folder will contain all the pages we make.
