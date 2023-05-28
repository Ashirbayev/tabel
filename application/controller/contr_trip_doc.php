<?php
    $db = new My_sql_db();

    //построение обьекта Employee
    $empId = $_GET['employee_id'];
    $trip_id = $_GET['trip_id'];
    
    //создаем обьект Employee, в параметры передаем ID
    $employee = new Employee($empId);
    
    //функция get_emp_from_DB() возвращает массив с данными о работнике из базы
    $empInfo = $employee -> get_emp_from_DB_trivial();
    
    $sqlEmpInfo = "select triv.DATE_POST, 
                             triv.DATE_LAYOFF, 
                             triv.REASON_LAYOFF, 
                             triv.TAB_NUM, 
                             triv.LASTNAME, 
                             triv.FIRSTNAME,
                             triv.MIDDLENAME, 
                             triv.BIRTHDATE, 
                             triv.BIRTH_PLACE, 
                             triv.SEX, 
                             triv.IIN, 
                             triv.NACIONAL, 
                             triv.FAMILY, 
                             triv.CONTRACT_JOB_NUM, 
                             triv.CONTRACT_JOB_DATE, 
                             triv.STAZH_ALL, 
                             triv.STAZH_CONTIN, 
                             triv.DOCTYPE, 
                             triv.DOCSER, 
                             triv.DOCNUM, 
                             triv.DOCDATE, 
                             triv.DOCPLACE, 
                             triv.REG_ADDRESS_COUNTRY_ID,
                             triv.REG_ADDRESS_DISTRICTS_ID,
                             triv.REG_ADDRESS_REGION_ID,
                             triv.REG_ADDRESS_CITY,
                             triv.REG_ADDRESS_STREET,
                             triv.REG_ADDRESS_BUILDING,
                             triv.REG_ADDRESS_CORPUS,
                             triv.REG_ADDRESS_FLAT,
                             triv.FACT_ADDRESS_COUNTRY_ID,
                             triv.FACT_ADDRESS_DISTRICTS_ID,
                             triv.FACT_ADDRESS_REGION_ID,
                             triv.FACT_ADDRESS_CITY,
                             triv.FACT_ADDRESS_STREET,
                             triv.FACT_ADDRESS_BUILDING,
                             triv.FACT_ADDRESS_CORPUS,
                             triv.FACT_ADDRESS_FLAT,
                             triv.JOB_SP,
                             triv.JOB_POSITION,
                             triv.BRANCHID,
                             triv.WORK_PHONE,
                             triv.HOME_PHONE,
                             triv.MOB_PHONE,
                             triv.FAX,
                             triv.EMAIL,
                             triv.MILITARY_GROUP,
                             triv.MILITARY_CATEG,
                             triv.MILITARY_SOST,
                             triv.MILITARY_RANK,
                             triv.MILITARY_SPECIALITY,
                             triv.MILITARY_VOENKOM,
                             triv.MILITARY_SPEC_UCH,
                             triv.MILITARY_SPEC_UCH_NUM,
                             triv.MILITARY_FIT,
                             triv.ID_RUKOV,
                             triv.BANK_ID,
                             triv.ACCOUNT_TYPE,
                             triv.ACCOUNT,
                             triv.OKLAD,
                             triv.ZV_DATE,
                             triv.GOS_NAGR,
                             triv.INVENTION,
                             triv.STATE,
                             triv.SEX,
                             triv.EMP_ID,
                             triv.PERSONAL_EMAIL
                             from
                             EMPLOYEES triv
                             where triv.id = '$empId'";
    $empInfo = $db -> Select($sqlEmpInfo);

    $sqlEmpEdu = "select * from PERSON_EDUCATION where ID_PERSON = $empId order by id";
    $empEdu = $db -> Select($sqlEmpEdu);

    $sqlExperiance = "select * from PERSON_STAZH where ID_PERSON = $empId order by id";
    $empExperiance = $db -> Select($sqlExperiance);    

    $sql_trip = "select * from PERSON_TRIP where ID = $trip_id";
    $list_trip = $db -> Select($sql_trip);
    //echo '<pre>';
    //print_r($list_trip);
    //echo '<pre>';
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

    $sql_trip_det = "select FROM_TO.*, TRANS.NAME TR_NAME from TRIP_FROM_TO FROM_TO, DIC_TRANSPORT_FOR_TRIP TRANS where TRANS.ID = FROM_TO.TRANSPORT AND FROM_TO.TRIP_ID = $trip_id order by FROM_TO.id";
    $list_trip_det = $db -> Select($sql_trip_det);

    $sql_t2_inf_transf = "select * from T2_CARD where ACT_ID = 3 and ID_PERSON = $empId order by id";
    $list_t2_inf_transf = $db -> Select($sql_t2_inf_transf);

    $sql_t2_inf_holy = "select * from PERSON_HOLIDAYS where ID_PERSON = $empId order by id";
    $list_t2_inf_holy = $db -> Select($sql_t2_inf_holy);    

    $lastname = $empInfo[0]['LASTNAME'];
    $firstname = $empInfo[0]['FIRSTNAME'];
    $middlename = $empInfo[0]['MIDDLENAME'];
    $BIRTHDATE = $empInfo[0]['BIRTHDATE'];
    $DOCNUM = $empInfo[0]['DOCNUM'];
    $DOCDATE = $empInfo[0]['DOCDATE'];
    $country = $empInfo[0]['RU_NAME'];
    $cityname = $empInfo[0]['FACT_ADDRESS_CITY'];
    $fact_street = $empInfo[0]['FACT_ADDRESS_STREET'];
    $fact_address_building = $empInfo[0]['FACT_ADDRESS_BUILDING'];
    $DATE_LAYOFF = $empInfo[0]['DATE_LAYOFF'];
    
    $bossname = $_GET['bossname'];
    $bossname_kaz = $_GET['bossname_kaz'];
    //position ID
    $pos_id = $empInfo[0]['JOB_POSITION'];
    $dep_id = $empInfo[0]['JOB_SP'];
    $filial_id = $empInfo[0]['FILIAL'];
    $branch_id = $empInfo[0]['BRANCHID'];
    $sql_branch = "select NAME, ADDRESS, ADDRESS_KZ from DIC_BRANCH where RFBN_ID = $branch_id";
    $emp_branch = $db -> Select($sql_branch);
    $address_kaz = $emp_branch[0]['ADDRESS_KZ'];
    $address = $emp_branch[0]['ADDRESS'];
    $branch_name = $emp_branch[0]['NAME'];
    $sql_depart = "select NAME from DIC_DEPARTMENT where BRANCH_ID = $branch_id";
    $emp_depart = $db -> Select($sql_depart);
    $depName = $emp_depart[0]['NAME'];
    $sql_position = "select D_NAME from DIC_DOLZH where ID = $pos_id";
    $emp_position = $db -> Select($sql_position);
    $posName = $emp_position[0]['D_NAME'];

    //position ID
    $telNum = $empInfo[0]['MOB_PHONE'];
    $IIN = $empInfo[0]['IIN'];
    $IIN = $empInfo[0]['IIN'];
    $OKLAD = $empInfo[0]['OKLAD'];
    $TAB_NUM = $empInfo[0]['TAB_NUM'];
    $DOC_PLACE = $empInfo[0]['DOC_PLACE'];
    $FAMILY_STATE = $empInfo[0]['FAMILY_STATE'];
    $NATION = $empInfo[0]['NATION'];
    $MOB_PHONE = $empInfo[0]['MOB_PHONE'];
    $HOME_PHONE = $empInfo[0]['HOME_PHONE'];

    $DOCPLACE_ID = $empInfo[0]['DOCPLACE'];
    $sql_doc = "select NAME_KAZ, NAME from DIC_DOC_PLACE where ID = $DOCPLACE_ID";
    $emp_doc = $db -> Select($sql_doc);
    $DOCPLACE = $emp_doc[0]['NAME'];
    $DOCPLACE_KAZ = $emp_doc[0]['NAME_KAZ'];

    $DOCDATE = $empInfo[0]['DOCDATE'];
    $FACT_ADDRESS = $empInfo[0]['FACT_ADDRESS'];

    $today_date = date('d.m.Y');
    $now_time = date('H:i:s');
    $d = getdate();

    foreach ( $d as $key => $val )
    $_monthsList = array(
    "1"=>"Января","2"=>"Февраля","3"=>"Марта",
    "4"=>"Апреля","5"=>"Мая", "6"=>"Июня",
    "7"=>"Июля","8"=>"Августа","9"=>"Сентября",
    "10"=>"Октября","11"=>"Ноября","12"=>"Декабря");

    $month = $_monthsList[date("n")];

    $DATE_POST = $empInfo[0]['DATE_POST'];
    $last = substr($DATE_POST, -1);
    $last_rep = $last+1;
    $DATE_POST_PLUS_YEAR = substr_replace($DATE_POST, $last_rep,-1);

    $html = '';?>

    <?php
    include("methods/mpdf/mpdf.php");
    
    //$mpdf = new mPDF('UTF-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
    //$mpdf->charset_in = 'cp1251'; /*не забываем про русский*/
    //$mpdf->WriteHTML($stylesheet, 1);

    //$mpdf->list_indent_first_level = 0; 
    //$mpdf->WriteHTML($html, 2); /*формируем pdf*/
    //$mpdf->Output('mpdf.pdf', 'I');
    
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
            array('тиын' ,'тиын' ,'тиын',    1),
            array('тенге'   ,'тенге'   ,'тенге'    ,0),
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
        $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
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
            array('тиын' ,'тиын' ,'тиын',    1),
            array('теңге'   ,'теңге'   ,'теңге'    ,0),
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
        $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
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
        Редактирование документа документ
    </h2>
