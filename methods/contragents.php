<?php
	class CONTRAGENT
    {
        private $db;
        public $array;
        public $html;
        public $message = '';
        public $dan;
        public $load_page;
        private $role_branch;
        private $role_type;
        private $role_emp;
        private $sql = "SELECT id,
       NAME,
       ( CASE
           WHEN actual = 2 THEN 'Ликвидируемая'
           WHEN actual = 3 THEN 'Ликвидирован'
           ELSE NULL
         END )            rab,
       actual,
       shortname,
       type,
       Typ_name(type)     typ_name,
       rnn,
       bin,
       address,
       chief,
       Reg_name2(reg_id)  reg_name,
       Deyat_name(ved_id) deyat_name,
       mainbk,
       phone,
       sec_econom,
       bank_id,
       p_account,
       reg_id,
       Bank_name(bank_id) bank_name,
       period_dey,
       ved_id,
       osnovanie,
       resident,
       bin,
       name_kaz,
       address_kaz,
       kbe,
       chief_dolzh2,
       chief2,
       chief_dolzh,
       chief_dolzh_kaz,
       osnovanie_kaz,
       group_id,
       country_id,
       natural_person_bool,
       lastname,
       firstname,
       middlename,
       birthdate,
       sex_id,
       doctype,
       docnum,
       docdate,
       docplace,
       oked_id
FROM   contr_agents ";
        
        public function __construct()
        {
            global $active_user_dan;
            $this->role_type = $active_user_dan['role_type'];
            $this->role_branch = $active_user_dan['brid'];
            $this->role_emp = $active_user_dan['emp'];
            
            require_once 'application/units/database3.php';
            $this->db = new DB3();            
            $method = $_SERVER['REQUEST_METHOD'];            
            $this->$method();
            
            $this->page();                        
        }
                
        private function GET()
        {
            if(count($_GET) <= 0){
                $this->dan = array();                
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
                        $this->$k($v); 
                    }
                }
            }            
            $this->GET();             
        }
        
        private function view($id)
        {
            $this->edit($id);
        }
        /**
         * Справочники
        */
        private function kbe($id_res)
        {
            if($id_res == 0){
                $q = $this->db->Select("select CODE, NAME from DIC_ECONOMICS_SECTORS where code <> 0 order by code");
            }else{
                $q = $this->db->Select("select CODE, NAME from DIC_ECONOMICS_SECTORS where CODE_NEREZ is not null order by code");
            }            
            return $q;
        }
        
        private function edit($id)
        {
            $this->dan['OPF'] = $this->db->Select("select id kod, name from DIC_SEGMENT_OPF");
            $this->dan['KATEGORY'] = array(
                array("id"=>"мелкий", "text"=>"мелкий"), 
                array("id"=>"крупный", "text"=>"крупный"),
                array("id"=>"средний", "text"=>"средний")
            ); 
            $this->dan['GROUP_COMPANY'] = $this->db->Select("select * from DIC_GROUP_CONTRAGENTS order by id_group");
            $this->dan['KOD_SECTOR'] = $this->kbe(0);
            
            $this->dan['SVYAZ'] = array("головной офис"=>"головной офис","филиал"=>"филиал","дочка"=>"дочка","внучка"=>"внучка");

            $this->dan['BANKS'] = $this->db->Select("select bank_id kod, name  from dic_banks where status = 0");
            $this->dan['OKED'] = $this->db->Select("select id,name_oked ved_name, oked, risk_id, name,t_min, t_max from dic_oked_afn order by oked");
            $this->dan['OKED_ESBD'] = $this->db->Select("select * from ESBD_ACTIVITYS order by name");
            
            $sql = "select RFBN_ID kod, name from dic_branch where nvl(asko, 0) = ".$this->role_type;
            if($this->role_branch !== '0000'){
                $br = substr($this->role_branch, 0, 2);
                $sql .= " and RFBN_ID like '$br%'";
            }   
            $sql .= " order by 1";                      
            $this->dan['FILIAL'] = $this->db->Select($sql);
            $this->dan['ZAKUP'] = array("конкурс"=>"конкурс","ценовое предложение"=>"ценовое предложение","аукцион"=>"аукцион"); 
            $this->dan['STRANA'] = $this->db->Select("select * from dic_countries_esbd order by id");
            
            if($id == ''){$id = 0;}
            $this->dan['ID'] = $id;
            
            if($id > 0){
                $q = $this->db->Select("select * from contr_agents where id = $id");
                $this->dan['CN'] = $q[0];
                $this->dan['ID'] = $q[0]['ID'];
                                                                  
                $qs = $this->db->Select("
                select 
                    s.*,
                    (select region_name from DIC_SEGMENT_REGION where id = S.REGION_ID) region_name,
                    (select city_name from DIC_SEGMENT_CITY where id_region = S.REGION_ID and id = s.city_id) city_name
                from 
                    segment_insur s 
                where 
                    s.id_insur =  $id");
                $this->dan['SI'] = $qs[0];    
                $ok = $this->db->Select("select * from dic_oked_afn where id = ".$q[0]['OKED_ID']);
                $this->dan['OKED_DAN'] = $ok[0];                          
            }
            $this->dan['PROTOKOL'] = $this->protokol_edit($id);
        }
        
        private function search_post($s)
        {            
            $text = file_get_contents("https://api.post.kz/api/byAddress/$s");
            echo $text;
            exit;
        }
        
        private function search_bin($bin)
        {
            $sql = "select count(*) c from contr_agents where BIN = '$bin'";
            $bin = $this->db->Select($sql);
            echo $bin[0]['C'];
            exit;
        }
        
        private function osn_vid_deyatel($id)
        {
            $q = $this->db->Select("select * from dic_oked_afn where id = $id");            
            echo json_encode($q[0]);
            exit;
        }
        
        private function set_nerez($id)
        {
            $kbe = $this->kbe($id);
            echo json_encode($kbe);
            exit;
        }
        
        private function contragent($st)
        {
            if(trim($st) == ''){
                $this->html = ALERTS::ErrorMin('Поле наименование не может быть пустым');
                return;
            }
            
            $sql = $this->sql." where upper(name) like upper('%".htmlspecialchars($st)."%')";
            if($this->role_type !== '0'){
                $sql .= " and asko = ".$this->role_type;
            }
            $q = $this->db->Select($sql);
            if(count($q) <= 0){
                $this->html = '<div class="text-center ibox-title"><button class="btn btn-warning dim btn-large-dim" type="button"><i class="fa fa-warning"></i></button>
                <h1>Ничего не найдено </h1></div>';
                return;
            }
            
            $this->html = '<div class="ibox-content">                
            <div class="form-horizontal">                    
                <table class="table table-bordered dataTables-example">
                <thead>
                    <tr>
                        <th>Тип контрагента</th>
                        <th>Наименование</th>
                        <th>БИН</th>
                        <th>Адрес</th>
                    </tr>
                </thead>
                <tbody>';
                                 
            foreach($q as $k=>$v){
               $this->html .=  '<tr class="gradeX tableDateContr" data="'.$v['ID'].'">
                        <td>'.$v['TYP_NAME'].'</td>
                        <td>'.$v['NAME'].'</td>
                        <td>'.$v['BIN'].'</td>
                        <td>'.$v['ADDRESS'].'</td>
                    </tr>';
            }    
                        
            $this->html .= '</tbody></table></div></div>';
        }
        
        private function dan_contr($id)
        {            
            $this->sql .= " where id = $id";
            $dan = $this->db->Select($this->sql);                        
            $ok = $this->db->Select("select * from dic_oked_afn where id = ".$dan[0]['OKED_ID']);
            
           
            $sss = '';
            if($this->role_branch !== '0000'){
                $sss = 'and branch_id = '.$this->role_branch;
            }
            
            $contracts = $this->db->Select("
            select 
                cnct_id,
                contract_num, 
                contract_date, 
                state_name(state) state, 
                pay_sum_p, 
                pay_sum_v,
                progr_name(paym_code) progname
            from 
                contracts 
            where id_insur = $id $sss
            union all
            select 
                cnct_id,
                contract_num, 
                contract_date, 
                state_name(state) state, 
                pay_sum_p, 
                pay_sum_v,
                progr_name(paym_code) progname
            from 
                contracts_maket 
            where id_insur = $id $sss");            
            require_once VIEWS.'contragents/view_search.php';          
            //echo VIEWS.'contragents/view_search.php';
            exit;
        }
        
        private function bin($bin)
        {
            if(trim($bin) == ''){
                $this->html = ALERTS::ErrorMin('Поле БИН не может быть пустым');
                return;
            }
            
            $sql = $this->sql." where bin = '".htmlspecialchars($bin)."'";            
            
            if($this->role_type !== '0'){
                $sql .= " and asko = ".$this->role_type;
            }
            $q = $this->db->Select($sql);
            if(count($q) <= 0){
                $this->html = '<div class="text-center ibox-title"><button class="btn btn-warning dim btn-large-dim" type="button"><i class="fa fa-warning"></i></button>
                <h1>Ничего не найдено </h1></div>';                
                return;
            }
            
            $this->html = '<div class="ibox-content">                
            <div class="form-horizontal">                    
                <table class="table table-bordered dataTables-example">
                <thead>
                    <tr>
                        <th>Тип контрагента</th>
                        <th>Наименование</th>
                        <th>БИН</th>
                        <th>Адрес</th>
                    </tr>
                </thead>
                <tbody>';
                                 
            foreach($q as $k=>$v){
               $this->html .=  '<tr class="gradeX tableDateContr" data="'.$v['ID'].'">
                        <td>'.$v['TYP_NAME'].'</td>
                        <td>'.$v['NAME'].'</td>
                        <td>'.$v['BIN'].'</td>
                        <td>'.$v['ADDRESS'].'</td>
                    </tr>';
            }    
                        
            $this->html .= '</tbody></table></div></div>';                        
        }
        
        private function regionid($name)
        {
            $q = $this->db->Select("select * from DIC_SEGMENT_REGION where upper(region_name) like upper('%$name%')");
            if(count($q) > 0){
                return $q[0]['ID'];
            }else{
                $mx = $this->db->Select("select max(id)+1 ids from DIC_SEGMENT_REGION");
                $ids = $mx[0]['IDS'];
                $this->db->Execute("insert into DIC_SEGMENT_REGION(ID, REGION_NAME) values($ids, $name)");
                return $ids;
            }
        }
        
        private function cityid($name, $id_region)
        {
            $q = $this->db->Select("select id kod, city_name name from DIC_SEGMENT_CITY where upper(city_name) like upper('%$name%') id_region = $id_region");
            if(count($q) > 0){
                return $q[0]['ID'];
            }else{
                $this->db->Execute("INSERT INTO DIC_SEGMENT_CITY (ID, CITY_NAME, ID_REGION) 
                VALUES (SEQ_SEGMENT_CITY.nextval, '$name', $id_region)");
                $qs = $this->db->Select("select max(id) id from DIC_SEGMENT_CITY");
                return $qs[0]['ID'];                                
            }
        }
        
        private function save_contr_agents()
        {
            $this->edit_contr_agents();
            if($this->html !== ''){
                global $msg;
                $msg = $this->html;
            }else{
                header("Location: contragents");
                exit;   
            }                        
        }
        
        private function save_contr_agents_edit()
        {
            $ids = $this->edit_contr_agents();
            if($this->html !== ''){
                global $msg;
                $msg = $this->html;
            }else{
                header("Location: contragents?edit=$ids");
                exit;
            }
        }
                
        private function edit_contr_agents()
        {   
            $OPF_ID                 =   $this->array['OPF_ID'];
            $NATURAL_PERSON_BOOL    =   $this->array["NATURAL_PERSON_BOOL"];            
            $LASTNAME               =	htmlspecialchars($this->array['LASTNAME']);
            $FIRSTNAME              = 	htmlspecialchars($this->array['FIRSTNAME']);
            $MIDDLENAME             = 	htmlspecialchars($this->array['MIDDLENAME']); 
            $BIRTHDATE              = 	$this->array['BIRTHDATE']; 
            $SEX_ID                 = 	OnToNumber($this->array['SEX_ID'], 1, 0); 
            $DOCTYPE                = 	$this->array['DOCTYPE']; 
            $DOCNUM                 = 	$this->array['DOCNUM']; 
            $DOCPLACE               = 	htmlspecialchars($this->array['DOCPLACE']); 
            $DOCDATE                = 	$this->array['DOCDATE']; 
            $NAME                   = 	htmlspecialchars($this->array['NAME']); 
            $NAME_KAZ               = 	htmlspecialchars($this->array['NAME_KAZ']); 
            $SHORTNAME              = 	htmlspecialchars($this->array['SHORTNAME']); 
            $TYPE                   = 	$this->array['TYPE']; 
            $RESIDENT               =   OnToNumber($this->dan['RESIDENT'], 1, 2);
            $COUNTRY_ID             = 	$this->array['COUNTRY_ID']; 
            $REGION_NAME            = 	htmlspecialchars($this->array['REGION_NAME']);
            $RAION                  = 	htmlspecialchars($this->array['RAION']);
            $TYPE_CITY              = 	$this->array['TYPE_CITY'];                           //нету параметра 
            $CITY_NAME              = 	$this->array['CITY_NAME'];
            $POSTCODE               = 	$this->array['POSTCODE'];
            $STREET                 = 	htmlspecialchars($this->array['STREET']);
            $HOME_NUM               = 	htmlspecialchars($this->array['HOME_NUM']); 
            $OFICE                  = 	htmlspecialchars($this->array['OFICE']);
            $PHONE                  = 	$this->array['PHONE'];
            $ADDRESS                = 	htmlspecialchars($this->array['ADDRESS']); 
            $ADDRESS_KAZ            = 	htmlspecialchars($this->array['ADDRESS_KAZ']); 
            $BIN                    = 	$this->array['BIN']; 
            $KATEGOR                = 	$this->array['KATEGOR']; 
            $BIN_RASHIFR            = 	htmlspecialchars($this->array['BIN_RASHIFR']); 
            $AFFILIR                = 	$this->array['AFFILIR']; 
            $STRUCTURE              = 	OnToNumber($this->array['STRUCTURE'], 'С', 'Д'); 
            $GROUP_COMPANY          = 	$this->array['GROUP_COMPANY']; 
            $BANK_NAME              = 	$this->array['BANK_NAME']; 
            $P_ACCOUNT              = 	$this->array['P_ACCOUNT']; 
            $NOTE                   = 	htmlspecialchars($this->array['NOTE']); 
            $OKED_ID                = 	$this->array['OKED_ID']; 
            $SEC_ECONOM             = 	$this->array['SEC_ECONOM']; 
            $VED_ID                 = 	$this->array['VED_ID']; 
            $PERIOD_DEY             = 	$this->array['PERIOD_DEY']; 
            $CHIEF                  = 	htmlspecialchars($this->array['CHIEF']); 
            $CHIEF2                 = 	htmlspecialchars($this->array['CHIEF2']);
            $CHIEF_DOLZH            = 	htmlspecialchars($this->array['CHIEF_DOLZH']); 
            $CHIEF_DOLZH2           = 	htmlspecialchars($this->array['CHIEF_DOLZH2']); 
            $CHIEF_DOLZH_KAZ        = 	htmlspecialchars($this->array['CHIEF_DOLZH_KAZ']); 
            $OSNOVANIE_KAZ          = 	htmlspecialchars($this->array['OSNOVANIE_KAZ']); 
            $OSNOVANIE              = 	htmlspecialchars($this->array['OSNOVANIE']); 
            $MAINBK                 = 	$this->array['MAINBK']; 
            $GL_BUH                 = 	htmlspecialchars($this->array['GL_BUH']); 
            $FIRST_RUK              = 	htmlspecialchars($this->array['FIRST_RUK']); 
            $KONTACT_FACE           = 	htmlspecialchars($this->array['KONTACT_FACE']); 
            $BRANCH_ID              = 	$this->array['BRANCH_ID']; 
            $SPOSOB_ZAKUP           = 	$this->array['SPOSOB_ZAKUP']; 
            $DATE_V                 = 	$this->array['DATE_V']; 
            $ID                     = 	$this->array['ID'];                    
                        
            $REGION_ID = $this->regionid($REGION_NAME);
            $CITY_ID - $this->cityid($CITY_NAME, $REGION_ID);
            
            if($BIRTHDATE !== ''){
                if(date("d.m.Y", strtotime($BIRTHDATE)) == '01.01.1970'){
                    $BIRTHDATE = null;
                }else{
                    $BIRTHDATE = date("d.m.Y", strtotime($BIRTHDATE));
                }
            }       
                        
            if($DOCDATE !== ''){
                if(date("d.m.Y", strtotime($DOCDATE)) == '01.01.1970'){
                    $DOCDATE = '';
                }else{
                    $DOCDATE = date("d.m.Y", strtotime($DOCDATE));    
                }            
            }
            if($DATE_V !== ''){
                $DATE_V = date("d.m.Y", strtotime($DATE_V));
            }
            
            $kbe = $RESIDENT.$SEC_ECONOM;
                        
            
            $vid = 'new';   
            if($ID > 0){
                $this->db->Execute("insert into CONTR_AGENTS_ARC select * from CONTR_AGENTS where id = $ID");
                $vid = 'upd';
            }
            
            $sql = "begin
              gak_dict.edit_contr_agent(
                '$vid',
                '$ID',
                '$NAME',
                '$SHORTNAME',
                '$TYPE',
                null,
                '$ADDRESS',
                '$CHIEF',
                '$OSNOVANIE',
                '$MAINBK',
                '$PHONE',
                '$SEC_ECONOM',
                '$BANK_NAME',
                '$P_ACCOUNT',
                null,
                '$PERIOD_DEY',
                '$VED_ID',
                '$RESIDENT',
                '$BIN',
                '$NAME_KAZ',
                '$ADDRESS_KAZ',
                '$kbe',
                '$CHIEF_DOLZH',
                '$CHIEF2',
                '$CHIEF_DOLZH2',
                '$CHIEF_DOLZH_KAZ',
                '$OSNOVANIE_KAZ',
                '$this->role_emp',
                '$GROUP_COMPANY',
                '$COUNTRY_ID',
                '$NATURAL_PERSON_BOOL',
                '$LASTNAME',
                '$FIRSTNAME',
                '$MIDDLENAME',
                '$BIRTHDATE',
                '$SEX_ID',
                '$DOCTYPE',
                '$DOCNUM',
                '$DOCDATE',
                '$DOCPLACE',
                null,
                '$BRANCH_ID',
                0, 
                '$OKED_ID',
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                null,
                null,
                0,
                0,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                '$KATEGOR',
                '$BIN_RASHIFR',
                '$OPF_ID',
                '0',
                '$AFFILIR',
                '$STRUCTURE',
                null,
                '$SPOSOB_ZAKUP',
                '$DATE_V',
                '$REGION_ID',
                '$RAION',
                '$CITY_ID',
                '$STREET',
                '$HOME_NUM',
                '$OFICE',
                '$FIRST_RUK',
                '$GL_BUH',
                '$KONTACT_FACE',
                '0',
                '$this->role_emp',
                '$NOTE',
                '$POSTCODE',
                '$TYPE_CITY'
              );        
            end;";    
                        
            $ds = $db->ExecProc($sql, array());                           
            if(trim($ds['error']) !== ''){
                $this->html = $ds['error'];
            }else{
                if($ID == 0){
                    $q = $this->db->Select("select max(id) id from contr_agents");
                    return $q[0]['ID'];
                }
                return $ID;                                
            }                                    
        }
        
        private function col_meta_name($col_name)
        {
            $qs = $this->db->Select("select id from S_META_TABLES where table_name = 'CONTR_AGENTS'");
            $id_table = $qs[0]['ID'];
            
            $q =  $this->db->Select("select nvl(col_meta, '$col_name') cl from S_META_COLUMNS where id_table = 4 and upper(col_name) = upper('$col_name')");
            return $q[0]['CL'];
        }
        
        private function protokol_edit($id_insur)
        {
            $dan_res[] = array();
            $q = $this->db->Select("
            select d.*, TO_CHAR(m.date_edit, 'DD.MM.YYYY HH24:MI:SS') date_edit, g.name gs_name, G.EMP_ID id_user_create from(
                select c.* from contr_agents c, CONTR_AGENTS_MS m where 
                C.ID = M.ID_INSUR
                and C.MSID  = M.MSID
                and c.id = $id_insur
                union all
                select c.*  from contr_agents_arc c, CONTR_AGENTS_MS m where 
                C.ID = M.ID_INSUR
                and C.MSID  = M.MSID
                and c.id = $id_insur
                ) d, contr_agents_ms m, gs_emp g
                where d.msid = m.msid
                and G.EMP_ID = M.EMP_ID
                and d.id = m.id_insur
                order by d.msid
            ");
            $i = 0;            
            $ds_old = array();
            foreach($q as $k=>$v){                
                if($i > 0){                    
                    foreach($v as $t=>$c){                        
                        if($t !== 'MSID'){
                            if($t !== 'DATE_EDIT'){
                                if($t !== 'GS_NAME'){
                                    if($t !== 'ID_USER_CREATE'){
                                        
                                        if($ds_old[$t] !== $v[$t]){
                                            $dan['col'] = $this->col_meta_name($t)."($t)";
                                            $dan['text'] = $c;
                                            $dan['old_text'] = $ds_old[$t];
                                            $dan['user'] = $v['GS_NAME'];
                                            $dan['user_id'] = $v['ID_USER_CREATE'];
                                            $dan['date'] = $v['DATE_EDIT'];
                                            $dan['id'] = $v['MSID'];
                                            $dan_res[] = $dan;
                                        }
                                        
                                    }
                                }
                            }
                        }                        
                    }                                
                }
                $ds_old = $v;
                $i++;
            }            
            return $dan_res;
        }
        
        private function prov_name($name)
        {
            $ps = explode(' ', $name);
            foreach($ps as $i=>$p){     
                $sql = "select * from DIC_SEGMENT_OPF where upper(name) like upper('%$p%')
                union all
                select * from DIC_SEGMENT_OPF where upper(name_min) like upper('%$p%')
                ";
                $q = $this->db->Select($sql);
                if(count($q) > 0){
                    echo "Слово '$p' не должно присутствовать в полном наименовании клиента"; 
                    exit;        
                }
            }            
            exit;
        }
        
        private function page()
        {
            $this->load_page = 'search';
            if(count($_GET) > 0){
                foreach($_GET as $k=>$v);        
                $this->load_page = $k;
            }
        }
	}
?>