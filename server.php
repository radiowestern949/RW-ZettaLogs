<?php
	require_once("class-ProcessLogger.php");
	require_once("class-LogEventFactory.php");
	require_once("class-MessageHandler.php");
	require_once("class-ZettaLog.php");
	require_once("class-IcecastLogger.php");
	require_once('./settings/server-settings.php');

	$process_logger = ProcessLogger::get_instance();
	$process_logger->write_log("Service started");
	$message_handler = new MessageHandler();
	$process_logger->write_log("Message Handler Instantiated");
	$logevent_factory = LogEventFactory::get_instance();
	$process_logger->write_log("LogEventFactory Instatiated");
	$zetta_log_ORM = new ZettaLog();
	$process_logger->write_log("ZettaLog-ORM Instatiated");
	$icecast_logger = new IcecastLogger();
	$process_logger->write_log("IcecastLogger Instatiated");

	$server_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	$process_logger->write_log("Socket created");
	socket_bind($server_socket, 0, PORT);
	$process_logger->write_log("Socket bound to port " . PORT);
	socket_listen($server_socket);
	$process_logger->write_log("Socket listening...");
	
	while(true){
	//OUTER_START

		$client_socket = socket_accept($server_socket);
		if($client_socket===false){
			$process_logger->write_log("socket_accept() failed: reason: " . socket_strerror(socket_last_error($server_socket)));
			break;//GO TO OUTER_EXIT
		}

		while(true){
	//INNER_START
	
			$data = socket_read($client_socket,BUFFER_READ_SIZE);
			if($data === false){
				$process_logger->write_log("socket_read() failed: reason: " . socket_strerror(socket_last_error($client_socket)));
				break 2; // go to OUTER_EXIT
			}

			if($data==""){
				break; // finished receiving all data
			}

			//print_r("DATA = $data");
			$message_handler->append_buffer($data);

			if(!$message_handler->buffer_is_regex_complete()){
				$process_logger->write_log("REGEX FALSE"); 	// need to collect more data. 
				$process_logger->write_log($data);
				continue;									// go to INNER_START and await more data
			}
				
			$process_logger->write_log("REGEX TRUE");
			$message_handler->trim_unmatched_buffer();
			$message_handler->convert_string_to_xml();
			
			$n = $message_handler->count_xmls();// a buffer could contain more than 1 <ZettaClipboard>
			$process_logger->write_log("PARSE START");
			for ($i=0; $i < $n; $i++) { 
				$zettaclipboard_xml = $message_handler->get_xmls()[$i];
				$logevent_array = @$zettaclipboard_xml->LogEvents->xpath("//LogEvent");// a <ZettaCliopboard> could contain more than 1 LogEvent
				for ($j=0; $j < count($logevent_array); $j++) {
					$logevent_xml = $logevent_array[$j];
					$process_logger->write_log("spawning");
					$logevent = $logevent_factory->spawn_logevent($logevent_xml);
					if($logevent){
						$process_logger->write_log("writing");
						$zetta_log_ORM->create_record($logevent->get_metadata());
						$icecast_logger->write_icecast($logevent->get_metadata());
					}
				}
			}
			$process_logger->write_log("PARSE END");
			// reset the xml_objects and xml_strings within MessageHandler
			$message_handler->reset_xml_strings();
			$message_handler->reset_xml_objects();
			$process_logger->write_log("reset message_handler");
			$process_logger->write_log("buffer = " . $message_handler->buffer);
			$process_logger->write_log("---------------------");
		}
		socket_close($client_socket);
//INNER_EXIT --> this goes back to while(true)
	}
//OUTER_EXIT --> this exits the script all together. 
	$process_logger->write_log("Socket is closing");
	socket_close($server_socket);
	$process_logger->write_log("Service stopped");

;?>
