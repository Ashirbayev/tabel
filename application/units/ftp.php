<?php
	class FTP
    {
        private $server;
        private $username;
        private $password;
        
        private $ftp_ses;
        
        public function __construct($server, $user, $pass)
        {
            $this->server = $server;
            $this->username = $user;
            $this->password = $pass;
            
            $this->connect();
        }
        
        private function connect()
        {
            $this->ftp_ses = ftp_connect($this->server) or die("Could not connect to $this->server");
            $login = ftp_login($this->ftp_ses, $this->username, $this->password);
        }
        
        public function scandir($dir)
        {            
            $contents = ftp_nlist($this->ftp_ses, "./".$dir);
            return $contents;
        } 
        
        public function upload($filename)
        {          
            $size = $this->filesize($filename);
            $tempHandle = fopen('php://temp', 'r+');
            if (@ftp_fget($this->ftp_ses, $tempHandle, $filename, FTP_BINARY, 0)) {
                rewind($tempHandle);
                $rs =  stream_get_contents($tempHandle);
                fclose($tempHandle);
                return $rs;
            } else { 
                fclose($tempHandle);
                return false;
            } 
        }
        
        private function filesize($filename)
        {
            $res = ftp_size($this->ftp_ses, $filename);
            return $res;
        }
        
        public function create_path($path)
        {
            if(!$this->check_path($path)){
                return ftp_mkdir($this->ftp_ses, $path);
            }            
        }    
        
        public function check_path($path)
        {
            if(ftp_site($this->ftp_ses, "CHMOD 0600 /$path")){
                return true;
            }else{
                return false;    
            }
        }
        
        public function uploadfile($ftp_path, $filename, $local_file)
        {
            $conn_id = ftp_connect(FTP_SERVER);
            $login_result = ftp_login($conn_id, 'upload', 'Astana2014');
            //echo $local_file;
            
            return ftp_fput($conn_id, $ftp_path.$filename, $local_file, FTP_BINARY);
            //return ftp_put($conn_id, $ftp_path.$filename, $local_file, FTP_BINARY);
        }
        
        public function download($remote_file)
        {
            $s = explode('/', $remote_file);            
            $t = count($s);       
            
            chmod(__DIR__.'/', 0755);
                 
            $local_file = 'local.zip';//__DIR__.'/'.$s[$t-1];
            echo $local_file."<br />";
            
            
            $conn_id = ftp_connect($this->server);
            $login_result = ftp_login($conn_id, $this->username, $this->password);
            if($login_result){
                ftp_pasv($conn_id, true);
            }else{
                echo 'Ошибка подключения';
                exit;
            }
            
            error_reporting(E_ALL);
            $e = ftp_fget($conn_id, $local_file, substr($remote_file, 1), FTP_BINARY);            
            var_dump($e);
                        
            ftp_close($conn_id);            
            exit;
        }
        
        private function __destruct(){
            ftp_close($this->ftp_ses);
        }
    }
?>