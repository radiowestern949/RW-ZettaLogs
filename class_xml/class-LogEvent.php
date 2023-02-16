<?php
    class LogEvent{
        protected $logevent_type;
        protected $logevent_id;
        protected $air_start_time;
        protected $air_stop_time;
        protected $air_date;
        protected $asset_id;
        protected $asset_filename;
        protected $asset_participant_name;
        protected $asset_participant_id;
        protected $asset_sponsor_id;
        protected $asset_sponsor_name;
        protected $asset_product_id;
        protected $asset_product_name;
        protected $comment;
        protected $rw_local;
        protected $rw_cancon;
        protected $rw_hit;
        protected $rw_female;
        protected $rw_indigenous;
        protected $rw_explicit;
        protected $rw_release_date;
        protected $rw_genre;
        protected $artist_id;
        protected $artist_name;
        protected $album_id;
        protected $album_name;
        protected $title;

        function get_metadata():array{
            return array(
                'logevent_type'=>(string)$this->logevent_type,
                'logevent_id'=>(string)$this->logevent_id,
                'air_start_time'=>(string)$this->air_start_time,
                'air_stop_time'=>(string)$this->air_stop_time,
                'air_date'=>(string)$this->air_date,
                'asset_id'=>(string)$this->asset_id,
                'asset_filename'=>(string)$this->asset_filename,
                'asset_participant_name'=>(string)$this->asset_participant_name,
                'asset_participant_id'=>(string)$this->asset_participant_id,
                'asset_sponsor_id'=>(string)$this->asset_sponsor_id,
                'asset_sponsor_name'=>(string)$this->asset_sponsor_name,
                'asset_product_id'=>(string)$this->asset_product_id,
                'asset_product_name'=>(string)$this->asset_product_name,
                'comment'=>(string)$this->comment,
                'rw_local'=>(string)$this->rw_local,
                'rw_cancon'=>(string)$this->rw_cancon,
                'rw_hit'=>(string)$this->rw_hit,
                'rw_female'=>(string)$this->rw_female,
                'rw_indigenous'=>(string)$this->rw_indigenous,
                'rw_explicit'=>(string)$this->rw_explicit,
                'rw_release_date'=>(string)$this->rw_release_date,
                'rw_genre'=>(string)$this->rw_genre,
                'artist_id'=>(string)$this->artist_id,
                'artist_name'=>(string)$this->artist_name,
                'album_id'=>(string)$this->album_id,
                'album_name'=>(string)$this->album_name,
                'title'=>(string)$this->title
            );
        }
        
        protected function generate_default_timestamp(){
            return(date('Y-m-d H:i:s'));
        }

        protected function generate_default_date(){
            return substr($this->air_start_time,0,10);
        }

        protected function generate_default_logeventID(){
            return str_replace(array(" ", "-", ":", "PM","AM"), '', $this->air_start_time);
        }
    }

;?>