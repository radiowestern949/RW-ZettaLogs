<?php
// https://refactoring.guru/design-patterns/singleton/php/example#example-1
// is this an abstract class? 

    class Singleton{
        
        private static $instances = [];

        private function __construct(){}

        // a static function can be called by the class even before instantiating
        public static function get_instance($kwargs=null){
            $subclass = static::class;
            // print_r(self::$instances);
            if(!isset(self::$instances[$subclass]))
                self::$instances[$subclass] = new static($kwargs);
            return self::$instances[$subclass];
        }
    }

;?>