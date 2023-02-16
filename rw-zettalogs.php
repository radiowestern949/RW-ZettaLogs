<?php
/**
 * Plugin Name: RW-ZettaLogs
 * Plugin URI: https://navmohan.site
 * Author: Navaneeth Mohan
 * Author URI: https://navmohan.site
 * Description: A plugin that can be used to start/stop/restart the zetta_logger Daemon service and also serves the frontend page for 'what_song_was_that'
 * Version: 0.1.0
 * License: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: prefix-plugin-name
*/

// create what_song_was_that page 
add_action("init",'rw_zettalogs_plugin_custom_page_creator');
function rw_zettalogs_plugin_custom_page_creator(){
    $zettalogs_page_title = "RW-ZettaLogs";
    $zettalogs_page_slug = "what_song_was_that";
    if(get_page_by_title($zettalogs_page_title) == NULL && get_page_by_path($zettalogs_page_slug)==NULL){
        $zettalogs_page_args = array(
            "post_title" => $zettalogs_page_title,
            "post_content" => "",
            "post_status" => "publish",  
            "post_type" => "page",
            "post_name" => $zettalogs_page_slug // this is teh slug
        );   
        $create_zettalogs_page = wp_insert_post($zettalogs_page_args);
    }
}

add_action('admin_menu', 'rw_zettalogs_plugin_create_menu_entry');

// creating the menu entries
function rw_zettalogs_plugin_create_menu_entry()
{
    // icon image path that will appear in the menu
    $icon = plugins_url('/images/rw-zettalogs-plugin-icon-16X16.png', __FILE__);

    // adding the main menu entry
    add_menu_page(
        'RW-ZettaLogs Plugin',
        'RW-ZettaLogs',
        'manage_options',
        'main-page-rw-zettalogs-plugin',
        'rw_zettalogs_plugin_show_main_page',
        $icon
    );
}

function rw_zettalogs_plugin_show_main_page()
{
    require_once('templates/dashboard.php');
}

require_once('ajax-endpoints/ajax-rw-zettalogs-get-status-and-logs.php');
require_once('ajax-endpoints/ajax-rw-zettalogs-get-history.php');
require_once('ajax-endpoints/ajax-rw-zettalogs-update-icecast-settings.php');