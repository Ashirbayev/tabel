<?php
	class IMAPMAIL
    {        
        private $imap = false;
        private $login;
        private $pass;
        private $server;
                
        public function __construct($server, $login, $pass)
        {            
            $this->server = $server;
            $this->login = $login;
            $this->pass = $pass;                        
        }
        
        
        public function connect()
        {
            $this->imap = new Imap($this->server, $this->login, $this->pass, 'tls');            
            if($this->imap->isConnected()===false)die($this->imap->getError());
        }
        
        
        public function paths()
        {
            if(!$this->imap){$this->connect();}
            $dan = array();
            $folders = $this->imap->getFolders();
            
            foreach($folders as $folder){
                $this->imap->selectFolder($folder);
                
                $i = $this->PathNum($folder);
                $dan[$i]['path_name'] = $folder;
                $dan[$i]['count_unread'] = $this->imap->countUnreadMessages();
                $dan[$i]['name'] = $this->pathname($folder);
                $dan[$i]['icon'] = $this->PathIcon($folder);
            }            
            return $dan;
        }
        
        
        public function add_path($name)
        {
            if(!$this->imap){$this->connect();}
            return $this->imap->addFolder($name);
        }
                
        public function send_message_to_path($msg_idm, $path)
        {
            if(!$this->imap){$this->connect();}
            $this->imap->moveMessage($msg_idm, $path);
        }
                
        public function delete($id)
        {
            if(!$this->imap){$this->connect();}
            $this->imap->deleteMessage($id);
        }
                
        public function list_messages_from_path($path)
        {
            if(!$this->imap){$this->connect();}
            
            $this->imap->selectFolder($path);
            $dan = array();
            
            $dan['count'] = $this->imap->countMessages();            
            $dan['messages'] = $this->imap->getMessages();
            return $dan;
        }
        
        public function MessageDan($path, $id)
        {
            if(!$this->imap){$this->connect();}
            $this->imap->selectFolder($path);
            $ds = $this->imap->getMessages();
            
            $i = 0;
            foreach($ds as $k=>$v){
                if($v['uid'] == $id){
                   $dan = $v; 
                }
            }
            
            return $dan;
        }
                    
        private function PathNum($folder)
        {
            switch(strtoupper($folder))
            {
                case "INBOX": return 0; break;
                case "SENT": return 1; break;
                case "DRAFTS": return 2; break;
                case "JUNK": return 3; break;
                case "TRASH": return 4; break;                
                case "ARCHIVE": return 5; break;                
            }
            return 6;
        }
                   
        private function PathIcon($folder)
        {
            switch(strtoupper($folder))
            {
                case "INBOX": return 'fa-inbox'; break;
                case "SENT": return 'fa-envelope-o'; break;
                case "DRAFTS": return 'fa-certificate'; break;
                case "JUNK": return 'fa-thumbs-o-down'; break;
                case "TRASH": return 'fa-trash-o'; break;                
                case "ARCHIVE": return 'fa-archive'; break;                
            }
            return 'fa-folder';
        }
                       
        private function pathname($folder)
        {
            switch(strtoupper($folder))
            {
                case "INBOX": return "Входящие"; break;
                case "SENT": return "Отправленные"; break;
                case "TRASH": return "Удаленные"; break;
                case "DRAFTS": return "Черновики"; break;
                case "ARCHIVE": return "Архив"; break;
                case "JUNK": return "Спам"; break;
            }
            return $folder;
        }
        
        public function __destruct(){
            imap_close($this->imap);
        }
    }
?>