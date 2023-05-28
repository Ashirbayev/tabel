<?php
	class TASKS
    {
        private $db;
        private $array;
        public $html;
        
        public function __construct()
        {
            $this->db = new DB();
            $method = $_SERVER['REQUEST_METHOD'];
            $this->$method();
        }
        
        private function GET()
        {            
            if(count($_GET) <= 0){
                $this->html = $this->index();                
            }else{            
                foreach($_GET as $k=>$v){
                    if(method_exists($this, $k)){
                        $this->$k($v);
                    }else{
                        $this->array[$k] = $v;
                    }
                }
            }                        
        }
        
        private function POST()
        {
            if(count($_POST) > 0){                
                foreach($_POST as $k=>$v);                                
                if(method_exists($this, $k)){                                        
                    $this->array = $_POST;
                    $this->$k($v); 
                }
            }
        }
        
        private function index()
        {
            $this->html = '';
        }
        
        
    }
?>