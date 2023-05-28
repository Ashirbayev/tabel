<?php
	class MARKETING_EDIT_PLAN
    {
        private $db;
        private $array;
        public $html;
        public $dan;
        public $branch = '';
        private $view_agent = true;
        private $view_inspector = false;
        public $year;
        
        public function __construct()
        {
            global $active_user_dan;
            if(!isset($active_user_dan['brid'])){
                $this->branch = '0000';
            }else{
                $this->branch = $active_user_dan['brid'];   
            }            
            $this->year = date("Y");
            
            $this->db = new DB3();
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
                        $this->array = $_GET;
                        $this->$k($v);
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
                        $this->$k($v); 
                    }
                }
            }
        }
        
        private function index()
        {
            $d1 = '01.01.'.$this->year;
            $d2 = '31.12.'.$this->year;            
            
            $this->dan['list_year'] = $this->listYear();
            $this->dan['list_region'] = $this->list_branch();
            $this->dan['month_name'] = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
            $this->dan['month_int'] = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
            
            $plan = array();
            foreach($this->dan['list_region'] as $k=>$v){
                
                $pa = $this->db->Select("select 
                            extract(month from p.period) month_int,
                            p.sum_plan,
                            p.id
                        from 
                            plan_branch_new p
                        where 
                            p.period between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                            and p.rfpm_id = '01'
                            and p.rfbn_id = '".$v['ID']."'
                        order by p.rfbn_id, p.rfpm_id, p.period
                        ");
                
                $osor = $this->db->Select("select 
                            extract(month from p.period) month_int,
                            p.sum_plan,
                            p.id
                        from 
                            plan_branch_new p
                        where 
                            p.period between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                            and p.rfpm_id = '02'
                            and p.rfbn_id = '".$v['ID']."'
                        order by p.rfbn_id, p.rfpm_id, p.period
                        ");
                $osns = $this->db->Select("select 
                            extract(month from p.period) month_int,
                            p.sum_plan,
                            p.id
                        from 
                            plan_branch_new p
                        where 
                            p.period between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                            and p.rfpm_id = '07'
                            and p.rfbn_id = '".$v['ID']."'
                        order by p.rfbn_id, p.rfpm_id, p.period
                        ");
                $ds = $this->db->Select("select 
                            extract(month from p.period) month_int,
                            p.sum_plan,
                            p.id
                        from 
                            plan_branch_new p
                        where 
                            p.period between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                            and p.rfpm_id = '06'
                            and p.rfbn_id = '".$v['ID']."'
                        order by p.rfbn_id, p.rfpm_id, p.period
                        ");
                
                $dan = array(
                    "id" => $v['ID'],
                    "name" => $v['NAME'],
                    "product"=>array(
                        array(
                            "id"=>"01",
                            "name"=>"ПА",
                            "plan"=>$pa
                        ),                                            
                        array(
                            "id"=>"02",
                            "name"=>"ОСОР",
                            "plan"=>$osor
                        ),
                        array(
                            "id"=>"07",
                            "name"=>"ОСНС",
                            "plan"=>$osns
                        ),
                        array(
                            "id"=>"06",
                            "name"=>"Хранитель",
                            "plan"=>$ds
                        )
                    )
                );
                $plan[] = $dan;
                          
            }             
            $this->dan['plan'] = $plan;                  
        }
        
        private function view_year($year)
        {
            $this->year = $year;
            $this->index();
        }
        
        private function listYear()
        {
            $d = date("Y");
            $ds = array();
            for($i=10;$i>0;$i--){
                $ds[] = $d - $i;
            }
            $ds[] = $d;
            for($i=1;$i<10;$i++){
                $ds[] = $d + $i;
            }
            return $ds;
        }
        
        private function set_year($year)
        {            
            $id_plan = $this->array['id_plan'];
            $region = $this->array['region'];
            $product = $this->array['product'];
            $month = $this->array['month']+1;
            $sum_plan = $this->array['sum_plan'];
            
            if($id_plan > 0){
                $sql = "update PLAN_BRANCH_NEW set sum_plan = '$sum_plan' where id = $id_plan";
            }else{
                $sql = "INSERT INTO PLAN_BRANCH_NEW (ID, PERIOD, RFBN_ID, RFPM_ID, SUM_PLAN) 
                VALUES (SEQ_PLAN_BRANCH_NEW.nextval, to_date('01.$month.$year', 'dd.mm.yyyy'), '$region', '$product', '$sum_plan')";
            }
            
                       
            if(!$this->db->Execute($sql)){
                echo $this->db->message;
            }
            
            $url =  substr($_SERVER['REQUEST_URI'], 1);
            header("Location: $url");
        }
        
        private function list_branch()
        {            
            global $active_user_dan;
            if(!isset($active_user_dan['brid'])){
                $branch = '0000';
            }else{
                $branch = $active_user_dan['brid'];   
            }                           
            
            if($branch == '0000'){
                $q = $this->db->Select("select rfrg_id id, name3 name from RFRG_REGION");    
            }else{
                $br = substr($branch, 0, 2);
                $q = $this->db->Select("select rfrg_id id, name3 name from RFRG_REGION where rfrg_id = '$br'");
            }            
            return $q;            
        }
        
        private function plan_sum($id)
        {        
            $ft = '';
            if($this->branch !== '0000'){                
                $ps = substr($this->branch, 0, 2);
                $ft = " and rfbn_id = '$ps'";
            }
                        
            $d1 = '01.01.'.$this->year;
            $d2 = '31.12.'.$this->year;
            
            $q = $this->db->Select("select sum(sum_plan) sp from plan_branch_new where period between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy') $ft and rfpm_id = '$id'");
            if(count($q) <= 0){
                return '0';
            }
            return $q[0]['SP'];
        }
    }
?>