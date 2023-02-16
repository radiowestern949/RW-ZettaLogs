<?php
    include_once("design-Singleton.php");

    class ProcessLogger extends Singleton{

        // there shall only only be one file systemwide for all logs
        private static $foldername = "log"; 
        private static $filename_prefix = "log_";
        private static $file_number = 1;

        function __construct($args=null){
            $foldername = @$args['foldername'];
            $filename_prefix = @$args['filename_prefix'];

            if(isset($foldername))
                self::$foldername = $foldername;
            
            if(isset($filename_prefix))
                self::$filename_prefix = $filename_prefix;
            
            if (!file_exists(self::$foldername)) 
                mkdir(self::$foldername, 0777, true);
        }
        private static function generate_filepath(){
            clearstatcache();
            $filepath = self::$foldername . "/" . self::$filename_prefix . date('Y-m-d') . '_' . self::$file_number . '.log';
            if(!file_exists($filepath))// a newly dated log file
                self::$file_number=1;
            if(filesize($filepath) > 1000000 && file_exists($filepath))//log file has a 1MB file-size limit
                self::$file_number+=1;
            $filepath = self::$foldername . "/" . self::$filename_prefix . date('Y-m-d') . '_' . self::$file_number . '.log';
            return $filepath;
        } 

        public function write_log($log_msg){
            $log_msg = date('Y-m-d H:i:s') . " " . $log_msg . "\n";
            $filepath = self::generate_filepath();
            file_put_contents($filepath,$log_msg,FILE_APPEND);
        }
    }

    // $kwargs_warn = array('foldername'=>'warn','filename_prefix'=>'warn_');
    // $kwargs_debug = array('foldername'=>'debug','filename_prefix'=>'debug_');
    // $kwargs_log = array('foldername'=>'log','filename_prefix'=>'log_');
    // $process_logger_instance_log = ProcessLogger::get_instance($kwargs_log);
    // $process_logger_instance_warn = ProcessLogger::get_instance($kwargs_warn);
    // $process_logger_instance_log->write_log("this is log message");

;?>
