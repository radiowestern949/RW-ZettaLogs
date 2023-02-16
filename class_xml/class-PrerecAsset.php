<?php
    include_once("class-LogEvent.php");


    class PrerecAsset extends LogEvent{

        private $asset_attributes;
        private $regex_local = "/local/i";
        private $regex_cancon = "/cancon/i";
        private $regex_hit = "/hit/i";
        private $regex_female = "/female/i";
        private $regex_indigenous = "/indigenous/i";
        private $regex_explicit = "/explicit/i";
        private $regex_release_date = "/release/i";
        private $regex_genre = "/genre/i";



        function __construct($logevent_xml){
            $this->air_start_time           = (string)@$logevent_xml->attributes()->AirStarttimeLocal;
            $this->air_stop_time            = (string)@$logevent_xml->attributes()->AirStoptimeLocal;
            $this->logevent_id              = (string)@$logevent_xml->attributes()->LogEventID;
            $this->air_date                 = $this->generate_default_date();
            $this->logevent_type            = (string)@$logevent_xml->AssetEvent->Asset->attributes()->AssetTypeName;
            $this->asset_id                 = (string)@$logevent_xml->AssetEvent->Asset->attributes()->AssetID;
            $this->asset_filename           = (string)@$logevent_xml->AssetEvent->Asset->Resource->attributes()->ResourceFile;
            $this->comment                  = (string)@$logevent_xml->AssetEvent->Asset->attributes()->Comment;
            $this->asset_participant_id     = (string)@$logevent_xml->AssetEvent->Asset->Participant->attributes()->ParticipantID;
            $this->asset_participant_name   = (string)@$logevent_xml->AssetEvent->Asset->Participant->attributes()->Name;
            $this->asset_sponsor_id         = (string)@$logevent_xml->AssetEvent->Asset->Sponsor->attributes()->SponsorID;
            $this->asset_sponsor_name       = (string)@$logevent_xml->AssetEvent->Asset->Sponsor->attributes()->Name;
            $this->asset_product_id         = (string)@$logevent_xml->AssetEvent->Asset->Product->attributes()->ProductID;
            $this->asset_product_name       = (string)@$logevent_xml->AssetEvent->Asset->Product->attributes()->Name;
            $this->artist_name              = (string)@$logevent_xml->AssetEvent->Asset->Artist->attributes()->Name;
            $this->artist_id                = (string)@$logevent_xml->AssetEvent->Asset->Artist->attributes()->ArtistID;
            $this->album_name               = (string)@$logevent_xml->AssetEvent->Asset->Album->attributes()->Name;
            $this->album_id                 = (string)@$logevent_xml->AssetEvent->Asset->Album->attributes()->AlbumID;
            $this->title                    = (string)@$logevent_xml->AssetEvent->Asset->attributes()->Title;

            $this->asset_attributes = @$logevent_xml->AssetEvent->Asset->xpath("//AssetAttribute");
            $this->parse_asset_attributes();
        }

        private function parse_asset_attributes(){
            foreach ($this->asset_attributes as $a) {
                $a_type = $a['AttributeTypeName'];
                $a_value = $a['AttributeValueName'];
    
                if(preg_match($this->regex_local,$a_type))//rw_local
                    $this->rw_local = $a_value;
                if(preg_match($this->regex_cancon,$a_type))//rw_cancon
                    $this->rw_cancon = $a_value;
                if(preg_match($this->regex_hit,$a_type))//rw_hit
                    $this->rw_hit = $a_value;
                if(preg_match($this->regex_explicit,$a_type))//rw_explicit
                    $this->rw_explicit = $a_value;
                if(preg_match($this->regex_indigenous,$a_type))//rw_indigenous
                    $this->rw_indigenous = $a_value;
                if(preg_match($this->regex_release_date,$a_type))//rw_release_date
                    $this->rw_release_date = $a_value;
                if(preg_match($this->regex_genre,$a_type))//rw_release_date
                    $this->rw_genre = $a_value;
            }
        }
    }
;?>