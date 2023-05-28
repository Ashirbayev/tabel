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
            array_push($js_loader, 'styles/js/demo/contracts_osns.js');
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
            $branch = $this->user_dan['brid'];
            $sql = "select a.id kod,  decode(a.vid,1,lastname ||' '|| firstname||' '||middlename, a.org_name) name, 
            a.CONTRACT_NUM, a.CONTRACT_DATE_BEGIN, a.PERCENT_OSNS 
            from agents a where a.state = 7 and a.date_close is null  and a.vid not in (4, 5)";
            
            if($branch !== '0000'){
                $sq = substr($branch, 0, 2);
                $sql .= " and a.branchid like '%$sq%'";
            }
            
            $sql .= " or a.id in (select b.id from agents_branch_other b where b.branchid = '$branch')";
                        
            $q = $this->db->Select($sql);
            $this->dan['AGENT'] = $q;
        }
        
        private function search_contragent($txt)
        {
            $dan = array();
            $q = $this->db->Select("
            SELECT 
                c.id, 
                c.NAME, 
                c.ved_id, 
                c.group_id, 
                c.bin,
                C.OKED_ID,
                a.oked,
                a.name_oked,
                a.name oked_name_other,    
                A.RISK_ID,
                A.TARIF,
                S.AFFILIR
            FROM 
                contr_agents c,
                dic_oked_afn a,
                SEGMENT_INSUR s
            WHERE 
                c.type IN (1,3)
                and a.id = C.OKED_ID
                and S.ID_INSUR = c.id
                and upper(c.name) like upper('%$txt%')"
            );
            $dan = $q;
            
            foreach($dan as $k=>$v){
                $q = $this->db->Select("select * from CONTR_AGENTS_FILIAL where id_insur = ".$v['ID']);  
                $dan[$k]['FILIALS'] = $q;
            }
            
            echo json_encode($dan);
            exit;
        }
        
        private function search_oked($text)
        {
            $q = $this->db->Select("
            select 
                a.id,
                a.oked, 
                a.name_oked, 
                a.name oked_name_other, 
                A.RISK_ID, 
                A.TARIF 
            from 
                dic_oked_afn a 
            where 
                CONCAT(A.OKED, upper(A.NAME_OKED)) like upper('%$text%')"
            );
            echo json_encode($q);
            exit;
        }
        
        private function oked_dan($id)
        {
            $q = $this->db->Select("
            select 
                a.id,
                a.oked, 
                a.name_oked, 
                a.name oked_name_other, 
                A.RISK_ID, 
                A.TARIF 
            from 
                dic_oked_afn a 
            where 
                a.id = $id"
            );
            echo json_encode($q[0]);
            exit;
        }
        
        private function date_add_year($d)
        {
            $ds = strtotime($d);
            $newdate = strtotime("+1 year", $ds);
            echo  date("d.m.Y", $newdate-1);
            exit;
        }
        
        private function pril2_dolg()
        {
            print_r($this->array);
            exit;
        }
        
        private function calc_pril2($ds)
        {       
            $result['message'] = '';
            $result['pril2'] = $ds;
            $result['raschet'] = array();
            $result['pay_sum_v'] = 0;
            $result['pay_sum_p'] = 0;
            $result['pp_koef'] = 0;
            $result['sgchp'] = 0;
            $result['koef_uv'] = 0;
            
            //Узнаем год договора для проверки МЗП            
            $mzp_year = date("Y", strtotime($this->array['contract_date']));
            if($this->array['id_head'] !== '0'){
                $q = $this->db->Select("select extract(year from contract_date) year from contracts where cnct_id = ".$this->array['id_head']);
                $mzp_year = $q[0]['YEAR'];
            }
                    
            //Если Год МЗП больше текущего года тогда выводим ошибку
            if($mzp_year > date("Y")){
                $result['message'] = ALERTS::ErrorMin("МЗП на $mzp_year год не утвержден! Расчет не возможен");
                echo json_encode($result);
                exit;
            }
            
            //Узнаем МЗП
            $q = $this->db->Select("select mzp from DIC_CONSTANTS where year = $mzp_year");
            $mzp = $q[0]['MZP'];
            //-------------------------------------------------
            
            //Среднегодовая численность пострадавших            
            $skp = 1;
            $chprab = 0;
            $kol_vo_rab = 0;
            $sum_gfot = 0;
            //Проверяем на максимальный ГФОТ по всем сотрудникам
            foreach($result['pril2'] as $k=>$v){
                $s = $v['gfot'] / 12 / $v['count'];
                if($mzp > $s){
                    $result['message'] = ALERTS::ErrorMin('ГФОТ по одному сотруднику меньше МЗП. Расчет и сохранение не возможно');
                    echo json_encode($result);
                    exit;
                }                
                $kol_vo_rab += $v['count'];
                $sum_gfot += $v['gfot'];
            }
            
            if(count($this->array['ns']) > 0){
                foreach($this->array['ns'] as $k=>$v){
                    $chprab += $v['upt_s']+$v['upt_not_s']+$v['ns_postr'];
                }                
            }    
            $pst = round($chprab /  5);
            if($pst >= 2){
                $q = $this->db->Select("select * from DIC_PP_KOEF where schp_min <= $pst and schp_max >= $pst");
                $v = $q[0];
                if($kol_vo_rab <= 100){$skp = $v['R_100'];}
                if($kol_vo_rab > 100){$skp = $v['R_500'];}
                if(($kol_vo_rab > 500) and ($kol_vo_rab <= 1000)){$skp = $v['R_1000'];}
                if(($kol_vo_rab > 1000) and ($kol_vo_rab <= 10000)){$skp = $v['R_10000'];}
                if(($kol_vo_rab > 10000) and ($kol_vo_rab <= 20000)){$skp = $v['R_20000'];}
                if($kol_vo_rab > 20000){$skp = $v['R_MAX'];}
            }
            
            $max_gfot = $kol_vo_rab * $mzp * 10 * 12;
            if ($sum_gfot > $max_gfot){
               $result['message'] = ALERTS::ErrorMin('Превышен лимит ГФОТ-а! Расчет не возможен!');
               echo json_encode($result);                
               exit;
            }
            //----------------------------------------------
            
            $pitogo = 0;
            //Перебираем приложение 2
            foreach($result['pril2'] as $k=>$v){ 
                $result['pril2'][$k]['str_sum_koef'] = $v['str_sum'];
                //Проверка ГФОТ не должен быть больше страховой суммы
                if(floatval($v['str_sum']) < floatval($v['gfot'])){
                    $result['message'] = ALERTS::ErrorMin("Страховая сумма по 1 сотруднику не может быть меньше ГФОТ");
                    echo json_encode($result);
                    exit;
                }
                
                //Сразу создаем расчетную таблицу
                $dan = array();
                $dan = $v;            
                unset($dan['smzp']);
                unset($dan['str_sum_koef']);
                unset($dan['oklad']);
                unset($dan['dolgnost']);                               
                
                //Добалвяем имена в поле страхователь                
                $name = 'Страхователь';
                if($v['id_insur'] !== '0'){                
                    $q = $this->db->Select("select * from CONTR_AGENTS_FILIAL where id_insur = ".$v['id_insur']);
                    $name = $q[0]['NAME'];                                        
                }else{                    
                    $q = $this->db->Select("select d.risk_id, D.TARIF from dic_oked_afn d where d.OKED = '".$this->array['oked']."'");
                }
                $result['pril2'][$k]['name'] = $name;                
                $dan['name'] = $name;
                
                //Страховая премия
                $dan['pay_sum_p'] = round(floatval($v['str_sum']) * floatval($q[0]['TARIF']) / 100, 2);
                //Тариф
                $dan['tarif'] = $q[0]['TARIF'];
                //Класс проф риска
                $dan['risk'] = $q[0]['RISK_ID'];                
                
                
                //По умолчанию ставим что нету записи
                $b = -1;
                
                //Перебираем расчетную таблицу
                foreach($result['raschet'] as $t=>$r){                    
                    //Если в расчетной таблице имеется запись с таким же филиалом тогда 
                    //в переменную заносим номер записи
                    if($r['id_insur'] == $v['id_insur']){
                        $b = $t;   
                    }                    
                }
                
                //Если нету записи в расчетной таблице тогда добавляем
                if($b == -1){
                    array_push($result['raschet'], $dan);
                }else{
                    //Иначе просто к выбранной записи плюсуем суммы
                    $result['raschet'][$b]['count'] += floatval($dan['count']);
                    $result['raschet'][$b]['gfot'] += floatval($dan['gfot']);
                    $result['raschet'][$b]['str_sum'] += floatval($dan['str_sum']);
                    $result['raschet'][$b]['pay_sum_p'] += floatval($dan['pay_sum_p']);                
                }
                
                //Проверяем на соответствие МЗП
                $m1 = floatval($v['gfot']) / floatval($v['count']) / 12; 
                $m2 = floatval($mzp) * 10;           
                if($m1 > $m2){
                    $result['message'] = ALERTS::ErrorMin("ГФОТ по одному сотруднику более (10 МЗП * 12)");
                    echo json_encode($result);
                    exit;
                }
                
                $pitogo += $dan['pay_sum_p'];
            }
            
            $pay_sum_p = $pitogo * $skp; 
            if($pay_sum_p < $mzp){
                //$result['message'] = ALERTS::InfoMin('Страховая премия меньше МЗП был произведен перерасчет!');
                $result['koef_uv'] = $mzp / $pay_sum_p;
                
                foreach($result['pril2'] as $k=>$v){
                    $result['pril2'][$k]['str_sum_koef'] = round(floatval($v['str_sum']) * floatval($result['koef_uv']), 2); 
                }
                
                foreach($result['raschet'] as $k=>$v){
                    $result['raschet'][$k]['pay_sum_p'] = round((floatval($v['str_sum']) * floatval($q[0]['TARIF']) / 100) * floatval($result['koef_uv']), 2);                    
                }
            }
            
            foreach($result['raschet'] as $k=>$v){
                $result['pay_sum_v'] += $v['str_sum'];
                $result['pay_sum_p'] += $v['pay_sum_p'];                               
            }
            
            $result['pp_koef'] = $skp;
            $result['sgchp'] = $pst; 
            
            if($result['koef_uv'] > 0){
                $html = '<div class="col-lg-12"><span class="text-success">Согласно Статьи № 311-V от 27.04.15 г. пунктом 2-1 в соответствии с Законом РК<br /></span> 
                <span class="text-danger">2-1. В случае если размер <b>страховой премии</b>, рассчитанный в соответствии с пунктами 1,2 
                настоящей статьи, <b>менее минимального размера заработной платы</b>, установленного законом 
                о республиканском бюджете на соответствующий финансовый год, то размер страховой премии по 
                договору обязательного страхования работника от несчастных случаев составляет 
                <b>минимальный размер заработной платы</b>. При этом страховая сумма увеличивается пропорционально 
                увеличению размера страховой премии.<br />
                <b>Коэфицент увеличения составляет: '.$result['koef_uv'].'</b>
                </span></div>';                                    
            }else{
                $html = '';
            }            
            
            foreach($result['pril2'] as $k=>$v){
                $inp = '';
                foreach($v as $t=>$d){
                    $inp .= $t.':'.$d.';';
                }
                
                $html .= '
                <div class="col-lg-3 list_pril2" id="p2_'.$k.'">
                    <div class="ibox float-e-margins">
                        <input type="hidden" name="pril2[]" class="pril2" value="'.$inp.'">
                        <div class="ibox-title">
                            <button class="label label-danger pull-right del_pril2" data="#p2_'.$k.'"><i class="fa fa-trash"></i></button>
                            <h5 class="p_strah">'.$v['name'].'</h5>
                        </div>
                        <div class="ibox-content">
                            <h5></h5>
                            <ul class="list-group clear-list m-t"><li class="list-group-item fist-item">
                                <span class="pull-right">'.$v['count'].'</span>Численность</li>
                                <li class="list-group-item"><span class="pull-right">'.$v['risk'].'</span>Класс проф.риска</li>
                                <li class="list-group-item"><span class="pull-right">'.$v['oklad'].'</span>Оклад</li>
                                <li class="list-group-item"><span class="pull-right">'.$v['smzp'].'</span>СМЗП</li>
                                <li class="list-group-item"><span class="pull-right">'.$v['gfot'].'</span>ГФОТ</li>
                                <li class="list-group-item"><span class="pull-right">'.$v['str_sum'].'</span>Страховая сумма</li>
                                <li class="list-group-item"><span class="pull-right">'.$v['str_sum_koef'].'</span>Страховая сумма <span>∑</span>×</li>
                            </ul>
                        </div>
                    </div>
                </div>';                
            }
            
            $result['pril2_html'] = $html;
            echo json_encode($result);
            exit;
        }
                
    }
?>