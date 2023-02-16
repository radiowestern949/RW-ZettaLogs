function get_status_and_logs(arguments) {
    console.log(arguments)
    FORM_GET_DAEMON_STATUS = new FormData();
    FORM_GET_DAEMON_STATUS.set('action',RW_ZETTALOGS_WP_ACTION);
    Object.keys(arguments).forEach((k)=>{
        FORM_GET_DAEMON_STATUS.set(k,arguments[k]);
    })
    return fetch(WP_AJAX_URL, 
        {
            method:"POST",
            body:FORM_GET_DAEMON_STATUS
        }
    )
    .then(function(res){
        if(res.ok)
            return res.text();
        else
            alert("There was an error");
    })
    .then((res_html)=>{
        document.getElementById('title').innerText = JSON.stringify(arguments);
        document.getElementById('stdout').innerText = res_html.trim();
    })
}