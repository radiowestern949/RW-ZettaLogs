## Daeom process
The plugin activation interferes with the `Daemon Service` because they both _define_ the `ZettaLog` class. Only one of them 
should define it. `ZettaLog` is not a Singleton but it can only be declared/defined once duh!


`$ sudo nano /etc/systemd/system/zetta_logger.service`
```
[Unit]
Description=TCP Server of RW-ZettaLogs Wordpress Plugin
After=mysql.service
StartLimitIntervalSec=0
[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/fm949.ca/wp-content/plugins/RW-ZettaLogs
Type=simple
PIDFile=/run/zetta_logger.pid
ExecStart=/usr/bin/php /var/www/fm949.ca/wp-content/plugins/RW-ZettaLogs/server.php
StandardOutput=file:/var/www/fm949.ca/wp-content/plugins/RW-ZettaLogs/stdout.txt
StandardError=file:/var/www/fm949.ca/wp-content/plugins/RW-ZettaLogs/stderr.txt
KillMode=process

Restart=always
RestartSec=1

[Install]
WantedBy=default.target

```
