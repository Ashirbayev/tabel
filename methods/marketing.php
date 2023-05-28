<?php
	class MARKETING
    {
        private $db;
        private $array;
        public $html;
        public $dan;
        public $branch = '';
        private $view_agent = true;
        private $view_inspector = false;
        
        public function __construct()
        {
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
        
        public function init()
        {
            $this->html = '';
        }
        
        public function index()
        {
            global $active_user_dan;
            $branch = $active_user_dan['brid'];
                        
            $filter = '';            
            if($this->branch !== ''){                
                if($branch !== '0000'){
                    $filter = "and BRANCH_ID = '$branch'";                
                }else{
                    $filter = "and BRANCH_ID = '$this->branch'";
                }
            }
            
            $result = array();
            $agents = array();
            $month_name = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
            $month_int  = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
            
            for($i = 0;$i < count($month_name);$i++){
                $d = "01.".$month_int[$i].".".date("Y");
                $mn = $month_name[$i];
                     
                $q = $this->sql1($mn, $d, $filter);
                $result[$i] = array($q);
                                       
                //Предоставление данные по агентам
                $ag = $this->agent_sql($d, $filter);
                foreach($ag as $k=>$v){
                    if($this->view_inspector){
                        $ag[$k]['list_products'] = $this->paym_insp($d, $filter, $v['ID_AGENT']);
                    }else{
                        $ag[$k]['list_products'] = $this->paym_agent($d, $filter, $v['ID_AGENT']);    
                    }
                }                
                $agents[$i] = $ag;                
            }
            
            $this->dan['kvartal'] = $result;
            $this->dan['agents'] = $agents;                        
            if($branch == '0000'){
                $this->dan['list_region'] = $this->db->Select("select d.rfbn_id id, d.name, t.name type_name  
                from dic_branch d, DIR_TYPE_PROC t where T.ID = nvl(d.asko, 0) and d.rfbn_id <> '0000'  order by nvl(d.asko, 0), d.name");    
            }else{
                $this->dan['list_region'] = $this->db->Select("select d.rfbn_id id, d.name, t.name type_name  
                from dic_branch d, DIR_TYPE_PROC t where d.rfbn_id = '$branch' and T.ID = nvl(d.asko, 0) order by nvl(d.asko, 0), d.name");
            }
            $this->dan['active_btn'] = array(
                "agent"=>true,
                "insp"=>false
            );
            
            if(isset($_GET['user_view'])){
                if($_GET['user_view'] == 'insp'){
                    $this->dan['active_btn'] = array(
                        "agent"=>false,
                        "insp"=>true
                    );
                }
            }
            
            return '';            
        }
        
        private function filter_branch($id)
        {
            if(isset($this->array['user_view'])){
                $this->view_inspector = false;
                $this->view_agent = true;
                if($this->array['user_view'] == 'insp'){
                    $this->view_inspector = true;
                    $this->view_agent = false;
                }
            }
            $this->branch = $id;
            $this->index();
        }
        
        private function user_view($id)
        {
            if($id == 'insp'){
                $this->view_inspector = true;
                $this->view_agent = false;
            }else{
                $this->view_inspector = false;
                $this->view_agent = true;
            }
            $this->index();
        }
        
        private function sql1($mn, $d, $filter)
        {
            $sql = "
                select 
                  '$mn' month_name,
                  nvl(to_char(round(sum(pay_sum_p)), '999G999G999G999G999G999'), 0) all_sum, 
                  nvl(to_char(round(sum(SUM_OPL_PREM)), '999G999G999G999G999G999'), 0) result,
                  nvl(round(round(sum(SUM_OPL_PREM)) / round(sum(pay_sum_p)) * 100, 2), 0) proc
                from(  
                select * from market_02
                where date_dohod between to_date('$d', 'dd.mm.yyyy') and last_day(to_date('$d', 'dd.mm.yyyy'))
                $filter
                )";                 
            $this->html = $sql;
            $q = $this->db->Select($sql);
            return $q[0];   
        }
        
        private function agent_sql($d, $filter)
        {
            $ss1 = "sicid_agent id_agent,                  
                  agent_name(sicid_agent) agent,";
            $ss2 = "group by sicid_agent";
            $sp = "'agent' view_user";
            
            if(!$this->view_agent){
                $ss1 = "emp_id id_agent,                  
                        emp_name(emp_id) agent,";
                $ss2 = "group by emp_id";
                $sp = "'insp' view_user";
            }
            
            $ag_sql = "select
                  '$d' date_view, 
                  $sp, 
                  $ss1
                  nvl(to_char(round(sum(pay_sum_p)), '999G999G999G999G999G999'), 0) all_sum, 
                  nvl(to_char(round(sum(SUM_OPL_PREM)), '999G999G999G999G999G999'), 0) result,
                  nvl(round(round(sum(SUM_OPL_PREM)) / round(sum(pay_sum_p)) * 100, 2), 0) proc
                from(  
                select * from market_02
                where date_dohod between to_date('$d', 'dd.mm.yyyy') and last_day(to_date('$d', 'dd.mm.yyyy'))
                $filter
                )
                $ss2
                order by 2
                ";
                                            
            return $this->db->Select($ag_sql); 
        }
        
        private function paym_agent($d, $filter, $id_agent)
        {
            $sql2 = "select 
                      paym_name2(PAYM_CODE) product,                  
                      nvl(to_char(round(sum(pay_sum_p)), '999G999G999G999G999G999'), 0) all_sum, 
                      nvl(to_char(round(sum(SUM_OPL_PREM)), '999G999G999G999G999G999'), 0) result,
                      nvl(round(round(sum(SUM_OPL_PREM)) / round(sum(pay_sum_p)) * 100, 2), 0) proc
                    from(  
                    select * from market_02
                    where date_dohod between to_date('$d', 'dd.mm.yyyy') and last_day(to_date('$d', 'dd.mm.yyyy'))
                    and sicid_agent = $id_agent
                    $filter
                    )
                    group by PAYM_CODE";
                    
            return $this->db->Select($sql2);
        }
        
        private function paym_insp($d, $filter, $id_insp)
        {
            $sql2 = "select 
                      paym_name2(PAYM_CODE) product,                  
                      nvl(to_char(round(sum(pay_sum_p)), '999G999G999G999G999G999'), 0) all_sum, 
                      nvl(to_char(round(sum(SUM_OPL_PREM)), '999G999G999G999G999G999'), 0) result,
                      nvl(round(round(sum(SUM_OPL_PREM)) / round(sum(pay_sum_p)) * 100, 2), 0) proc
                    from(  
                    select * from market_02
                    where date_dohod between to_date('$d', 'dd.mm.yyyy') and last_day(to_date('$d', 'dd.mm.yyyy'))
                    and emp_id = $id_insp
                    $filter
                    )
                    group by PAYM_CODE";            
            return $this->db->Select($sql2);
        }
        
        private function view_contracts($id)
        {
            $html = '';            
            if($this->array['user'] == 'insp'){
                $q = $this->view_contracts_insp($id, $this->array['data']);
            }else{
                $q = $this->view_contracts_agent($id, $this->array['data']);
            }
            
            $html .= '<table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>№ договора</th>
                    <th>Дата договора</th>            
                    <th>Инспектор</th>
                    <th>Агент</th>                        
                    <th>Сумма</th>
                    <th>% агента</th>
                    <th>Дата дохода</th>
                    <th>Регион</th>
                    <th>Программа</th>
                </tr> 
            </thead>
            <tbody>';
            
            foreach($q as $k=>$v){
                $html .= '<tr>
                    <td><a href="contracts?CNCT_ID='.$v['CNCT_ID'].'" target="_blank">'.$v['CONTRACT_NUM'].'</a></td>
                    <td>'.$v['CONTRACT_DATE'].'</td>
                    <td>'.$v['INSP'].'</td>
                    <td>'.$v['AGENT'].'</td>            
                    <td>'.$v['PAY_SUM_P'].'</td>
                    <td>'.$v['SUM_OPL_PREM'].'</td>            
                    <td>'.$v['DATE_DOHOD'].'</td>
                    <td>'.$v['REGION'].'</td>
                    <td>'.$v['PAYMNAME'].'</td>
                </tr>';
            }
            $html .= '</tbody></table>';
            echo $html;
            exit;
        }
        
        private function view_contracts_insp($id, $date)
        {
            $sqls = '';
            if(isset($_GET['filter_branch'])){
                $sqls = " and d.branch_id = '".$_GET['filter_branch']."'"; 
            }
            $sql = "select
              d.contract_num,
              d.contract_date,
              emp_name(m.emp_id) insp,
              agent_name(m.sicid_agent) agent,
              paym_name2(m.paym_code) paymname,
              branch_name(m.branch_id) region,   
              m.* 
            from 
              market_02 m, 
              contracts d
            where 
              d.cnct_id = m.CNCT_ID     
              and m.date_dohod between to_date('$date', 'dd.mm.yyyy') and last_day(to_date('$date', 'dd.mm.yyyy'))
              and m.emp_id = $id
              $sqls
            order by m.PAYM_CODE";            
            return $this->db->Select($sql);
        }
        
        private function view_contracts_agent($id, $date)
        {
            $sqls = '';
            if(isset($_GET['filter_branch'])){
                $sqls = " and d.branch_id = '".$_GET['filter_branch']."'"; 
            }
            $sql = "select
              d.contract_num,
              d.contract_date,
              emp_name(m.emp_id) insp,
              agent_name(m.sicid_agent) agent,
              paym_name2(m.paym_code) paymname,
              branch_name(m.branch_id) region,   
              m.* 
            from 
              market_02 m, 
              contracts d
            where 
              d.cnct_id = m.CNCT_ID     
              and m.date_dohod between to_date('$date', 'dd.mm.yyyy') and last_day(to_date('$date', 'dd.mm.yyyy'))
              and m.sicid_agent = $id
              $sqls
            order by m.PAYM_CODE";            
            return $this->db->Select($sql);
        }
    }