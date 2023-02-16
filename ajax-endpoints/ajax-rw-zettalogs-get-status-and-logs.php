<?php
include_once("/var/www/fm949.ca/wp-load.php");

require(plugin_dir_path( __DIR__ ) . "/settings/daemon-settings.php");

function rw_zettalogs_get_status_and_logs()
{
    if(!is_user_logged_in() or !in_array('administrator',wp_get_current_user()->roles)){
        echo ("You are not authorized to view this!");
        exit;
    }
    $task = $_POST["task"];
    switch($task){
        case "daemon_status":
            rw_zettalogs_get_daemon_status();
            break;

        case "nginx_status":
            rw_zettalogs_get_nginx_status();
            break;
        
        case "nginx_log_dir":
            rw_zettalogs_list_nginx_log_dir();
            break;
        
        case "nginx_log_file":
            $filename = $_POST['filename'];
            // if(!isset($filename) || trim($filename)=="")
                // $filename = "access.log";
            rw_zettalogs_read_nginx_log($filename);
            break;

        case "daemon_log_dir":
            rw_zettalogs_list_daemon_log_dir();
            break;
            
            
        default:
            rw_zettalogs_get_daemon_status();
            break;
    }
}

function rw_zettalogs_get_daemon_status()
{
    exec( "systemctl status " . DAEMON_NAME, $status );
    foreach ($status as $line => $value)
        echo($value . "\n");
    die();
}

function rw_zettalogs_get_nginx_status()
{
    exec( "systemctl status nginx", $status );
    foreach ($status as $line => $value)
        echo($value . "\n");
    die();
}

function rw_zettalogs_list_nginx_log_dir()
{
    exec( "ls " . NGINX_LOG_DIR, $ls );
    foreach ($ls as $line => $value)
        echo($value . "\n");
    die();
}

function rw_zettalogs_read_nginx_log($filename)
{
    echo("cat " . NGINX_LOG_DIR . $filename);
    
    exec( "cat " . NGINX_LOG_DIR . $filename, $output );
    foreach ($output as $line => $value)
        echo($value . "\n");
    die();
}

function rw_zettalogs_list_daemon_log_dir()
{
    exec( "ls " . DAEMON_LOG_DIR, $ls );
    foreach ($ls as $line => $value)
        echo($value . "\n");
    die();
}

add_action('wp_ajax_rw_zettalogs_get_status_and_logs', 'rw_zettalogs_get_status_and_logs');           // for logged in user

;?>
