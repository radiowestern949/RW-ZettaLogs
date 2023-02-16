<?php
    require "/var/www/customAPIs/ZettaLogger/class-MessageHandler.php";
    use PHPUnit\Framework\TestCase;
    
    class TestMessageHandler extends TestCase{
        private $message_handler;
        private $complete_file;
        private $complete_xml;
        private $incomplete_file;
        private $incomplete_xml;

        protected function setUp(): void{
            $this->message_handler = new MessageHandler();
            $this->complete_file = fopen('test-completexml.xml',"r");
            $this->complete_xml = fread($this->complete_file,10000000);
            $this->incomplete_file = fopen('test-incompletexml.xml',"r");
            $this->incomplete_xml = fread($this->incomplete_file,10000000);
        }
        protected function tearDown():void{
            $this->message_handler = NULL;
            $this->complete_file = NULL;
            $this->complete_xml = NULL;
            $this->incomplete_file = NULL;
            $this->incomplete_xml = NULL;
        }
        public function testComplete():void{
            $this->message_handler->append_buffer($this->complete_xml);
            $this->assertEquals($this->message_handler->buffer_is_complete(),true);
            $this->message_handler->convert_string_to_xml();
            
            $this->message_handler->reset_all();

            $this->message_handler->append_buffer($this->incomplete_xml);
            $this->assertEquals($this->message_handler->buffer_is_complete(),false);
        }
    }

;?>