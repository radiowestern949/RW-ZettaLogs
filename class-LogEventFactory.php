<?php
    // this is a factory. 
    // it is also a singleton

	include_once("class-ProcessLogger.php");
	$process_logger = ProcessLogger::get_instance();

    include_once("design-Singleton.php");
    include_once ("./class_xml/class-PrerecAsset.php");
    include_once ("./class_xml/class-MacroTask.php");
    include_once ("./class_xml/class-WeirdAsset.php");

    class LogEventFactory extends Singleton{

        public function spawn_logevent($logevent_xml){
            if(
                ($logevent_xml->attributes()->LogEventID > 0) && 
                ($logevent_xml->AssetEvent->Asset) && 
                ($logevent_xml->attributes()->LastStarted=="true")
            )
                return new PrerecAsset($logevent_xml);

            elseif(
                ($logevent_xml->attributes()->LogEventID==0) && 
                ($logevent_xml->AssetEvent->Asset)
                )
                return new WeirdAsset($logevent_xml);
            
            elseif(($logevent_xml->Task))
                return new MacroTask($logevent_xml);
            
            global $process_logger;
            $process_logger->write_log("stopping/unknown");
            return 0;
        }
    }

    // $zetta_clipboard_xml = simplexml_load_file('./__exampleXMLs/LiveTask.xml');
    // // $zetta_clipboard_xml = simplexml_load_file('./__exampleXMLs/WeirdAsset.xml');
    // // $zetta_clipboard_xml = simplexml_load_file('./__exampleXMLs/Prerec_started.xml');
    // $logevent_xml = $zetta_clipboard_xml->LogEvents->LogEvent;
	// $logevent_factory = LogEventFactory::get_instance();
    // $logevent = $logevent_factory->spawn_logevent($logevent_xml);
    // if($logevent)
    //     print_r($logevent->getMetadata());
;?>
