<?php
	class REINS_REPORT
    {
        private $db;
        private $date_begin;
        private $date_end;
        private $array;
        public $dan = array();
        public $list_reins;   
        public $message = ''; 
        public $html;
        private $state_f;   
        private $vid; 
        
        public function __construct()
        {            
            $this->db = new DB3();            
            $method = $_SERVER['REQUEST_METHOD'];                           
            $this->$method();
        }
        
        private function GET()
        {
            if(count($_GET) <= 0){
                $this->lists();                                
            }else{            
                foreach($_GET as $k=>$v){
                    if(method_exists($this, $k)){                        
                        $this->$k($v);
                    }else{
                        $this->dan[$k] = $v;
                    }
                }
            }                                    
        }
        
        private function POST()
        {                         
            if(count($_POST) <= 0){
                $this->dan = array();
            }else{                
                $i = 0;
                foreach($_POST as $k=>$v){
                    if(method_exists($this, $k)){
                        $i++;
                        $this->array = $_POST;
                        $this->$k($v); 
                    }
                }
                if($i == 0){
                    exit;
                }
            }            
        }
        
        private function fs_prov($d)
        {    
            
            if($this->proverkaBlockBase() == false){
                $dan['message'] = "База заблокированна САРиА! <br />Идет расчет резервов";
                echo json_encode($dan);
                exit;
            }
            
            $s = '';
            $i = 0;
            $dan = array();
            $dan['message'] = '';
            foreach($d as $k){
                if($i > 0){
                    $s .= ",";
                }
                $s .= $k;
                $i++;
            }
            
            $vid = $this->db->Select("select vid from contracts where cnct_id in ($s) group by vid");
            
            if(count($vid) > 1){
                $dan['message'] = 'Вы выбрали 2 типа договоров основной и дополнительно соглашение';
            }
            
            if($vid[0]['VID'] == "2"){
                $sql = "select r.contract_num, R.REINSUR_ID from reinsurance r  where 
                r.cnct_id in(select id_head from contracts where cnct_id in($s))
                group by r.contract_num, R.REINSUR_ID ";
                                
                $q = $this->db->Select($sql);
                
                if(count($q) > 1){
                    $dan['message'] = 'Для заведения дополнительного соглашения 
                    <br />необходимо выбрать договора подходящие к 1 договору перестрахования';
                }else{
                    $sql = "
                    select 
                        r.contract_num, 
                        R.REINSUR_ID,
                        (select count(*) + 1 from contracts d, reinsurance rs 
                            where rs.cnct_id = d.cnct_id and d.id_head = r.cnct_id 
                            and rs.contract_num like '%Д%') cnt,
                        (select min(id) from bordero_contracts 
                        where contract_num = r.contract_num and id_head is null) id_head                         
                    from 
                        reinsurance r 
                    where 
                        r.cnct_id in(select id_head from contracts where cnct_id in($s))";
                    
                                        
                    $q = $this->db->Select($sql);
                    $dan['reins_name'] = $q[0]['REINSUR_ID'];                    
                    $dan['contract_num'] = $q[0]['CONTRACT_NUM']."/Д".$q[0]['CNT'];
                    $dan['id_head'] = $q[0]['ID_HEAD'];
                }                
            }
            echo json_encode($dan);
            exit;
        }
        
        private function date_begin($dan)
        {
            $this->date_begin = $dan;
        }
        
        private function date_end($dan)
        {
            $this->date_end = $dan;
        }
        
        private function state($dan)
        {
            $this->state_f = $dan;
        }
        
        private function main_dog()
        {
            $this->vid = '';
        }
        
        private function dop_dog()
        {
            $this->vid = 'not';
        }
        
        private function filter()
        {
            $filter = "";            
            if(isset($this->date_begin)){
                $filter = " and contract_date between '".date("d.m.Y", strtotime($this->date_begin))."' and '".date("d.m.Y", strtotime($this->date_end))."'";
            }                        
            return $filter;
        }
        
        
        
        private function lists($vid = 1)
        {
            $this->list_reins = $this->db->Select("select * from DIC_REINSURANCE");
                        
            $filter = $this->filter();
            $sql = "
            select 
                d.contract_num, 
                d.contract_date, 
                fond_name(d.id_insur) strahovatel, 
                d.pay_sum_p, 
                d.pay_sum_v, 
                agent_name(D.SICID_AGENT) agent, 
                branch_name(d.branch_id) region,
                (select contract_num from reinsurance where cnct_id = d.id_head) contract_num_osn,
                (select b.id from bordero_contracts b, reinsurance r where r.cnct_id = d.id_head 
                and R.CONTRACT_NUM = b.contract_num and b.id_head is null group by b.id) id_reins_osn,
                o.*
            from 
              contracts d, 
              osns_calc o 
            where 
                o.cnct_id = d.cnct_id and (O.REINS_ID = 4 or O.REINS_ID is null) 
                and d.state <> 13 
                and SICID_AGENT = 1620 and d.cnct_id not in(select cnct_id from REINSURANCE_OWN)
                and d.state in(12, 32)
                and d.vid = $vid
                $filter";
            //echo $sql;
            $list = $this->db->Select($sql);
            $this->dan = $list;
            
            global $js_loader, $css_loader, $othersJs;
            array_push($js_loader, 
                'styles/js/plugins/dataTables/jquery.dataTables.js',
                'styles/js/plugins/dataTables/dataTables.bootstrap.js',
                'styles/js/plugins/dataTables/dataTables.responsive.js',
                'styles/js/plugins/dataTables/dataTables.tableTools.min.js'
            );
                
            array_push($css_loader, 
                'styles/css/plugins/dataTables/dataTables.bootstrap.css',
                'styles/css/plugins/dataTables/dataTables.responsive.css',
                'styles/css/plugins/dataTables/dataTables.tableTools.min.css'        
            );        
            
            $othersJs = "<script>
                $(document).ready(function() {
                    $('.dataTables-example').DataTable();                        
                    var oTable = $('#editable').DataTable();            
                });        
            </script>";  
            
        }
        
        private function gen_reins_num($dan)
        {
            $q = $this->db->Select("select SEQ_REINS_CONTRACT_NUM.nextval ns from dual");
            
            $ds = date('Ymd', strtotime(trim($dan)));
            $cn = 'RE/'.$ds.'/F/'.$q[0]['NS'];
            echo trim($cn);
            exit;
        }
        
        private function contr_num($dan)
        {
            $cn = '';
            $i = 0;
            foreach($dan as $k=>$v){
                if($i > 0){$cn .= ',';}
                $cn .= $v;  
                $i++;          
            }
               
            $sql = "
            select    
                d.contract_num, 
                fond_name(d.id_insur) strahovatel,
                case 
                    when d.vid = 1 then d.pay_sum_p
                    else D.SUM_VOZVR                    
                end pay_sum_p, 
                d.cnct_id, 
                substr(d.PERIODICH, 1, 1) PR, 
                substr(d.PERIODICH, 2) PERIODICH, 
                case 
                    when d.vid = 1 then d.PAY_SUM_V                    
                    else D.PAY_SUM_V -
                nvl( 
                    (select pay_sum_v from contracts where cnct_id = (select max(cnct_id) from contracts where cnct_id < d.cnct_id and id_head = (select id_head from contracts where cnct_id = d.cnct_id))
                    ),
                    (select pay_sum_v from contracts where cnct_id = d.id_head)
                   ) 
                 end pay_sum_v, 
                dbms_random.random||'tst' reins_contr_num 
            from 
                contracts d 
            where 
                d.cnct_id in($cn)
                and d.state in(12, 32)";
            /*
            else D.pay_sum_p -
                nvl( 
                    (select pay_sum_p from contracts where cnct_id = (select max(cnct_id) from contracts where cnct_id < d.cnct_id and id_head = (select id_head from contracts where cnct_id = d.cnct_id))
                    ),
                    (select pay_sum_p from contracts where cnct_id = d.id_head)
                   ) 
            */
            //echo $sql;            
            $this->dan = $this->db->Select($sql);
            
            $r = $this->db->Select("select * from dic_reinsurance where id = ".$_POST['reins_name']);            
            $this->list_reins = $r[0];//['R_NAME'];
            
        }
        
        private function proc($dan)
        {
            $this->dan['proc'] = $dan;            
        }
        
        private function reins_transh($dan)
        {            
            $cnct = $dan['id'];
            $proc = $dan['proc'];
            
            $qs = $this->db->Select("select vid from contracts where cnct_id = $cnct union all select vid from contracts_maket where cnct_id = $cnct");            
            
            $html = '';
            $qst = $this->db->Select('select count(*) c from transh where cnct_id = 72556 and date_f is null');
            if($qst[0]['C'] !== '0'){
                $sql = "select round(pay_sum * ($proc / 100), 2) ps, date_pl  from transh where cnct_id = $cnct and date_f is null order by date_pl";    
                $q = $this->db->Select($sql);
            
                $html .= '<table border="1" width="100%">';
                $i = 0;
                foreach($q as $k=>$v){
                    if($i == 0){
                        $first = $v['PS'];
                    }                
                    $html .= '<tr style="text-align: center;border-bottom: solid 0px;"><td>'.$v['DATE_PL'].'</td></tr>
                    <tr style="text-align: center;"><td>'.$v['PS'].'</td></tr>';                
                    $i++;
                }
                
                $html .= "</table>";       
                if($qs[0]['VID'] == '1'){
                    $ss = $this->db->Select("select sum(round(pay_sum * ($proc / 100), 2)) ps  from transh where cnct_id = $cnct and date_f is not null");
                    $first = $ss[0]['PS'];
                }
                
                $html .= "<script>$('#$cnct.prs_prem_opls').html('$first');</script>";                     
            }
                       
            echo $html;
            exit;
        }
        
        private function save_reins_contr_num($dan)
        {     
            $id_head = $this->array['id_head'];                        
            //Сначала делаем проверку чтобы в процентах не было нулей             
            foreach($dan as $k=>$v){    
                $cnct = $v['cnct_id'];
                $q = $this->db->Select("select fond_name(id_insur) c, vid from contracts where cnct_id = $cnct");                
                foreach($v as $t=>$d){
                    if(($d == '0') and ($q[0]['VID'] !== '2')){                        
                        echo ALERTS::ErrorMin('Выбраннные вами данные не могут равняться нулю(0) или пустому значению! Проверьте страхователя - <b>'.$q[0]['C'].'</b>');
                        exit;
                    }                     
                }                                
            }
                                    
            $q = $this->db->Select("select SEQ_BORDERO_CONTRACTS.nextval id from dual");
            $id_contracts = $q[0]['ID'];
            
            $dsp = $dan[0];
                   
            global $active_user_dan;
                                    
            //Сохраняем данные
            foreach($dan as $k=>$v){                
                $cn = $this->db->Select("select * from contracts where cnct_id = ".$v['cnct_id']);
                                
                $contract = $cn[0];
                $sql = "begin 
                    card.new_reinsurance(
                        0,
                        '".$v['cnct_id']."',
                        '".$contract['ID_HEAD']."',
                        '".$contract['PAY_SUM_V']."',
                        '".$contract['PAY_SUM_P']."',
                        '".$v['reins_id']."',
                        '".$v['vid']."',
                        '".$v['contract_num']."',
                        '".$v['contract_date']."',
                        '".$contract['DATE_BEGIN']."',
                        '".$contract['DATE_END']."',
                        ".$v['reins_proc'].",
                        ".$v['reins_prem_proc'].",
                        0,
                        ".str_replace(',', '.', $v['reins_summa']).",
                        ".str_replace(',', '.',$v['reins_prem_summa']).",
                        '".$v['skidka']."',
                        '',
                        '',
                        '',
                        '',
                        ''                                                
                    );
                end;";  
                
                //echo $sql."<br />-------------------------------------------------<br />";                
                if($this->db->Execute($sql) !== true){
                    echo ALERTS::ErrorMin($this->db->message.'<br />'.$sql.'<br />');
                    exit;
                }
                
                //R.SUM_P_STRAH,
                $qs = $this->db->Select("
                select                    
                    case 
                        when d.vid = 1 then 
                            case when (select count(*) from transh where cnct_id = d.cnct_id) > 0 then 
                              round((select PAY_SUM from transh where cnct_id = d.cnct_id and nom = 1) * (R.PERC_P_STRAH / 100), 2)
                            else
                              R.SUM_P_STRAH 
                            end
                    else
                      R.SUM_P_STRAH 
                    end SUM_P_STRAH,
                    round(
                        case 
                        when d.vid = 1 then d.pay_sum_p 
                        else D.SUM_VOZVR
                        end * (R.PERC_P_STRAH / 100)
                    , 2) pay_sum,
                    r.sum_s_strah
                from 
                    contracts d,         
                    reinsurance r                
                where
                    r.cnct_id = d.cnct_id
                    AND R.CNCT_ID = ".$v['cnct_id']
                );
                
                $sql_list = "insert into bordero_contracts_list(ID, ID_CONTRACTS, CNCT_ID, PAY_SUM, PAY_SUM_OPL, sum_s_strah) 
                values(
                seq_bordero_contract_list.nextval, 
                $id_contracts, 
                ".$v['cnct_id'].", 
                '".$qs[0]['PAY_SUM']."', 
                '".$qs[0]['SUM_P_STRAH']."',
                '".$qs[0]['SUM_S_STRAH']."')";
                
                $this->db->Execute($sql_list);
                
                                
                $tr = $this->db->Select("select P.ID_TRUNSH, T.PAY_SUM from bordero_contracts bc, bordero_contracts_list bl, transh t, plat_to_1c p, 
                contracts d where bl.id_contracts = bc.id and d.cnct_id = bl.cnct_id and p.cnct_id = t.cnct_id and P.ID_TRUNSH = T.ID
                and bl.cnct_id = t.cnct_id and bc.typ = 2 and P.PAY_SUM_D <> 0 and d.cnct_id = ".$v['cnct_id']."
                and t.id not in(select id_transh from BORDERO_CONTRACTS_TRANSH_OWN union all select id_transh from bordero_contracts_transh) ");
                
                if(count($tr) > 0){
                    foreach($tr as $t=>$r){
                        $this->db->Execute("INSERT INTO BORDERO_CONTRACTS_TRANSH (ID, ID_CONTRACTS, CNCT_ID, ID_TRANSH, PAY_SUM)
                        VALUES (SEQ_BORDERO_CONTRACTS_TRANSH.nextval, $id_contracts, ".$v['cnct_id'].", ".$r["ID_TRANSH"].", ".$r["PAY_SUM"]." )");
                    }                  
                }                                
            }
            
            //Сохраняем в таблицу bordero_contracts
            $DDS = $this->db->Select("select sum(pay_sum) pay_sum, sum(pay_sum_opl) pay_sum_opl, SUM(sum_s_strah) sum_s_strah 
            from bordero_contracts_list where id_contracts = $id_contracts");
            
            $pay_sum = $DDS[0]['PAY_SUM'];
            $pay_sum_OPL = $DDS[0]['PAY_SUM_OPL'];
            $SUM_S_STAH = $DDS[0]['SUM_S_STRAH'];
            
            $sql_bordero = "insert into bordero_contracts
            (ID, CONTRACT_NUM, CONTRACT_DATE, EMP_ID, DATE_CREATE, PAY_SUM, PAY_SUM_OPL, STATE, ID_REINS, OTPR, TYP, SUM_S_STRAH) values
            ($id_contracts, 
            '".$dsp['contract_num']."', 
            '".$dsp['contract_date']."', 
            '".$active_user_dan['emp']."', 
            sysdate,             
            '$pay_sum',
            '$pay_sum_OPL',             
            0, 
            '".$dsp['reins_id']."', 0, 2, '$SUM_S_STAH')";                                    
            $this->db->Execute($sql_bordero);            
            
            
            if(trim($this->message) == ''){
                $s = '<a target="_blank" href="reins_export?contract_num='.$id_contracts.'&&export=xls"><i class="fa fa-2x fa-file-excel-o"></i> Excel</a>';
                $s .= '<a target="_blank" style="margin-left: 15px;" href="reins_export?contract_num='.$id_contracts.'&&export=pdf"><i class="fa fa-2x fa-file-pdf-o"></i> PDF</a>';
                $js = "$('.ibox-footer').html('$s');"; 
                echo "<script>alert('Данные сохранены успешно!<br />Выберите формат для экспорта данных<br />".'<p style="margin-top: 15px;">'."$s</p>');$js</script>";
            }else{
                echo ALERTS::ErrorMin($this->message);
            }
                                    
            exit;
        }
        
        private function own_cnct($dan)
        {
            foreach($dan as $k=>$v){
                if(!$this->db->Execute("insert into REINSURANCE_OWN (cnct_id, date_add) values ($v, sysdate)")){
                    $this->message .= 'Ошибка #1. Обратитесь в ДИТ';
                }
            }            
            echo $this->message;
            exit;
        }
        
        private function list_contracts()
        {            
            $filter = '';
            if(isset($this->date_begin)){
                if($this->date_begin !== ''){
                    $filter = ' and b.CONTRACT_DATE';
                }
                
                if(isset($this->date_end)){
                    if($this->date_end  !== ''){
                        $filter .= " between to_date('$this->date_begin', 'dd.mm.yyyy') and to_date('$this->date_end', 'dd.mm.yyyy')";
                    }
                }
            }
            if(isset($this->state_f)){
                if($this->state_f !== ''){
                    $filter .= " and b.state = $this->state_f";
                }
            }
            
            if(isset($this->vid)){
                $filter .= " and b.id_head is $this->vid null";                
            }
                              
            if($filter == ''){
                $filter .= " and B.CONTRACT_DATE between ADD_MONTHS(sysdate, -1) and sysdate";
            }
            
            $sql = "
            select 
                B.ID, 
                B.CONTRACT_NUM, 
                B.CONTRACT_DATE,
                (select sum(L.PAY_SUM) from bordero_contracts_list l where L.ID_CONTRACTS = b.id) pay_sum,
                (select count(*) from bordero_contracts_list l where L.ID_CONTRACTS = b.id) cnt,
                b.state,
                state_name_bordero(b.state) state_name,
                b.note,
                b.id_head,
                case 
                  when id_head is not null then
                    (select contract_num from bordero_contracts where id = b.id_head)
                  else null
                end main_dog,                  
                'Факультатив пропорциональный' type     
            from 
                bordero_contracts b where B.TYP in(2, 3) $filter
            order by to_date(B.CONTRACT_DATE, 'dd.mm.yyyy')";
            
            
            $ldan = $this->db->Select($sql);            
            $dan = array();
            foreach($ldan as $k=>$v){
                $sql = "select 
                    r.id,
                    DR.R_NAME name,
                    fond_name(d.id_insur) strah_name,    
                    o.cnct_id,
                    d.contract_num contract_num_dogovor,
                    R.CONTRACT_NUM,
                    R.CONTRACT_DATE,
                    bl.pay_sum,
                    bl.pay_sum_opl,
                    reins_type_name(r.vid) type
                from bordero_contracts_list bl, osns_calc o, reinsurance r, dic_reinsurance dr, contracts d
                where o.cnct_id = bl.cnct_id
                and d.cnct_id = o.cnct_id
                and r.cnct_id = o.cnct_id
                and O.REINS_ID = DR.ID  
                and BL.ID_CONTRACTS = ".$v['ID'];
                $q = $this->db->Select($sql);
                $dan[$k] = $ldan[$k];
                $dan[$k]['lists'] = $q;
            }            
            $this->dan['list_contracts'] = $dan;
            $this->dan['list_states'] = $this->db->Select("select id, id||' - '||name name from bordero_state order by id");
            $this->dan['filter'] = $filter;
        }
        
        private function form_setstate($id)
        {
            
            if($id == ''){exit;}            
            
            $qs = $this->db->Select("select typ from bordero_contracts where id = $id");            
            $typ = $qs[0]['TYP'];
            
            $this->html = '';
            
            $email = trim($_SESSION[USER_SESSION]['login'])."@gak.kz";            
            
            $sql = "select S.ID, S.JOB_SP, S.JOB_POSITION from SUP_PERSON s, DIC_DEPARTMENT d, DIC_DOLZH z
            where S.JOB_SP = D.ID and S.JOB_POSITION =  Z.ID and S.EMAIL = '$email' and s.date_layoff is null";
            //echo $sql;
            $db = new DB();                        
            $dsp = $db->Select($sql);            
                                                
            $dep = $dsp[0]['JOB_SP']; //Департамент
            $dolzh = $dsp[0]['JOB_POSITION']; //Должность                                    
            
            $s = $this->db->Select("select b.*, emp_name(b.emp_id) empname, state_name_bordero(b.state) state_name, reins_name(b.id_reins) reinsname, 
            (select count(*) from BORDERO_CONTRACTS_LIST where id_contracts = b.id) cn_count from BORDERO_CONTRACTS b where b.id = $id");
            //echo $this->db->sql;
                        
            $v = $s[0];
            $state = $v['STATE'];
            
            $btn_set_state = 'set_note';
                        
            if($state == 2){$btn_set_state = 'set_note_rasp';}            
            if($state == 14){$btn_set_state = 'set_note_rasp';}
            
            $this->html .= '<div class="col-lg-6 well">';
            $this->html .= '<p><b>№ договора: </b>'.$v['CONTRACT_NUM'].'</p>';
            $this->html .= '<p><b>Дата договора: </b>'.$v['CONTRACT_DATE'].'</p>';
            $this->html .= '<p><b>Перестраховщик: </b>'.$v['REINSNAME'].'</p>';
            $this->html .= '<p><b>№ распоряжения: </b>'.$v['NUM_RASP'].'</p>';
            $this->html .= '<p><b>Дата распоряжения: </b>'.$v['DATE_RASP'].'</p>';
            $this->html .= '</div>';
            $this->html .= '<div class="col-lg-6 well">';
            $this->html .= '<p><b>Количество договоров: </b>'.$v['CN_COUNT'].'</p>';
            $this->html .= '<p><b>Страховая сумма: </b>'.$v['PAY_SUM'].'</p>';            
            $this->html .= '<p><b>Статус: </b>'.$v['STATE_NAME'].'</p>';
            $this->html .= '<p><b>№ счета: </b><a href="ftp://upload:Astana2014@192.168.5.2/'.$v['FILE_SCHET'].'" target="_blank" download>'.$v['NUM_SCHET'].'</a></p>';
            $this->html .= '<p><b>Дата счета: </b>'.$v['DATE_SCHET'].'</p>';
            $this->html .= '</div>';
            
            $this->html .= '<div class="col-lg-12">';
            $q = $this->db->Select("select * from BORDERO_STATE_PROC where DEPARTMENT_BEGIN = $dep and DOLZH_BEGIN = $dolzh and state_begin = $state order by TYPE_BTN");
            //echo $this->db->sql;
                        
            if(count($q) == 0){                
                $this->html .= '<label class="label-danger">Вы не можете утверждать или отклонять данный договор.</label>';
            }else{
                $q = $this->db->Select("select * from BORDERO_STATE_PROC where state_begin = $state order by TYPE_BTN");
                foreach($q as $k=>$t){   
                    $btn = 'btn-info';
                    $text = 'Утвердить';                
                    if($t['TYPE_BTN'] == 1){
                        $btn = 'btn-danger';
                        $text = 'Отклонить';                    
                    }                                
                    
                    $this->html .= '<button class="btn '.$btn.' btn-sm hts set_note pull-left" data-toggle="modal" data-target="#'.$btn_set_state.'" id="'.$id.'" data="'.$t['TYPE_BTN'].'">'.$text.'</button> ';
                }    
            }
            
            
            $this->html .= '<div class="pull-right">
                                <a href="reins_export?contract_num='.$id.'&&export=html" target="_blank" class="btn btn-default"><i class="fa fa-2x fa-html5"></i></a>                                
                                <a href="reins_export?contract_num='.$id.'&&export=pdf" target="_blank" class="btn btn-default"><i class="fa fa-2x fa-file-pdf-o"></i></a>
                                <a href="reins_export?contract_num='.$id.'&&export=xls" target="_blank" class="btn btn-default"><i class="fa fa-2x fa-file-excel-o"></i></a>
                            </div>';
                            
            $this->html .= '</div>';   
            
            $this->html .= '<div style="height: 600px;overflow: auto;float: left;width: 100%;">';
            if($typ == '3'){
                $this->html .= $this->contract_num_transh($id);
            }else{
                $this->html .= $this->contract_num($v['CONTRACT_NUM']);    
            }                        
            $this->html .= '</div>';                                
        }         
        
        private function contract_num_transh($id)
        {
            $html = '<table class="table table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>  
                            <th>№ п\п</th>                          
                            <th>№ договора</th>
                            <th>№ договора перестрахования</th>
                            <th>Дата договора</th>
                            <th>Наименование</th>
                            <th>№ транша</th>
                            <th>Сумма начисления</th>                            
                            <th>Сумма к оплате</th>                            
                        </tr>
                    </thead>
                    <tbody>';
                    
            $dan = $this->db->Select("
            select 
                r.id,
                DR.R_NAME name,
                fond_name(d.id_insur) STRAHOVATEL,    
                o.cnct_id,
                d.contract_num CONTRACT_NUM_OSN,
                R.CONTRACT_NUM,
                R.CONTRACT_DATE,
                tr.nom,
                bl.pay_sum,
                bl.pay_sum_opl,
                reins_type_name(r.vid) type
            from 
                bordero_contracts_list bl, 
                osns_calc o, 
                reinsurance r, 
                dic_reinsurance dr, 
                contracts d,
                transh tr
            where 
                o.cnct_id = bl.cnct_id
                and d.cnct_id = o.cnct_id
                and r.cnct_id = o.cnct_id
                and O.REINS_ID = DR.ID
                and tr.cnct_id = d.cnct_id
                and tr.id = bl.id_transh
                and BL.ID_CONTRACTS = $id");
                                              
            $i = 1;                                                  
            foreach($dan as $k=>$v){
                $html .= '<tr data="'.$v['CNCT_ID'].'">
                    <td><center>'.$i.'</center></td>
                    <td>'.$v['CONTRACT_NUM_OSN'].'</a></td>
                    <td>'.$v['CONTRACT_NUM'].'</a></td>                    
                    <td>'.$v['CONTRACT_DATE'].'</td>
                    <td>'.$v['STRAHOVATEL'].'</td>
                    <td>'.$v['NOM'].'</td>
                    <td>'.$v['PAY_SUM'].'</td>                                
                    <td>'.$v['PAY_SUM_OPL'].'</td>                        
                </tr>';
                $i++;
            }
            $html .= '</tbody></table>';
            return $html;
        }       
        
        private function contract_num($dan)
        {
            $sql = "
            select 
                rownum,
                d.contract_num, 
                'Новый' status_reins, 
                C.NAME,
                C.BIN,
                branch_name(d.branch_id) region,
                case 
                  when d.vid = 1 then d.contract_date 
                  else (select contract_date from contracts where cnct_id = d.id_head)
                end contract_date,
                O.RISK_ID,
                d.date_begin,
                d.date_end,
                nvl(R.DATE_BEGIN, d.date_begin) reins_DATE_BEGIN, 
                nvl(R.DATE_end, d.date_end) reins_DATE_end,
                case
                  when nvl((select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id), 0) = 0 then  O.CNT_AUP+O.CNT_PP+o.CNT_VP 
                  else (select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id)
                end cnt,
                d.pay_sum_v,
                A.TARIF,
                R.PERC_S_GAK,
                R.SUM_S_GAK,
                R.PERC_S_STRAH,
                R.SUM_S_STRAH,
                D.PAY_SUM_P,
                R.PERC_P_STRAH,
                R.SUM_P_STRAH_all,
                R.SUM_P_STRAH SUM_P_STRAHs,
                trim(substr(D.PERIODICH, 2)) PERIODICH,
                reins_transh_html(d.cnct_id, r.PERC_P_STRAH) primechanie
            from 
                REINSURANCE r, 
                contracts d,
                contr_agents c,
                osns_calc o,
                DIC_OKED_AFN a 
            where  
                d.cnct_id = r.cnct_id
                and A.ID = D.OKED_ID
                and o.cnct_id = d.cnct_id 
                and R.CONTRACT_NUM = '$dan'
                and C.ID = d.id_insur
                and d.state <> 13";
            
            if(isset($_GET['cnct_id'])){
                $sql .= " and d.cnct_id = ".$_GET['cnct_id'];
            }
            
            $q = $this->db->Select($sql);
            $this->q_dan1 = $q;
            
            $html = '';
            $html .= '<style type="text/css">        
            table {
                width: 100%;
                border-collapse: collapse;                
            }
            table, td, th {
                border: 1px solid black;                
                font-size: 10px;
                font-family: "Times New Roman";                
            }
            
            td, th{
                padding-left: 5px;
                padding-right: 5px;
            }
            th{
                background-color: #F5F5F6;
            }            
            </style>';
                        
            $html .= '<div style="float: left; width: 100%;"><table border="1"><thead>
                        <tr>
                            <th rowspan="2">№</th>
                            <th rowspan="2">№ договора страхования</th>                            
                            <th rowspan="2">Статус бизнеса</th>
                            <th rowspan="2">Страхователь</th>
                            <th rowspan="2">БИН</th>
                            <th rowspan="2">Регион Страхователя</th>
                            <th rowspan="2">Дата заключения основного договора</th>
                            <th rowspan="2">Класс профессионального риска</th>
                            <th rowspan="2">Начало действия договора страхования</th>
                            <th rowspan="2">Окончание действия договора страхования</th>
                            <th rowspan="2">Начало действия периода перестрахования</th>
                            <th rowspan="2">Окончание действия перестрахования</th>
                            <th rowspan="2">Количество работников</th>                            
                            <th rowspan="2">Страховая сумма</th>
                            <th rowspan="2">Оригинальный страховой тариф</th>                            
                            <th colspan="2">Собственное удержание </th>
                            <th colspan="2">Ответственность перестраховщика</th>
                            <th rowspan="2">Страховая премия по договору</th>
                            <th colspan="2">Перестраховочная премия</th>
                            <th rowspan="2">Перестраховочная премия к оплате</th>
                            <th rowspan="2">Условия оплаты страховой премии</th>
                            <th rowspan="2">Примечание</th>
                        </tr>
                        <tr>                                                        
                            <th>%</th>
                            <th>Сумма</th>
                            <th>%</th>
                            <th>Сумма</th>                            
                            <th>%</th>
                            <th>Сумма</th>                                                                                    
                        </tr>
                    </thead>
                    <tbody>';
            foreach($q as $k=>$v)
            {
                $html .= '<tr>';
                foreach($v as $i=>$d)
                {                     
                    if(substr($d, 0, 1) == ','){
                        $html .= '<td><center>0'.$d.'</center></td>';
                    }elseif(substr($d, 0, 1) == '.'){
                        $html .= '<td><center>0'.$d.'</center></td>';
                    }else{
                        $html .= '<td><center>'.$d.'</center></td>';    
                    }
                }
                $html .= '</tr>';
            }
            
            $ds = $this->db->Select("select 
                sum(case when nvl((select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id), 0) = 0 then  O.CNT_AUP+O.CNT_PP+o.CNT_VP else (select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id) end) cnt,
                sum(d.pay_sum_v) pay_sum_v,
                null TARIF,
                null PERC_S_GAK,
                sum(R.SUM_S_GAK) SUM_S_GAK,
                null PERC_S_STRAH,
                sum(R.SUM_S_STRAH) SUM_S_STRAH,
                sum(D.PAY_SUM_P) PAY_SUM_P,
                null PERC_P_STRAH,
                sum(R.SUM_P_STRAH_all) SUM_P_STRAH,
                sum(R.SUM_P_STRAH) SUM_P_STRAHs,
                null PERIODICH,
                null primechanie
            from 
                REINSURANCE r, 
                contracts d,
                contr_agents c,
                osns_calc o,
                DIC_OKED_AFN a 
            where  
                d.cnct_id = r.cnct_id
                and A.ID = D.OKED_ID
                and o.cnct_id = d.cnct_id 
                and R.CONTRACT_NUM = '$dan'
                and C.ID = d.id_insur
                and d.state <> 13");
                
            $this->q_dan2 = $ds;
            
            foreach($ds as $k=>$v){
                $html .= '<tr>
                    <td colspan="11"></td>
                    <td><center>Итого:</center></td>';
                foreach($v as $i=>$d){
                    $html .= '<td><center>'.$d.'</center></td>';
                }
                
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';                        
            return $html;
        }
        
        
        private function send_replace($id)
        {
            $q = $this->db->Select("select * from BORDERO_STATE_PROC where state_end = (select state from BORDERO_CONTRACTS where id = $id)");            
            $id_pers = $q[0]['DOLZH_END'];
                        
            $sql = "select s.lastname||' '||s.firstname||' '||s.middlename fio, S.ID, S.JOB_SP, S.JOB_POSITION, S.EMAIL from SUP_PERSON s, DIC_DEPARTMENT d, DIC_DOLZH z
            where S.JOB_SP = D.ID and S.JOB_POSITION =  Z.ID and s.date_layoff is null and S.JOB_POSITION = $id_pers";  
                                             
            $db = new DB();                        
            $dsp = $db->Select($sql);            
            
            require_once 'methods/xmpp.php';
            $j = new JABBER();
            $message_send = "Повторное уведомление для утверждения договора по перестрахованию - http://192.168.5.244/reins_fakultativ?form_setstate=$id";
            
            $users = '';
             
            foreach($dsp as $k=>$v){                
                $j->send_message($v['EMAIL'], $message_send);
                $users .= $v['FIO']." ";    
            }
            echo 'Повторное уведомление отправлено '.$users; 
            exit;
        }
        
        private function set_state($id)
        {
            //$mail = new MAIL();            
            //sendmail('a.saleev@gak.kz', 'test', '<b>HELLO</b>');
            
            $type = $this->array['type']; //Кнопка нажатия 0 - утвердить 1 - отклонить
            $note = $this->array['note']; //Примечание
            $email = trim($_SESSION[USER_SESSION]['login'])."@gak.kz"; //Эмаил текущего пользователя
            
            //Узнаем статус договора бордеро
            $q = $this->db->Select("select state from bordero_contracts where id = $id");
            $state = $q[0]['STATE'];
            
            //Данный блог при переходе на другую базу переделать
            $sql = "select S.ID, S.JOB_SP, S.JOB_POSITION from SUP_PERSON s, DIC_DEPARTMENT d, DIC_DOLZH z
            where S.JOB_SP = D.ID and S.JOB_POSITION =  Z.ID and S.EMAIL = '$email' and s.date_layoff is null";  
                                             
            $db = new DB();                        
            $dsp = $db->Select($sql);
                        
            
            $dep = $dsp[0]['JOB_SP']; //Департамент
            $dolzh = $dsp[0]['JOB_POSITION']; //Должность                        
            
            $sql = "select * from BORDERO_STATE_PROC where state_begin = $state and DEPARTMENT_BEGIN = $dep and type_btn = $type";            
                       
            $q = $this->db->Select($sql);
            
                                    
            if(count($q) == 0){
                echo 'Вы не можете Утверждать или Отклонять данный договор<br />';
                exit;
            }
            
            $dan = $q[0];
            $new_state = $dan['STATE_END'];     
            
            if($new_state !== "8"){
                if(trim($dan['DOLZH_BEGIN']) !== ''){
                    if(trim($dan['DOLZH_BEGIN']) !== $dolzh){
                        echo 'Ошибка! Вы не можете Утверждать или Отклонять данный договор';
                        exit;
                    }
                }
            }
            //Если поле процедура не пустая тогда выполняем ее 
            //Во все процедуры необходиом завязать только ID контракта и все
            
            if(trim($q[0]['FUNCT_PROV']) !== ''){                
                $proc = $q[0]['FUNCT_PROV'];
                if(!$this->db->Execute("begin $proc($id); end;")){
                    echo $this->db->message;
                    exit;   
                }
            }                        
            
            $this->db->Execute("
                insert into bordero_contracts_arc 
                select * from bordero_contracts where id = $id
            ");
            
            //$this->db->Execute("INSERT INTO SIAP_ACT_PRT (ACTP_ID, SICID, RFBN_ID, EMP_ID, ACT_ID, CNCT_ID, DATE_OP, NOTES, DATE_CALC, IP_PC) 
            //VALUES ( /* ACTP_ID */, /* SICID */, /* RFBN_ID */, /* EMP_ID */, /* ACT_ID */, /* CNCT_ID */, /* DATE_OP */, /* NOTES */, /* DATE_CALC */, /* IP_PC */ )");
                        
                   
            $sql = "update bordero_contracts set state = $new_state, note = '$note' where id = $id";
            $b = $this->db->Execute($sql);
            if($b !== true){
                echo $b;
            }     
            
            //Узнаем текст статуса
            $st = $this->db->Select("select name from bordero_state where id = $new_state");
            $state_text = $st[0]['NAME'];
            
            $message_send = "Для согласования договора по перестрахованию бордеро. Статус $state_text; http://192.168.5.9/reins_bordero?form_setstate=$id";
            //Узнаем кто Должен следующий утверждать
            
            if($new_state !== "8"){
                $next_depart = $q[0]['DEPARTMENT_END'];
                $next_dolzh = $q[0]['DOLZH_END'];    
            }else{
                $message_send = $state_text." - http://192.168.5.244/reins_fakultativ?form_setstate=$id";
                $next_depart = '13';
                $next_dolzh = '50';
            }
            
            //Находим пользователей в департаменте по должности
            if(trim($next_dolzh) !== ''){
                $ss = "and JOB_POSITION = $next_dolzh";
            }
            
            $q = $db->Select("select EMAIL from SUP_PERSON where JOB_SP = $next_depart $ss");
            //Отправляем сообщение по пандиону 
                                    
            require_once 'methods/xmpp.php';
            $j = new JABBER();
            
            foreach($q as $k=>$v){
                $j->send_message($v['EMAIL'], $message_send);    
            }
                      
            echo '';
            exit;
        }
        
        private function transh()
        {            
            $dan = array();
            $sql = "
            select 
                BC.ID, BC.CONTRACT_NUM, BC.CONTRACT_DATE from bordero_contracts bc, bordero_contracts_list bl, transh t, plat_to_1c p, contracts d
            where
                bl.id_contracts = bc.id
                and d.cnct_id = bl.cnct_id
                and p.cnct_id = t.cnct_id
                and P.ID_TRUNSH = T.ID
                and bl.cnct_id = t.cnct_id
                and P.ID_TRUNSH not in(select id_transh from bordero_contracts_transh)                
            group by BC.ID, BC.CONTRACT_NUM, BC.CONTRACT_DATE
            order by BC.CONTRACT_DATE, BC.CONTRACT_NUM";
            
            $sql = "
            select                 
                D.CNCT_ID,                
                D.CONTRACT_NUM,                
                BC.ID,
                BC.CONTRACT_NUM CONTRACT_NUM_OSN, 
                BC.CONTRACT_DATE, 
                fond_name(D.ID_INSUR) STRAHOVATEL,
                T.NOM, 
                P.ID_TRUNSH, 
                P.PAY_SUM_D,
                P.DATE_DOHOD,
                BRANCH_NAME(D.BRANCH_ID) REGION 
            from 
                bordero_contracts bc, 
                bordero_contracts_list bl, 
                transh t, 
                plat_to_1c p, 
                contracts d
            where
                bl.id_contracts = bc.id
                and d.cnct_id = bl.cnct_id
                and p.cnct_id = t.cnct_id
                and P.ID_TRUNSH = T.ID
                and t.nom <> 1
                and bl.cnct_id = t.cnct_id
                and P.ID_TRUNSH not in(select id_transh from bordero_contracts_transh)                
                and bc.typ = 2
                and P.PAY_SUM_D <> 0
                and t.id not in(select id_transh from BORDERO_CONTRACTS_TRANSH_OWN)
            order by BC.CONTRACT_DATE, BC.CONTRACT_NUM, D.ID_INSUR";
            
            $q = $this->db->Select($sql);
            $this->dan = $q;
        }
        
        private function del_transh($dan)
        {            
            foreach($dan as $k){
                $t = explode("_", $k);
                if(!$this->db->Execute("insert into BORDERO_CONTRACTS_TRANSH_OWN(id_transh) values('$t[2]')")){
                    echo $this->db->message;
                    exit;
                }                
            }  
            echo '';                      
            exit;
        }
        
        private function prov_transh_uved($dan)
        {
            
            if($this->proverkaBlockBase() == false){
                $dan['message'] = "База заблокированна САРиА! <br />Идет расчет резервов";
                echo json_encode($dan);
                exit;
            }
            
            $s = '';
            $i = 0;
            $a = array();
            
            foreach($dan as $k){
                if($i > 0){$s .= ",";}
                $s .= $k;
                $i++;
            }
            $sql = "select 
                b.id_contracts,
                BC.CONTRACT_NUM||'/T' CONTRACT_NUM,
                BC.ID_REINS,
                DR.R_NAME
            from 
                transh t, 
                bordero_contracts_list b,
                bordero_contracts bc,
                dic_reinsurance dr
            where
                b.cnct_id = t.cnct_id
                and bc.id = b.id_contracts
                and DR.ID = BC.ID_REINS
                and T.ID in($s)
                group by b.id_contracts, BC.CONTRACT_NUM, BC.ID_REINS, DR.R_NAME";
                
                
            $sql = "select max(id_contracts) id_contracts, contract_num, id_reins, r_name from( 
            select 
                b.id_contracts, 
                BC.CONTRACT_NUM||case when BC.CONTRACT_NUM like '%/T' then null else '/T' end CONTRACT_NUM, 
                BC.ID_REINS, 
                DR.R_NAME 
            from 
                transh t, 
                bordero_contracts_list b, 
                bordero_contracts bc, 
                dic_reinsurance dr 
            where 
                b.cnct_id = t.cnct_id 
                and bc.id = b.id_contracts 
                and DR.ID = BC.ID_REINS 
                and T.ID in($s) 
                group by b.id_contracts, BC.CONTRACT_NUM, BC.ID_REINS, DR.R_NAME
            ) group by CONTRACT_NUM, ID_REINS, R_NAME";
            $q = $this->db->Select($sql);
            $a = $q[0];
            $a['message'] = '';
            if(count($q) > 1){
                $a['message'] = 'Необходимо выбрать договора и доп соглашения только по 1 договору перестрахования '.$sql;                
            }
                        
            echo json_encode($a);
            exit;
        }
        
        private function bordero_transh_head($dan)
        {   
            $email = $this->array["email"];
            $contract_date = $this->array["contract_date"];
            $contract_num = $this->array["contract_num"];
            $id_reins = $this->array["bordero_transh_id_reins"];
            $id_head = $this->array["bordero_transh_head"];
            
            $transh = $this->array["uved_transh"];
            
            global $active_user_dan;   
            global $msg;
            $EMP_ID = $active_user_dan['emp'];
            
            $s = '';
            $i = 0;            
            foreach($transh as $k){
                if($i > 0){$s .= ",";}
                $s .= $k;
                $i++;
            }
            
            //Задаем ID договора
            $q = $this->db->Select("select SEQ_BORDERO_CONTRACTS.nextval id from dual");
            $id_contracts = $q[0]['ID'];
            
            //Выводим список всех выбранных с суммами
            $sql = "
            select                 
                D.CNCT_ID,                
                D.CONTRACT_NUM,                
                BC.ID,
                BC.CONTRACT_NUM CONTRACT_NUM_OSN, 
                BC.CONTRACT_DATE, 
                fond_name(D.ID_INSUR) STRAHOVATEL,
                T.NOM, 
                P.ID_TRUNSH,                 
                round(P.PAY_SUM_D * (R.PERC_P_STRAH / 100), 2) PAY_SUM_D,
                P.DATE_DOHOD,
                BRANCH_NAME(D.BRANCH_ID) REGION 
            from 
                bordero_contracts bc, 
                bordero_contracts_list bl, 
                transh t, 
                plat_to_1c p, 
                contracts d,
                reinsurance r
            where
                bl.id_contracts = bc.id
                and r.cnct_id = d.cnct_id
                and d.cnct_id = bl.cnct_id
                and p.cnct_id = t.cnct_id
                and P.ID_TRUNSH = T.ID
                and bl.cnct_id = t.cnct_id
                and P.ID_TRUNSH in($s)
                and bc.typ = 2
                and P.PAY_SUM_D <> 0                
            order by BC.CONTRACT_DATE, BC.CONTRACT_NUM, D.ID_INSUR";                         
            $q = $this->db->Select($sql);
            echo $sql."<br />";
                        
            //заносим все данные в таблицу list
            foreach($q as $k=>$v){
                $sql_ins1 = "
                INSERT INTO BORDERO_CONTRACTS_LIST (ID, ID_CONTRACTS, CNCT_ID, PAY_SUM_OPL, ID_TRANSH, SUM_S_STRAH, PAY_SUM) 
                VALUES (seq_bordero_contract_list.nextval, '$id_contracts', '".$v['CNCT_ID']."',
                '".$v['PAY_SUM_D']."','".$v['ID_TRUNSH']."', 0, 0)";
                echo $sql_ins1."<br />";
                
                if(!$this->db->Execute($sql_ins1)){
                    $msg = ALERTS::ErrorMin($this->db->message."<br />".$this->db->sql);
                    return false;
                }
                
                if(!$this->db->Execute("
                INSERT INTO BORDERO_CONTRACTS_TRANSH (ID, ID_CONTRACTS, CNCT_ID, ID_TRANSH, PAY_SUM) 
                VALUES (SEQ_BORDERO_CONTRACTS_TRANSH.nextval, '$id_contracts', '".$v['CNCT_ID']."', 
                '".$v['ID_TRUNSH']."','".$v['PAY_SUM_D']."')
                ")){
                    $msg = ALERTS::ErrorMin($this->db->message."<br />".$this->db->sql);
                    return false;
                }
            }
            
            //Вычесляем общую сумму
            $all_sql = "select sum(round(P.PAY_SUM_D * (R.PERC_P_STRAH / 100), 2)) pay_sum from 
                bordero_contracts bc, bordero_contracts_list bl, transh t, plat_to_1c p, contracts d,
                reinsurance r
            where
                bl.id_contracts = bc.id and d.cnct_id = bl.cnct_id and p.cnct_id = t.cnct_id
                and r.cnct_id = d.cnct_id 
                and P.ID_TRUNSH = T.ID and bl.cnct_id = t.cnct_id
                and P.ID_TRUNSH in($s)
                and bc.typ = 2 and P.PAY_SUM_D <> 0                
                order by BC.CONTRACT_DATE, BC.CONTRACT_NUM, D.ID_INSUR";            
            $all_sum = $this->db->Select($all_sql);
            echo $all_sql."<br />";
                
            $pay_sum = $all_sum[0]['PAY_SUM'];
                        
            
            //Теперь вносим 
            $sql_bordero = "insert into bordero_contracts
            (ID, CONTRACT_NUM, CONTRACT_DATE, SEND_MAIL, EMP_ID, DATE_CREATE, PAY_SUM_OPL, STATE, ID_REINS, OTPR, TYP, SUM_S_STRAH, PAY_SUM) values
            ($id_contracts, '$contract_num', '$contract_date', '$email', '$EMP_ID', sysdate, '$pay_sum', 14, '$id_reins', 0, 3, 0, 0)";
            echo $sql_bordero."<br />";
            if(!$this->db->Execute($sql_bordero)){
                $msg = ALERTS::ErrorMin($this->db->message."<br />".$this->db->sql);
                return false;
            }
            header("Location: reins_fakultativ?transh");
        }
        
        private function proverkaBlockBase()
        {
            $prov = $this->db->Select("select get_block_mode('0701000001') iblock from dual");
            if($prov[0]['IBLOCK'] == '1'){
                return false;
            }
            return true;
        }
        
        private function vozvrat($id)
        {            
            $q = $this->db->Select("select * from BORDERO_CONTRACTS where id = $id");
                        
            $cnct = $this->array['vozvrat_cnct'];
            $contract_num = $this->array['vozvrat_contract_num'];
            $date_contract = $this->array['vozvrat_date_contract'];
            $pay_sum_opl = $this->array['vozvrat_pay_sum_opl'];
            $sum_s_strah = $this->array['vozvrat_sum_s_strah'];            
            $id_reins = $q[0]['ID_REINS'];
            
            $qs = $this->db->Select("select seq_bordero_contracts.nextval ids from dual");
            $id_contract = $qs[0]['IDS'];
            
            $sql = "INSERT INTO BORDERO_CONTRACTS(
              id, 
              contract_num, 
              contract_date, 
              emp_id, 
              date_create,
              pay_sum, 
              state, 
              id_reins, 
              otpr, 
              typ, 
              id_head, 
              pay_sum_opl, 
              sum_s_strah
            ) VALUES(
              $id_contract, 
              '$contract_num', 
              '$date_contract', 
              '".$q[0]['EMP_ID']."', 
              sysdate,
              $pay_sum_opl, 
              0,                
              '$id_reins',
              0, 
              2, 
              '$id', 
              $pay_sum_opl, 
              $sum_s_strah
            )";
            
            if(!$this->db->Execute($sql)){
                echo $this->db->message;                
                exit;
            }
            
            $sql1 = "INSERT INTO BORDERO_CONTRACTS_LIST (ID, ID_CONTRACTS, CNCT_ID, PAY_SUM, PAY_SUM_OPL, SUM_S_STRAH) 
            VALUES (seq_BORDERO_CONTRACT_LIST.nextval, '$id_contract', '$cnct', '$pay_sum_opl', '$pay_sum_opl', '$sum_s_strah')";            
            if(!$this->db->Execute($sql1)){
                $this->db->Execute("delete from BORDERO_CONTRACTS where id = $id_contract");
                echo $this->db->message;                
                exit;
            }
            
            $sql_del_reins = "delete from reinsurance where cnct_id = $cnct";
            if(!$this->db->Execute($sql_del_reins)){
                $this->db->Execute("delete from BORDERO_CONTRACTS where id = $id_contract");
                $this->db->Execute("delete from BORDERO_CONTRACTS_LIST where id = $id_contract");
                echo $this->db->message;                
                exit;
            }
            
            $sql_osns_calc = "update OSNS_CALC set reins_id = 4 where cnct_id = $cnct";
            if(!$this->db->Execute($sql_osns_calc)){
                echo $this->db->message;                
                exit;
            }
            
            echo '';            
            exit;
        }
        
        private function dan_vozvrat($id)
        {            
            $dan = array();
            $cnct = $this->array['cnct_vozvrat'];            
            $q = $this->db->Select("select b.id, b.contract_num, bl.pay_sum_opl, bl.sum_s_strah from BORDERO_CONTRACTS_LIST BL, BORDERO_CONTRACTS B where B.ID = BL.ID_CONTRACTS AND BL.ID_CONTRACTS = $id and BL.CNCT_ID = $cnct");
            echo json_encode($q[0]);
            exit;
        }
        
        private function set_num_rasp($id)
        {
            $rsp = $this->db->ExecuteReturn("begin :irasp_nom := payments.getraspnum('RR_RASP'); end;", array('irasp_nom'));
            $inum_rasp = $rsp['irasp_nom'];                    
                              
            $idate_rasp = $this->array['idate_rasp'];
            $inum_shet = $this->array['inum_shet'];
            $idate_schet = $this->array['idate_schet'];
            $note = $this->array['note'];            
            
            unset($this->array);
            
            $b = true;
            
            if(trim($idate_rasp) == ''){
                $b = false;
                $this->msg .= 'Не задана дата распоряжения';
            }
            
            if($b){
                $fst = '';
                if(isset($_FILES['ischet_fail'])){                    
                    $file = $_FILES['ischet_fail'];
                    if($file['tmp_name'] !== ''){
                        $ftp = new FTP(FTP_SERVER, FTP_USER, FTP_PASS);
                        $s = explode(".", $file['name']);
                        $is = count($s);
                        $file_type = $s[$is-1]; 
                        
                        $files = $id.".".$file_type;
                        $handle = $handle = fopen($file['tmp_name'], 'r');
                        if(!$ftp->uploadfile("reinsurance/shet_opl/", $files, $handle))
                        {                        
                            echo "Ошибка создания файла!";
                        }
                        $fst = 'reinsurance/shet_opl/'.$files;
                    }
                }                                
                
                $sql = "update BORDERO_CONTRACTS set num_rasp = '$inum_rasp', date_rasp = to_date('$idate_rasp', 'dd.mm.yyyy'), 
                num_schet = '$inum_shet', date_schet = to_date('$idate_schet', 'dd.mm.yyyy'), file_schet = '$fst' where id = $id";
                
                if(!$this->db->Execute($sql)){
                    print_r($this->db->message);
                    exit;   
                }               
                
                $this->array['type'] = 0;
                $this->array['note'] = $note;
                 
                $this->set_state($id);                   
                header("Location: reins_fakultativ?form_setstate=$id");
                exit;
            }                            
        }
        
    }