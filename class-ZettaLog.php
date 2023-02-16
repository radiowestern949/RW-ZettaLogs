<?php

/**
 * this is the model for the rw_zettalogs table
 * it handles all CRUD operations of the table
 * it is used by the Zetta-Listener's socket server when writing data
 * it is used by the 'what_song_was_that' API as well
 */

	include_once("class-ProcessLogger.php");
	$process_logger = ProcessLogger::get_instance();

    include_once("/var/www/fm949.ca/wp-load.php");
    require_once('/var/www/fm949.ca/wp-admin/includes/upgrade.php' );

    global $wpdb;

	class ZettaLog {
        private $db_handle;
        public $table_name = 'rw_zettalogs';

		function __construct(){
            global $wpdb;
            $this->db_handle = $wpdb;
			$this->create_table();
		}

		// this is used by wordpress hook for 'what_song_was_that?' API
		function get_latest(){
			$SQL = "SELECT * FROM $this->table_name ORDER BY creation_ts DESC LIMIT 1";
			$result = $this->db_handle->get_results($SQL);
			$last_error = $this->db_handle->last_error;
			$response = array('result'=>$result,'error'=>$last_error);
			return($response);
		}
		function get_by_date($air_date){
			$SQL = "SELECT * FROM $this->table_name WHERE air_date='$air_date' ORDER BY air_start_time ASC";
			$result = $this->db_handle->get_results($SQL);
            $last_error = $this->db_handle->last_error;
            $response = array('result'=>$result,'error'=>$last_error);
			return($response);
		}

		function get_all(){
			$SQL = "SELECT * FROM $this->table_name ORDER BY air_date,air_start_time ASC";
			$result = $this->db_handle->get_results($SQL);
            $last_error = $this->db_handle->last_error;
            $response = array('result'=>$result,'error'=>$last_error);
			return($response);
		}

		function create_record($metadata){
			
			// Wordpress function to escape special characters 
			$metadata = esc_sql($metadata);
			global $process_logger;
			$process_logger->write_log($metadata['air_start_time']);
			$logevent_type = $metadata['logevent_type'];
			$logevent_id = $metadata['logevent_id'];
			$air_start_time = $metadata['air_start_time'];
			$air_stop_time = $metadata['air_stop_time'];
			$air_date = $metadata['air_date'];
			$asset_id = $metadata['asset_id'];
			$asset_filename = $metadata['asset_filename'];
			$asset_participant_name = $metadata['asset_participant_name'];
			$asset_participant_id = $metadata['asset_participant_id'];
			$asset_sponsor_id = $metadata['asset_sponsor_id'];
			$asset_sponsor_name = $metadata['asset_sponsor_name'];
			$asset_product_id = $metadata['asset_product_id'];
			$asset_product_name = $metadata['asset_product_name'];
			$comment = $metadata['comment'];
			$rw_local = $metadata['rw_local'];
			$rw_cancon = $metadata['rw_cancon'];
			$rw_hit = $metadata['rw_hit'];
			$rw_female = $metadata['rw_female'];
			$rw_indigenous = $metadata['rw_indigenous'];
			$rw_explicit = $metadata['rw_explicit'];
			$rw_release_date = $metadata['rw_release_date'];
			$rw_genre = $metadata['rw_genre'];
			$artist_id = $metadata['artist_id'];
			$artist_name = $metadata['artist_name'];
			$album_id = $metadata['album_id'];
			$album_name = $metadata['album_name'];
			$title = $metadata['title'];
			
            $SQL = "INSERT INTO $this->table_name (
				logevent_type,
				logevent_id,
				air_start_time,
				air_stop_time,
				air_date,
				asset_id,
				asset_filename,
				asset_participant_name,
				asset_participant_id,
				asset_sponsor_id,
				asset_sponsor_name,
				asset_product_id,
				asset_product_name,
				comment,
				rw_local,
				rw_cancon,
				rw_hit,
				rw_female,
				rw_indigenous,
				rw_explicit,
				rw_release_date,
				rw_genre,
				artist_id,
				artist_name,
				album_id,
				album_name,
				title
				) VALUES (
				'$logevent_type',
				'$logevent_id',
				'$air_start_time',
				'$air_stop_time',
				'$air_date',
				'$asset_id',
				'$asset_filename',
				'$asset_participant_name',
				'$asset_participant_id',
				'$asset_sponsor_id',
				'$asset_sponsor_name',
				'$asset_product_id',
				'$asset_product_name',
				'$comment',
				'$rw_local',
				'$rw_cancon',
				'$rw_hit',
				'$rw_female',
				'$rw_indigenous',
				'$rw_explicit',
				'$rw_release_date',
				'$rw_genre',
				'$artist_id',
				'$artist_name',
				'$album_id',
				'$album_name',
				'$title'
					)";
            $count = $this->db_handle->query($SQL);
            $last_error = $this->db_handle->last_error;
            $response = array('count'=>$count,'error'=>$last_error);
            return $response;			
		}
	
	    function create_table() {
			//* Create the zetta logs table
			$SQL = "CREATE TABLE $this->table_name (
			rw_event_id INTEGER NOT NULL AUTO_INCREMENT,
			creation_ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			modification_ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			logevent_id BIGINT NOT NULL UNIQUE,
			logevent_type VARCHAR(255) NOT NULL,
			air_start_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			air_stop_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			air_date DATE NOT NULL,
			asset_id INTEGER,
			asset_filename VARCHAR(255),
			asset_participant_name VARCHAR(255),
			asset_participant_id INTEGER,
			asset_sponsor_id INTEGER,
			asset_sponsor_name VARCHAR(255),
			asset_product_id INTEGER,
			asset_product_name VARCHAR(255),
			comment TEXT,
			rw_local INTEGER,
			rw_cancon INTEGER,
			rw_hit INTEGER,
			rw_female INTEGER,
			rw_indigenous INTEGER,
			rw_explicit INTEGER,
			rw_release_date VARCHAR(64),
			rw_genre VARCHAR(255),
			artist_id INTEGER,
			artist_name VARCHAR(255),
			album_id INTEGER,
			album_name VARCHAR(255),
			title VARCHAR(255),
			PRIMARY KEY (rw_event_id)
			);";
			// dbDelta( $SQL );
			maybe_create_table( $this->table_name,$SQL );
		}
	
	}

;?>
