<?php
	class TABLE_LINKS
    {
        private $db;
        private $array;
        public $dan;
        
        public function __construct()
        {
            $this->db = new DB3();
            $method = $_SERVER['REQUEST_METHOD'];            
            $this->$method();                         
        }   
        
        private function GET()
        {
            if(count($_GET) <= 0){
                $this->index();                
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
                foreach($_POST as $k=>$v){
                    if(method_exists($this, $k)){                           
                        $this->array = $_POST;
                        unset($this->array[$k]);
                        $this->$k($v); 
                    }    
                }
                $this->GET();
            }
        }
        
        private function index()
        {
            $dan = array();            
            $dan['TABLES'] = $this->db->Select("select * from S_META_TABLES order by id");  
            $dan['COLUMNS'] = $this->db->Select("select * from S_META_COLUMNS where id_table = ".$dan['TABLES'][0]['ID']." order by ID");                       
            $dan['LIST'] = $this->db->Select("select 
                sm.ID, 
                st1.table_name table_name1, 
                st1.table_meta table_meta1, 
                st1.descript descript1,
                st2.table_name table_name2, 
                st2.table_meta table_meta2, 
                st2.descript descript2,  
                SC1.COL_NAME col_name1,
                SC1.COL_META col_meta1,
                SC2.COL_NAME col_name2,
                SC2.COL_META col_meta2                             
            from 
                S_META_CONNECTED sm, 
                S_META_TABLES st1, 
                S_META_TABLES st2,
                S_META_COLUMNS SC1,
                S_META_COLUMNS SC2
            where 
              sm.id_table1 = st1.id
              and sm.id_table2 = st2.id 
              and SC1.id_table = st1.id
              and SC2.id_table = st2.id
              and SC1.ID = sm.COL_NAME1
              and SC2.ID = sm.COL_NAME2 order by 2");
            
            $this->dan = $dan;
            return $dan;
        }
        
        private function list_columns($id)
        {            
            $q = $this->db->Select("select ID, COL_NAME, COL_META from S_META_COLUMNS where id_table = $id order by id");
            echo json_encode($q);
            exit;               
        }
        
        private function save_link()
        {            
            $table1 = $this->array['table1'];      
            $table2 = $this->array['table2'];
            $column1 = $this->array['column1'];
            $column2 = $this->array['column2'];
            
            $sql = "INSERT INTO S_META_CONNECTED (ID, ID_TABLE1, ID_TABLE2, CONDIT, COL_NAME1, COL_NAME2) 
            VALUES (SEQ_S_META_CONNECTED.nextval, $table1, $table2, '=', $column1, $column2)";             
            if(!$this->db->Execute($sql)){
                echo $this->db->message;
            }            
            exit;
        }
        
    }