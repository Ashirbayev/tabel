<?php
	class TYPICAL_FORMS
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
        
        //-------------------------------- Начало основной формы --------------------------------------------
        private function index()
        {
            $q = $this->db->Select("select * from s_form");
            $this->dan['table'] = $q;
            
            $s = $this->db->Select("select sum(cnt) cnt, sum(act) act, sum(no_act) no_act from(
                select count(*) cnt, 0 act, 0 no_act from S_FORM
                union all
                select 0 cnt, count(*) act, 0 no_act from S_FORM where active = 1
                union all
                select 0 cnt, 0 act, count(*) no_act from S_FORM where active = 0 
                )
            ");
            $this->dan['info'] = $s[0];
            $this->dan['dic_forms'] = $this->db->Select("select * from s_form_type");
            $this->dan['list_tables'] = $this->db->Select("select id, table_meta, descript from s_meta_tables");
            $this->dan['list_columns'] = $this->db->Select("select id, col_meta, descript from s_meta_columns where id_table = ".$this->dan['list_tables'][0]['ID']." order by col_meta");
            $this->dan['list_condit'] = $this->db->Select("select * from S_META_CONDIT order by id");
            foreach($this->dan['table'] as $k=>$v)
            {
                $sqld = "select d.*, t.table_name, t.table_meta, t.descript descript_table, c.col_name, c.col_meta,
                c.descript descript_col, m.name, m.condt, m.descrit from S_DATERMINANT d, s_meta_tables t, s_meta_columns c,
                S_META_CONDIT m where t.id = d.id_table and c.id = d.id_col and m.id = d.condit and d.id_form = ".$v['ID']." order by d.id";
                $this->dan['table'][$k]['LIST_CONDIT'] = $this->db->Select($sqld);
            }
            
            $this->dan['forms_type'] = $this->db->Select("select * from S_FORM_TYPE order by id");
            return $q;
        }
        
        private function edit_form($id)
        {     
            $dan = $this->array;
            $active = '0';
            if(isset($dan['ACTIVE'])){
                $active = $dan['ACTIVE'];
            }
            
            if($id == "0"){
                $sql = "INSERT INTO S_FORM (ID, NAME, VERS, DATE_BEGIN, DATE_END, ACTIVE, DESCRIPT, TYP) 
                        VALUES (SEQ_S_FORM.nextval, '".$dan['NAME']."', '".$dan['VERS']."', 
                        '".$dan['DATE_BEGIN']."', '".$dan['DATE_END']."', $active, '".$dan['DESCRIPT']."', 
                        ".$dan['TYP'].")";                    
            }else{
                $sql = "UPDATE S_FORM
                SET    NAME       = '".$dan['NAME']."',
                       VERS       = '".$dan['VERS']."',
                       DATE_BEGIN = '".$dan['DATE_BEGIN']."',
                       DATE_END   = '".$dan['DATE_END']."',
                       ACTIVE     = $active,
                       DESCRIPT   = '".$dan['DESCRIPT']."',
                       TYP        = ".$dan['TYP']."  
                WHERE  ID         = $id
                ";   
            }  
            
            //echo $sql;
            if(!$this->db->Execute($sql)){                
                global $msg;
                $msg = $this->db->message;
                echo $msg;
            }
            
        }
        
        private function form_dan($id)
        {
            $q = $this->db->Select("select * from s_form where id = $id");
            if(count($q) > 0){
                $a = $q[0];
            }else{
                $a = array(
                "ID" => "0", "NAME" => "", "VERS" => "", "DATE_BEGIN" => "", "DATE_END" => "", "ACTIVE" => "", "DESCRIPT" => "", "TYP"=>""
                );                
            }
            echo json_encode($a);            
            exit;
        }
        
        private function list_params_col_table($id)
        {
            $q = $this->db->Select("select id, col_meta, descript from s_meta_columns where id_table = $id order by col_meta");
            foreach($q as $k=>$v){
                echo '<option value="'.$v['ID'].'" data="'.$v['DESCRIPT'].'">'.$v['COL_META'].'</option>';
            }
            exit;
        }
        
        private function set_params($id)
        {            
            $PARAMS_TABLE = $this->array['PARAMS_TABLE'];
            $PARAMS_COLUMNS = $this->array['PARAMS_COLUMNS'];
            $PARAMS_CONDIT = $this->array['PARAMS_CONDIT'];
            $PARAMS_RES = $this->array['PARAMS_RES'];
            
            $sql = "INSERT INTO S_DATERMINANT (ID, ID_FORM, ID_TABLE, ID_COL, CONDIT, RES)
            VALUES (SEQ_S_DATERMINANT.nextval, $id, $PARAMS_TABLE, $PARAMS_COLUMNS, $PARAMS_CONDIT, '$PARAMS_RES')";
            if(!$this->db->Execute($sql)){
                global $msg;
                $msg = $this->db->message;
            }else{
                
            }
        }
        
        private function del_param($id)
        {
            $sql = "delete from S_DATERMINANT where id = $id";
            if(!$this->db->Execute($sql)){
                echo $this->db->message;
            }            
            exit;
        }
        
        //-------------------------------- Конец основной формы --------------------------------------------
        
        //-------------------------------- Начало основной формы --------------------------------------------
        
        private function id($id)
        {            
            $q = $this->db->Select("select id, table_meta, descript from s_meta_tables");
            foreach($q as $k=>$v){
                $q[$k]['columns'] = $this->db->Select("select id, col_meta, descript from s_meta_columns where id_table = ".$v['ID']." order by col_meta");
            }
            
            $this->dan['meta'] = $q;
            $this->dan['html'] = $this->list_form($id); 
            return $this->dan;
        }        
        
        private function new_id_block($id)
        {
            $id = str_replace('#', '', $id);
            $q = $this->db->Select("select nvl(max(num_pp), 0)+1 sp from S_BLOCKS where ID_FORM = $id");
            echo $q[0]['SP'];
            exit;
        }     
        
        private function set_bloc_report($id)
        {
            $id_block = $this->array['id'];
            $result = '';
            $title = $this->array['title'];
            $pos_num = $this->array['pos_num'];
            $position = $this->array['position'];
            $p['HTML'] = base64_encode($this->array['html']);
            
            if($p['HTML'] == ''){
                $result .= ALERTS::ErrorMin('Тело блока не может быть пустым');
            }
            
            if($id_block == 0){                         
                $sql = "INSERT INTO S_BLOCKS (ID, ID_FORM, NUM_PP, NAME, WIDTH_BLOCK, HTML_TEXT) 
                VALUES (SEQ_S_BLOCKS.nextval, $id, $pos_num, '$title', $position, EMPTY_CLOB()) RETURNING HTML_TEXT INTO :HTML";
            }else{
                $sql = "UPDATE S_BLOCKS set  
                NUM_PP = $pos_num,
                NAME = '$title',
                WIDTH_BLOCK = $position,
                HTML_TEXT = EMPTY_CLOB() where ID = $id_block
                RETURNING HTML_TEXT INTO :HTML";
            }            
            $this->db->AddClob($sql, $p);
            $result .= $this->list_form($id);
            
            
            if($id_block == 0){
                $l = $this->db->Select("select max(id) id from S_BLOCKS where id_form = $id");
                $id_block = $l[0]['ID'];
            }
            
            $this->db->Execute("delete from S_FORM_PARAMS where id_form = $id and id_block = $id_block");
            foreach($this->array['list_meta'] as $k=>$v){
                $this->set_form_toblock_meta($id, $v['id_table'], $v['id_col'], $id_block);
            }
                                    
            echo $result;            
            exit;
        }    
        
        private function list_form($id)
        {
            $i = 0;
            $html = '';
            $q = $this->db->Select("select * from S_BLOCKS where id_form = $id order by num_pp");
            foreach($q as $k=>$v){
                if($i >= 12){
                    $html .= '<div class="col-lg-12"></div>';
                    $i = 0;
                }
                $i += $v['WIDTH_BLOCK'];
                $html .= '<div class="col-lg-'.$v['WIDTH_BLOCK'].'" id="block'.$v['ID'].'" data="'.$v['ID'].'">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>№ п\п: '.$v['NUM_PP'].'. Название блока: '.$v['NAME'].'</h5>
                                <div class="ibox-tools">
                                    <a class="dropdown-toggle" data-toggle="modal" onclick="edit_block('.$v['ID'].');" data-target="#add_standart_contracts"><i class="fa fa-edit"></i></a>
                                    <a onclick="deleteBlock('.$v['ID'].');"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                            
                            <div class="ibox-content">
                                <div id="blockContent">'.base64_decode($v['HTML_TEXT']).'</div>
                            </div>
                        </div>
                    </div>';
            }
            return $html;
        }
        
        private function edit_block($id)
        {
            $q = $this->db->Select("select * from S_BLOCKS where id = $id");
            $dan = $q[0];
            $dan['HTML_TEXT'] = base64_decode($dan['HTML_TEXT']);
            echo json_encode($dan);
            exit;
        }
        
        private function del_block($id)
        {
            $res = '';
            $sql = "delete from S_BLOCKS where id = $id";            
            if(!$this->db->Execute($sql)){
                $res .= ALERTS::ErrorMin($this->db->message);    
            }
            
            $this->db->Execute("delete from S_FORM_PARAMS where id_block = $id");
                        
            $res .= $this->list_form($this->array['id_report']);
            echo $res;
            exit;       
        }
        
        private function set_form_toblock_meta($id_form, $id_table, $id_col, $id_block)
        {            
            $sql = "INSERT INTO S_FORM_PARAMS (ID_FORM, ID_TABLE, ID_COL, ID_BLOCK) VALUES ($id_form, $id_table, $id_col, $id_block)";
            if(!$this->db->Execute($sql)){
                return false;
            }
            return true;
            
        }
        
        private function SQLContracts($id_rep)
        {
            
        }
	}
    