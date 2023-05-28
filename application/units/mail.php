<?php
	class MAIL
    {
        private $login;
        private $pass;
        private $connect;           
        public  $imap;
        public  $user_session; 
        
        public function __construct()
        {
            $this->server = MAIL_SERVER;            
            if (!extension_loaded('imap'))
            {
	           echo "ERROR: Your PHP is not compiled with IMAP Support.<BR /> 
               *NIX Users should recompile the PHP with the --with-imap flag and Windows users can simply 
               uncomment the extension='php_imap.dll' line in their php.ini";
	           exit;
            } 
        } 
        
        public function Autentification($login, $pass)
        {
            if($login == ''){return false;}
            if($pass == ''){return false;}
            $this->login = $login;
            $this->pass = $pass;
            
            $this->imap = imap_open($this->server, $this->login, $this->pass) or die(imap_errors());
            $_SESSION['imap'] = $this->imap;            
            return true;
        }
                
        public function Path()
        {
            $dan = array();
            $folders = imap_list($this->imap, $this->server, "*");                                   
            foreach ($folders as $folder) {          
                $imap = imap_open($folder, $this->login, $this->pass);
                
                $folder = str_replace($this->server, "",  $folder);
                $text = str_replace('&', '+', $folder);
                $text = str_replace(',', '/', $text);
                $fs = iconv('UTF-7','UTF-8//IGNORE', $text);
                $group = explode("/", $this->TranslatePath($fs));
                $gr = array("group"=>"");
                if(count($group) > 1){
                    $gr["group"] = $group[0];
                    $gr["group_text"] = $group[1];
                }                          
                $dan[] = array(
                    "num"=>$this->PathNum($fs), 
                    'folder_url'=>$folder, 
                    "folder_name" => $this->TranslatePath($fs), 
                    "folder_icon" => $this->PathIcon($fs),
                    "msg_count" => imap_num_msg($imap),
                    $gr);
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
        
        public function listMessages($path)
        {
            
        }
        
        private function TranslatePath($folder)
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
        
        /**/
        
        public function listpath()
        {
            $dan = array();
            $folders = imap_listmailbox($this->imap, $this->server, "*");  
                                             
            foreach ($folders as $folder) {          
                $imap = imap_open($folder, $this->login, $this->pass);
                
                $folder = str_replace($this->server, "",  $folder);
                $text = str_replace('&', '+', $folder);
                $text = str_replace(',', '/', $text);
                $fs = iconv('UTF-7','UTF-8//IGNORE', $text);
                $group = explode("/", $this->TranslatePath($fs));
                $gr = array("group"=>"");
                if(count($group) > 1){
                    $gr["group"] = $group[0];
                    $gr["group_text"] = $group[1];
                }           
                
                $list_header = $this->list_mail_header($folder);
                               
                $dan[] = array(
                    "num"=>$this->PathNum($fs), 
                    'folder_url'=>$folder, 
                    "folder_name" => $this->TranslatePath($fs), 
                    "folder_icon" => $this->PathIcon($fs),
                    "msg_count" => imap_num_msg($imap),
                    $gr,
                    "header" => $list_header);
            }    
            imap_close($this->imap);
            return $dan;
        }
        
        private function list_mail_header($inbox)
        {
            $imap = imap_open($this->server.$inbox, $this->login, $this->pass);                        
            $numMessages = imap_num_msg($imap);
            $dan = array();
            for ($i = $numMessages; $i > 0; $i--) 
            {
                $header = imap_header($imap, $i);
                        
                if($folder == 'INBOX'){
                    $to = imap_mime_header_decode($header->fromaddress);               
                    $toAdress = $to[0]->text;
                }else{
                    $to = imap_mime_header_decode($header->toaddress);               
                    $toAdress = $to[0]->text;
                }
        
                $ms = imap_mime_header_decode($header->reply_toaddress);
                $replytoaddr = $ms[0]->text;
        
                $sub = imap_mime_header_decode($header->subject);        
                $subject = $sub[0]->text;  
        
                if(trim($subject) == ''){
                    $subject = '(Без темы)';
                }
        
                $maildate = date("d.m.Y H:i:s", strtotime($header->date));
                                        
                $ds = array();
                $ds['unseen'] = trim($header->Unseen);
                $ds['num_pp'] = trim($header->Msgno);
                $ds['to_adress'] = $toAdress;
                $ds['reply'] = $replytoaddr;
                $ds['subject'] = $subject;
                $ds['flag'] = $header->Flagged;
                $ds['maildate'] = $maildate;
                $ds['files'] = $this->files($imap, $i);                
                //$ds['other'] = $header;                
                //$ds['structure'] = $structure;
                $dan[] = $ds;                        
            }
            imap_close($imap);
            return $dan;
        }
        
        private function files($imap, $id)
        {
            $structure = imap_fetchstructure($imap,$id); 
                       
            $f = $structure->parts;
            $dan = array();
            $boundary = $f[0]->parameters[0]->value;
            for($i = 1; $i < count($f); $i++){
                $ds = array();
                $ds['boundary'] = $boundary;                
                $ds['bytes'] = $f[$i]->bytes;
                $ds['type'] = $f[$i]->subtype;                
                $ds['title'] = $this->EncodeFilename($f[$i]->parameters[0]->value);
                $ds['json'] = json_encode($structure->parts);
                $dan[] = $ds; 
            }
            return $dan;
        }
        
        private function EncodeFilename($str)
        {
            $arrStr = explode('?', $str);
            if (isset($arrStr[1]) && in_array($arrStr[1], mb_list_encodings())) 
            {
                switch ($arrStr[2]) 
                {
                    case 'B':
                    $str = base64_decode($arrStr[3]);
                break;
                case 'Q': //quoted printable encoded
                    $str = quoted_printable_decode($arrStr[3]);
                    break;
                }
                $str = iconv($arrStr[1], 'UTF-8', $str);
            }
            return $str;
        }
                
    }
?>