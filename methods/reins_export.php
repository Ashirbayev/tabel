<?php
	class REINS_EXPORT
    {
	   private $db;
       private $dan = array();
       public $array;
       public $html;
       
       private $q_dan1 = array();
       private $q_dan2 = array();
       
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
                foreach($_POST as $k=>$v);   
                if(method_exists($this, $k)){
                    $this->array = $_POST;
                    $this->$k($v); 
                }else{
                    $this->dan[$k] = $v;                    
                }
            }
        }
        
        /*--GET--*/
        private function contract_num($dan)
        {       
            $sql = "
            select 
                rownum rs, 
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
                    when b.typ = 3 then 0 
                    else 
                    case 
                        when d.vid = 1 then 
                        case 
                            when nvl((select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id), 0) = 0 then O.CNT_AUP+O.CNT_PP+o.CNT_VP 
                            else (select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id) 
                        end 
                    else 
                        (select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id) - 
                        (select sum(cnt) from osns_calc_new where cnct_id = ( 
                            case 
                                when (select count(*) from contracts where id_head = d.id_head and state <> 13) > 1 then (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id and state <> 13) 
                                else d.id_head 
                            end ) ) 
                    end 
                end cnt, 
                case 
                    when b.typ = 3 then 0 
                    else d.pay_sum_v - case when d.vid = 2 then 
                    nvl(
                            (select pay_sum_v from contracts where cnct_id = (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id)),
                            (select pay_sum_v from contracts where cnct_id = d.id_head)
                       )
                    else 0 end 
                end pay_sum_v, 
                A.TARIF, 
                R.PERC_S_GAK, 
                case 
                    when b.typ = 3 then 0 
                    else 
                    case 
                        when r.vid = 2 then R.SUM_S_GAK            
                        else round( (d.pay_sum_v - case when d.vid = 1 then 0 else
                        nvl(
                            (select pay_sum_v from contracts where cnct_id = (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id)),
                            (select pay_sum_v from contracts where cnct_id = d.id_head)
                       )                               
                       end) * (R.PERC_S_GAK / 100), 2)
                    end
                end SUM_S_GAK,
                R.PERC_S_STRAH,     
                case 
                    when b.typ = 3 then 0 
                    else
                    case 
                        when r.vid = 2 then R.SUM_S_STRAH            
                        else  round( (d.pay_sum_v - case when d.vid = 1 then 0 else 
                        nvl(
                            (select pay_sum_v from contracts where cnct_id = (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id)),
                            (select pay_sum_v from contracts where cnct_id = d.id_head)
                       )                         
                        end) * (R.PERC_S_STRAH / 100) , 2)
                    end     
                end SUM_S_STRAH, 
                case 
                    when b.typ = 3 then 0 
                    else 
                    case 
                        when d.vid = 1 then D.PAY_SUM_P 
                        else d.sum_vozvr 
                    end 
                end PAY_SUM_P, 
                R.PERC_P_STRAH, 
                case 
                    when b.typ = 3 then 0 
                    else bl.pay_sum 
                end SUM_P_STRAH_all, 
                bl.pay_sum_opl SUM_P_STRAH, 
                trim(substr(D.PERIODICH, 2)) PERIODICH, 
                reins_transh_html(d.cnct_id, r.PERC_P_STRAH) primechanie 
            from 
                REINSURANCE r, 
                contracts d, 
                contr_agents c, 
                osns_calc o, 
                DIC_OKED_AFN a, 
                bordero_contracts b, 
                bordero_contracts_list bl 
            where 
                d.cnct_id = r.cnct_id 
                and A.ID = D.OKED_ID 
                and o.cnct_id = d.cnct_id 
                and C.ID = d.id_insur 
                and B.ID = bl.id_contracts 
                and bl.cnct_id = d.cnct_id 
                and d.state <> 13 
                and b.id = $dan
            ";
                
            if(isset($_GET['cnct_id'])){
                $sql .= " and d.cnct_id = ".$_GET['cnct_id'];
            }
            //echo $sql;
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
            
            //$ds = $this->db->Select("select max(contract_date) contract_date from reinsurance where contract_num = '$dan'");
            $ds = $this->db->Select("select * from bordero_contracts where id = $dan");            
            $html .= '<div style="text-align: left; float: left; width: 45%; font-size: 8px;margin-bottom: 15px;">
            Қосымша №1<br />
            қызметкердің өзінің еңбек (қызмет) мiндеттерiн атқарумен<br />
            байланысты жазатайым оқиғалардан факультативтік<br /> 
            қайта сақтандыру Шартына<br />
            '.$ds[0]['CONTRACT_NUM'].'<br />
            '.$ds[0]['CONTRACT_DATE'].' ж.</div>
            <div style="text-align: right; float: right; width: 45%; font-size: 8px;margin-bottom: 15px;">
            Приложение № 1<br />
            к Договору факультативного перестрахования работника<br /> 
            от несчастных случаев при исполнении им<br />
            трудовых (служебных) обязанностей<br />
            '.$ds[0]['CONTRACT_NUM'].'<br />
            от '.$ds[0]['CONTRACT_DATE'].' г.<br />
            </div>';
            $contr_num = $ds[0]['CONTRACT_NUM'];
            
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
            
            
            $sql = "
            select
                sum(case 
                    when b.typ = 3 then 0 
                    else 
                    case 
                        when d.vid = 1 then 
                        case 
                            when nvl((select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id), 0) = 0 then O.CNT_AUP+O.CNT_PP+o.CNT_VP 
                            else (select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id) 
                        end 
                    else 
                        (select sum(cnt) from osns_calc_new where cnct_id = d.cnct_id) - 
                        (select sum(cnt) from osns_calc_new where cnct_id = ( 
                            case 
                                when (select count(*) from contracts where id_head = d.id_head and state <> 13) > 1 then (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id and state <> 13) 
                                else d.id_head 
                            end ) ) 
                    end 
                end) cnt,
                sum(case 
                    when b.typ = 3 then 0 
                    else d.pay_sum_v - case when d.vid = 2 then (select pay_sum_v from contracts where cnct_id = (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id)) else 0 end 
                end) pay_sum_v,                
                null TARIF,
                null PERC_S_GAK,
                sum(case 
                    when b.typ = 3 then 0 
                    else 
                    case 
                        when r.vid = 2 then R.SUM_S_GAK            
                        else round( (d.pay_sum_v - case when d.vid = 1 then 0 else (select pay_sum_v from contracts where cnct_id = (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id)) end) * (R.PERC_S_GAK / 100), 2)
                    end
                end) SUM_S_GAK,
                null PERC_S_STRAH,
                sum(case 
                    when b.typ = 3 then 0 
                    else
                    case 
                        when r.vid = 2 then R.SUM_S_STRAH            
                        else  round( (d.pay_sum_v - case when d.vid = 1 then 0 else (select pay_sum_v from contracts where cnct_id = (select max(cnct_id) from contracts where id_head = d.id_head and cnct_id < d.cnct_id)) end) * (R.PERC_S_STRAH / 100) , 2)
                    end     
                end) SUM_S_STRAH,
                sum(case 
                    when b.typ = 3 then 0 
                    else 
                    case 
                        when d.vid = 1 then D.PAY_SUM_P 
                        else d.sum_vozvr 
                    end 
                end) PAY_SUM_P,
                null PERC_P_STRAH,
                sum(case 
                    when b.typ = 3 then 0 
                    else bl.pay_sum 
                end) SUM_P_STRAH_all,
                sum(BL.PAY_SUM_OPL) SUM_P_STRAHs,
                null PERIODICH,
                null primechanie
            from 
                REINSURANCE r, 
                contracts d,
                contr_agents c,
                osns_calc o,
                DIC_OKED_AFN a,
                bordero_contracts b,
                bordero_contracts_list bl 
            where  
                 d.cnct_id = r.cnct_id 
                and A.ID = D.OKED_ID 
                and o.cnct_id = d.cnct_id                  
                and C.ID = d.id_insur 
                and B.ID = bl.id_contracts
                and bl.cnct_id = d.cnct_id
                and d.state <> 13
                and b.id = $dan
                group by b.typ";
            //echo $sql;
            $ds = $this->db->Select($sql);
                
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
            
            
            $ps = $this->db->Select("select * from dic_reinsurance where id = (select REINSUR_ID from reinsurance where CONTRACT_NUM = '$contr_num' group by REINSUR_ID)");            
            
            $html .= '<div style="float:left;width: 45%;">
                <h6>ПЕРЕСТРАХОВЩИК:</h6>
                <p style="font-size: 8px;">'.$ps[0]['DIR_DOLGNOST'].'</p>
                <table border=0 width="100%" style="font-size: 8px;">
                <tr>
                    <td style="border-color: #fff;">_______________________________________</td>
                    <td style="border-color: #fff;">'.$ps[0]['DIR_NAME'].'</td>
                </tr>
                
                <tr>
                    <td style="border-color: #fff;"><span style="font-size:6px;">М.П.</span></td>
                    <td style="border-color: #fff;"></td>
                </tr>
                </table>
                
            </div>';
            /*
            $html .= '<div style="float:right;width: 45%;">
            <h6>ПЕРЕСТРАХОВАТЕЛЬ:</h6>
                <p style="font-size: 8px;">И.о. Председателя Правления</p>
                
                <table border=0 width="100%" style="font-size: 8px;">
                <tr>
                    <td style="border-color: #fff;">_______________________________________</td>
                    <td style="border-color: #fff;">Маканова Асель Куандыковна</td>
                </tr>
                
                <tr>
                    <td style="border-color: #fff;"><span style="font-size:6px;">М.П.</span></td>
                    <td style="border-color: #fff;"></td>
                </tr>
                </table>                                
            </div></div>';
            */
            /*
            $html .= '<div style="float:right;width: 45%;">
            <h6>ПЕРЕСТРАХОВАТЕЛЬ:</h6>
                <p style="font-size: 8px;">Председатель Правления</p>
                
                <table border=0 width="100%" style="font-size: 8px;">
                <tr>
                    <td style="border-color: #fff;">_______________________________________</td>
                    <td style="border-color: #fff;">Амерходжаев Галым Ташмуханбетович</td>
                </tr>
                
                <tr>
                    <td style="border-color: #fff;"><span style="font-size:6px;">М.П.</span></td>
                    <td style="border-color: #fff;"></td>
                </tr>
                </table>                                
            </div></div>';
            */
            $html .= '<div style="float:right;width: 45%;">
            <h6>ПЕРЕСТРАХОВАТЕЛЬ:</h6>
                <p style="font-size: 8px;">Управляющий директор</p>
                
                <table border=0 width="100%" style="font-size: 8px;">
                <tr>
                    <td style="border-color: #fff;">_______________________________________</td>
                    <td style="border-color: #fff;">Акажанов Алемжан Алтынбекович</td>
                </tr>
                
                <tr>
                    <td style="border-color: #fff;"><span style="font-size:6px;">М.П.</span></td>
                    <td style="border-color: #fff;"></td>
                </tr>
                </table>                                
            </div></div>';
            
            $this->html = $html;
        }
        
        private function export($dan)
        {
            if(method_exists($this, $dan)){
                $this->$dan();
            }else{
                echo 'Ошибка запроса формата файла!';
            }                       
            exit; 
        }
        
        private function pdf()
        {
            require_once("methods/mpdf/mpdf.php");
            $mpdf = new mPDF();      
            $mpdf->showImageErrors = true;       
            $mpdf->SetTitle($_GET['contract_num']);  
            $mpdf->AddPage('L');  
            //$date = date('d.m.Y H:i:s');           
            //$mpdf->setFooter($date.' Страница - {PAGENO}');
            
                        
            $base64 = 'styles/img/logo_gak_min.jpg';
            //Водяной знак
            
            $mpdf->SetWatermarkImage($base64);
            $mpdf->showWatermarkImage = true;
            $mpdf->watermarkImageAlpha = 0.1;
            
            //Вставить footer с картинкой
            
            $mpdf->SetHTMLFooter('
            <div style="position: relative;float: left; width: 33%;font-size: 8px;opacity: 0.5;">АО "Компания по страхованию жизни "Государственная аннуитетная компания"<br />www.gak.kz</div> 
            <div style="position: relative;float: left; width: 33%;text-align: center;opacity: 0.5;"><img src="'.$base64.'" width="25" height="25" ></div> 
            <div style="position: relative;float: right; width: 33%;text-align: right;font-size: 8px;opacity: 0.5;">АО "Компания по страхованию жизни "Государственная аннуитетная компания"<br />www.gak.kz</div>');
            
             
            $mpdf->WriteHTML($this->html);                 
            $c = $_GET['contract_num'];                   
            $mpdf->Output(); 
        }
        
        private function xls()
        {            
            $c = $_GET['contract_num'];

            error_reporting(E_ALL);
            ini_set('display_errors', TRUE); 
            ini_set('display_startup_errors', TRUE); 

            header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment;Filename=$c.xls");
            echo $this->html;
                        
        }
        
        private function html()
        {
            echo $this->html;            
        }
        
        /*--POST--*/
         
	}