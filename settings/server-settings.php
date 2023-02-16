<?php

	error_reporting(E_ALL);
	set_time_limit(0);//wait indefinitely for a client-connection
	//ob_implicit_flush();//print everything to STDOUT as and when it arrives
	
	$null = NULL;//this is aparently to deal with a bug in one of the socketClass's functions. 
	
	define("HOST_NAME", "tcp://0.0.0.0");
	define("PORT",10001);
	define("BUFFER_READ_SIZE",2**10);
	define("QUEUE_SIZE",5);

;?>