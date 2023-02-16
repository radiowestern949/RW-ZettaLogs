<?php
	include_once("/var/www/customAPIs/ZettaLogger/class-ZettaLog.php");


	$zl = new ZettaLog();
	$zl->createRecord(
		$logevent_type = 'Prerec. Music',
		$logevent_id = '44351',
		$air_start_time = '2022-10-10 19:00',
		$air_stop_time = '2022-10-10 20:00',
		$air_date = '2022-10-10',
		$asset_id = '123123',
		$asset_filename = 'alsdals.mp3',
		$asset_participant_name = '12',
		$asset_participant_id = 'asd8',
		$asset_sponsor_id = '12312',
		$asset_sponsor_name = '23ds',
		$asset_product_id = 'asd3',
		$asset_product_name = 'asd33',
		$comment = 'asd3q23r3r',
		$rw_local = '1',
		$rw_cancon = '1',
		$rw_hit = '1',
		$rw_female = '1',
		$rw_indigenous = '1',
		$rw_explicit = '1',
		$rw_release_date = '1994-10-10',
		$rw_genre = 'Music is the medicine',
		$artist = 'Kim crawfrm',
		$album = '2022-10-10',
		$title = 'alsjda9s8'
	);
	print_r($zl->getAll());

    ;?>