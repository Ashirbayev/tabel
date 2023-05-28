<?php
	class JABBER
    {
        private $webi;
        
        public function __construct()
        {
            include_once(__DIR__."/xmpp/xmpp.class.php");
            $this->webi = new XMPP($webi_conf);
            $this->webi->connect();
            
            //$webi->sendStatus('text status','chat'); // установка статуса                        
        }
        
        public function send_message($user, $msg)
        {
            $this->webi->sendMessage($user, $msg);
        }
    }
    /*
    $jabber = new JABBER();
    $jabber->send_message('i.akhmetov@gak.kz', 'HELLO');
    */
?>