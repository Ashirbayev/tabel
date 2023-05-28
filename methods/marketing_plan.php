<?php
	class MARKET_PLAN
    {
        private $db;
        private $array;
        public $html;
        public $js;
        public $dan;
        public $branch = '';
        private $view_agent = true;
        private $view_inspector = false;
        
        public function __construct()
        {
            global $active_user_dan;
            if(!isset($active_user_dan['brid'])){
                $this->branch = '0000';
            }else{
                $this->branch = $active_user_dan['brid'];    
            }
            
            
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
            $q = $this->static_all();
            foreach($q as $k=>$v){
                $q[$k]['list_max'] = $this->max_paysum_contract($v['PAYM_CODE']);
                $q[$k]['SUM_PLAN'] = $this->plan_sum($v['PAYM_CODE']);
            }
            $this->dan['static'] = $q;
            
            $this->js = $this->graphik_contracts();
                        
            $this->dan['list_region'] = $this->list_branch();
            $this->dan['active_region'] = $this->active_region();
            $this->dan['active_region_id'] = $this->branch;            
        }
                
        private function list_branch()
        {            
            global $active_user_dan;
            if(!isset($active_user_dan['brid'])){
                $branch = '0000';
            }else{
                $branch = $active_user_dan['brid'];    
            }
            
            if(trim($branch) == ''){
                $branch = '0000';
            }
            
            if($branch == '0000'){
                $q = $this->db->Select("select d.rfbn_id id, d.name||' ('||d.short_name||')' name, t.name type_name  
                from dic_branch d, DIR_TYPE_PROC t where T.ID = nvl(d.asko, 0) and d.rfbn_id <> '0000'  order by nvl(d.asko, 0), d.name");    
            }else{
                $q = $this->db->Select("select d.rfbn_id id, d.name, t.name type_name  
                from dic_branch d, DIR_TYPE_PROC t where d.rfbn_id = '$branch' and T.ID = nvl(d.asko, 0) order by nvl(d.asko, 0), d.name");
            }            
            return $q;            
        }
        
        private function view_branch($id)
        {
            $this->branch = $id;
            $this->index();
        }
        
        private function active_region()
        {
            if($this->branch == '0000'){
                return 'Все филиалы';
            }else{
                $q = $this->db->Select("select name, short_name from dic_branch where rfbn_id = '$this->branch'");
                return $q[0]['NAME']." (".$q[0]['SHORT_NAME'].")";
            }
        }
                
        private function plan_sum($id)
        {        
            $ft = '';
            if($this->branch !== '0000'){                
                $ps = substr($this->branch, 0, 2);
                $ft = " and rfbn_id = '$ps'";
            }
                        
            $d1 = '01.01.'.date("Y");
            $d2 = '31.12.'.date("Y");
            
            $q = $this->db->Select("select sum(sum_plan) sp from plan_branch_new where period between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy') $ft and rfpm_id = '$id'");
            if(count($q) <= 0){
                return '1';
            }
            return $q[0]['SP'];
        }
        
        private function static_all()
        {
            $filter = '';          
            if($this->branch !== ''){
                if($this->branch !== '0000'){
                    $filter = " and branch_id = '$this->branch'";                
                }
            }
                        
            $d1 = '01.01.'.date("Y");
            $d2 = '31.12.'.date("Y");
            
            $q = $this->db->Select("
            select 
                count(*) cnt, 
                sum(pay_sum_p) pay_sum,    
                '01' PAYM_CODE,
                'Пенсионный аннуитет' product_name     
            from 
                contracts 
            where 
                state = 12
                and paym_code like '01%'
                and date_begin between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                $filter
            union all
            select 
                count(*) cnt, 
                sum(pay_sum_p) pay_sum,  
                '02' PAYM_CODE,  
                'ОСОР' product_name     
            from 
                contracts 
            where 
                state = 12
                and paym_code like '02%'
                and date_begin between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                $filter
            union all
            select 
                count(*) cnt, 
                sum(pay_sum_p) pay_sum, 
                '07' PAYM_CODE,   
                'ОСНС' product_name     
            from 
                contracts 
            where 
                state = 12
                and paym_code like '07%'
                and date_begin between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                $filter
            union all
            select 
                count(*) cnt, 
                sum(INS_PREMIYA) pay_sum, 
                '06' PAYM_CODE,  
                'Хранитель' product_name
            from 
                dobr_dogovors 
            where    
                state = 11
                and PAYM_CODE like '06%'
                and viplat_begin between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                $filter
            ");
            //echo $this->db->sql;
            return $q;
        }   
        
        private function max_paysum_contract($paymcode)
        {
            $filter = '';
            if($this->branch !== ''){
                if($this->branch !== '0000'){
                    $filter = " and d.branch_id = '$this->branch'";                
                }
            }
            
            $d1 = '01.01.'.date("Y");
            $d2 = '31.12.'.date("Y");
            
            return $this->db->Select("select rownum, d.* from(
                select      
                    max(round(d.pay_sum_p)) pay_sum,
                    fond_name(d.id_insur) name
                from 
                    contracts d
                where 
                    d.state = 12   
                    and D.PAYM_CODE like '$paymcode%' 
                    and date_begin between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                    $filter
                group by d.id_insur
                union all
                select      
                    max(round(D.INS_PREMIYA)) pay_sum,
                    case 
                        when D.TYPE_STRAHOVATEL = 0 then client_name(D.ID_STRAHOVATEL) 
                        else fond_name(D.ID_STRAHOVATEL)
                    end name
                from 
                    dobr_dogovors d 
                where    
                    state = 11
                    and D.PAYM_CODE like '$paymcode%'
                    and viplat_begin between to_date('$d1', 'dd.mm.yyyy') and to_date('$d2', 'dd.mm.yyyy')
                    $filter
                group by d.ID_STRAHOVATEL, D.TYPE_STRAHOVATEL    
                order by 1 desc    
                ) d where rownum <= 3"
            );
        }
        
        private function graphik_contracts()
        {
            $filter = '';
            if($this->branch !== ''){
                if($this->branch !== '0000'){
                    $filter = " and branch_id = '$this->branch'";
                }
            }
            $color = array(
                "01" => "#6495D9", //ПА
                "02" => "#008000",   //ОСОР
                "07" => "#FF6600",   //ОСНС
                "06" => "#CC99FF"    //Хранитель
            );
            $year = date('Y');
            $q = $this->db->Select("
            select      
                round(sum(pay_sum_p)) pay_sum,
                'ПА' product_name,
                '01' pk,
                'data1' dt,
                extract(month from date_begin) month_begin
            from 
                contracts 
            where 
                state = 12
                and paym_code like '01%'
                and date_begin between to_date('01.01.$year', 'dd.mm.yyyy') and to_date('31.12.$year', 'dd.mm.yyyy')
                $filter
            group by extract(month from date_begin)
            union all
            select      
                round(sum(pay_sum_p)) pay_sum,
                'ОСОР' product_name,
                '02' pk,
                'data2' dt,
                extract(month from date_begin) month_begin
            from 
                contracts 
            where 
                state = 12
                and paym_code like '02%'
                and date_begin between to_date('01.01.$year', 'dd.mm.yyyy') and to_date('31.12.$year', 'dd.mm.yyyy')
                $filter
            group by extract(month from date_begin)
            union all
            select      
                round(sum(pay_sum_p)) pay_sum,
                'ОСНС' product_name,
                '07' pk,
                'data3' dt,
                extract(month from date_begin) month_begin
            from 
                contracts 
            where 
                state = 12
                and paym_code like '07%'
                and date_begin between to_date('01.01.$year', 'dd.mm.yyyy') and to_date('31.12.$year', 'dd.mm.yyyy')
                $filter
            group by extract(month from date_begin)
            union all
            select      
                round(sum(D.INS_PREMIYA)) pay_sum,
                'Хранитель' product_name,
                '06' pk,
                'data4' dt,
                extract(month from D.VIPLAT_BEGIN) month_begin     
            from 
                dobr_dogovors d
            where    
                state = 11
                and D.PAYM_CODE like '06%'
                and D.VIPLAT_BEGIN between to_date('01.01.$year', 'dd.mm.yyyy') and to_date('31.12.$year', 'dd.mm.yyyy')
                $filter
            group by extract(month from D.VIPLAT_BEGIN)    
            order by 4, 5");
            
            //echo $this->db->sql;
            
            
            $dan = array();
            foreach($q as $k=>$v){
                $dan[$v['PRODUCT_NAME']]['color'] = $color[$v['PK']];
                $dan[$v['PRODUCT_NAME']]['data_name'] = $v['DT'];                
                $dan[$v['PRODUCT_NAME']]['data'][] = $v['PAY_SUM'];                
            }
            
            for($i = 0;$i < 12; $i++){
                foreach($dan as $k=>$v){
                    if(!isset($dan[$k]['data'][$i])){
                        $dan[$k]['data'][$i] = '0';
                    }
                } 
            }
            
            $columns = '';
            $colors = '';
            $i = 0;
                        
            foreach($dan as $k=>$v)
            {
                if($i > 0){$columns .= ",";}
                $columns .= "['$k'";
                
                foreach($v['data'] as $t=>$d){                    
                    $columns .= ",".$d;
                }                
                $columns .= "]";
                
                if($i > 0){$colors .= ",";}
                $colors .= $v['data_name'].": '".$v['color']."'";
                $i++;
            }
            
            $html = "
            var months_name = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Дексбрь'];
            c3.generate({
                bindto: '#lineChart',
                data:{
                    columns: [
                        $columns
                    ],
                    colors:{
                        $colors
                    }
                },
                tooltip: {
                    format: {
                        title: function (d) { return months_name[d]; }
                    }
                }
            });";
            //$html .= 'console.log("'.$this->db->sql.'");';                        
            return $html;
            
        }                
                
    }
?>