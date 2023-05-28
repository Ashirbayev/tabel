<?php
	class REASON_DOP
    {
        private $db;
        private $array;
        private $method;
        
        public $message;
        public $html;
        public $dan = array();
        public $load_page;
        
        public function __construct()
        {
            $this->db = new DB3();
            $method = $_SERVER['REQUEST_METHOD'];                           
            $this->$method();
        }
        
        private function GET()
        {
            if(count($_GET) <= 0){
                exit;                
            }else{            
                $this->array = $_GET;
                foreach($_GET as $k=>$v);
                if(method_exists($this, $k)){
                    $this->$k($v);               
                }else{
                    echo $k;
                    exit;
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
        
        private function gen_zv_num()
        {
            global $active_user_dan;
            $paym_code = $this->array['paym_code'];
            $branch = $this->array['branch'];
            $role = $active_user_dan['role'];            
            $r = $this->db->Select("select gen_zv_num('$branch', '$paym_code', '$role') cn from dual");        
            echo trim($r[0]['CN']);        
            exit;
        }
        
        private function reason_dop($id)
        {
            $dan = array();
            $cnct = 0;
            if(isset($this->array['cnct_id'])){
                $cnct = $this->array['cnct_id'];
            } 
            
            $q = $this->db->Select("select * from dic_reason_dops where id = $id");
            if($q[0]['VID_DOG'] == '07'){
                $this->load_page = 'osns';
                $this->osns($id, $cnct);
            }
            
        }
        
        private function edit()
        {
            $this->load_page = 'osns';
            global $active_user_dan;
            $cnct = $this->array['CNCT_ID'];
            
            $sql1 = "select 
                d.cnct_id,  
                d.contract_num,              
                d.id_insur,
                fond_name(d.id_insur) strahovatel,
                case                 
                    when d.id_head = 0 then d.cnct_id
                    else d.id_head
                end id_head,
                d.branch_id,
                branch_name(d.branch_id) region,
                d.CONTRACT_TYPE,
                d.paym_code,
                d.sicid_agent,
                d.date_begin,
                d.date_end,
                d.oked_id,
                d.oked,
                d.PERIODICH,
                d.pay_sum_p,
                d.pay_sum_v,
                d.reason_dops reason_dop,
                d.state,
                d.date_calc,
                d.emp_id,
                d.sum_vozvr";
                
            $sql = $sql1." from contracts d where d.cnct_id = $cnct union all ".$sql1." from contracts_maket d where d.cnct_id = $cnct";
            
            $q = $this->db->Select($sql);
            $dan = $q[0];           
            
            $osns_calc = $this->db->Select("select * from osns_calc where cnct_id = $cnct");            
            $dan['osns_calc'] = $osns_calc[0];
                        
            $dan['osns_ns'] = $this->db->Select("select * from osns_ns where cnct_id = $cnct");                        
            
            $dan['osns_calc_new'] = $this->db->Select("select case when o.id_filial = 0 then 'Страхователь' else c.name end name, o.* 
            from osns_calc_new o, CONTR_AGENTS_FILIAL c where o.id_filial = c.id(+) and o.cnct_id = $cnct");
            
            $dan['osns_pril2'] = $this->db->Select("select case when o.id_filial = 0 then 'Страхователь' else c.name end name,
            case when o.id_filial = 0 then (select oked from contracts_maket where cnct_id = o.cnct_id union all select oked from contracts where cnct_id = o.cnct_id)
            else c.oked end oked, 
            o.* 
            from OSNS_PRIL2 o, CONTR_AGENTS_FILIAL c where o.id_filial = c.id(+) and o.cnct_id = $cnct");
            
            $dan['akt1'] = $this->db->Select("select * from OSNS_ACT_N1 where CNCT_ID = $cnct");
            
            $dan['bad_sluch'] = $this->db->Select("select case when o.id_filial = 0 then 'Страхователь' else (select name from CONTR_AGENTS_FILIAL where id = o.id_filial) 
            end name, o.* from OSNS_STAT_ACCIDENT o where o.cnct_id = $cnct");
            
            $dan['transh'] = $this->db->Select("select * from transh where cnct_id = $cnct"); 
              
            
            $dan['list_branch'] = BRANCH::lists($active_user_dan['role_type']); 
            $dan['listPersonKos'] = $this->db->Select("select * from dic_person_kos where BRANCH_ID = ".$active_user_dan['brid']." order by id");                                                    
            $dan['listAgents'] = $this->db->Select("
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS 
                from agents a where a.state = 7 and a.date_close is null and a.vid not in (4, 5) 
                and A.BRANCHID = '".$active_user_dan['brid']."'
                union all 
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS 
                from agents_branch_other b, agents a where a.id = b.id and a.state = 7 and a.vid not in (4, 5) and a.date_close is null and b.branchid = '".$active_user_dan['brid']."'
                union all
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS
                from agents a where a.state = 7 and a.date_close is null and a.vid not in (4, 5) 
                and a.id = 1620
            ");
              
            $ag = $this->db->Select("select 'Договор № '||a.CONTRACT_NUM||' от '||a.CONTRACT_DATE_BEGIN osnovanie, A.PERCENT_OSNS, A.PERCENT, A.PERCENT_OSOR  from agents a where a.id = ".$dan['SICID_AGENT']);
            $dan['agent_dan'] = $ag[0];             
            
            $vid = $this->db->Select("SELECT id, name_oked ved_name, oked, risk_id, NAME, t_min, t_max FROM dic_oked_afn where id = ".$dan['OKED_ID']);
            $dan['osn_vid_deytel'] = $vid[0];
            $dan['vid_deyat'] = $this->db->Select("SELECT id, name_oked ved_name, oked, risk_id, NAME, t_min, t_max FROM dic_oked_afn ORDER  BY oked");
            
            
            $others_params = array();    
            $others_params['ihead'] = $dan['ID_HEAD'];            
            $others_params['icnct'] = $cnct;
            $others_params['ireason_dop'] = $dan['reason_dop'];            
            $others_params['istate'] = $dan['STATE'];
            $others_params['iPAYM_CODE'] = $dan['PAYM_CODE'];                 
            $others_params['iDATE_CALC'] = $dan['DATE_CALC'];       
            $others_params['iEMP_ID'] = $dan['EMP_ID'];
            $others_params['iid_strah'] = $dan['ID_INSUR'];            
                        
            $dan['others'] = $others_params;
            
            $this->dan = $dan;
        }
        
        private function osns($id_reason, $cnct)
        {
            global $active_user_dan;
            if($cnct == 0){
                $ss = "gen_contract_num_dop(d.cnct_id)";
            }else{
                $ss = "d.contract_num";
            }
            
            $sql = "select 
                $cnct cnct_id,  
                $ss contract_num,              
                d.id_insur,
                fond_name(d.id_insur) strahovatel,
                case                 
                    when d.id_head = 0 then d.cnct_id
                    else d.id_head
                end id_head,
                d.branch_id,
                branch_name(d.branch_id) region,
                d.CONTRACT_TYPE,
                d.paym_code,
                d.sicid_agent,
                null date_begin,
                d.date_end,
                d.oked_id,
                d.oked,
                d.PERIODICH,
                d.pay_sum_p,
                d.pay_sum_v
            from 
                contracts d                
            where 
                d.cnct_id = ".$this->array['id_head'];
            
            $q = $this->db->Select($sql);
            $dan = $q[0];           
            
            $osns_calc = $this->db->Select("select * from osns_calc where cnct_id = ".$this->array['id_head']);            
            $dan['osns_calc'] = $osns_calc[0];
                        
            $dan['osns_ns'] = $this->db->Select("select * from osns_ns where cnct_id = ".$this->array['id_head']);                        
            
            $dan['osns_calc_new'] = $this->db->Select("select case when o.id_filial = 0 then 'Страхователь' else c.name end name, o.* 
            from osns_calc_new o, CONTR_AGENTS_FILIAL c where o.id_filial = c.id(+) and o.cnct_id = ".$this->array['id_head']);
            
            $dan['osns_pril2'] = $this->db->Select("select case when o.id_filial = 0 then 'Страхователь' else c.name end name,
            case when o.id_filial = 0 then (select oked from contracts_maket where cnct_id = o.cnct_id union all select oked from contracts where cnct_id = o.cnct_id)
            else c.oked end oked, 
            o.* 
            from OSNS_PRIL2 o, CONTR_AGENTS_FILIAL c where o.id_filial = c.id(+) and o.cnct_id = ".$this->array['id_head']);
            
            $dan['akt1'] = $this->db->Select("select * from OSNS_ACT_N1 where CNCT_ID = ".$this->array['id_head']);
            
            $dan['bad_sluch'] = $this->db->Select("select case when o.id_filial = 0 then 'Страхователь' else (select name from CONTR_AGENTS_FILIAL where id = o.id_filial) 
            end name, o.* from OSNS_STAT_ACCIDENT o where o.cnct_id = ".$this->array['id_head']);
            
            $dan['transh'] = $this->db->Select("select * from transh where cnct_id = ".$this->array['id_head']); 
              
            $dan['reason_dop'] = $id_reason;
            $dan['list_branch'] = BRANCH::lists($active_user_dan['role_type']); 
            $dan['listPersonKos'] = $this->db->Select("select * from dic_person_kos where BRANCH_ID = ".$active_user_dan['brid']." order by id");                                                    
            $dan['listAgents'] = $this->db->Select("
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS 
                from agents a where a.state = 7 and a.date_close is null and a.vid not in (4, 5) 
                and A.BRANCHID = '".$active_user_dan['brid']."'
                union all 
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS 
                from agents_branch_other b, agents a where a.id = b.id and a.state = 7 and a.vid not in (4, 5) and a.date_close is null and b.branchid = '".$active_user_dan['brid']."'
                union all
                select a.id kod, decode(a.vid,1,lastname || ' '|| firstname||' '||middlename,a.org_name) name, a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS
                from agents a where a.state = 7 and a.date_close is null and a.vid not in (4, 5) 
                and a.id = 1620
            ");
                        
            $ag = $this->db->Select("select 'Договор № '||a.CONTRACT_NUM||' от '||a.CONTRACT_DATE_BEGIN osnovanie, A.PERCENT_OSNS, A.PERCENT, A.PERCENT_OSOR  from agents a where a.id = ".$dan['SICID_AGENT']);
            $dan['agent_dan'] = $ag[0];             
            
            $vid = $this->db->Select("SELECT id, name_oked ved_name, oked, risk_id, NAME, t_min, t_max FROM dic_oked_afn where id = ".$dan['OKED_ID']);
            $dan['osn_vid_deytel'] = $vid[0];
            $dan['vid_deyat'] = $this->db->Select("SELECT id, name_oked ved_name, oked, risk_id, NAME, t_min, t_max FROM dic_oked_afn ORDER  BY oked");
            
            
            $others_params = array();    
            $others_params['ihead'] = $dan['ID_HEAD'];            
            $others_params['icnct'] = $cnct;
            $others_params['ireason_dop'] = $id_reason;            
            $others_params['istate'] = 0;
            $others_params['iPAYM_CODE'] = $dan['PAYM_CODE'];                 
            $others_params['iDATE_CALC'] = date("d/m/Y");       
            $others_params['iEMP_ID'] = $active_user_dan['role'];
            $others_params['iid_strah'] = $dan['ID_INSUR'];            
                        
            $dan['others'] = $others_params;
            
            $this->dan = $dan; 
        }
        
        private function calc_osns_new()
        {            
            $result = array();
            $result['message'] = '';
            $result['alert'] = '';        
            $k_uv = 0;
                        
            $d = $this->array['calc_osns_new'];
            
            $h = $_POST['head'];
            $year_now = date("Y");
            
            $sql = "select mzp from DIC_CONSTANTS where year = ";
            if($h == 0){
                $sql .= $year_now;
            }else{
                $sql .= "(select extract(year from contract_date) from contracts where cnct_id = $h)";
            }
                        
            $row = $this->db->Select($sql);
            $mzp = $row[0]['MZP'];
            
            $s = array();                
            foreach($d as $k=>$v){
                $t = explode(';', $v);   
                unset($t[10]);
                $s[] = $t;         
            }
            
            
            $ds = array();        
            $i = 0;
            $ts = array();
            foreach($s as $k=>$v){
                if($v[1] == 0){
                    $sql = "select d.risk_id, D.TARIF from dic_oked_afn d where d.OKED = '".$v[9]."'";
                }else{
                    $sql = "select risk_id, tarif from CONTR_AGENTS_FILIAL where id = ".$v[1];
                }
                $row = $this->db->Select($sql);
                $risk = $row[0]['RISK_ID'];
                $tarif = StrToFloat($row[0]['TARIF']);
                
                
                $ts['naimen'] = $v[0];
                $ts['filial'] = $v[1];                
                $ts['cnt'] = $v[3];                
                $ts['oklad'] = StrToFloat($v[5]);
                $ts['smzp'] = StrToFloat($v[6]);
                $ts['gfot'] = StrToFloat($v[7]);
                $ts['str_summa'] = StrToFloat($v[8]);
                $ts['oked'] = $v[9];
                $ts['risk'] = $risk;
                $ts['tarif'] = $tarif;            
                            
                if($i > 0){       
                    $ds[$v[1]]['naimen'] = $v[0];
                    $ds[$v[1]]['filial'] = $v[1];
                    $ds[$v[1]]['cnt'] += $v[3];                
                    $ds[$v[1]]['oklad'] += $v[5];
                    $ds[$v[1]]['smzp'] += $v[6];
                    $ds[$v[1]]['gfot'] += $v[7];
                    $ds[$v[1]]['str_summa'] += $v[8];
                    $ds[$v[1]]['oked'] = $v[9];
                    $ds[$v[1]]['risk'] = $risk;
                    $ds[$v[1]]['tarif'] = $tarif;
                }else{
                    $ds[$v[1]] = $ts; 
                }
                $i++;
            }      
            
            //Проверка МЗП с ГФОТ
            $b = true;
            foreach($ds as $k=>$v){
                $ms = $v['gfot'] / $v['cnt'] / 12; 
                $mzp2 = $mzp * 10;           
                if($ms > $mzp2){
                    $b = false;
                }
            }
            
            $kol_vo_rab = 0;        
            $result['alert'] = '';        
            if($b == false){
                $result['alert'] = "ГФОТ по одному сотруднику более (10 МЗП * 12)";
                echo json_encode($result);
                exit;
            }else{
                sort($ds);  
                //$result['pril2_table'] = array();
                $raschet_table = array();          
                foreach($ds as $k=>$v){
                    $raschet_table[] = array(
                    'filial' => $v['filial'],
                    'naimen' => $v['naimen'], 
                    'cnt' => $v['cnt'],
                    'gfot' => $v['gfot'],
                    'str_summa' => $v['str_summa'],
                    'tarif' => StrToFloat($v['tarif']),
                    'pay_sum_p' => round($v['str_summa'] * $v['tarif'] / 100, 2));
                    if($v['str_summa'] < $v['gfot']){
                        $result['alert'] = 'Страховая сумма в Приложении 2 не может быть меньше ГФОТ';
                    }
                    $kol_vo_rab += $v['cnt'];        
                }
                            
            }                
            
            $chprab = 0;
            $ns = array();
            
            if(isset($_POST['ns'])){
                foreach($_POST['ns'] as $k=>$v){
                    $sn = explode(";", $v);
                    $chprab += $sn[3]+$sn[4]+$sn[5];
                    $ns[] = $sn;
                }
            }
            
            
            $pst = round($chprab / 5);
            $pr = 1;
            if ($pst >= 2){                                      
                $row = $this->db->Select("select * from DIC_PP_KOEF where schp_min <= $pst and schp_max >= $pst");
                if(count($row) > 0){
                    if($kol_vo_rab <= 100){$pr = $row[0]['R_100'];}    
                    if($kol_vo_rab > 100 && $kol_vo_rab <= 500){$pr = $row[0]['R_500'];}                
                    if ($kol_vo_rab > 500 && $kol_vo_rab <= 1000){$pr = $row[0]['R_1000'];}
                    if ($kol_vo_rab > 1000 && $kol_vo_rab <= 10000){$pr = $row[0]['R_10000'];}
                    if ($kol_vo_rab > 10000 && $kol_vo_rab <= 20000){$pr = $row[0]['R_20000'];}
                    if ($kol_vo_rab > 20000){$pr = $row[0]['R_MAX'];}
                }
            }
            
            
            //$result['pr'] = $pst;
            
            $max_gfot = $kol_vo_rab * $mzp * 10 * 12;
            
            $sum_gfot = 0;
            $pitogo = 0;
            $pay_sum_v = 0;
            
            foreach($raschet_table as $k=>$v){
                $sum_gfot += $v['gfot'];
                $pitogo += $v['pay_sum_p'];
                $pay_sum_v += $v['str_summa'];
            }
            
            if ($sum_gfot > $max_gfot){
               $result['alert'] .= 'Превышен лимит ГФОТ-а! Расчет не возможен!';
               echo json_encode($result);                
               exit;  
            } 
            
            $pay_sum_p = $pitogo * $pr;                        
            $result['mzp'] = $mzp;
                            
            
            /*Второй раз расчет идет*/
            if($pay_sum_p < $mzp){            
                $result['message'] = 'Страховая премия меньше МЗП был произведен перерасчет!';
                $k_uv = 0;
                
                $k_uv = $mzp / $pay_sum_p;                        
                $result['mzp'] = $mzp;
                
                
                foreach($ds as $k=>$v){
                    $ds[$k]['str_summa'] = round($v['str_summa'] * $k_uv, 2);
                }
                
                $result['psp'] = $k_uv;
                
                $raschet_table = array();
                foreach($ds as $k=>$v){
                    $raschet_table[] = array(
                    'naimen' => $v['naimen'],
                    'filial' => $v['filial'], 
                    'cnt' => $v['cnt'],
                    'gfot' => $v['gfot'],
                    'str_summa' => $v['str_summa'],
                    'tarif' => floatval($v['tarif']),
                    'pay_sum_p' => round(round($v['gfot'] * $v['tarif'] / 100, 2) * $k_uv)
                    );                                       
                }
                
                $sum_gfot = 0;
                $pitogo = 0;
                $pay_sum_v = 0;
                foreach($raschet_table as $k=>$v){
                    $sum_gfot += $v['gfot'];
                    $pitogo += $v['pay_sum_p'];
                    $pay_sum_v += $v['str_summa'];
                }
                
                $pay_sum_p = $pitogo * $pr;
                
            }
            
            $osns_calc_new_table = '';
            foreach($raschet_table as $k=>$v){
                $txt = $v['filial'].';'.$v['cnt'].';'.str_replace(".", ",", $v['gfot']).';'.str_replace(".", ",", $v['str_summa']).';'.str_replace(".", ",", $v['tarif']).';'.str_replace(".", ",", $v['pay_sum_p']).';0;0;0;0;';
                $inp = '<input type="hidden" class="i_osns_calc_new" id="'.$v['filial'].'" name="i_osns_calc_new[]" value="'.$txt.'">';
                $osns_calc_new_table .= '<tr>
                <td>'.$inp.$v['naimen'].'</td>
                <td style="text-align: center;">'.$v['cnt'].'</td>
                <td style="text-align: center;">'.$v['gfot'].'</td>
                <td style="text-align: center;">'.$v['str_summa'].'</td>
                <td style="text-align: center;">'.$v['tarif'].'</td>
                <td style="text-align: center;">'.$v['pay_sum_p'].'</td>
                </tr>';
            }                
            
            $koef_uv = $k_uv;
            if($k_uv <= 0){
                $k_uv = 0;
                $koef_uv = 1;
            }
            
            $result['others'] = $_POST;        
            $tr = '';        
                    
            $calc_osns_new = $_POST['calc_osns_new'];
            foreach($_POST['pril2_save'] as $k=>$v){
                $vtext = '';
                $vtext2 = '';
                
                $ddd = explode(";", $v);
                
                $ddd[7] = round($ddd[6] * $koef_uv, 2);
                $i = 0;
                foreach($ddd as $d){
                    if($i < count($ddd)-1){
                        $vtext .= $d.";";
                    }
                    $i++;     
                }            
                //$vtext = substr($vtext, 1, strlen($vtext)-1);
                            
                
                $sss = explode(";", $calc_osns_new[$k]);                        
                $sss[8] = round($sss[7] * $koef_uv, 2);
                $i = 0;
                foreach($sss as $sp){
                    if($i < count($sss)-1){
                        $vtext2 .= $sp.";";
                    }
                    $i++;
                }   
                            
                $tr .= '<tr id="pril2_inc'.$k.'" class="pril2_list">
                        <td>
                            <input type="hidden" name="pril2[]" class="pril2_save" value="'.$vtext.'">
                            <input type="hidden" class="pril2_edit" value="'.$vtext2.'">
                            <span class="btn btn-danger btn-sm del_pril2" data="'.$k.'"><i class="fa fa-trash"></i></span>
                        </td>
                        <td>'.$sss[0].'</td>
                        <td>'.$sss[2].'</td>
                        <td>'.$sss[3].'</td>
                        <td>'.$sss[4].'</td>
                        <td>'.$sss[5].'</td>
                        <td>'.$sss[6].'</td>
                        <td>'.$sss[7].'</td>
                        <td>'.$sss[8].'</td>
                    </tr>';                                     
            }                                
                           
            $result['pril2_table'] = $tr;        
            $result['pay_sum_v'] = round($pay_sum_v, 2);                
            $result['pay_sum_p'] = $pay_sum_p;    
            $result['pp_koef'] = round($pr, 2);
            $result['sgchp'] = round($pst, 2);
            $result['koef_uv'] = $k_uv;                                         
            
            $result['raschet_table_html'] = $osns_calc_new_table;
            $result['raschet_table'] = $raschet_table;
            IF(isset($_POST['ns'])){
                $result['ns'] = $_POST['ns'];    
            }else{
                $result['ns'] = array();
            }
            
            $sql = "begin sum_calc.calc_dopka_osns('".$this->array['head']."', '".$this->array['contr_num']."', '".$this->array['contr_date']."', '$pay_sum_p', :IKOL_D_YEAR, :IKOL_PROSH_D, 
            :IKOL_OST_D, :IZARAB_P, :INEZARAB_P, :PREM_NEW1, :PREM_NEW2, :SUM_ITOG); end;";
                           
            $res = array("IKOL_D_YEAR", "IKOL_PROSH_D", "IKOL_OST_D", "IZARAB_P", "INEZARAB_P", "PREM_NEW1", "PREM_NEW2", "SUM_ITOG");
            
            $dop_dan = $this->db->ExecuteReturn($sql, $res);
            if($dop_dan['SUM_ITOG'] > 0){
                $dop_dan['vozv_opl'] = 'Подлежит к оплате';
            }else{
                $dop_dan['vozv_opl'] = 'Подлежит к возврату';
            }
            $result['dop_dan'] = $dop_dan;
                                     
            echo json_encode($result);
            exit;
        }
        
        function save_osns()
        {            
            //$this->dan = $this->array;            
            global $active_user_dan;
            $b = true;
            
            //проверки на правильность ввода
            if($this->array['iid_strah'] == ''){
                $this->message = ALERTS::WarningMin('Страхователь должен быть задан!');
                $b = false;                
            }
            
            if($this->array['irisk_id'] == ''){
                $this->message = ALERTS::WarningMin('Не указан класс риска!');
                $b = false;                
            }
            
            if($this->array['ioked_id'] == ''){
                $this->message = ALERTS::WarningMin('Укажите ОКЭД!');  
                $b = false;              
            }
            
            if($this->array['iCONTRACT_DATE'] == ''){
                $this->message = ALERTS::WarningMin('Дата договора не может быть пустым!');                
            }
            
            if($this->array['ikol_d_year'] == 0){
                $this->message = ALERTS::WarningMin('Вы не произвели расчет!');
            }
                    
            //Конец проверок
            
            if(isset($this->array['badsluch'])){
                $badsluch_state = 1;
            }else{
                $badsluch_state = 0;
            }
            
            $istat_bad_sluch = '';
            if(isset($this->array['istat_bad_sluch'])){                
                foreach($this->array['istat_bad_sluch'] as $k=>$v){
                    $istat_bad_sluch .= $v;
                }
            }
            
            
            $pril2 = '';
            if(isset($this->array['pril2'])){
                foreach($this->array['pril2'] as $k=>$v){                                        
                    $pril2 .= $v;
                }
            }
            
            $actn1 = '';
            if(isset($this->array['actn1'])){
                foreach($this->array['actn1'] as $k=>$v){
                    $actn1 .= $v;
                }
            }
            
            $i_osns_calc_new = '';
            if(isset($this->array['i_osns_calc_new'])){
                foreach($this->array['i_osns_calc_new'] as $k=>$v){
                    $i_osns_calc_new .= $v;
                }
            }
            
            $transh = '';
            if(isset($this->array['transh'])){
                foreach($this->array['transh'] as $k=>$v){
                    $transh .= $v;
                }
            }
            
            if($this->array['typ_dog'] == ''){
                $typ_dog = 1;
            }else{
                $typ_dog = 2;
            }        
            
            if(!isset($this->array['istate'])){
                $this->array['istate'] = 0;
            }
            
            
            if($this->array['vPAY_SUM_V'] > 7000000000){        
                $this->message = ALERTS::WarningMin('Сумма страховой выплаты не должна превышать 7000000000 тг.');
                return false;
            }
            
            
            $sql = "BEGIN card.new_osns(
                '".$this->array['icnct']."',
                '".$this->array['irisk_id']."',
                '".$this->array['CONTRACT_NUM']."',
                '".$this->array['iCONTRACT_DATE']."',
                '".$this->array['istate']."',
                '".$this->array['iPAYM_CODE']."',
                '".$this->array['IOKED']."',
                '".$this->array['vPAY_SUM_V']."',
                '".$this->array['vPAY_SUM_P']."',
                '".$this->array['iDATE_CALC']."',
                '".$this->array['idate_begin']."',
                '".$this->array['idate_end']."',
                '".$this->array['iPERIODICH']."',
                '".$this->array['ZV_NUM']."',
                '".$this->array['iZV_DATE']."',
                '".$this->array['iid_strah']."',
                '".$this->array['BRANCH_ID']."',
                '".$this->array['iSICID_AGENT']."',
                '".$badsluch_state."',
                0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
                '".$active_user_dan['emp']."',
                '".$this->array['ihead']."',
                '".$typ_dog."',
                '".$this->array['ikol_d_year']."',
                '".$this->array['ikol_prosh_d']."',
                '".$this->array['ikol_ost_d']."',
                '".$this->array['izarab_p']."',
                '".$this->array['inezarab_p']."',
                '".$this->array['prem_new1']."',
                '".$this->array['prem_new2']."',
                '".$this->array['sum_itog']."',
                0,0,0,0,0,0,0,0,0,0,0,0,
                '".$this->array['AFFILIR']."',
                '',
                '',
                '".$transh."',
                '".$istat_bad_sluch."',
                '".$pril2."',
                '".$actn1."',
                '".$this->array['ioked_id']."',
                '".$i_osns_calc_new."',
                ".$this->array['ikoef_uv'].",
                '".$this->array['sgchp']."',
                ".$this->array['koef_pp'].",
                '".$this->array['ireason_dop']."',
                '".$this->array['otv_lico']."'); 
            end;";
            
                 
            $rs = $this->db->ExecProc($sql);
            if($rs['error'] == ''){
                if($s['icnct'] == 0){
                    $q = $this->db->Select("select max(cnct_id) cnct_id from (
                        select cnct_id from contracts where id_insur = ".$s['iid_strah']."
                        union all
                        select cnct_id from contracts_maket where id_insur = ".$s['iid_strah'].")");
                    $cnct_id = $q[0]['CNCT_ID'];
                }else{
                    $cnct_id = $s['icnct'];
                }
                header("Location: contracts?CNCT_ID=$cnct_id");
            }else{                
                $this->dan = $this->array;
                $this->message = ALERTS::WarningMin($rs['error']);                
            }
        }
        
        
    }
?>