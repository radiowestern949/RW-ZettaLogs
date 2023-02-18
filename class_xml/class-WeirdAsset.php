<?php
    include_once("class-LogEvent.php");

    // this is when Steve sends a song name or when red macros play rapidly without a stop
    class WeirdAsset extends LogEvent{
        function __construct($logevent_xml){
            $this->air_start_time = (string)$logevent_xml->attributes()->AirStarttimeLocal;
            $this->air_stop_time= $this->air_start_time;
            $this->logevent_id = $this->generate_default_logeventID($this->air_start_time);
            $this->air_date = $this->generate_default_date();
            $this->title = (string)$logevent_xml->AssetEvent->Asset->attributes()->Title;
            $this->artist_name = (string)@$logevent_xml->AssetEvent->Asset->Artist->attributes()->Name;
            $this->logevent_type = (string)@$logevent_xml->AssetEvent->Asset->Participant->attributes()->Name;
            if(!$this->logevent_type)
                $this->logevent_type = "Live Song";
        }
    }

;?>
