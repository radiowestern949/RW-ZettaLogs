function update_icecast_settings(arguments) {
    FORM_UPDATE_ICECAST_SETTINGS = new FormData();
    FORM_UPDATE_ICECAST_SETTINGS.set('action',RW_ZETTALOGS_UPDATE_ICECAST_SETTINGS_ACTION);
    
    FORM_UPDATE_ICECAST_SETTINGS.set('ICECAST_URL',document.getElementById('icecast-url').value);
    FORM_UPDATE_ICECAST_SETTINGS.set('ICECAST_ADMIN_PORT',document.getElementById('icecast-admin-port').value);
    FORM_UPDATE_ICECAST_SETTINGS.set('ICECAST_ADMIN_USERNAME',document.getElementById('icecast-admin-username').value);
    FORM_UPDATE_ICECAST_SETTINGS.set('ICECAST_ADMIN_PASSWORD',document.getElementById('icecast-admin-password').value);
    FORM_UPDATE_ICECAST_SETTINGS.set('ICECAST_MPEG_MOUNTPOINT',document.getElementById('icecast-mpeg-mountpoint').value);
    FORM_UPDATE_ICECAST_SETTINGS.set('ICECAST_AAC_MOUNTPOINT',document.getElementById('icecast-aac-mountpoint').value);
    FORM_UPDATE_ICECAST_SETTINGS.set('ICECAST_OUTFILE',document.getElementById('icecast-outfile').value);
    return fetch(WP_AJAX_URL, 
        {
            method:"POST",
            body:FORM_UPDATE_ICECAST_SETTINGS
        }
    )
    .then(function(res){
        if(res.ok)
            return res.text();
        else
            alert("There was an error");
    })
    .then((res_html)=>{
        alert(res_html.trim());
    })
}

