<?php
include_once("/var/www/fm949.ca/wp-load.php");

define ("DAEMON_NAME" , "zetta_logger.service");
define ("DAEMON_LOG_DIR", plugin_dir_path( __FILE__ ) . "/log");
define ("NGINX_LOG_DIR", "/var/log/nginx/zetta_logger/");


;?>
