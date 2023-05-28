<?php
$db = new My_sql_db();

$trip_id = $_GET['trip_id'];

$sql_trip = "select * from PERSON_TRIP where ID = $trip_id";
$list_trip = $db -> Select($sql_trip);

$empId = $list_trip[0]['PERSON_ID'];
$DATE_BEGIN = $list_trip[0]['DATE_BEGIN'];
$DATE_END = $list_trip[0]['DATE_END'];
$CNT_DAYS = $list_trip[0]['CNT_DAYS'];
$ORDER_NUM = $list_trip[0]['ORDER_NUM'];
$ORDER_DATE = $list_trip[0]['ORDER_DATE'];
$EMP_ID = $list_trip[0]['EMP_ID'];
$AIM = $list_trip[0]['AIM'];
$AIM_KAZ = $list_trip[0]['AIM_KAZ'];
$FINAL_DESTINATION = $list_trip[0]['FINAL_DESTINATION'];
$FINAL_DESTINATION_KAZ = $list_trip[0]['FINAL_DESTINATION_KAZ'];

$sql_trip_detail = "select TRIP_DETAIL.*, TRANSPORT.* from TRIP_FROM_TO TRIP_DETAIL, DIC_TRANSPORT_FOR_TRIP TRANSPORT where TRANSPORT.ID = TRIP_DETAIL.TRANSPORT and TRIP_ID = $trip_id order by TRIP_DETAIL.ID";
$list_trip_detail = $db -> Select($sql_trip_detail);

//echo '<pre>';
//print_r($list_trip_detail);
//echo '<pre>';

$FROM_PLACE = $list_trip_detail[0]['FROM_PLACE'];
$TO_PLACE = $list_trip_detail[0]['TO_PLACE'];
$TRANS_NAME = $list_trip_detail[0]['NAME'];
$TRANS_NAME_KAZ = $list_trip_detail[0]['NAME_KAZ'];

//создаем обьект Employee, в параметры передаем ID
$employee = new Employee($empId);

//функция get_emp_from_DB() возвращает массив с данными о работнике из базы
$empInfo = $employee -> get_emp_from_DB_trivial();

$lastname = $empInfo[0]['LASTNAME'];
$name = $empInfo[0]['FIRSTNAME'];
$name_first_simb = mb_substr($name,0,1,"UTF-8");
$middlename = $empInfo[0]['MIDDLENAME'];
$middlename_first_simb = mb_substr($middlename,0,1,"UTF-8");
$DOCNUM = $empInfo[0]['DOCNUM'];
$DOCDATE = $empInfo[0]['DOCDATE'];
$country = $empInfo[0]['RU_NAME'];
$cityname = $empInfo[0]['FACT_ADDRESS_CITY'];
$fact_street = $empInfo[0]['FACT_ADDRESS_STREET'];
$fact_address_building = $empInfo[0]['FACT_ADDRESS_BUILDING'];
//position ID
$pos_id = $empInfo[0]['JOB_POSITION'];
$dep_id = $empInfo[0]['JOB_SP'];
$filial_id = $empInfo[0]['FILIAL'];
$branch_id = $empInfo[0]['BRANCHID'];
$sql_branch = "select NAME, NAME_KZ, ADDRESS, ADDRESS_KZ from DIC_BRANCH where RFBN_ID = $branch_id";
$emp_branch = $db -> Select($sql_branch);
$address_kaz = $emp_branch[0]['ADDRESS_KZ'];
$address = $emp_branch[0]['ADDRESS'];
$branch_name = $emp_branch[0]['NAME'];
$branch_name_kaz = $emp_branch[0]['NAME_KZ'];
$sql_depart = "select NAME, NAME_KAZ from DIC_DEPARTMENT where ID = $dep_id";
$emp_depart = $db -> Select($sql_depart);
$depName = $emp_depart[0]['NAME'];
$depName_kaz = $emp_depart[0]['NAME_KAZ'];
$sql_position = "select D_NAME, D_NAME_KAZ from DIC_DOLZH where id = $pos_id";
$emp_position = $db -> Select($sql_position);
$posName = $emp_position[0]['D_NAME'];
$posNameKaz = $emp_position[0]['D_NAME_KAZ'];
//position ID
$telNum = $empInfo[0]['MOB_PHONE'];
$IIN = $empInfo[0]['IIN'];
$IIN = $empInfo[0]['IIN'];
$OKLAD = $empInfo[0]['OKLAD'];

