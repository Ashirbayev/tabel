<?php
	class CHAT
    {
        public function __construct()
        {
            $this->db = new DB();
            $method = $_SERVER['REQUEST_METHOD'];                           
            $this->$method();
        }
        
        private function GET()
        {
            if(count($_GET) <= 0){
                $this->lists();                
            }else{            
                foreach($_GET as $k=>$v){
                    $this->$k($v);
                }
            }                        
        }
        
        private function POST()
        {
            if(count($_POST) <= 0){
                $this->dan = array();
            }else{
                foreach($_POST as $k=>$v);
                if(method_exists($this, $k)){
                    $this->array = $_POST;
                    $this->$k($v); 
                }
            }
        }
        
        
    }
?>