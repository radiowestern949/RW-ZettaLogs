<?php

/**
 * This handles writing to the icecast.txt file at the home folder of the wordpress theme
 * It also makes a HTTP GET request to update the Icecast metadata
 */

	include_once("./settings/icecast-settings.php");
	// "https://admin:hackme@949fm.ca:443/admin/metadata?mount=/RadioWestern&mode=updinfo&song=Speed+of+Sound";
	define("MPEG_UPDATE_METADATA_URL",  "https://" . ICECAST_ADMIN_USERNAME . ":" . ICECAST_ADMIN_PASSWORD . "@" . ICECAST_URL . ":" . ICECAST_ADMIN_PORT . "/admin/metadata?mount=/" . ICECAST_MPEG_MOUNTPOINT . "&mode=updinfo&song=");
	define( "AAC_UPDATE_METADATA_URL",  "https://" . ICECAST_ADMIN_USERNAME . ":" . ICECAST_ADMIN_PASSWORD . "@" . ICECAST_URL . ":" . ICECAST_ADMIN_PORT . "/admin/metadata?mount=/" . ICECAST_AAC_MOUNTPOINT .  "&mode=updinfo&song=");

	include_once("class-ProcessLogger.php");
	$process_logger = ProcessLogger::get_instance();

    include_once("/var/www/fm949.ca/wp-load.php");
    require_once('/var/www/fm949.ca/wp-admin/includes/upgrade.php' );

	class IcecastLogger {
		function write_icecast($metadata)
		{
			global $process_logger;
			$logevent_type = $metadata['logevent_type'];
			switch ($logevent_type) {
				case "Live Music Show":
					$icecast_metadata = $metadata['title'];
					break;
				case "Live Song":
					$icecast_metadata = $metadata['title'];
					break;
				case "Live Talk Show":
					$icecast_metadata = $metadata['title'];
					break;
				case "Prerec. Music":
					$icecast_metadata = $metadata['rw_genre'];
					break;
				case "Song":
					$icecast_metadata = $metadata['title'];
					break;
				case "Prerec. Talk":
					$icecast_metadata = $metadata['rw_genre'];
					break;
				default:
					$icecast_metadata = "Radio Western";
					break;
			}
			file_put_contents(get_template_directory() . "/" . ICECAST_OUTFILE , $icecast_metadata);
            $process_logger->write_log("Icecast outfile written: " . $icecast_metadata);

			$icecast_metadata = str_replace(" ", "+", $icecast_metadata);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($ch, CURLOPT_URL, MPEG_UPDATE_METADATA_URL . $icecast_metadata);
			$server_output = curl_exec($ch);
            if(str_contains($server_output,"Metadata update successful"))
			    $process_logger->write_log("MPEG Icecast Mountpoint metadata updated successfully: " . $icecast_metadata);

			curl_setopt($ch, CURLOPT_URL, AAC_UPDATE_METADATA_URL . $icecast_metadata);
			$server_output = curl_exec($ch);
            if(str_contains($server_output,"Metadata update successful"))
			    $process_logger->write_log("AAC Icecast Mountpoint metadata updated successfully: " . $icecast_metadata);
		}

	}

;?>