$DOCPLACE_ID = $empInfo[0]['DOCPLACE'];
$sql_doc = "select NAME_KAZ, NAME from DIC_DOC_PLACE where ID = $DOCPLACE_ID";
$emp_doc = $db -> Select($sql_doc);
$DOCPLACE = $emp_doc[0]['NAME'];
$DOCPLACE_KAZ = $emp_doc[0]['NAME_KAZ'];

$DOCDATE = $empInfo[0]['DOCDATE'];
$FACT_ADDRESS = $empInfo[0]['FACT_ADDRESS'];
$FACT_ADDRESS_FLAT = $empInfo[0]['FACT_ADDRESS_FLAT'];

$d = getdate();

foreach ( $d as $key => $val )
$_monthsList = array(
"1"=>"Января","2"=>"Февраля","3"=>"Марта",
"4"=>"Апреля","5"=>"Мая", "6"=>"Июня",
"7"=>"Июля","8"=>"Августа","9"=>"Сентября",
"10"=>"Октября","11"=>"Ноября","12"=>"Декабря");

$month = $_monthsList[date("n")];

$DATE_POST = $empInfo[0]['DATE_POST'];

$html .= '<br><br><br><br><br><br><br>
<div border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: "Times New Roman", Times, serif; 
            text-align: justify;
            font-size: 14pt;
            margin-left: 20px;
            margin-right: 10px;
            font-weight: normal;
            line-height: 1.0;">
                <p>
                    <div style="font-size: 14pt; line-height: 1.0; text-align: justify;"><br /><br /><br /><br /><br />
                    <font face="verdana">
                        <strong>'.$name_first_simb.'. '.$middlename_first_simb.'. '.$lastname.' іс-сапарға жіберу туралы</strong><br>
                    </font>
                    </div>
                    </p><div align="justify" style="text-indent: 30px; line-height: 1.0; font-size: 14pt; text-align: justify;">
                        <font face="verdana">
                            '.$AIM_KAZ.', <strong>БҰЙЫРАМЫН:</strong><br>
                        </font>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            1. '.$depName_kaz.' '.$posNameKaz.' '.$name.' '.$middlename.' '.$lastname.' '.$FINAL_DESTINATION_KAZ.' '.$CNT_DAYS.' күнге '.$DATE_BEGIN.' ж. бастап '.$DATE_END.' ж. дейін іс-сапарға жіберілсін.
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            2. Персоналды басқару бойынша бас маманға іс-сапар куәлігін беру тапсырылсын.
                        </font>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            3. Бухгалтерлік есеп және қаржылық есептілік департаменті тәуліктік шығындарды, қонақ үй шығындары, '; 
                            foreach($list_trip_detail as $k => $v){
                                $html .= $v['FROM_PLACE'].' - '.$v['TO_PLACE'].' '.$v['NAME_KAZ'].', ';
                            }
                                    
                $html .= 'төленсін.
                        </font>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            4. '.$DATE_BEGIN.' бастан '.$DATE_END.' дейін Басқарма төрағасының міндеттерін атқаруды Басқарма төрағасының орынбасары Имя Отчество Фамилия жүктеймін.
                        </font>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            Негіздеме: '.$depName_kaz.' қызметтік жазбасы.
                        </font>
                    </div>
                    
                    <br><br>
                    <div style="text-indent: 30px; font-size: 14pt;">
                        <font face="verdana">
                            <strong>Басқарма төрағасы &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
И. Директора</strong>
                        </font>
                    </div><br><br>
                    
</div>