</div>
<div class="col-lg-12 animated fadeInRight" style="background-color: white;">
    <form id="form_send_html" method="POST" action="just_print" target="_blank">
    <textarea name="content" style="width: 100%;">
    
<div align="center" style="float: left; width: 100%; margin-right: 10px; font-size: 14px; float: left; font-family: TimesNewRoman; font-style: normal;">
    <div style="text-align: right;">
        <strong>Командировочное удостоверение № _____</strong>
    </div>
    <div align="justify" style="border-bottom: black; font-size: 10px;">
           
                 <div align="justify" style="float: left; width: 50%; ">
                 <p>
                <strong>Акционерное общество <br /> "Компания"</strong>  
                </p>
                <br />
                <br />
                <br />
                <br />
                <p align="justify">
                <strong>Дата:</strong> <?php echo $ORDER_DATE; ?> 
                </p>
                 <br />
                  <br /> 
                  <br /> 
                  <br />
                   <br />
                 <p align="left">
                <strong>М.П.</strong>
                </p>
                   <br /> 
                  <br />
                   <br />
                  <br /> 
                   <br />
                   <br />
                   <br />
                   <br />
                   <br />
                   <br />
                   <br />
                   <br />
                <p align="justify">
                <strong>Отметки о прибытии и убытии командированного лица</strong> 
                </p>
            </div>    
    <div align="justify" style="float: left; width: 50%; ">
                <p align="justify">
                    Выдано: <br /> <strong><?php echo $lastname.' '.$firstname.' '.$middlename; ?></strong> <br /> <strong> <?php echo $posName; ?> </strong> <br /> <strong><?php echo $depName ?></strong> <br />  Ф.И.О, должность, департамент
                </p>
                <p align="justify">
                    <strong>  АО "Компания" </strong> <br /> наименование организации
                </p>
                <p align="justify">
                    <strong> <?php echo $FINAL_DESTINATION; ?>  </strong> <br /> куда командируется
                </p>
                <p align="justify">
                   Срок командирования: c <?php echo $DATE_BEGIN; ?> по <?php echo $DATE_END; ?> года
                </p>
                <p align="justify">
                    <?php echo $AIM; ?> <br /> цель командировки
                </p>
                <p align="justify">
                   Основание: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; приказ 
                </p>
                <p align="justify">
                от <?php echo $ORDER_DATE; ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; №<?php echo $ORDER_NUM; ?> 
                </p>
                <p align="justify">
                    <strong>Подпись ответственного лица за выдачу <br /> командировочного удостоверения: </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___________________________
                </p>  
     </div>                                                                
    <hr />
    </div>
    <?php 
        foreach($list_trip_det as $t => $y){
    ?>
            <div align="justify" style="border-bottom: black; font-size: 10px;">
                <div align="justify" style="float: left; width: 50%; ">
                    <strong>Выбыл из города: </strong> <?php echo $y['FROM_PLACE']; ?>
                    <p>"_______"________________20____г.</p>
                    <strong>подпись</strong> ____________________________<br /><br /><br /><br />
                    <strong>печать</strong><br /><br />                            
                </div>
                <div align="justify" style="float: left; width: 50%; ">
                    <strong>Прибыл в город: </strong> <?php echo $y['TO_PLACE']; ?><br /><br />
                    <p>"_______"________________20____г.</p>
                    <strong>подпись</strong> ____________________________<br /><br /><br />
                    <strong>печать</strong><br /><br />
                </div>
                <hr />
            </div>
            
                        <div align="justify" style="border-bottom: black; font-size: 10px;">
                <div align="justify" style="float: left; width: 50%; ">
                    <strong>Выбыл из города: </strong> <?php echo $y['TO_PLACE']; ?>
                    <p>"_______"________________20____г.</p>
                    <strong>подпись</strong> ____________________________<br /><br /><br /><br />
                    <strong>печать</strong><br /><br />                            
                </div>
                <div align="justify" style="float: left; width: 50%; ">
                    <strong>Прибыл в город: </strong> <?php echo $y['FROM_PLACE']; ?><br /><br />
                    <p>"_______"________________20____г.</p>
                    <strong>подпись</strong> ____________________________<br /><br /><br />
                    <strong>печать</strong><br /><br />
                </div>
                <hr />
            </div>
                                    <div align="justify" style="border-bottom: black; font-size: 10px;">
                <div align="justify" style="float: left; width: 50%; ">
                    <strong>Выбыл из города: </strong> ____________________
                    <p>"_______"________________20____г.</p>
                    <strong>подпись</strong> ____________________________<br /><br /><br /><br />
                    <strong>печать</strong><br /><br />                            
                </div>
                <div align="justify" style="float: left; width: 50%; ">
                    <strong>Прибыл в город: </strong> _______________<br /><br />
                    <p>"_______"________________20____г.</p>
                    <strong>подпись</strong> ____________________________<br /><br /><br />
                    <strong>печать</strong><br /><br />
                </div>
                <hr />
            </div>
    <?php 
        }
    ?>
    </textarea>
       
    <div class="mail-body text-right tooltip-demo">
        <button onclick="" type="submit" target="_blank" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="print"><i class="fa fa-reply"></i> Конвертировать в PDF</button>
    </div>
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