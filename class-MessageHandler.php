<?php
/**
 * this class checks if the REGEX is satisfied
 * when REGEX satisfied it creates an array of N XML strings
 * it takes the array of XML strings and makes an array of XML objects
 * it then takes the array of XML objects and turns them into LogEvent Objects
 * the LogEvent objects are then turned into metadata values
 * it then takes the array of metadata values and passes it onto the zetta_log Object for writing to database
 * 
 * */

    include_once("class-ProcessLogger.php");
    $process_logger = ProcessLogger::get_instance();

    class MessageHandler{
        public $buffer;
        private $REGEX_PATTERN = '/\<\?xml.*?\<\/ZettaClipboard\>/s';
        private $xml_strings;//an array of all <?xml version>...</ZettaClipboard>
        private $xml_objects;
        private $strikes;

        function __construct(){
            $this->buffer = "";
            $this->xml_strings=array();
            $this->xml_objects=array();
            $this->strikes = 0;
        }

        function reset_buffer():void{
            $this->buffer = "";
        }
        function reset_xml_objects():void{
            $this->xml_objects = array();
        }
        function reset_xml_strings():void{
            $this->xml_strings = array();
        }

        function get_xmls():array{
            return $this->xml_objects;
        }

        function append_buffer($data):void{
            $this->buffer.=$data;
        }

        function buffer_is_regex_complete():bool{
    		preg_match_all($this->REGEX_PATTERN,$this->buffer,$this->xml_strings);
            return (count($this->xml_strings) == 1 && count($this->xml_strings[0]) > 0);
        }

        function trim_unmatched_buffer(){
            $this->buffer = trim(preg_replace($this->REGEX_PATTERN,'',$this->buffer));
        }

        function count_xmls():int{
            return count($this->xml_objects);
        }
        
        function count_strings():int{
		    return @count($this->xml_strings[0]);
	    }

        function convert_string_to_xml():void{
	    libxml_use_internal_errors(true);

            foreach($this->xml_strings[0] as $xml_string){
                $x = simplexml_load_string($xml_string);
                if($x){
                    $this->xml_objects[] = $x;
                }
                else{
                    global $process_logger;
                    $this->strikes += 1;
		    $errors = libxml_get_errors();
                    $process_logger->write_log("***********************************\nBROKEN XML \n $xml_string \n STRIKE $this->strikes");
		    foreach($errors as $error){
			//$process_logger->write_log("--------\n$error\n--------");
			print_r($error);
		    }
		    libxml_clear_errors();
                    if($this->strikes > 3){
                        $process_logger->write_log('STRIKE 3: resetting buffer!');
                        $this->reset_buffer();
                        $this->strikes = 0;
                    }
		    $process_logger->write_log("***********************************");
                }
            }
        }

        function print_all_strings(){
            print_r($this->xml_strings);
        }

        function print_all_objects(){
            print_r($this->xml_objects);
        }
    }

;?>
