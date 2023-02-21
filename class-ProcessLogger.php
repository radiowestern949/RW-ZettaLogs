<?php
    include_once("design-Singleton.php");

    class ProcessLogger extends Singleton{

        // there shall only only be one file systemwide for all logs
        private static $foldername = "log"; 
        private static $filename_prefix = "log_";
        private static $file_number = 1;
        private static $current_filepath = "";
        private static $current_filestream = FALSE;

        function __construct($args=null)
        {
            $foldername = @$args['foldername'];
            $filename_prefix = @$args['filename_prefix'];

            if(isset($foldername))
                self::$foldername = $foldername;
            
            if(isset($filename_prefix))
                self::$filename_prefix = $filename_prefix;
            
            // create the 'log' folder
            if (!file_exists(self::$foldername)) 
                mkdir(self::$foldername, 0777, true);
        }

        public function write_log($log_msg)
        {
            clearstatcache(); // this is necessary to update the filesize correctly
            
            // 1MB size limit
            if(filesize(self::$current_filepath) > 1000000)
            {
                self::$file_number += 1;
                fclose(self::$current_filestream);
                self::$current_filepath = self::$foldername . "/" . self::$filename_prefix . date('Y-m-d') . '_' . self::$file_number . '.log';
            }

            // if the file does not exist, then it means we're entering a new date. so close the current_filestream
            if(!file_exists(self::$current_filepath) && self::$current_filestream != FALSE)
            {
                self::$file_number = 1;
                fclose(self::$current_filestream);
            }

            self::$current_filepath = self::$foldername . "/" . self::$filename_prefix . date('Y-m-d') . '_' . self::$file_number . '.log';
            
            self::$current_filestream = fopen(self::$current_filepath,"a");
            if(self::$current_filestream == FALSE){
                fwrite(STDERR, "Failed to create/open log file " . self::$current_filepath);
                return ;
            }

            $log_msg = date('Y-m-d H:i:s') . " " . $log_msg . "\n";
            $bytes_written = fwrite(self::$current_filestream,$log_msg);
            if($bytes_written == FALSE)
            {
                fwrite(STDERR, "Failed to write to log file " . self::$current_filepath);
                return;
            }
            fclose(self::$current_filestream);
        }
    }

    // $kwargs_warn = array('foldername'=>'warn','filename_prefix'=>'warn_');
    // $process_logger_instance_warn = ProcessLogger::get_instance($kwargs_warn);
    // $process_logger_instance_warn->write_log("this is log message");

;?>
