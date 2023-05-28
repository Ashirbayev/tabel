<?php
	class NEW_CONTRACT
    {
        private $db;
        private $array;
        private $user_dan;
        public $dan = array();
        
        
        public function __construct()
        { 
            $this->db = new DB3();
            $method = $_SERVER['REQUEST_METHOD'];
            $this->$method();
            global $js_loader;
            global $active_user_dan;            
            $this->user_dan = $active_user_dan;
            array_push($js_loader, 'styles/js/demo/contracts_pa.js');
        }
        
        private function POST()
        {
            if(count($_POST) > 0){                
                $this->array = $_POST;
                foreach($_POST as $k=>$v){                                
                    if(method_exists($this, $k)){                                                                
                        $this->$k($v); 
                    }
                }
            }
        }
        
        private function GET()
        {            
            $this->array = $_GET;
            unset($this->array['paym_code']);
            if(count($this->array) <= 0){
                $this->index();                
            }else{                           
                foreach($this->array as $k=>$v){
                    if(method_exists($this, $k)){
                        $this->$k($v);
                    }
                }
            }
        }
        
        private function index()
        {                        
            $this->dan['branch'] = $this->db->Select("SELECT rfbn_id kod, rfbn_id||' - '|| NAME NAME FROM dic_branch WHERE asko is null ORDER  BY NAME");
            $this->dan['branch']['selected'] = $this->user_dan['brid'];
            $this->dan['clients'] = $this->db->Select("select SICID ID, lastname||' '||firstname||' '||middlename||' '||birthdate||' г.р' name from clients order by lastname, firstname");
            
            $br = $this->user_dan['brid'];
            $sqlAgent = "
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS 
                from agents a where a.state = 7 and a.date_close is null and a.vid not in (4, 5) 
                and A.BRANCHID = '$br'
                union all 
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS 
                from agents_branch_other b, agents a where a.id = b.id and a.state = 7 and a.vid not in (4, 5) and a.date_close is null and b.branchid = '$br'
                union all
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS
                from agents a where a.state = 7 and a.date_close is null and a.vid not in (4, 5) 
                and a.id = 1620
            ";    
            $this->dan['agents'] = $this->db->Select($sqlAgent);                        
            $this->dan['fond'] = $this->db->Select("SELECT id kod, NAME, ved_id, group_id FROM contr_agents WHERE  type = 2 AND actual = 1");                
            $this->dan['pred_kszh'] = $this->db->Select("SELECT id kod, NAME FROM contr_agents WHERE type = 5 AND actual = 1");
            $this->dan['banks'] = $this->db->Select("select bank_id kod, name from DIC_BANKS WHERE status = 0");
            $this->dan['periodich_list'] = $this->db->Select("SELECT ID, NAME FROM DIC_PERIODICH WHERE  TYPE = 1 and id between 1 and 4 ORDER BY ID");
            
        }
        
        private function calculator()
        {
            $pay_sum_gfss = $this->array['pay_sum_gfss']; 
            $birthday = $this->array['birthday'];
            $periodich = $this->array['periodich'];
            $sex = $this->array['sex'];
            $gp_year = $this->array['gp_year'];
            if(empty($this->array['gp_date'])){
                $gp_date = date("d.m.Y");
            }else{
                $gp_date = $this->array['gp_date'];    
            }
            
            
            $v = $this->db->Select("select get_age(sysdate, to_date('$birthday', 'dd.mm.yyyy')) cn from dual");
            $vozrast = $v[0]['CN'];
            
            $sql = "
                begin
                  sum_calc.calc_af_pens_2017_07(
                    4,
                    NULL,
                    '$pay_sum_gfss',
                    6,
                    $vozrast,
                    '$periodich',
                    0,
                    0,
                    100,                    
                    $sex,
                    '$gp_year',
                    3,
                    3,
                    :OUTAF, 
                    :OUTAF2,
                    :OUTSUM,
                    :CNTMES,
                    :CNT_GAR_VIPL,
                    :OUTFIRSTVIPL,
                    :OUT_PAYSUM_P_OST,
                    :OUT_SUM_DOST
                  );
                end;
            ";                      
            
            $array = array("OUTAF", "OUTAF2", "OUTSUM", "CNTMES", "CNT_GAR_VIPL", "OUTFIRSTVIPL", "OUT_PAYSUM_P_OST", "OUT_SUM_DOST");            
                             
            $ar = $this->db->ExecuteReturn($sql, $array);   
            //$ar['sql'] = $sql;
            echo json_encode($ar);
            exit;
        }
        
        private function calcUser($id_user)
        {
            $cl = $this->db->Select("select * from clients where sicid = $id_user");
            $this->array['birthday'] = $cl[0]['BIRTHDATE'];                                              
            $this->array['gp_date'] = date('d.m.Y');
            $this->array['sex'] = $cl[0]['SEX'];                                      
            $this->calculator();
        }
        
        private function search_user($text)
        {
            $q = $this->db->Select("
            select 
                SICID ID, 
                lastname||' '||firstname||' '||middlename||' '||birthdate||' г.р' name,
                birthdate 
            from 
                clients 
            where 
                upper(lastname||' '||firstname||' '||middlename||' '||birthdate||' г.р') like upper('%$text%') 
                and rownum <= 30 
            order by lastname, firstname
            ");
            echo json_encode($q);
            exit;
        }
        
        private function calc_saits()
        {
            $this->calculator();
            exit;
        }
    }