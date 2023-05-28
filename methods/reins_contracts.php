<?php
	class REINS_CONTRACTS
    {
        private $db;
        private $array; 
        public $html;
        public $dan;
        public $type = array("checked", "", "");
        
        private $sql_contracts = "select 
            b.id, 
            b.contract_num, 
            b.contract_date, 
            b.pay_sum, 
            b.pay_sum_opl, 
            nvl(b.komis_reins, 0) komis_reins, 
            d.r_name, 
            b.sum_s_strah, 
            b.typ,
            case 
                when b.typ = 1 then 'Облигатор' 
                else 'Факультатив' 
            end type_dog,
            state_name_bordero(b.state) state_name,
            (select count(*) from bordero_contracts_list where id_contracts = b.id) count_contracts      
        from 
            bordero_contracts b, 
            dic_reinsurance d
        where 
            b.id_reins = d.id";
        
        
        public function __construct()
        {
            $this->db = new DB3();            
            $method = $_SERVER['REQUEST_METHOD'];
            $this->$method();            
        }
        
        public function reins_list()
        {            
            return $this->db->Select("select r.id, r.r_name from bordero_contracts b, dic_reinsurance r
            where r.id = B.ID_REINS group by r.id, r.r_name order by 1");
        }
        
        private function contracts_list($id_contracts)
        {
            $sql = "select
                d.cnct_id, 
                d.contract_num,
                d.contract_date,
                fond_name(d.id_insur) strah,
                bl.pay_sum,
                bl.pay_sum_opl,
                bl.komis_reins,
                BL.SUM_S_STRAH
            from 
                bordero_contracts_list bl, 
                contracts d 
            where 
                d.cnct_id = bl.cnct_id
                and id_contracts = $id_contracts";
            $q = $this->db->Select($sql);
            return $q;              
        }
        
        /*=======================================*/
        private function GET()
        {
            $this->array = $_GET;
            if(count($_GET) <= 0){
                $this->html = '';                
            }else{            
                foreach($_GET as $k=>$v){
                    if(method_exists($this, $k)){
                        $this->$k($v);
                    }                                        
                }
            }                        
        }
        
        private function search_contragents($d)
        {
            if(trim($d) !== '')
            {
                $this->sql_contracts .= " and b.id in(
                    select id_contracts from bordero_contracts_list bl, contracts d, contr_agents c
                    where bl.cnct_id = d.cnct_id
                    and d.id_insur = c.id
                    and upper(c.name) like upper('%$d%')
                )";
            }
        }
        
        private function date_begin($d)
        {
            if(trim($d) !== ''){
                if(trim($this->array['date_end']) !== ''){                
                    $this->sql_contracts .= " and b.contract_date between to_date('$d', 'dd.mm.yyyy') ";
                }else{
                    $this->sql_contracts .= " and b.contract_date >= to_date('$d', 'dd.mm.yyyy')";
                }
            }
        }                
        
        private function date_end($d)
        {
            if(trim($d) !== ''){
                if(trim($this->array['date_begin']) !== ''){                
                    $this->sql_contracts .= " and to_date('$d', 'dd.mm.yyyy') ";
                }else{
                    $this->sql_contracts .= " and b.contract_date <= to_date('$d', 'dd.mm.yyyy')";
                }
            }
        }
        
        private function contract_num($d)
        {
            if(trim($d) !== ''){
                $this->sql_contracts .= " and upper(b.contract_num) like upper('%$d%')";
            }
        }
        
        private function search_reins($d)
        {
            if($d !== '0'){
                $this->sql_contracts .= " and b.id_reins = $d";
            }                        
        }
        
        private function typ($d)
        {
            if($d !== '0'){
                $this->sql_contracts .= " and b.typ in($d)";
            }
                        
            $s = substr($d, 0, 1);
            for($i = 0; $i<3; $i++){
                $t = '';
                if($i == $s){$t = 'checked';}
                $this->type[$i] = $t;
            }            
            
        }
        
        private function search($d)
        {
            $dan = $this->db->Select($this->sql_contracts." order by b.contract_date");
            foreach($dan as $k=>$v){
                $ds = $this->contracts_list($v['ID']);
                $dan[$k]['list_contracts'] = $ds;            
            }            
            $this->dan = $dan;
            return;            
        }
                        
        /*=======================================*/
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
        
        private function search_contragent($dan)
        {
            $q = $this->db->Select("select id, name from CONTR_AGENTS where upper(name) like upper('%$dan%') and rownum <= 10");
            echo json_encode($q);
            exit;
        }
        
        /*=======================================*/
        
    }