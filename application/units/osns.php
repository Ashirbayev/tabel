<?php
class OSNS
{
    function Calc_osns_new()
    {
        $db = new DB3();
        $result = array();
        $result['message'] = '';
        $result['alert'] = '';        
        $k_uv = 0;
        
        $d = $_POST['calc_osns_new'];
                        
        $h = $_POST['head'];
        $year_now = date("Y");
        
        $sql = "select mzp from DIC_CONSTANTS where year = ";
        if($h == 0){
            $sql .= $year_now;
        }else{
            $sql .= "(select extract(year from contract_date) from contracts where cnct_id = $h)";
        }
        
        $db->ClearParams();
        $row = $db->Select($sql);
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
            $db->ClearParams();
            if($v[1] == 0){
                $sql = "select d.risk_id, D.TARIF from dic_oked_afn d where d.OKED = '".$v[9]."'";
            }else{
                $sql = "select risk_id, tarif from CONTR_AGENTS_FILIAL where id = ".$v[1];
            }
            $row = $db->Select($sql);
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
                'pay_sum_p' => round($v['gfot'] * $v['tarif'] / 100, 2));
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
            $db->ClearParams();            
            $row = $db->Select("select * from DIC_PP_KOEF where schp_min <= $pst and schp_max >= $pst");
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
                $ds[$k]['str_summa'] = round($v['gfot'] * $k_uv, 2);
            }
            
            
            $raschet_table = array();
            foreach($ds as $k=>$v){
                $raschet_table[] = array(
                'naimen' => $v['naimen'],
                'filial' => $v['filial'], 
                'cnt' => $v['cnt'],
                'gfot' => $v['gfot'],
                'str_summa' => $v['str_summa'],
                'tarif' => floatval($v['tarif']),
                'pay_sum_p' => round(round($v['gfot'] * $v['tarif'] / 100, 2) * $k_uv));                                       
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
            $txt = $v['filial'].';'.$v['cnt'].';'.str_replace(".", ",", $v['gfot']).';'.str_replace(".", ",", $v['str_summa']).';'.str_replace(".", ",", $v['tarif']).';'.str_replace(".", ",", $v['pay_sum_p']).';';
            $inp = '<input type="hidden" name="i_osns_calc_new[]" value="'.$txt.'">';
            $osns_calc_new_table .= '<tr><td>'.$inp.$v['naimen'].'</td>
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
        
        echo json_encode($result);
    }
    
    
    function SaveOSNS($s)
    {                          
        global $msg;
        $db = new DB3();
        
        //проверки на правильность ввода                                
        if($s['iID_INSUR'] == ''){
            $msg = ALERTS::WarningMin('Страхователь должен быть задан!');
            return false;
        }
        
        if($s['irisk_id'] == ''){
            $msg = ALERTS::WarningMin('Не указан класс риска!');
            return false;
        }
        
        if($s['ioked_id'] == ''){
            $msg = ALERTS::WarningMin('Укажите ОКЭД!');
            return false;
        }
        
        if($s['iCONTRACT_DATE'] == ''){
            $msg = ALERTS::WarningMin('Дата договора не может быть пустым!');
            return false;
        }
                
        //Конец проверок
        
        if(isset($s['badsluch'])){
            $badsluch_state = 1;
        }else{
            $badsluch_state = 0;
        }
        
        $istat_bad_sluch = '';
        if(isset($s['istat_bad_sluch'])){
            foreach($s['istat_bad_sluch'] as $k=>$v){
                $istat_bad_sluch .= $v;
            }
        }
        
        $pril2 = '';
        if(isset($s['pril2'])){
            foreach($s['pril2'] as $k=>$v){
                $pril2 .= $v;
            }
        }
        
        $actn1 = '';
        if(isset($s['actn1'])){
            foreach($s['actn1'] as $k=>$v){
                $actn1 .= $v;
            }
        }
        
        $i_osns_calc_new = '';
        if(isset($s['i_osns_calc_new'])){
            foreach($s['i_osns_calc_new'] as $k=>$v){
                $i_osns_calc_new .= $v;
            }
        }
        
        $transh = '';
        if(isset($s['transh'])){
            foreach($s['transh'] as $k=>$v){
                $transh .= $v;
            }
        }
        
        if(empty($s['typ_dog'])){
            $typ_dog = 2;
        }else{
            $typ_dog = 1;
        }        
        global $active_user_dan;
        if($s['vPAY_SUM_P'] > 1000000){
            $msg = ALERTS::WarningMin('Сумма страховой премии не должна превышать 1000000 тг.');
            return false;
        } 
        
        if($s['vPAY_SUM_V'] > 1000000000){        
            $msg = ALERTS::WarningMin('Сумма страховой выплаты не должна превышать 1000000000 тг.');
            return false;
        }
        
        if($s['irisk_id'] > 15){
            $msg = ALERTS::WarningMin('Класс профессионального риска не болжен быть выше 15 класса');
            return false;
        }
        
        $sql = "BEGIN card.new_osns(
            '".$s['icnct']."',
            '".$s['irisk_id']."',
            '".$s['iCONTRACT_NUM']."',
            '".$s['iCONTRACT_DATE']."',
            '".$s['istate']."',
            '".$s['iPAYM_CODE']."',
            '".$s['IOKED']."',
            ".$s['vPAY_SUM_V'].",
            ".$s['vPAY_SUM_P'].",
            '".$s['iDATE_CALC']."',
            '".$s['idate_begin']."',
            '".$s['idate_end']."',
            '".$s['iPERIODICH']."',
            '".$s['iZV_NUM']."',
            '".$s['iZV_DATE']."',
            '".$s['iID_INSUR']."',
            '".$s['iBRANCH_ID']."',
            '".$s['iSICID_AGENT']."',
            '".$badsluch_state."',
            0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
            '".$active_user_dan['emp']."',
            '".$s['ihead']."',
            '".$typ_dog."',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            0,0,0,0,0,0,0,0,0,0,0,0,
            '".$s['AFFILIR']."',
            '',
            '',
            '".$transh."',
            '".$istat_bad_sluch."',
            '".$pril2."',
            '".$actn1."',
            '".$s['ioked_id']."',
            '".$i_osns_calc_new."',
            ".$s['ikoef_uv'].",
            '".$s['sgchp']."',
            ".$s['koef_pp'].",
            '".$s['ireason_dop']."',
            '".$s['otv_lico']."'); 
        end;";
                  
        $rs = $db->ExecProc($sql);
        if($rs['error'] == ''){
            if($s['icnct'] == 0){
                $q = $db->Select("select max(cnct_id) cnct_id from (
                    select cnct_id from contracts where id_insur = ".$s['iID_INSUR']."
                    union all
                    select cnct_id from contracts_maket where id_insur = ".$s['iID_INSUR'].")");
                $cnct_id = $q[0]['CNCT_ID'];
            }else{
                $cnct_id = $s['icnct'];
            }
            header("Location: contracts?CNCT_ID=$cnct_id");
        }else{
            $dan = $s;
            $msg = ALERTS::WarningMin($rs['error']);
            return false;
        }
    }

    
    function Tables_AktN1($DOLZHN, $FIO, $ACT_NOM, $ACT_DATE, $REASON, $AVG_ZP, $AGE, $VINA, $id = '')
    {
        if($id == ''){
            $id = rand(0, 1000);
        }
        $dolz_name = '';
        switch ($DOLZHN)
        {
            case 1: $dolz_name = "Административно-управленческий персонал";
            break;
            case 2: $dolz_name = "Производственный персонал";
            break;
            case 3: $dolz_name = "Вспомогательный персонал";
            break;
        }
        
        $reason_name = '';        
        switch ($REASON)
        {
            case 1: $reason_name = "Проф заболевание";
            break;
            case 2: $reason_name = "Смерть";
            break;
            case 3: $reason_name = "Трудовое увечье";
            break;
        }
        
        $txt = $DOLZHN.';'.$FIO.';'.$ACT_NOM.';'.$ACT_DATE.';'.$REASON.';'.$AVG_ZP.';'.$AGE.';'.$VINA.';';
        /*
        2;                          Должность
        Таранда Игорь Анатольевич;  ФИО
        2,3;                        Номер Акта
        06.12.2012;                 Дата акта
        1;                          Причина
        ;                           СМЗП
        48;                         Возраст
        ;                           Степень вины работодателя
        */
        
        $inp = '<input type="hidden" name="actn1[]" value="'.$txt.'">';        
        return '<tr class="gradeX field n1_'.$id.'" style="display: table-row;">
        <td>'.$inp.'            
            <a class="btn btn-danger btn-sm del_act_n1" data="'.$id.'"><i class="fa fa-trash"></i></a>
        </td>
        <td>'.$dolz_name.'</td>
        <td>'.$FIO.'</td>
        <td>'.$ACT_NOM.'</td>
        <td>'.$ACT_DATE.'</td>
        <td>'.$REASON.'</td>
        <td>'.$AVG_ZP.'</td>
        <td>'.$AGE.'</td>
        <td>'.$VINA.'</td>
        </tr>';
    }
    
    function FilialsIdInsur($id_insur)
    {
        $db = new DB3();
        $dan = array();         
        $sql = "select 0 id, null id_filial, c.id id_insur, 'Страхователь' name, d.oked, c.oked_id, d.risk_id, d.tarif 
        from contr_agents c, dic_oked_afn d where d.id(+) = c.oked_id and  C.ID = $id_insur";
        
        $db->ClearParams();
        $db->Select($sql);
        $dan['oked_id'] = $db->row[0]['OKED_ID'];
               
        $st = $db->row;
        
        $db->ClearParams();
        $sql = "select * from CONTR_AGENTS_FILIAL where id_insur = $id_insur";
        $r = $db->Select($sql);
                   
        if(count($r) > 0){
            foreach($r as $k=>$v){                
                foreach($v as $t=>$y){
                    $v[$t] = str_replace('"', "", $y);
                }
                array_push($st, $v);
            }
        }                
        $dan = $st;
        
        return json_encode($dan);
    }
    
    function Tables_Pril2($id_filial, $name_filial, $dolgnost, $kolvo, $risk_id, $oklad, $smzp, $gfot, $sum, $oked, $id = '')
    {
        if($id == ''){$id = random(1000, 5000);}
        $inp1 = $id_filial.';'.$dolgnost.';'.$kolvo.';'.$risk_id.';'.$oklad.';'.$smzp.';'.$gfot.';'.$sum.';';
        $inp2 = $name_filial.';'.$id_filial.';'.$dolgnost.';'.$kolvo.';'.$risk_id.';'.$oklad.';'.$smzp.';'.$gfot.';'.$sum.';'.$oked.';';
        
        /*
        0;          Наименование страхователь или филиал
        Должность;  Должность
        9;          Численность
        1;          класс проф риска
        0;          оклад
        0;          СМЗП    
        24687720;   ГФОТ
        24687720;   Страховая сумма
        */
        
        return '<tr id="pril2_inc'.$id.'" class="pril2_list">
            <td>
                <input type="hidden" name="pril2[]" class="pril2_save" value="'.$inp1.'">
                <input type="hidden" class="pril2_edit" value="'.$inp2.'">
                <span class="btn btn-danger btn-sm del_pril2" data="'.$id.'"><i class="fa fa-trash"></i></span>
            </td>'."
            <td>$name_filial</td>
            <td>$dolgnost</td>
            <td>$kolvo</td>
            <td>$risk_id</td>
            <td>$oklad</td>
            <td>$smzp</td>
            <td>$gfot</td>
            <td>$sum</td>
        </tr>";
    }
    
    function TableTransh($pay_sum, $date_plan, $date_dact, $sum_fact, $mhmh_id, $date_dohod, $id){        
        if($id == ''){$id = random(1, 5000);}
        $txt = $date_plan.';'.$pay_sum.';'.$date_dact.';'.$sum_fact.';'.$mhmh_id.';'.$date_dohod.';';
        /*
        Date_plan; summa_plan; date_fact; summa_fact; mhmh_id; date_dohod;
        */
        $r = '<tr id="transh_inc'.$id.'" class="transh_list">
            <td>
                <input type="hidden" name="transh[]" class="transh_save" value="'.$txt.'">';
        if($sum_fact == 0){
            $r .= '<span class="btn btn-danger btn-sm del_transh" data="'.$id.'"><i class="fa fa-trash"></i></span>';
        }
        $r .= "                
            </td>            
            <td>$pay_sum</td>
            <td>$date_plan</td>
            <td>$date_dact</td>
            <td>$sum_fact</td>
            <td>$date_dohod</td>
        </tr>";
        
        return $r;
    }
    
    function Table_bad_sluch($id_filial, $filial_name, $god, $cnt_z, $upt_c, $upt_no, $death, $cnt_p, $id)
    {        
        $txt = $id_filial.';'.$god.';'.$cnt_z.';'.$upt_c.';'.$upt_no.';'.$death.';'.$cnt_p.';;;';
        return '<tr id="ns_inc'.$id.'" class="hs_list">
        <td>
            <input type="hidden" name="istat_bad_sluch[]" class="stat_bad_sluch" value="'.$txt.'">
            <span class="btn btn-danger btn-sm del_ns" data="'.$id.'"><i class="fa fa-trash"></i></span>
        </td>'."
        <td>$filial_name</td>
        <td>$god</td>
        <td>$cnt_z</td>
        <td>$upt_c</td>
        <td>$upt_no</td>
        <td>$death</td>
        <td>$cnt_p</td>
        </tr>";
        
        /*
        0;      Страхователь или филиал
        2011;   год
        2715;   численность застрахованных
        1;      УПТ со сроком
        ;       УПТ без срочно
        ;       Смертность
        1;      Численность пострадавших
        */
    }
    
    function Table_OSNS_CALC_NEW($filial_name, $id_filial, $cnt, $gfot, $pay_sum_v, $tarif, $pay_sum_p)
    {
        $gfot = StrToFloat($gfot);
        $pay_sum_v = StrToFloat($pay_sum_v);        
        $tarif = StrToFloat($tarif);
        $pay_sum_p = StrToFloat($pay_sum_p);
        
        $txt = "$id_filial;$cnt;$gfot;$pay_sum_v;$tarif;$pay_sum_p;";
        $inp = '<input type="hidden" name="i_osns_calc_new[]" value="'.$txt.'">';
        return '
        <tr>
            <td>'.$inp.$filial_name.'</td>
            <td style="text-align: center;">'.$cnt.'</td>
            <td style="text-align: center;">'.$gfot.'</td>
            <td style="text-align: center;">'.$pay_sum_v.'</td>
            <td style="text-align: center;">'.$tarif.'</td>
            <td style="text-align: center;">'.$pay_sum_p.'</td>
            </tr>
        ';
    }
    
    function move_arhive($cnct, $isfile, $text)
    {
        $s = "begin card.move_archive ('$cnct','$isfile','$text'); end;";
        $db = new DB3();
        $ds = $db->ExecProc($s);
        if($ds['error'] == ''){
            header("Location: contracts?CNCT_ID=$cnct");
        }else{
            global $msg;
            $msg = ALERTS::ErrorMin($ds['error']);  
        }                
    }
    
    function prov_schet_opl($cnct)
    {
        $db = new DB3();     
        //Узнаем траншевый договоро или нет?
        $tr = $db->Select("select count(*) c from transh where cnct_id = $cnct");
        $count_transh = $tr[0]['C'];
        if($count_transh > 0){
            $sql_prov = "select count(*) c from acc_on_pay a, transh t where t.id = A.ID_TRUNSH and a.cnct_id = $cnct and t.sum_fact is null"; 
        }else{
            $sql_prov = "select count(*) c from contracts d, contr_agents p, acc_on_pay s, dic_branch b  where s.cnct_id = $cnct and s.state = 1
            and s.cnct_id = d.cnct_id and d.ID_INSUR = p.ID and d.BRANCH_ID = b.RFBN_ID";
        }
                                        
        $dan = $db->Select($sql_prov);        
        $s = '';
        if($dan[0]['C'] == 0){
            global $active_user_dan;
            if($count_transh > 0){
                $t = $db->Select("select id from transh where cnct_id = 63619 and sum_fact is null and rownum = 1 order by nom");
                $s = self::new_shet_opl($cnct, $active_user_dan['emp'], $t[0]['ID']);
            }else{
                $s = self::new_shet_opl($cnct, $active_user_dan['emp']);
            }
        }
        $dan = array();
        $dan['href'] = 'printdog?cnct_id='.$cnct.'&other=1';
        $dan['alert'] = $s;
        return $dan;
    }
    
    function new_shet_opl($cnct, $emp, $id_transh = "null")
    {
        $db = new DB3();
        $d = $db->Execute("begin card.new_schet_opl(0, '$cnct','$emp', $id_transh); end;");
        if($d == true){
            return '';
        }else{
            return $d;
        }
    }
}
?>