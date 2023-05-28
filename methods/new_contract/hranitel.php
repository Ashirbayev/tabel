<?php            
	class NEW_CONTRACT
    {
        private $db;
        private $array;
        private $user_dan;
        public $dan = array();
        private $filename_load;
        
        public function __construct()
        {
            global $js_loader;
            global $active_user_dan;
            $this->user_dan = $active_user_dan;
            
            $this->db = new DB3();
            $method = $_SERVER['REQUEST_METHOD'];
                        
            $this->$method();
        }
        
        private function POST()
        {
            if(count($_FILES) > 0){
                if($this->file($_FILES)){
                    $this->parse_excel($this->filename_load);
                }
                exit;
            }
                        
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
        
        private function raznica_date()
        {
            $d1 = $this->array['date_begin'];
            $d2 = $this->array['date_end'];
            
            $q = $this->db->Select("select round((to_date('$d2', 'dd.mm.yyyy') - to_date('$d1', 'dd.mm.yyyy')) / 365) ds from dual");
            echo json_encode($q[0]);
            exit;
        }
        
        private function set_arhive($cnct)
        {
            $qs = $this->db->ExecProc("begin voluntary.move_archive($cnct, ''); end;", array());
            echo json_encode($qs);
            exit;            
        }
        
        private function set_state($cnct)
        {
            $btn = $this->array['set_state_btn'];
            global $active_user_dan;                                    
            $role = $active_user_dan['role'];
            $qs = $this->db->ExecProc("begin voluntary.NewState($cnct, '$role', '$btn', null); end;", array());
            echo json_encode($qs);
            exit;
        }
        
        private function file($f)
        {
            ini_set('display_errors','On');
            error_reporting(E_ALL | E_STRICT);
                        
            $fileName = basename($f["file"]["name"]);              
            $p = explode('.', $fileName);
            $s = count($p);            
            $fileName = time().'.'.$p[$s-1];              

            define ('SITE_ROOT', realpath(dirname(__FILE__)));            
            $targetFilePath = SITE_ROOT.'/../../upload/'.$fileName;
                        
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);                        
            $allowTypes = array('csv','xls','xlsx');
                  
            if(in_array($fileType, $allowTypes)){
                //chmod(SITE_ROOT.'/../../upload/', 0755);
                if(move_uploaded_file($f["file"]["tmp_name"], "upload/".$fileName)){
                    $this->filename_load = "upload/".$fileName;
                    return true;
                }else{
                    $this->filename_load = '';
                    return false;
                }
            }else{
                $this->filename_load = '';
                return false;
            }
            
            exit;
        }
        
        private function parse_excel($file_name)
        {
            $html = '<div class="tabs-container" style="over">';
                        
            if(file_exists('methods/Excel/PHPExcel/IOFactory.php')){
                require_once 'methods/Excel/PHPExcel/IOFactory.php';            
                
                $sheet = array();
                $tabs = array();
                $ul = '<ul class="nav nav-tabs">';
                $tabs = '<div class="tab-content ">';
                $i = 0;
                
                $xls = PHPExcel_IOFactory::load($file_name);                
                $s = $xls->getSheetNames();
                foreach($s as $k=>$v){
                    $s = '';
                    if($i == 0){$s = 'active';}
                    $ul .= '<li class="'.$s.'"><a data-toggle="tab" href="#sheet-'.$i.'">'.$v.'</a></li>';
                    $tabs .= '<div id="sheet-'.$i.'" class="tab-pane '.$s.'"><div class="panel-body">';
                    $tabs .= '<table class="table table-bordered excel_table">';
                    
                    $sheet[$k]['sheetname'] = $v;
                    $xls->setActiveSheetIndex($k);                    
                    $sh = $xls->getActiveSheet();
                    
                    for ($i = 1; $i <= $sh->getHighestRow(); $i++) {
                        $tabs .= '<tr class="row_'.$i.'">';
                        $nColumn = PHPExcel_Cell::columnIndexFromString($sh->getHighestColumn());                         
                        for ($j = 0; $j < $nColumn; $j++) {                            
                            $value = $sh->getCellByColumnAndRow($j, $i)->getValue();
                            $sheet[$k]['cells'][$i][$j] = $value;
                            
                            $ssp = '<li><a href="#" class="prov_user">Проверить</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" class="del_row">Удалить строку</a></li>
                                    <li><a href="#" class="del_col">Удалить колонку</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" class="set_fio">Установить как ФИО</a></li>
                                    <li><a href="#" class="set_birthday">Установить как Дата рождения</a></li>
                                    <li><a href="#" class="set_iin">Установить как ИИН</a></li>';
                            if(trim($value) == ''){
                                $ssp = '<li><a href="#" class="del_row">Удалить строку</a></li>
                                    <li><a href="#" class="del_col">Удалить колонку</a></li>';
                            }
                            $tabs .= '<td class="column_'.$j.'">                            
                            <div class="btn-group">
                                <a data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false"><span class="caret"></span></a>
                                <ul class="dropdown-menu">'.$ssp.'</ul>
                            </div>
                            <span title="Клик для проверки по ФИО в БД" class="set">'.$value.'</span>
                            </td>';
                        }
                        $tabs .= '</tr>';
                    }
                    $tabs .= '</table></div></div>';
                    $i++;
                }
                //echo json_encode($sheet);
                unlink($file_name);                                                                
            }else{
                echo '';
                exit;
            }
            $ul .= '</ul>';
            $tabs .= '</div>';
            
            $html .= $ul.$tabs;
            $html .= '</div>';
            echo $html;
            exit;
        }
        
        private function index()
        {
            $branch = $this->user_dan['brid'];
            
            $sql = "select a.id kod,  decode(a.vid,1,lastname ||' '|| firstname||' '||middlename, a.org_name) name, 
            a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN
            from agents a where a.state = 7 and a.date_close is null  and a.vid not in (4, 5)";
            
            if($branch !== '0000'){
                $sq = substr($branch, 0, 2);
                $sql .= " and a.branchid like '%$sq%'";
            }
            
            $sql .= " or a.id in (select b.id from agents_branch_other b where b.branchid = '$branch')";
                                    
            $this->dan['AGENT'] = $this->db->Select($sql);               
            $this->dan['regions'] = $this->db->Select("select * from DIC_BRANCH where nvl(asko, 0) = 0 and rfbn_id <> '0000' order by 1");
            $this->dan['osn_product'] = $this->db->Select("SELECT id, naimen name FROM DOBR_SPR_OSN_P WHERE id_prod = 121");
            $this->dan['dop_product'] = $this->db->Select("select id, naimen name from DOBR_DOP_STRAH order by num_id");
            $this->dan['spr_zab'] = $this->db->Select("select num_id id, naimen name from DOBR_SPR_ZAB");
            $this->dan['spr_prof'] = $this->db->Select("select num_id id, naimen name from DOBR_SPR_PROF");
            $this->dan['spr_sport'] = $this->db->Select("select num_id id, naimen name from DOBR_SPR_SPORT");
            $this->dan['spr_city'] = $this->db->Select("select num_id id, naimen name from DOBR_COUNTRY");
            $this->dan['banks'] = $this->db->Select("select bank_id kod, name, kor_account schet from dic_banks where status = 0");
        }
        
        private function CNCT_ID($cnct)
        {
            $q = $this->db->Select("select * from LIST_DOBR_DOGOVORS where cnct_id = $cnct");
            $this->dan['contract'] = $q[0];
            $this->dan['clients'] = $this->db->Select("select * from LIST_DOBR_DOGOVORS_CLIENTS where cnct_id = $cnct");
            foreach($this->dan['clients'] as $k=>$v){
                $this->dan['clients'][$k]['obtain'] = $this->db->Select("
                select d.*, C.LASTNAME, C.FIRSTNAME, C.MIDDLENAME, C.IIN, C.BIRTHDATE, C.ADDRESS_RUS, C.SIC, C.RNN 
                from DOBR_OBTAIN d, clients c where c.sicid = d.sicid and d.cnct_id = $cnct and d.sicid_client = ".$v['ID_ANNUIT']);
                
                $this->dan['clients'][$k]['NAGRUZ'] = $this->db->Select("select * from DOBR_DOGOVORS_CLIENTS_NAGRUS where cnct_id = $cnct and id_annuit = ".$v['ID_ANNUIT']);
                $this->dan['clients'][$k]['NAGRUZ_TABLE'] = $this->db->Select("
                select 'Справочник заболеваний' name_type, P.NAIMEN  from DOBR_DOGOVORS_CLIENTS_NAGRUS d, DOBR_SPR_ZAB p 
                where D.ID_ZABOLEV = P.NUM_ID and D.CNCT_ID = $cnct and D.ID_ANNUIT = ".$v['ID_ANNUIT']." 
                union all
                select 'Справочник профессий' name_type, P.NAIMEN  from DOBR_DOGOVORS_CLIENTS_NAGRUS d, DOBR_SPR_PROF p 
                where D.ID_PROFES = P.NUM_ID and D.CNCT_ID = $cnct and D.ID_ANNUIT = ".$v['ID_ANNUIT']."
                union all
                select 'Справочник спорта' name_type, P.NAIMEN  from DOBR_DOGOVORS_CLIENTS_NAGRUS d, DOBR_SPR_SPORT p 
                where D.ID_SPORT = P.NUM_ID and D.CNCT_ID = $cnct and D.ID_ANNUIT = ".$v['ID_ANNUIT']);
                
                $this->dan['clients'][$k]['CALC'] = $this->db->Select("select     
                    case 
                        when d.type_pokr = 0 then 'Основное покрытие' 
                        else 'Дополнительное покрытие' 
                    end name_type_pokr,
                    case 
                        when d.type_pokr = 0 then (select naimen from DOBR_SPR_OSN_P where id = d.id_pokr) 
                        else (select naimen from DOBR_DOP_STRAH where id = d.id_pokr) 
                    end name_pokr,
                    d.*
                from 
                    DOBR_DOGOVORS_CLIENTS_CALC d 
                where 
                    cnct_id = $cnct
                    and d.sicid = ".$v['ID_ANNUIT']);
            }
            
            $this->dan['reinsurance'] = $this->db->Select("
                select s.id ||' - '||s.r_name contag_name, reyting_ag__name(s.estimation, 1) RAG_NAME,
                reyting_ag__name(s.estimation, 2) ESTIMATION, r.* from reinsurance r, dic_REINSURANCE s
                where r.cnct_id = $cnct
                and r.REINSUR_ID = s.ID");
            
            $this->dan['list_files'] = $this->db->Select("select d.*, level_name(d.ID_ROLE) level_name, r.NAME otvetstv, 
            c.id id_cf, c.CNCT_ID, c.ID_FILES, c.FILENAME, c.NOTE 
            from
            dic_fails d, dir_role r, DOBR_DOGOVORS_FILES c 
            where  
            d.ID_ROLE = r.ID and c.ID_FILES(+) = d.ID 
            and c.CNCT_ID(+) = $cnct and d.PAYM_CODE = '06' 
            and d.LEVEL_R = nvl((select level_r from dobr_dogovors where cnct_id = $cnct and state <> 13), 0) order by d.ID"); 
            
            $this->dan['reason_dops'] = $this->db->Select("select id, reason name from DIC_REASON_DOPS where VID_DOG = '06' and actual = 1");
            
            $q = $this->db->Select("select d.type_strahovatel, d.id_strahovatel from dobr_dogovors d where cnct_id = $cnct");            
            $id_client = $q[0]['ID_STRAHOVATEL'];
            
            if($q[0]['TYPE_STRAHOVATEL'] == '0'){                
                $sqll = "
                    select contract_num, cnct_id from contracts where id_annuit = $id_client 
                    union all 
                    select contract_num, cnct_id from contracts_maket where id_annuit = $id_client
                    union all
                    select num_dog contract_num, cnct_id from dobr_dogovors where id_strahovatel = $id_client
                    ";  
            }else{                
                $sqll = "
                    select contract_num, cnct_id from contracts where id_insur = $id_client 
                    union all 
                    select contract_num, cnct_id from contracts_maket where id_insur = $id_client
                    union all
                    select num_dog contract_num, cnct_id from dobr_dogovors where id_strahovatel = $id_client
                    ";  
            }
            
            $this->dan['list_contract'] = $this->db->Select($sqll);
            
            $f = $_SERVER['REDIRECT_URL'];            
            if($f == '/new_contract'){
                $this->index();
            }                                      
        }
        
        private function reason_dops($id)
        {
            $q = $this->db->Select("select * from dic_reason_dops where id = $id");
            
        }
        
        private function search_fiz_client($text)
        {
            $date = $this->array['date_begin'];
            $q = $this->db->Select("select sicid, lastname||' '||firstname||' '||middlename fio, birthdate, iin, get_age(to_date('$date', 'dd.mm.yyyy'), BIRTHDATE) age from clients 
            where concat(upper(lastname||' '||firstname||' '||middlename), iin) like upper('%$text%')");
            echo json_encode($q);
            exit; 
        }
        
        private function prov_user($text)
        {
            $q = $this->db->Select("select sicid, lastname||' '||firstname||' '||middlename fio, birthdate, iin from clients 
            where concat(upper(lastname||' '||firstname||' '||middlename), iin) like upper('%$text%')");
            echo json_encode($q);
            exit;
        }
        
        private function search_clients($s)
        {       
            $b = true;
            if($this->user_dan['brid'] == '0000'){$b = false;}
            if($this->user_dan['brid'] == '1701'){$b = false;}
            
            $ssq = '';
            $ssl = '';
            if($b){
                $ssq = " and emp_id in(select emp_id from gs_emp where substr(branch_id, 1, 2) = substr('".$this->user_dan['brid']."', 1, 2))";
                $ssl = " and substr(branch_id, 1, 2) = substr('".$this->user_dan['brid']."', 1, 2)";
            }
            
            $sql = "select * from(
            select id, name||' ('||bin||') (Юридическое лицо)' name, 1 type_client from contr_agents where concat(upper(name), bin) like upper('%$s%') $ssq 
            union all
            select C.SICID id, C.LASTNAME||' '||C.FIRSTNAME||' '||C.MIDDLENAME||' ('||iin||') (Физическое лицо)' name, 0 type_client from clients c where 
            concat(upper(lastname||' '||firstname||' '||middlename), iin) like upper('%$s%') $ssl
            order by 3
            ) where rownum <= 500";   
                     
            $q = $this->db->Select($sql);
            $q['sql'] = $sql;
            echo json_encode($q);
            exit;
        }
        
        private function gen_zv_num($d)
        {            
            $branch = $this->array['branch'];
            $role = $this->user_dan['role'];        
            $r = $this->db->Select("select gen_zv_num('$branch', '0601000001', '$role') cn from dual");                
            echo trim($r[0]['CN']);        
            exit;
        }
        
        private function gen_contract_num($d)
        {
            $branch = $this->array['branch'];            
            $role = $this->user_dan['role'];            
            $r = $this->db->Select("select gen_contract_num('$d', '$branch', '0601000001', 0, '$role') cn from dual");                    
            echo trim($r[0]['CN']);        
            exit;
        }
        
        private function m_sicid($id)
        {
            $result = array();
            $result['sicid'] = $id;
            
            $result['error'] = '';
            if(trim($this->array['m_periodich']) == ''){
                $result['error'] = 'Пустое поле "Страховая сумма"!';    
            }
            
            if(trim($this->array['m_pay_sum_v']) == ''){
                $result['error'] = 'Пустое поле "Страховая сумма"!';    
            }
            
            if(trim($this->array['m_srok']) == ''){
                $result['error'] = 'Пустое поле "Срок страхования"!';    
            }
            
            if(trim($this->array['m_vozrast']) == ''){
                $result['error'] = 'У Данного клиента неопределен возраст. "Расчет не возможен"!';    
            }
            
            //Если у выгодопреобретателя процент стоит ноль
            
            
            //Если имеется ошибка при внесении данных клиента тогда выдаем ее и все...
            if($result['error'] !== ''){
                echo json_encode($result);
                exit;
            }
            
            //
            $dan = array();                        
            foreach($this->array as $k=>$v){
                $ks = substr($k, 2);
                $dan[$ks] = $v;
            }
            $date_calc = $this->array['m_date_calc'];
            $periodich = $this->array['m_periodich'];
            $str_sum = $this->array['m_pay_sum_v'];
            $srok = $this->array['m_srok'];
            $agent = $this->array['m_rashod'];
            $type_str = $this->array['m_type_str'];
            $main_pokr = $this->array['m_main_pokr'];
            
            /*-------------------------------------*/
            $dop_pokr = '';
            $i = 0;
            foreach($this->array['m_dop_pokr'] as $k){
                if($i > 0){$dop_pokr .= ',';}
                $dop_pokr .= $k;
                $i++;
            }
            /*-------------------------------------*/
            $zabolevaniya = '';
            $i = 0;
            foreach($this->array['m_zabolevaniya'] as $k){
                if($i > 0){$zabolevaniya .= ',';}
                $zabolevaniya .= $k;
                $i++;
            }
            /*-------------------------------------*/
            $professiya = '';
            $i = 0;
            foreach($this->array['m_professiya'] as $k){
                if($i > 0){$professiya .= ',';}
                $professiya .= $k;
                $i++;
            }
            /*-------------------------------------*/
            $sport = '';
            $i = 0;
            foreach($this->array['m_sport'] as $k){
                if($i > 0){$sport .= ',';}
                $sport .= $k;
                $i++;
            }
            /*-------------------------------------*/
            $country = $this->array['m_country'];
            $country_uslov = $this->array['m_country_uslov'];
            
            $sql = "SELECT * FROM table(voluntary.calc_new(to_date('$date_calc', 'dd.mm.yyyy'), '$id', '$periodich', '$str_sum', '$srok', '$agent',
            '$type_str', '$main_pokr', '$dop_pokr', '$zabolevaniya', '$professiya', '$sport', '$country', '$country_uslov'))";
            
            $rashet_sql = $sql;
            
            $raschet_table = $this->db->Select($sql);
            $pay_sum_v = 0;
            $pay_sum_p = 0;
            
            foreach($raschet_table as $k=>$v){
                if(trim($v['ERROR']) !== ''){
                    $result['error'] = $v['ERROR'];
                }
                $pay_sum_v += $v['PAY_SUM_V'];
                $pay_sum_p += $v['PAY_SUM_P'];
            }                        
            
            $vigodo = array(); 
            $vigodo_sicid = '';           
            $i = 0;
            foreach($this->array['vogodo_proc'] as $k=>$v){                                
                if(trim($v) !== ''){
                    if($i > 0){$vigodo_sicid .= ' union all ';}
                    $vigodo_sicid .= "select client_name2($k) fio, '$v' proc from dual";
                    $vigodo[$k] = $v;                    
                    $i++;
                }                
            }
            
                        
            $result['user_dan'] = array(
                "sicid"=>$id,                
                "age"=>$this->array['m_vozrast'],
                "ves"=>$this->array['m_ves'],
                "rost"=>$this->array['m_rost'],
                "rashod"=>$this->array['m_rashod'],
                "periodich"=>$this->array['m_periodich'],
                "srok"=>$this->array['m_srok'],
                "year_dohod"=>$this->array['m_dohod'],
                "str_sum"=>$this->array['m_pay_sum_v'],
                "main_pokr"=>$main_pokr,
                "dop_pokr"=>$this->array['m_dop_pokr'],
                "dat_calc"=>$this->array['m_date_calc'],
                "risks"=>array(
                    "zabolevaniya"=>$this->array['m_zabolevaniya'],
                    "professiya"=>$this->array['m_professiya'],
                    "sport"=>$this->array['m_sport'],
                    "country"=>$this->array['m_country'],
                    "country_uslov"=>$this->array['m_country_uslov']
                ),
                "raschet"=>$raschet_table,
                "pay_sum_v"=>$pay_sum_v,
                "pay_sum_p"=>$pay_sum_p,
                "poluchatel"=>$vigodo
            );
            
            $result['txt'] = $this->array;
                        
            $q = $this->db->Select("select lastname||' '||substr(firstname, 1, 1)||'. '||substr(middlename, 1,1) fio, c.* from clients c where sicid = $id");            
            $result['tab'] = '<li class="active"><a data-toggle="tab" href="#user_tab_'.$dan['sicid'].'">'.$q[0]['FIO'].'</a></li>';
            
            $form_dan = $dan;
            $q = $this->db->Select("SELECT naimen name FROM DOBR_SPR_OSN_P WHERE id = ".$dan['main_pokr']);
            $form_dan['main_pokr_name'] = $q[0]['NAME'];
                        
            $agent = array("15" => '0% - Минимальный', "25" => '25% - Базовый', "50" => '50% - Максимальный');            
            $form_dan['rashod_agent_name'] = $agent[$dan['rashod']];
            $form_dan['rashet_table'] = $raschet_table;
            
            $sql = "";
            if($zabolevaniya !== ''){
                $sql = "select 'Справочник заболеваний' type_name, naimen name from DOBR_SPR_ZAB where num_id in($zabolevaniya)";
            }            
            if($professiya !== ''){
                if($sql !== ''){$sql .= " union all ";}
                $sql .= "select 'Справочник профессий' type_name, naimen name from DOBR_SPR_PROF where num_id in($professiya)";
            }            
            if($sport !== ''){
                if($sql !== ''){$sql .= " union all ";}
                $sql .= "select 'Справочник спорта' type_name, naimen name from DOBR_SPR_SPORT where num_id in($sport)";
            }            
            $nagruz_table = array();
            if($sql !== ''){
                $sql = "select * from($sql)";                
                $nagruz_table = $this->db->Select($sql);    
            }
                        
            $form_dan['nagruzki'] = $nagruz_table;
            
            if($vigodo_sicid !== ''){
                $form_dan['poluchatel'] = $this->db->Select("select * from($vigodo_sicid)");                
            }
            
            $result['form'] = $this->user_form($form_dan);
            echo json_encode($result);
            exit;            
        }
        
        private function user_form($dan)
        {
            $html = '
            <div id="user_tab_'.$dan['sicid'].'" class="tab-pane user_tab_'.$dan['sicid'].' active">
                <div class="panel-body">                    
                    <div class="row">                        
                        <div class="col-lg-12" style="margin-top: -30px;">
                        <button class="btn btn-xs btn-danger pull-right delete_user" id="'.$dan['sicid'].'"><i class="fa fa-trash"></i></button>
                        <div class="form-horizontal">
                            <h3>Данные клиента</h3>                                                        
                            <div class="form-group">
                                <label class="col-lg-3 control-label">ФИО (Дата Рождения)(ИИН)</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="'.$dan['fio'].'" readonly>                                                                                                                                         
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Возраст</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" value="'.$dan['vozrast'].'" readonly>                                                                     
                                </div>                                                                
                            
                                <label class="col-lg-1 control-label">Вес</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" value="'.$dan['ves'].'" readonly>                                                                     
                                </div>
                            
                                <label class="col-lg-1 control-label">Рост</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" value="'.$dan['rost'].'" readonly>                                                                     
                                </div>
                            </div>
                                                        
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Агентские расходы</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="'.$dan['rashod_agent_name'].'" readonly>                                                                     
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Периодичность</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" value="'.$dan['periodich'].'" readonly>                                                                     
                                </div>
                                
                                <label class="col-lg-3 control-label">Срок страхования</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" value="'.$dan['srok'].'" readonly>                                                                     
                                </div>
                            </div>
                            <div class="form-group">                                                                
                                <label class="col-lg-3 control-label">Годовой доход</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" value="'.$dan['dohod'].'" readonly>                                                                     
                                </div>
                            
                                <label class="col-lg-3 control-label">Страховая сумма</label>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" value="'.$dan['pay_sum_v'].'" readonly>                                                                     
                                </div>
                            </div>';
            
            if(count($dan['nagruzki']) > 0){
                $html .= '<hr /><h3>Нагрузки</h3>
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Тип</th>
                            <th>Наименование</th>                        
                        </tr>
                    </thead>
                    <tbody>';
                foreach($dan['nagruzki'] as $k=>$v){
                    $html .= '<tr><td>'.$v['TYPE_NAME'].'</td><td>'.$v['NAME'].'</td></tr>';
                }                        
                $html .= '</tbody></table>';
            }              
            
            if(count($dan['rashet_table']) > 0){
                $html .= '<hr /><h3>Расчетные данные</h3>
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Тип</th>
                        <th>Наименование</th>
                        <th>Тариф</th>
                        <th>Нагрузка</th>
                        <th>Страховой взнос</th>                                                                                
                        <th>Страховая премия</th>
                    </tr>
                </thead>
                <tbody>';
                
                $tarif = 0;
                $nagruz = 0;
                $pay_sum_v = 0;
                $pay_sum_p = 0;
                                
                foreach($dan['rashet_table'] as $k=>$v){
                $html .= '
                    <tr>
                        <td>'.$v['TYPE_NAME'].'</td>
                        <td>'.$v['NAME'].'</td>
                        <td>'.StrToFloat($v['TARIF']).'</td>
                        <td>'.$v['NAGRUZ'].'</td>
                        <td>'.$v['PAY_SUM_V'].'</td>
                        <td>'.$v['PAY_SUM_P'].'</td>
                    </tr>';
                    $tarif += $v['TARIF'];
                    $nagruz += $v['NAGRUZ'];
                    $pay_sum_v += $v['PAY_SUM_V'];
                    $pay_sum_p += $v['PAY_SUM_P'];
                }
                
                $html .= '
                <tr>
                    <td colspan="2"><b>Итого: </b></td>                    
                    <td><b>'.$tarif.'</b></td>
                    <td><b>'.$nagruz.'</b></td>
                    <td><b>'.$pay_sum_v.'</b></td>
                    <td><b>'.$pay_sum_p.'</b></td>
                </tr>';
                $html .= '</tbody></table>';    
            }
            
            if(count($dan['poluchatel']) > 0){
                $html .= '<hr /><h3>Выгодоприобретатели</h3>
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Фамилия Имя Отчество</th>
                        <th>Процент(%)</th>                        
                    </tr>
                </thead>
                <tbody>';
                                                
                foreach($dan['poluchatel'] as $k=>$v){
                $html .= '
                    <tr>
                        <td>'.$v['FIO'].'</td>
                        <td>'.$v['PROC'].'</td>                        
                    </tr>';                    
                }                                
                $html .= '</tbody></table>';  
            }
            
            $html .= '</div></div></div></div></div>';
            return $html;
        }
        
        private function print_zayav($cnct)
        {            
            $this->CNCT_ID($cnct);
            
            $this->array['bank_schet']           = $this->dan['contract']['BANK_CHET'];
            $this->array['bank_iik']             = $this->dan['contract']['BANK_IIK'];
            $this->array['bank_date_lgot_begin'] = $this->dan['contract']['BANK_LGOT_SROK_S'];
            $this->array['bank_date_lgot_end']   = $this->dan['contract']['BANK_LGOT_SROK_PO'];
            $this->array['bank_date_do']         = $this->dan['contract']['KART_DEISTVIE'];
            $this->array['bank_num_sprav']       = $this->dan['contract']['BANK_NUM_SPR'];
            $this->array['id_insur']             = $this->dan['contract']['ID_STRAHOVATEL'];
            $this->array['type_insur']           = $this->dan['contract']['TYPE_STRAHOVATEL'];
            $this->array['id_agent']             = $this->dan['contract']['SICID_AGENT'];
            $this->array['date_begin']           = $this->dan['contract']['DATE_BEGIN_FIRST'];
            $this->array['date_end']             = $this->dan['contract']['DATE_END_FIRST'];
            $this->array['contract_num']         = $this->dan['contract']['CONTRACT_NUM'];
            $this->array['zv_num']               = $this->dan['contract']['ZV_NUM'];
            $this->array['contract_date']        = $this->dan['contract']['CONTRACT_DATE'];
            $this->array['zv_date']              = $this->dan['contract']['TYPE_STR'];
            $this->array['type_strah']           = $this->dan['contract'][''];
            
            foreach($this->dan['clients'] as $k=>$v){
                $ds = array(
                    "sicid"=>$v['ID_ANNUIT'],
                    "age"=>$v['AGE'],
                    "ves"=>$v['VES'],
                    "rost"=>$v['ROST'],
                    "rashod" =>$AGENT_TARIF,
                    "periodich" =>$v['PERIODICH'],                                                    
                    "srok" =>$v['SROK_STRAH'],
                    "year_dohod" =>$v['GOD_DOHOD'],
                    "str_sum" =>$v['STR_SUM'],
                    "main_pokr" =>$v['OSN_POKRITIE']
                );
                
                foreach($v['CALC'] as $t=>$c){
                    if($c['TYPE_POKR'] !== '0'){
                        $ds["dop_pokr"][] = $c['ID_POKR'];
                    }
                }
                
                $ds["dat_calc"] = $v['REGDATE'];
                
                
                $zabolevaniya = array();
                $professiya = array();
                $sport = array();
                
                foreach($v['NAGRUZ'] as $i=>$n){
                    if(trim($n['ID_ZABOLEV']) !== ''){$zabolevaniya[] = $n['ID_ZABOLEV'];}
                    if(trim($n['ID_PROFES']) !== ''){$professiya[] = $n['ID_PROFES'];}
                    if(trim($n['ID_SPORT']) !== ''){$sport[] = $n['ID_SPORT'];}
                }
                
                $ds["risks"] = array(
                        "zabolevaniya"=>$zabolevaniya,
                        "professiya"=>$professiya,
                        "sport"=>$sport,
                        "country"=>$v['ID_CITY'],
                        "country_uslov"=>$v['USL_PROG']
                );
                
                foreach($v['CALC'] as $i=>$c){
                    $ds["raschet"][] = array(
                        "ID_TYPE"   => $c['TYPE_POKR'],
                        "ID_POKR"   => $c['ID_POKR'],
                        "TYPE_NAME" => $c['NAME_TYPE_POKR'],
                        "NAME"      => $c['NAME_POKR'],
                        "TARIF"     => $c['TARIF'],
                        "NAGRUZ"    => $c['NAGRUZ'],
                        "PAY_SUM_V" => $c['PAY_SUM_V'],
                        "PAY_SUM_P" => $c['PAY_SUM_P'],
                        "ERROR"     => ''
                    );
                }
                
                    
                $ds["pay_sum_v"] = $v['STR_SUM'];
                $ds["pay_sum_p"] = $v['PAY_SUM_P'];
                $dsp = array();
                foreach($v['obtain'] as $i=>$o){
                    $q = $this->db->Select("select * from clients where sicid = ".$o['SICID']);
                    $dsp = $q[0];
                    $dsp['procent'] = $o['V_PERS'];
                    $ds["poluchatel"][] = $dsp;
                }
                
                $this->array['print_zayavlenie'][] = json_encode($ds);       
             }
             $this->print_zayavlenie();   
        }
        
        private function print_zayavlenie()
        {
            $i = 0;
            foreach($this->array['print_zayavlenie'] as $k=>$v){                
                $js = json_decode($v);
                $this->array['print_zayavlenie'][$k] = $js;
            }             
            
            $dan = $this->array;
            
            if($dan['type_insur'] == '1'){
                $q = $this->db->Select("select c.*, oked_name(C.OKED_ID) oked_name from contr_agents c where c.id = ".$dan['id_insur']);
                $this->array['type_strah'] = '2';                
            }else{
                $q = $this->db->Select("select * from clients where sicid = ".$dan['id_insur']);
                $this->array['type_strah'] = '1';                
            }
            $dan['strahovatel'] = $q[0];
                        
            if($this->array['type_strah'] == '1'){
                $req = 'hranitel_zav_ind.php';
            }else{
                $req = 'hranitel_zav_group.php';
            }
            $dan['max_strah_god'] = $dan['print_zayavlenie'][0]->srok;
            
            $pay_sum_p_all = 0;
            $pay_sum_v_all = 0;
            foreach($dan['print_zayavlenie'] as $k=>$v){
                $pay_sum_p_all += floatval($v->pay_sum_p);
                $pay_sum_v_all += floatval($v->pay_sum_v);
            }
                        
            $q = $this->db->Select("select $pay_sum_p_all pay_sum_p_all, tlsc.money_word($pay_sum_p_all) pay_sum_p_text,  
            $pay_sum_v_all pay_sum_v_all, tlsc.money_word($pay_sum_v_all) pay_sum_v_text from dual");
            $dan['PAY_SUM_P_ALL'] = $q[0]['PAY_SUM_P_ALL'];
            $dan['PAY_SUM_P_TEXT'] = $q[0]['PAY_SUM_P_TEXT'];
            $dan['PAY_SUM_V_ALL'] = $q[0]['PAY_SUM_V_ALL'];
            $dan['PAY_SUM_V_TEXT'] = $q[0]['PAY_SUM_V_TEXT'];
            
            foreach($dan['print_zayavlenie'][0]->dop_pokr as $k=>$v){
                $q = $this->db->Select("select naimen from DOBR_DOP_STRAH where id = $v");
                $dan['dop_pokr'][] = $q[0]['NAIMEN'];
                //$this->db->Select("select id, naimen name from DOBR_DOP_STRAH order by num_id")
            }
                        
            $dan['clients_obtain'] = array();
            $dan['god_dohod'] = 0;
            
            foreach($dan['print_zayavlenie'] as $k=>$v){
                $q = $this->db->Select("select * from clients where sicid = ".$v->sicid);
                $dan['clients'][] = $q[0];
                
                $dan['god_dohod'] += $v->year_dohod;
                    
                if(isset($v->poluchatel[0])){                    
                    $dan['clients_obtain'] = $this->db->Select("select lastname||' '||firstname||' '||middlename fio, ADDR_CONV, D.V_PERS procent, docum(d.sicid) documents, iin  
                    from clients c, dobr_obtain d where  d.sicid = c.sicid and d.CNCT_ID = ".$dan['print_zayav']);                                        
                }else{
                    foreach($v->poluchatel as $t=>$d){                        
                        if(!isset($dan['clients_obtain'][$t])){
                          $q = $this->db->Select("select lastname||' '||firstname||' '||middlename fio, ADDR_CONV, '$d%' procent, docum(sicid) documents, iin  from clients where sicid = ".$t);                      
                          $dan['clients_obtain'][$t] = $q[0];
                        }
                    }                    
                }
            }
            
            $q = $this->db->Select("select tlsc.money_word(".$dan['god_dohod'].") GD from dual");
            
            $dan['god_dohod_text'] = $q[0]['GD'];
                                            
            require_once 'methods/print/'.$req;        
            exit;            
        }
                
        private function download_file($filename)
        {
            $filename = base64_decode($filename);                        
            //ini_set('max_execution_time', 6000);
            // define some variables
                        
            $fs = explode("/", $filename);
            $fst = $filename;//$fs[count($fs)-1];
            
            $local_file = __DIR__.$fst;
            $server_file = $filename; // Change this target dir
            $ftp_server = '192.168.5.2';
            $ftp_user_name = 'upload';
            $ftp_user_pass = 'Astana2014';
            // set up basic connection
            $conn_id = ftp_connect($ftp_server);
            // login with username and password
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            // try to download $server_file and save to $local_file
            if (ftp_fget($conn_id, $local_file, $server_file, FTP_BINARY)) {
                echo "Successfully written to $local_file\n";
            } else {
                echo "There was a problem\n";
            }
            // close the connection
            ftp_close($conn_id);
            exit;
        }
        
        private function save()
        {            
            $result = array();
            global $active_user_dan;
                                  
            $id = $this->array['icnct'];
            $id_head = $this->array['id_head'];
            $vid = 1;
            if($id_head !== '0'){$vid = 2;}
            
            /*Уровень принятия решения (лимиты)*/
            $level = 3;
            $q = $this->db->Select("select g.sum_activ from GAK_CONSTANT g where rownum = 1");
            $sum_active = $q[0]['SUM_ACTIV'];
            /*
                надо будет потом доделать лимиты правильно
                if i_INS_SUMMA between 20000000 and isum_active * 20 / 100 then
                    ilevel:= 4;    
                end if;
                  
                if i_INS_SUMMA between isum_active * 20 / 100+1 and isum_active * 25 / 100 then 
                    ilevel := 5; 
                end if;
            */
            /*---------------------------------*/                  
            if(trim($id) == '0'){
                $q = $this->db->Select("select SEQ_DOBR_DOGOVOR.nextval ss from dual");
                $id = $q[0]['SS'];                
                $sql = "INSERT INTO DOBR_DOGOVORS (
                    ID_NUM, 
                    CNCT_ID,
                    NUM_DOG, 
                    DATE_DOG, 
                    NUM_ZAV, 
                    DATE_ZAV,
                    VIPLAT_BEGIN, 
                    VIPLAT_END, 
                    OPLATA_PO_DO,
                    ID_STRAHOVATEL,
                    PRODUCT_ID,                 
                    BANK_ID, 
                    BANK_CHET, 
                    BANK_TYPE_CHET, 
                    BANK_IIK,                      
                    BANK_NUM_SPR, 
                    BANK_LGOT, 
                    BANK_LGOT_SROK_S, 
                    BANK_LGOT_SROK_PO,
                    ID_HEAD, 
                    BRANCH_ID,
                    PAYM_CODE, 
                    SICID_AGENT, 
                    VID, 
                    STATE, 
                    EMP_ID, 
                    ID_CALCUL,
                    TYPE_STRAHOVATEL, 
                    LEVEL_R,
                    TYPE_STR, 
                    DATE_BEGIN_FIRST, 
                    DATE_END_FIRST
                ) 
                VALUES ( 
                    $id, 
                    $id,
                    '".$this->array['contract_num']."', 
                    '".$this->array['contract_date']."', 
                    '".$this->array['zv_num']."', 
                    '".$this->array['zv_date']."',
                    '".$this->array['date_begin']."', 
                    '".$this->array['date_end']."', 
                    to_date('".$this->array['date_begin']."', 'dd.mm.yyyy')+15,
                    '".$this->array['id_insur']."',
                    '121',                 
                    '".$this->array['bank_id']."', 
                    '".$this->array['bank_schet']."', 
                    '".$this->array['bank_type_schet']."', 
                    '".$this->array['bank_iik']."',
                    '".$this->array['bank_num_sprav']."', 
                    '".$this->array['bank_lgot']."', 
                    '".$this->array['bank_date_lgot_begin']."', 
                    '".$this->array['bank_date_lgot_end']."',
                    '$id_head',
                    '".$this->array['branch_id']."',
                    '0601000001', 
                    '".$this->array['id_agent']."', 
                    '$vid', 
                    '0', 
                    '".$active_user_dan['emp']."', 
                    '60',
                    '".$this->array['type_insur']."', 
                    '$level',
                    '".$this->array['type_strah']."', 
                    '".$this->array['date_begin']."', 
                    '".$this->array['date_end']."'
                )";
            }else{
                if(trim($id) !== '0'){
                    $sql = $this->db->Execute("
                    Begin
                      insert into DOBR_DOGOVORS_CLIENTS_ARC select * from DOBR_DOGOVORS_CLIENTS where cnct_id = $id;
                      insert into DOBR_DOGOVORS_CLIENTS_CALC_ARC select * from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id;
                      insert into DOBR_DOGOVORS_CLIENTS_NAGRUS_A select * from DOBR_DOGOVORS_CLIENTS_NAGRUS where cnct_id = $id;
                      insert into DOBR_OBTAIN_ARC select * from DOBR_OBTAIN where cnct_id = $id;
                      insert into DOBR_DOGOVORS_ARC select * from DOBR_DOGOVORS where cnct_id = $id;
                    end;
                    ");
                    
                    $this->db->Execute($sql);
                }
                
                $sql = "update DOBR_DOGOVORS set 
                    NUM_DOG             = '".$this->array['contract_num']."',
                    DATE_DOG            = '".$this->array['contract_date']."', 
                    NUM_ZAV             = '".$this->array['zv_num']."',
                    DATE_ZAV            = '".$this->array['zv_date']."',
                    VIPLAT_BEGIN        = '".$this->array['date_begin']."',
                    VIPLAT_END          = '".$this->array['date_end']."',
                    OPLATA_PO_DO        = to_date('".$this->array['date_begin']."', 'dd.mm.yyyy')+15,
                    ID_STRAHOVATEL      = '".$this->array['id_insur']."',                     
                    BANK_ID             = '".$this->array['bank_id']."',
                    BANK_CHET           = '".$this->array['bank_schet']."',
                    BANK_TYPE_CHET      = '".$this->array['bank_type_schet']."',
                    BANK_IIK            = '".$this->array['bank_iik']."',
                    BANK_NUM_SPR        = '".$this->array['bank_num_sprav']."',
                    BANK_LGOT           = '".$this->array['bank_lgot']."',
                    BANK_LGOT_SROK_S    = '".$this->array['bank_date_lgot_begin']."',
                    BANK_LGOT_SROK_PO   = '".$this->array['bank_date_lgot_end']."',
                    ID_HEAD             = '$id_head',
                    BRANCH_ID           = '".$this->array['branch_id']."',
                    SICID_AGENT         = '".$this->array['id_agent']."',                    
                    EMP_ID              = '".$active_user_dan['emp']."',                    
                    TYPE_STRAHOVATEL    = '".$this->array['type_insur']."',
                    LEVEL_R             = '$level',
                    TYPE_STR            = '".$this->array['type_strah']."',
                    DATE_BEGIN_FIRST    = '".$this->array['date_begin']."',
                    DATE_END_FIRST      = '".$this->array['date_end']."'
                where cnct_id = $id
                ";                
            }
            $result['cnct'] = $id;
            $result['error'] = '';
                        
            if(!$this->db->Execute($sql)){
                $result['error'] = 'Ошибка! '.$this->db->message;
                echo json_encode($result);
                exit;
            } 
                        
            //Удаляем все по пользователям
            
            
            $this->db->Execute("delete from DOBR_DOGOVORS_CLIENTS where cnct_id = $id");            
            $this->db->Execute("delete from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id");
            $this->db->Execute("delete from DOBR_DOGOVORS_CLIENTS_NAGRUS where cnct_id = $id");
            $this->db->Execute("delete from DOBR_OBTAIN where cnct_id = $id");
                        
            foreach($this->array['save'] as $k=>$cl){
                $client = json_decode($cl);
                
                $DP_SUM = 0; 
                $PAY_SUM_P = 0;
                $TARIF_DP = 0;
                $TARIF = 0;
                $PAY_SUM_P_ALL = 0;
                $RISK = 0;
                $DOP_RISK = 0;
                
                /*Расчетные данные*/
                foreach($client->raschet as $c=>$v){
                    $sql_calc_client = "
                    INSERT INTO DOBR_DOGOVORS_CLIENTS_CALC (ID, CNCT_ID, SICID, TYPE_POKR, ID_POKR, TARIF, NAGRUZ, PAY_SUM_V, PAY_SUM_P) 
                    VALUES ( SEQ_DOBR_DOGOVORS_CLIENTS_CALC.nextval, '$id', '$client->sicid', '$v->ID_TYPE', '$v->ID_POKR', 
                    '$v->TARIF', '$v->NAGRUZ', '$v->PAY_SUM_V', '$v->PAY_SUM_P')";
                                                                
                    if(!$this->db->Execute($sql_calc_client)){
                        $result['error'] = 'Ошибка! '.$this->db->message;
                        $this->deleteDogovor($id);                        
                        echo json_encode($result);
                        exit;
                    }
                }
                                
                if(count($client->poluchatel) > 0){                    
                    foreach($client->poluchatel as $c=>$d){
                        $sql_obtain = "INSERT INTO DOBR_OBTAIN (ID, CNCT_ID, SICID, V_PERS, SICID_CLIENT)
                        VALUES (SEQ_DOBR_OBTAIN.Nextval, '$id', '$c', '$d', '$client->sicid')";
                                                                        
                        if(!$this->db->Execute($sql_obtain)){
                            $result['error'] = 'Ошибка! '.$this->db->message;
                            $this->deleteDogovor($id);                        
                            echo json_encode($result);
                            exit;
                        }                        
                    }
                }
                                
                /*Данный блок необходимо доработать*/
                $risk = $client->risks;
                foreach($risk->professiya as $k=>$v){                    
                    $sql_nagruz = "INSERT INTO DOBR_DOGOVORS_CLIENTS_NAGRUS (CNCT_ID, ID_ANNUIT, ID_PROFES) 
                    VALUES ($id, $client->sicid, $v)";
                    if(!$this->db->Execute($sql_nagruz)){
                        $result['error'] = 'Ошибка! '.$this->db->message;
                        $this->deleteDogovor($id);                        
                        echo json_encode($result);
                        exit;
                    }
                }
                
                foreach($risk->sport as $k=>$v){
                    $sql_nagruz = "INSERT INTO DOBR_DOGOVORS_CLIENTS_NAGRUS (CNCT_ID, ID_ANNUIT, ID_SPORT) 
                    VALUES ($id, $client->sicid, $v)";
                    if(!$this->db->Execute($sql_nagruz)){
                        $result['error'] = 'Ошибка! '.$this->db->message;
                        $this->deleteDogovor($id);                        
                        echo json_encode($result);
                        exit;
                    }
                }
                
                foreach($risk->zabolevaniya as $k=>$v){
                    $sql_nagruz = "INSERT INTO DOBR_DOGOVORS_CLIENTS_NAGRUS (CNCT_ID, ID_ANNUIT, ID_ZABOLEV) 
                    VALUES ($id, $client->sicid, $v)"; 
                    if(!$this->db->Execute($sql_nagruz)){
                        $result['error'] = 'Ошибка! '.$this->db->message;
                        $this->deleteDogovor($id);                        
                        echo json_encode($result);
                        exit;
                    }
                }
                                
                $agents = '0% - Минимальный';
                if($client->rashod == '25'){$agents = '25% - Базовый';}
                if($client->rashod == '50'){$agents = '50% - Максимальный';}
                                  
                $sql_client = "INSERT INTO DOBR_DOGOVORS_CLIENTS (
                    CNCT_ID, 
                    ID_ANNUIT, 
                    ID_CITY,
                    ROST,  
                    VES, 
                    OSN_POKRITIE,
                    PERIODICH,
                    GOD_DOHOD, 
                    STR_SUM, 
                    SROK_STRAH, 
                    DP_SUM, 
                    PAY_SUM_P, 
                    TARIF, 
                    PAY_SUM_P_OSN, 
                    TARIF_DP,
                    AGENT_TARIF, 
                    RISK, 
                    DOP_RISK, 
                    PAY_SUM_P_ALL, 
                    NUM_PP, 
                    SP_OSN_POKR, 
                    SP_DOP_POKR, 
                    SP_ALL) 
                VALUES ( 
                    '$id',
                    '$client->sicid',
                    '$risk->country',
                    '$client->rost',
                    '$client->ves',
                    '$client->main_pokr',
                    '$client->periodich',
                    '$client->year_dohod',
                    '$client->str_sum',
                    '$client->srok',
                    nvl((select sum(PAY_SUM_P) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid and TYPE_POKR = 1), 0),
                    nvl((select sum(PAY_SUM_P) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid), 0),
                    nvl((select sum(TARIF) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid), 0),
                    nvl((select sum(PAY_SUM_P) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid and TYPE_POKR = 0), 0),
                    nvl((select sum(TARIF) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid and TYPE_POKR = 1), 0),                    
                    '$agents',
                    nvl((select sum(NAGRUZ) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid and TYPE_POKR = 0), 0),
                    nvl((select sum(NAGRUZ) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid and TYPE_POKR = 1), 0),
                    nvl((select sum(PAY_SUM_P) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid), 0),
                    '$k',
                    nvl((select sum(PAY_SUM_P) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid and TYPE_POKR = 0), 0),
                    nvl((select sum(PAY_SUM_P) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid and TYPE_POKR = 1), 0),
                    nvl((select sum(PAY_SUM_P) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id and SICID = $client->sicid), 0)
                )";   
                                
                if(!$this->db->Execute($sql_client)){
                    $result['error'] = 'Ошибка! '.$this->db->message;
                    $this->deleteDogovor($id);                        
                    echo json_encode($result);
                    exit;
                }
            }
            
            $sql = "update DOBR_DOGOVORS 
            set 
              ins_premiya = (select sum(pay_sum_p) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id),
              ins_summa = (select sum(pay_sum_v) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id),
              srok_ins = (select max(srok_strah) from DOBR_DOGOVORS_CLIENTS where cnct_id = $id),
              tarif = (select sum(tarif) from DOBR_DOGOVORS_CLIENTS_CALC where cnct_id = $id)
            where cnct_id = $id";
            
            if(!$this->db->Execute($sql)){
                $result['error'] = 'Ошибка! '.$this->db->message;
                $this->deleteDogovor($id);
                echo json_encode($result);
                exit;
            }
            
            echo json_encode($result);
            exit;
        }
        
        private function deleteDogovor($cnct)
        {
            $sql1 = "delete from DOBR_DOGOVORS where CNCT_ID = $cnct";
            $sql2 = "delete from DOBR_DOGOVORS_CLIENTS_CALC where CNCT_ID = $cnct";
            $sql3 = "delete from DOBR_OBTAIN where CNCT_ID = $cnct";
            $sql4 = "delete from DOBR_DOGOVORS_CLIENTS where CNCT_ID = $cnct";
            $sql5 = "delete from DOBR_DOGOVORS_CLIENTS_NAGRUS where CNCT_ID = $cnct";
            if(!$this->db->Execute($sql1)){return false;}            
            if(!$this->db->Execute($sql2)){return false;}
            if(!$this->db->Execute($sql3)){return false;}
            if(!$this->db->Execute($sql4)){return false;}
            if(!$this->db->Execute($sql5)){return false;}
            return true;
        }
    }
?>