<?php
	class SET_ROLES
    {
        private $db;
        public $array = array(); 
        
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
            unset($_POST);            
            $this->GET();
        }
        
        private function index()
        {
            $dan = array();
            $q = $this->db->Select("select rfbn_id id, name from dic_branch where asko is null");
            $dan = $q;
            
            foreach($dan as $k=>$v){                
                $qs = $this->db->Select("select id, name from DIC_DEPARTMENT where branch_id = '".trim($v['ID'])."'");
                if(count($qs) > 0){
                    $dan[$k]['departments'] = $qs;
                    foreach($qs as $a=>$d){
                        $qd = $this->db->Select("select id, d_name from DIC_DOLZH where id_department = ".trim($d['ID']));
                        $dan[$k]['departments'][$a]['dolzh'] = $qd;
                    }
                }else{
                    $dan[$k]['dolzh']['sql'] = "select id, d_name from DIC_DOLZH where branch_id = '".trim($v['ID'])."'";
                    $qd = $this->db->Select("select id, d_name from DIC_DOLZH where branch_id = '".trim($v['ID'])."'");
                    $dan[$k]['dolzh'] = $qd;
                }
            }
            $this->array = $dan;
        }
        
        private function provcheck($dolzh, $form, $method)
        {
            $view = $this->db->Select("select count(*) c from DIR_FORM_DOLZH 
                where ID_DOLZH = $dolzh and ID_FORM = $form and ID_METHOD = $method");
            if($view[0]['C'] == 0){
                return false;
            }else{
                return true;
            }
        }
        
        private function forms_dolzh($id)
        {
            $html = '';
            $q = $this->db->Select("select * from dir_forms order by id");
            foreach($q as $k=>$v){
                
                $ch = '';
                if($this->provcheck($id, $v['ID'], 0)){
                    $ch = 'checked';
                }
                $html .= '<ol class="breadcrumb">                    
                    <li><strong>'.$v['NAME_FORM'].'</strong></li>
                    <li><strong>'.$v['NAME_URL'].'</strong></li>                    
                </ol>
                
                    <p><label>
                        <input type="checkbox" class="id_method" value="'.$id.';'.$v['ID'].';0" '.$ch.'> Просмотр
                    </label></p>
                ';
                
                $w = $this->db->Select("select * from dir_method where state is null and id_form = ".$v['ID']);
                foreach($w as $i=>$d)
                {
                    $ch = '';
                    if($this->provcheck($id, $v['ID'], $d['ID'])){
                        $ch = 'checked';
                    }
                    $dest = $id.';'.$v['ID'].';'.$d['ID'];
                    $html .= '<p><label>
                        <input type="checkbox" class="id_method" value="'.$dest.'" '.$ch.'> '.$d['METHOD_NAME'].'
                    </label></p>';
                }
                $html .= '<hr />';
            }            
            echo $html;
            exit;
        }
        
        private function set_form_user()
        {
            $dan = $this->array;
            $t = explode(";",$dan['set_form_user']);
            $dolzh = $t[0];
            $form = $t[1];
            $method = $t[2];
            
            if($dan['emp'] == 'true'){
                $sql = "INSERT INTO DIR_FORM_DOLZH (ID_DOLZH, ID_FORM, ID_METHOD)
                VALUES ($dolzh, $form, $method)";   
            }else{
                $sql = "delete from DIR_FORM_DOLZH where ID_DOLZH = $dolzh and ID_FORM = $form and ID_METHOD = $method";
            }
            $this->db->Execute($sql);
            $this->forms_dolzh($dolzh);        
            exit;
        }
	}
/*
begin
for i in(
    select S.JOB_POSITION from sup_person s where state = 2
    and S.JOB_POSITION not in(select id_dolzh from DIR_FORM_DOLZH where ID_FORM in(101, 102))
)loop
    INSERT INTO INSURANCE2.DIR_FORM_DOLZH (ID_DOLZH, ID_FORM, ID_METHOD)  VALUES ( i.JOB_POSITION, 101, 0); 
    INSERT INTO INSURANCE2.DIR_FORM_DOLZH (ID_DOLZH, ID_FORM, ID_METHOD)  VALUES ( i.JOB_POSITION, 102, 0);    
end loop;
commit;
end;
*/
?>
