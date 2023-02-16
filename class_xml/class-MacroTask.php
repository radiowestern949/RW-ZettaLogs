<?php
    include_once("class-LogEvent.php");


    //  This is for Red-Macros, LiveMetadata.Send and Sequencer.SetMode

    class MacroTask extends LogEvent{
        private
        static $regex_pattern_tasktype = "/(^.*)\s\[/";
        static $regex_title_artist_composer = "/Title:\s(.*),\sArtist:\s(.*),\sComposer:\s(.*)\s\]/";
        static $regex_sequencer_set_mode = "/Mode:\s(.*)\s/";

        function __construct($logevent_xml){
            $this->air_start_time = (string)$logevent_xml->attributes()->AirStarttimeLocal;
            $this->air_stop_time = $this->air_start_time;
            $this->logevent_id = $this->generate_default_logeventID();
            $this->air_date = $this->generate_default_date();
            $this->comment = (string)$logevent_xml->Task->attributes()->Comment;
            $this->parse_comment();
        }

        private function parse_comment(){
            preg_match($this::$regex_pattern_tasktype,$this->comment,$output_array);
            if($output_array && count($output_array)==2){
                $tasktype = $output_array[1];

                switch ($tasktype) {
                    case "LiveMetadata.Send":
                        preg_match($this::$regex_title_artist_composer,$this->comment,$output_array);
                        if($output_array && count($output_array)==4){
                            $this->title = $output_array[1];
                            $this->artist_name = $output_array[2];
                            $this->logevent_type = $output_array[3];
                        }
                        break;
                    case "Sequencer.SetMode":
                        preg_match($this::$regex_sequencer_set_mode,$this->comment,$output_array);
                        if($output_array && count($output_array)==2)
                            $this->logevent_type = $output_array[1];
                        break;
                    default:
                        break;
                }
            }
        }
    }

;?>