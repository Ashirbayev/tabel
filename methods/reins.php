<?php
	class REINSURANCE
    {
        private $method;
        private $db;        
        public $dan = array();
        private $array;
        
        public function __construct()
        {
            $this->db = new DB3();
            $method = $_SERVER['REQUEST_METHOD'];                           
            $this->$method();                     
        }
        
        public function list_contacts($id)
        {
            $q = $this->db->Select("select * from DIC_REINSURANCE_CONTACTS where id_reins  = $id");
            return $q;
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
        
        private function set_reins_contact($id)
        {                        
            $dan = $this->array;            
            unset($dan['set_reins_contact']);
            $sql = "insert into DIC_REINSURANCE_CONTACTS (id, id_reins";
            $sql2 = '';
            foreach($dan as $k=>$v){
                $sql .= ','.$k;
                $sql2 .= ",'$v'";
            }
            $sql .= ") values(SEQ_DIC_REINSURANCE_CONTACTS.nextval, $id $sql2)";
            global $msg;
            $b = $this->db->Execute($sql);            
            if($b !== true){
                $msg .= ALERTS::ErrorMin($sql."<br>".$b);
            }
        }
        
        private function del_contact($dan)
        {
            $sql = "delete from DIC_REINSURANCE_CONTACTS where id = $dan";
            $b = $this->db->Execute($sql);
            if($b !== true){
                echo ALERTS::ErrorMin($sql."<br />".$b);                
            }            
            exit;
        }
        
        private function reins_block($id)
        {            
            $sql = "update DIC_REINSURANCE set ACTUAL = 2 where id = $id";
            $msg = $this->db->Execute($sql);
            
            if($msg == true){
                echo "window.location.href = 'reins';";
            }else{
                echo "alert('$msg');";
            }
            exit;
        }
        
        private function set_banks($dan)
        {       
            $ds = $this->array;
            unset($ds['set_banks']);
                        
            $sql = 'INSERT INTO DIC_REINSURANCE_BANKS (ID, id_reins';
            $sql2 = '';
            foreach($ds as $k=>$v){
                $sql .= ','.$k;
                $sql2 .= ",'$v'";
            }
            $sql .= ") values(SEQ_DIC_REINSURANCE_BANKS.nextval, $dan $sql2)";
            
            global $msg;
            $b = $this->db->Execute($sql);            
            if($b !== true){
                $msg .= ALERTS::ErrorMin($sql."<br>".$b);
            }   
        }
        
        private function del_bank($dan)
        {            
            $sql = "delete from DIC_REINSURANCE_BANKS where id = $dan";
            $b = $this->db->Execute($sql);
            if($b !== true){
                echo ALERTS::ErrorMin($b);
                exit;
            }
            echo '';
            exit;
        }
        
        private function id_reins($id)
        {
            $dan = $this->array;                    
            unset($dan['id_reins']);
            if($id == ''){
                return 'Неизвестный перестраховщик Создание или редактирование невозможно!';
            }
            $sql1 = "";        
            $i = 0;
            if($id == 0){
                $sql2 = "";
                $sql1 .= 'insert into DIC_REINSURANCE(ID';            
                foreach($dan as $k=>$v){                                          
                    $sql1 .= ','.$k;
                    $sql2 .= ",'$v'";
                    $i++;
                }
                $sql1 .= ") values(SEQ_DIC_REINSURANCE.nextval $sql2)";
            }else{
                $this->db->Execute("insert into DIC_REINSURANCE_ARC select * from DIC_REINSURANCE where id = $id");
                $sql1 .= "update DIC_REINSURANCE set ";
                foreach($dan as $k=>$v){
                    if($i > 0){$sql1 .= ",";}
                    $sql1 .= "$k = '$v'";
                    $i++;
                }
                $sql1 .= " where id = $id";
            }
            
            $message = $this->db->Execute($sql1);
            if($message == true){
                if($id == 0){
                    header("Location: reins");
                }else{
                    header("Location: reins?id=$id");
                }
            }else{
                global $msg;
                $msg = ALERTS::ErrorMin($message);
            }
        }
        
        
        
        private function reiting($id_agenstv)
        {
            $sql = "select * from REITING_ESTIMATION";
            if($id_agenstv !== 0){
                $sql .=" where id_ag = $id_agenstv";
            }
            $q = $this->db->Select($sql);
            echo json_encode($q);
            exit;
        }
        
        private function lists()
        {            
            $this->dan = $this->db->Select("select * from dic_reinsurance order by id");
        }
        
        private function id($id)
        {
            global $js_loader,$css_loader, $othersJs;  
            array_push($js_loader,  
                'styles/js/plugins/datapicker/bootstrap-datepicker.js', 
                'styles/js/plugins/fullcalendar/moment.min.js', 
                'styles/js/plugins/daterangepicker/daterangepicker.js', 
                'styles/js/others/datepicker.js', 
                'styles/js/plugins/iCheck/icheck.min.js'
            ); 
            
             
            array_push($css_loader,  
                'styles/css/plugins/datapicker/datepicker3.css', 
                'styles/css/plugins/daterangepicker/daterangepicker-bs3.css',
                'styles/css/plugins/dataTables/dataTables.bootstrap.css',
                'styles/css/plugins/dataTables/dataTables.responsive.css',
                'styles/css/plugins/dataTables/dataTables.tableTools.min.css'                         
            ); 
            
            $othersJs .= " 
            <script> 
                $(document).ready(function () { 
                    $('.input-group.date').datepicker({
                        todayBtn: 'linked',
                        keyboardNavigation: false,
                        forceParse: false,
                        calendarWeeks: true,
                        autoclose: true
                    }); 
                });
            </script>
            ";
            
            if($id == 0)$this->dan = array();
            
            $q = $this->db->Select("select * from dic_reinsurance where id = $id");
            $this->dan = $q[0];
        }
    }