<div border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: "Times New Roman", Times, serif; 
            text-align: justify;
            font-size: 14pt;
            margin-left: 20px;
            margin-right: 10px;
            font-weight: normal;
            line-height: 1.0;">
                    <div style="font-size: 14pt; ">
                       <font face="verdana">
                            <strong>О командировании '.$lastname.' '.$name_first_simb.'. '.$middlename_first_simb.'.</strong><br>
                        </font>
                    </div>
                        <br>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            '.$AIM.', <strong>ПРИКАЗЫВАЮ:</strong>
                        </font>        
                    <br>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            1. Командировать '.$posName.' '.$depName.' '.$lastname.' '.$name.' '.$middlename.' в '.$FINAL_DESTINATION.' на '.$CNT_DAYS.' дн., с '.$DATE_BEGIN.' г. по '.$DATE_END.' г. 
                        <font face="verdana">
                    </font></font></div><font face="verdana"><font face="verdana"> 
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            2. Главному специалисту по управлению персоналом выдать командировочное удостоверение.
                        </font>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            3. Департаменту бухгалтерского учета и финансовой отчетности оплатить суточные расходы, расходы на проживание, проезд по маршруту ';
                            foreach($list_trip_detail as $k => $v){
                                $html .= $v['FROM_PLACE'].' - '.$v['TO_PLACE'].' '.$v['NAME'].', ';
                            }
$html .= '</font>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            4. Исполнение обязанностей председателя Правления возлагаю с '.$DATE_BEGIN.' по '.$DATE_END.' на заместителя председателя Правления Маканову Асель Куандыковну.
                        </font>
                    </div>
                    <div style="text-indent: 30px; font-size: 14pt; line-height: 1.0; text-align: justify;">
                        <font face="verdana">
                            Основание: служебная записка '.$depName.'.
                        </font>
                    </div>
                    <br><br>
                    <div style="text-indent: 30px; font-size: 14pt;">
                        <font face="verdana">
                            <strong>Председатель Правления &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
И. Директора</strong>
                        </font>
                    </div>
                    <br><br>
                    <div style="font-size: 14pt;">
                    <font face="verdana">
                        Бұйрықпен таныстырылды:
                    </font>
                            <br><br>
                    <font face="verdana">
                        '.$name_first_simb.'. '.$middlename_first_simb.'. '.$lastname.' _____________ '.date("Y").' жылғы «___» _________
                    </font>
                <p></p>
</font></font></div>
        ';
    function num2str($num) {
        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit=array( // Units
            array('' ,'' ,'',    1),
            array(''   ,''   ,''    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        //$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }
    
    function num3str($num) {
        $nul='ноль';
        $ten=array(
            array('','бір','екі','үш','төрт','бес','алты','жеті', 'сегіз','тоғыз'),
            array('','бір','екі','үш','төрт','бес','алты','жеті', 'сегіз','тоғыз'),
        );
        $a20=array('он','он бір','он екі','он үш','он төрт' ,'он бес','он алты','он жеті','он сегіз','он тоғыз');
        $tens=array(2=>'жиырма','отыз','қырық','елу','алпыс','жетпіс' ,'сексен','тоқсан');
        $hundred=array('','жүз','екі жуз','үш жуз','төрт жуз','бес жуз','алты жуз', 'жеті жуз','сегіз жуз','тоғыз жуз');
        $unit=array( // Units
            array('' ,'' ,'',    1),
            array(''   ,''   ,''    ,0),
            array('мың'  ,'мың'  ,'мың'     ,1),
            array('миллион' ,'миллион','миллион' ,0),
            array('миллиард','миллиард','миллиард',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        //$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }
    
    /**
     * Склоняем словоформу
     * @ author runcore
     */
    function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }
?>

<div class="mail-box-header">
    <h2>
        Редактирование документа
    </h2>
</div>
<div class="col-lg-12 animated fadeInRight" style="background-color: white;">
    <form id="form_send_html" method="POST" action="just_print" target="_blank">
    <textarea name="content" style="width: 100%;">
    	<?php
            echo $html;
        ?>
    </textarea>
       
    <div class="mail-body text-right tooltip-demo">
        <button onclick="" type="submit" target="_blank" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="print"><i class="fa fa-reply"></i> Конвертировать в PDF</button>
    </div>
    </form>
</div>
<script type="text/javascript" src="styles/js/others/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

<?php
    exit;
?>