<?php
	class META
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
            $dan['TABLES'] = $this->db->Select("select table_name NAME from all_tables where owner = 'INSURANCE' 
            AND TABLESPACE_NAME = 'USERS' order by table_name");
            
            $this->dan = $dan;
            return $dan;
        }
        
        private function table_db($name)
        {            
            $dan['TABLENAME'] = $name;
            $ds = $this->db->Select("select * from S_META_TABLES where TABLE_NAME = '$name'");
            $dan["META_TABLE"]['ID'] = nvl($ds[0]['ID'], 0);            
            $dan["META_TABLE"]['TABLE_META'] = $ds[0]['TABLE_META'];
            $dan["META_TABLE"]['DESCRIPT'] = $ds[0]['DESCRIPT'];
            $dan["META_TABLE"]['UNIONALL'] = $ds[0]['UNIONALL'];
            
            $dan["COLUMNS"] = $this->db->Select("select * from table(search_contracts.list_columns('$name'))");
            
            echo json_encode($dan);
            exit;
        }
        
        private function save_meta_table($id)
        {
            $res = array();
            $res['msg'] = '';
            $TABLE_NAME = $this->array['table_name']; 
            $TABLE_META = $this->array['table_meta'];
            $DESCRIPT = $this->array['descr'];
            $UNIONALL = $this->array['table_unionall'];
            
            $res['id'] = $id;
            if($id == 0){
                $ids = $this->db->Select("select SEQ_S_META_TABLES.nextval id from dual");
                $res['id'] = $ids[0]['ID'];                
                $sql = "INSERT INTO S_META_TABLES (ID, TABLE_NAME, TABLE_META, DESCRIPT, UNIONALL) 
                VALUES (".$res['id'].", '$TABLE_NAME', '$TABLE_META', '$DESCRIPT', '$UNIONALL')";                
            }else{                
                $sql = "update S_META_TABLES set TABLE_META = '$TABLE_META', DESCRIPT = '$DESCRIPT', UNIONALL = '$UNIONALL' where id = $id";                
            }
            if(!$this->db->Execute($sql)){
                $res['msg'] = $this->db->message;
            }
            echo json_encode($res);            
            exit;
        }
        
        private function save_meta_col($id)
        {
            $id_table = $this->array['id_table'];
            $meta =  $this->array['meta'];
            $desc = $this->array['desc'];
            $funct = $this->array['funct'];
            
            $q = $this->db->Select("select * from S_META_COLUMNS where id_table = $id_table and col_name = '$id'");
            
            if(count($q) == 0){
                $sql = "INSERT INTO S_META_COLUMNS (ID, ID_TABLE, COL_NAME, COL_META, DESCRIPT, FUNCT)
                VALUES (SEQ_S_META_COLUMNS.nextval, $id_table, '$id', '$meta','$desc', '$funct')";
            }else{
                /*if(trim($meta) == ''){$ds = $this->db->Select("delete from S_META_COLUMNS where ID = ".$q[0]['ID']);}else{} */  
                $sql = "update S_META_COLUMNS set COL_META = '$meta', DESCRIPT = '$desc', FUNCT = '$funct' where ID = ".$q[0]['ID'];             
            }
            
            if(!$this->db->Execute($sql)){
                echo $this->db->message;                
            }            
            exit;
        }
        
        private function new_meta($id_table)
        {
            $dan = array();
            $dan['msg'] = '';
            $dan['res'] = '';
            $name = $this->array['name'];
            $funct = $this->array['funct'];
            $desc = $this->array['desc'];
            
            $q = $this->db->Select("select count(*) c from S_META_COLUMNS where id_table = $id_table and COL_META = '$name'");
            if($q[0]['C'] > 0){
                 $dan['msg'] = 'Ошибка! Мета с название '.$name.' уже существует!';                 
            }else{
                $ss = $this->db->Select("select SEQ_S_META_COLUMNS.nextval ss from dual");
                $ss_id = $ss[0]['SS'];
                
                $sql = "INSERT INTO S_META_COLUMNS (ID, COL_NAME, ID_TABLE, COL_META, DESCRIPT, FUNCT, MC)
                VALUES ($ss_id, 'META$ss_id', $id_table, '$name','$desc', '$funct', 1)";                
                if(!$this->db->Execute($sql)){
                    $dan['msg'] = $this->db->message;
                }else{
                    $q = $this->db->Select("select * from S_META_COLUMNS where id = $ss_id");
                    $dan['res'] = $this->form_meta($ss_id, $q[0]['COL_NAME'], $q[0]['COL_META'], $q[0]['FUNCT'], $q[0]['DESCRIPT']);                                         
                }                
            }
            echo json_encode($dan);
            exit;                 
        }
        
        private function del_meta($id)
        {
            $sql = "delete from S_META_COLUMNS where id = $id";
            if(!$this->db->Execute($sql)){
                echo $this->db->message;
            }            
            exit;
        }
        
        private function form_meta($ID, $COL_NAME, $COL_META, $FUNCT, $DESCRIPT)
        {
            return '<div class="form-group" id="G'.$ID.'">
                            <label class="col-lg-3 control-label">'.$COL_NAME.'</label>
                            <div class="col-lg-3">
                                <input id="'.$COL_NAME.'" data="2" type="text" class="form-control" value="'.$COL_META.'">
                            </div>
                            <div class="col-lg-3">
                                <input id="F_'.$COL_NAME.'" data="2" type="text" class="form-control" value="'.$FUNCT.'">
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group"><input id="DS_'.$COL_NAME.'" data="2" type="text" class="form-control" value="'.$DESCRIPT.'">
                                    <span class="input-group-btn">
                                        <button data="'.$COL_NAME.'" title="Сохранить данные" class="btn btn-primary save_col_table"><i class="fa fa-check"></i></button>
                                        <button data="'.$ID.'" title="Удалить запись" class="btn btn-danger del_meta"><i class="fa fa-trash"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>';
        }
    }
?>