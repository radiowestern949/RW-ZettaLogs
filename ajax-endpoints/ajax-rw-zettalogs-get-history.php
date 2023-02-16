<?php
// this is the what-song-was-that API

include_once("/var/www/fm949.ca/wp-load.php");

require_once(plugin_dir_path( __DIR__ ) . "/class-ZettaLog.php");

$zetta_log_ORM = new ZettaLog();

// get by specific date or today's or latest_one
function rw_zettalogs_get_history(){
    global $zetta_log_ORM;
    $date = $_GET['date'];
    $latest = $_GET['latest'];

    if(isset($latest)){
        $response = $zetta_log_ORM->get_latest();
        wp_send_json_success($response);
        die();
    }
    else{
        $date=date_format(date_create($date),"Y-m-d");
        $response = $zetta_log_ORM->get_by_date($date);
        wp_send_json_success($response);
        die();
    }
}

add_action('wp_ajax_rw_zettalogs_get_history', 'rw_zettalogs_get_history');
add_action('wp_ajax_nopriv_rw_zettalogs_get_history', 'rw_zettalogs_get_history');
