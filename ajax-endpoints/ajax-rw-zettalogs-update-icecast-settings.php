<?php

include_once("/var/www/fm949.ca/wp-load.php");

$settings_file = plugin_dir_path( __DIR__ ) . "settings/icecast-settings.php";

function rw_zettalogs_update_icecast_settings(){
    global $settings_file;
    if(!is_user_logged_in() or !in_array('administrator',wp_get_current_user()->roles)){
        echo ("You are not authorized to make this edit!");
        exit;
    }
    $new_settings = array(
        'ICECAST_URL'=> $_POST['ICECAST_URL'],
        'ICECAST_ADMIN_PORT'=> $_POST['ICECAST_ADMIN_PORT'],
        'ICECAST_ADMIN_USERNAME'=> $_POST['ICECAST_ADMIN_USERNAME'],
        'ICECAST_ADMIN_PASSWORD'=> $_POST['ICECAST_ADMIN_PASSWORD'],
        'ICECAST_MPEG_MOUNTPOINT'=> $_POST['ICECAST_MPEG_MOUNTPOINT'],
        'ICECAST_AAC_MOUNTPOINT'=> $_POST['ICECAST_AAC_MOUNTPOINT'],
        'ICECAST_OUTFILE'=> $_POST['ICECAST_OUTFILE'],
    );
    $new_file_output = "<?php\n";

    foreach ($new_settings as $key => $value) {
        $new_file_output .= "define('$key','$value');\n";
    }
    $new_file_output .= ";?>";

    $bytes_written = file_put_contents($settings_file,$new_file_output);
    if($bytes_written)
        echo("Succesfully updated the settings file. Now reload/restart the daemon to apply these new settings.");
    else
        echo("There was a problem with updating the settings file");
    die();

}

add_action('wp_ajax_rw_zettalogs_update_icecast_settings', 'rw_zettalogs_update_icecast_settings');
add_action('wp_ajax_nopriv_rw_zettalogs_update_icecast_settings', 'rw_zettalogs_update_icecast_settings');