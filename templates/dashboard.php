<?php
    $icecast_settings_file = plugin_dir_path( __DIR__ ) . "/settings/icecast-settings.php";
    $daemon_settings_file = plugin_dir_path( __DIR__ ) . "/settings/daemon-settings.php";

    include_once($icecast_settings_file);
    include_once($daemon_settings_file);
    
    wp_enqueue_script('zettalogs_global_vars', plugin_dir_url(__DIR__ ) . '/js/rw-zettalogs-global-vars.js','','',false);
    wp_enqueue_script('get_status_and_logs', plugin_dir_url(__DIR__ ) . '/js/rw-zettalogs-get-status-and-logs.js','','',false);
    wp_enqueue_script('update_icecast_settings', plugin_dir_url(__DIR__ ) . '/js/rw-zettalogs-update-icecast-settings.js','','',false);
;?>

<style>
    #stdout{
        background-color: black;
        border:1px solid green;
        border-radius: 10px;
        color: rgb(55, 200, 33);
        min-height: 200px;
        padding:20px;
        font-size:large;
        max-height:700px;
        overflow:scroll;
        max-width:90%;
    }
    #icecast-settings{
        background-color: aliceblue;
        border:1px solid black;
        border-radius: 10px;
        color: rgb(155, 0, 0);
        padding:10px;
        font-size:large;
        max-width:90%;
        margin:10px 0 10px 0;

    }
</style>

<script>
    window.addEventListener('load',()=>get_status_and_logs({'task':'daemon_status'}));
</script>

<button onClick="get_status_and_logs({'task':'daemon_status'})">Get Daemon Status</button><br>
<button onClick="get_status_and_logs({'task':'nginx_status'})">Get NGINX Status</button><br>

<button onClick="get_status_and_logs({'task':'nginx_log_dir'})">List NGINX log files for RW-ZettaLogs Plugin</button><br>

<input type="text" name="filename" id="filename" placeholder="logfile name"/>
<button onClick="get_status_and_logs({'task':'nginx_log_file','filename':document.getElementById('filename').value})">Read NGINX log file</button>


<div id = "title"></div>
<div id="stdout"></div>


<div id = "icecast-settings">
    Icecast settings : This will enable wordpress to update the metadata of Icecast
    <div class = "form-label"> Icecast URL:</div>
    <input type="text" name="icecast-url" id="icecast-url" placeholder="949fm.ca" value = <?php echo ICECAST_URL;?>>
    <br>
    <div class = "form-label"> Icecast Admin Port:</div>
    <input type="text" name="icecast-admin-port" id="icecast-admin-port" placeholder="443/8000/80" value = <?php echo ICECAST_ADMIN_PORT;?>>
    <br>
    <div class = "form-label"> Icecast Admin Username:</div>
    <input type="text" name="icecast-admin-username" id="icecast-admin-username" placeholder="admin" value = <?php echo ICECAST_ADMIN_USERNAME;?>>
    <br>
    <div class = "form-label"> Icecast Admin Password:</div>
    <input type="text" name="icecast-admin-password" id="icecast-admin-password" placeholder="hackme" value = <?php echo ICECAST_ADMIN_PASSWORD;?>>
    <br>
    <div class = "form-label"> Icecast Mpeg Mountpoint:</div>
    <input type="text" name="icecast-mpeg-mountpoint" id="icecast-mpeg-mountpoint" placeholder="stream" value = <?php echo ICECAST_MPEG_MOUNTPOINT;?>>
    <br>
    <div class = "form-label"> Icecast AAC Mountpoint:</div>
    <input type="text" name="icecast-aac-mountpoint" id="icecast-aac-mountpoint" placeholder="RadioWestern" value = <?php echo ICECAST_AAC_MOUNTPOINT;?>>
    <br>
    <div class = "form-label"> Icecast outfile:</div>
    <input type="text" name="icecast-outfile" id="icecast-outfile" placeholder="icecast.txt" value = <?php echo ICECAST_OUTFILE;?>>
    <br>
    <button onClick='update_icecast_settings()'>Save</button>
</div>