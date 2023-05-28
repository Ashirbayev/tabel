<?php
	class AUTOLOAD
    {
        private $db;
        private $role_id;
        private $page;
        
        public function __construct()
        {
            $this->db = new DB();            
        }
        
        public function init_method()
        {            
            global $active_user_dan;            
            global $page;            
            $this->page = $page;            
            if(isset($active_user_dan['role'])){                  
                $this->role_id = $active_user_dan['role'];                
                $this->loadscript();
            }
        }
        
        private function loadscript()
        {
            if($this->page == 'index'){
                $this->page = '/';
            }
            $sql = "select D.METHOD_ACTION from VIEW_FORM_ROLE v, dir_method d, dir_forms f 
            where D.ID = V.ID_METHOD and F.ID = V.ID_FORM and v.id_role = $this->role_id and F.NAME_URL = '$this->page'";            
            $load_scripts = $this->db->Select($sql);
                                    
            if(count($load_scripts) > 0){
                foreach($load_scripts as $k=>$v){
                    $funct = $v['METHOD_ACTION'];                                                                                
                    if(file_exists('methods/'.$funct.'.php')){  
                        require_once 'methods/'.$funct.'.php';
                        $class = strtoupper($funct);    
                        $ch = new $class();
                        $ch->init();
                    }                    
                }
            }
            //echo $sql;            
        }
    }
?>