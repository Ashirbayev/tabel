<?php
    $db = new My_sql_db();

    //построение обьекта Employee
    $empId = $_GET['employee_id'];
    
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
                             triv.PERSONAL_EMAIL,
                             NATION.RU_NAME NATION,
                             FAMILY.NAME family_state,
                             DOC_PLACE.NAME DOC_PLACE,
                             DEP_NAME.NAME DEP_NAME_RU
                             from
                             EMPLOYEES triv,
                             DIC_NATIONALITY NATION,
                             DIC_FAMILY FAMILY,
                             DIC_DEPARTMENT DEP_NAME,
                             DIC_DOC_PLACE DOC_PLACE
                             where triv.DOCPLACE = DOC_PLACE.ID and FAMILY.ID = triv.FAMILY and NATION.ID = triv.NACIONAL and triv.ID = $empId and DEP_NAME.ID = triv.JOB_SP";
    $empInfo = $db -> Select($sqlEmpInfo);

    $sqlEmpEdu = "select * from PERSON_EDUCATION where ID_PERSON = $empId order by id";
    $empEdu = $db -> Select($sqlEmpEdu);

    $sqlExperiance = "select * from PERSON_STAZH where ID_PERSON = $empId order by id";
    $empExperiance = $db -> Select($sqlExperiance);

    $sqlJOB_CONTR_NUM = 'select JOB_CONTR_NUM from JOB_CONTR_NUM where id = 1';
    $listJOB_CONTR_NUM = $db -> Select($sqlJOB_CONTR_NUM);
    $JOB_CONTR_NUM = $empInfo[0]['CONTRACT_JOB_NUM'];
    $CONTRACT_JOB_DATE = $empInfo[0]['CONTRACT_JOB_DATE'];

    $sql_t2_inf_transf =
    "SELECT
        t2.*,
        DEP_NAME.NAME DEP_NAME_RU,
        dolzh.D_NAME
    FROM
        T2_CARD t2,
        DIC_DOLZH dolzh,
        DIC_DEPARTMENT DEP_NAME
    WHERE
        t2.ACT_ID = 3
        AND dolzh.ID = t2.POSITION
        AND t2.ID_PERSON = $empId
        AND DEP_NAME.ID = t2.DEPARTMENT
    ORDER BY t2.id";
    $list_t2_inf_transf = $db -> Select($sql_t2_inf_transf);
    //echo '<pre>';
    //print_r($list_t2_inf_transf);
    //echo '<pre>';

    $sql_t2_inf_holy = "select * from PERSON_HOLIDAYS where ID_PERSON = $empId and (VID = 1 OR VID = 2) order by DATE_BEGIN";
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

    function num2str($num)
    {
        $nul='ноль';
        $ten=array
        (
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
        if (intval($rub)>0)
        {
            foreach(str_split($rub,3) as $uk=>$v)
            { // by 3 symbols
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
        if (intval($rub)>0)
        {
            foreach(str_split($rub,3) as $uk=>$v)
            { // by 3 symbols
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
    function morph($n, $f1, $f2, $f5)
    {
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
    
<div align="center">
    <div align="center" style="float: left; width: 100%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman;
            	font-size: 12px;
            	font-style: normal;
            	font-variant: normal;
            	font-weight: 400;">
                <div style="text-align: center;">
                <strong>Акционерное общество "KazImpex"</strong>
                </div>
                <div style="text-align:  left;">
                
                <br/>
                </div>
    </div>
    <div align='justify' style="float: left; width: 65%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman;">
            	 <table border="1">
                        <tr>
                            <td style="height: 120px; width: 90px;">Фото</td>
                        </tr>
                    </table>
    </div>
    <div align="right" style="float: left; width: 30%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman;">
            	<div style="text-align:  right;">
                    <table border="1">
                        <tr>
                            <td>Дата составления</td>
                            <td>Табельный номер</td>
                        </tr>
                        <tr>
                            <td><?php echo $today_date; ?></td>
                            <td><?php echo $TAB_NUM; ?></td>
                        </tr>
                    </table>
                </div>
    </div>
    <div align="center" style="float: left; width: 100%; margin-right: 10px; font-size: 14px; float: left; font-family: TimesNewRoman; font-style: normal;">
        <strong>1. Общие сведения</strong>
    </div>
    <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman; font-style: normal;"/>
                <p align="justify">
                <strong>1. Имя:</strong> <?php echo $firstname; ?> 
                </p>
                <p align="justify">
                <strong>Фамилия:</strong> <?php echo $lastname; ?>
                </p>
                <p align="justify">
                <strong>Отчество:</strong> <?php echo $middlename; ?>
                </p>
                <p align="justify">
                <strong>2. Дата рождения:</strong> <?php echo $BIRTHDATE; ?>
                </p>
                <p align="justify">
                <strong>3. Место рождения:</strong> _______________________________
                </p>
                <p align="justify">
                <strong>4. Национальность</strong> <?php echo $NATION; ?> 
                </p>
                <p align="justify">
                <strong>5. Образование </strong>
                </p>
                <?php
                    $i = 1;
                    foreach($empEdu as $k => $v)
                    {
                        $YEAR_BEGIN = $v['YEAR_BEGIN'];
                        $YEAR_END = $v['YEAR_END'];
                        $INSTITUTION = $v['INSTITUTION'];
                        $QUALIFICATION = $v['QUALIFICATION'];
                        $SPECIALITY = $v['SPECIALITY'];
                        $DIPLOM_NUM = $v['DIPLOM_NUM'];
                        echo
                          "<p align='justify'>
                              $i. $YEAR_BEGIN - $YEAR_END<br />
                              $INSTITUTION ($QUALIFICATION) <br />
                              Специальность по диплому (свидетельству): $SPECIALITY <br />
                              Диплом (свидетельство) № $DIPLOM_NUM
                          </p>";
                        $i++;
                    }
                ?>
                <p align="justify">
                <strong>6. Семейное положение</strong> <?php echo $FAMILY_STATE; ?>
                </p>
                <p align="justify">
                <strong>7. Удостоверение личности №</strong><?php echo $DOCNUM; ?>
                </p>
                <p align="justify">
                <strong>Кем выдано</strong> <?php echo $DOC_PLACE; ?>
                </p>
                <p align="justify">
                <strong>Дата выдачи</strong> <?php echo $DOCDATE; ?>
                </p>
                <p align="justify">
                <strong>8. Домашний телефон</strong> <?php echo $HOME_PHONE; ?>
                </p>
                <p align="justify">
                <strong>9. Телефон</strong> <?php echo $MOB_PHONE; ?>
                </p>
                <p align="justify">
                <strong>Дата заполнения:</strong>  <?php echo $today_date; ?>
                </p>
    </div>
    <div align="justify" style="float: left; width: 3%; margin-right: 10px; font-size: 14px; border-style:solid; border: 1px; border-color: white" float: right;>
    </div>
    <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman; font-style: normal;"/>
                <p align="justify">
                <strong>10. Стаж по специльности</strong><br />
                </p>
                <?php
                    $i = 1;
                    foreach($empExperiance as $x => $z)
                    {
                        $P_ADDRESS = $z['P_ADDRESS'];
                        $P_NAME = $z['P_NAME'];
                        $DATE_BEGIN = $z['DATE_BEGIN'];
                        $DATE_END = $z['DATE_END'];
                        $P_DOLZH = $z['P_DOLZH'];
                        echo 
                          "<p align='justify'>
                              $i. $DATE_BEGIN - $DATE_END<br />
                              Название: $P_NAME ($P_ADDRESS) <br />
                              Должность: $P_DOLZH
                          </p>";
                        $i++;
                    }
                ?>
                <p align="justify">
                <strong>Подпись</strong><br /><br /> _______________________________________________
                </p>
    </div>
    <div align="center" style="float: left; width: 100%; margin-right: 10px; font-size: 14px; float: left; font-family: TimesNewRoman; font-style: normal;">
        <strong>2. Сведения о воинском учете</strong>
    </div>
    <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman; font-style: normal;"/>
                <p align="justify">
                Группа учета: _____________________________ 
                </p>
                <p align="justify">
                Категория учета: _____________________________
                </p>
                <p align="justify">
                Состав: _____________________________
                </p>
                <p align="justify">
                Воинское звание: ______________________________
                </p>            
    </div>
    <div align="justify" style="float: left; width: 3%; margin-right: 10px; font-size: 10px; border-style:solid; border: 1px; border-color: white" float: right;>
    </div>
    <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman; font-style: normal;"/>
                <p align="justify">
                Военно-учетная специальность<br />_____________________________
                </p>
                <p align="justify">
                Годность к военной службе<br /> ______________________________________________________
                </p>
                <p align="justify">
                Наименование управления (отдела) по делам оброны по месту жительства: <br />
                ______________________________
                </p>
                <p align="justify">
                Состоит на спец. учете № ______________________________
                </p>            
    </div>
    <br /><br />
    <div align="center" style="float: left; width: 100%; margin-right: 10px; font-size: 14px; float: left; font-family: TimesNewRoman; font-style: normal;"/>
            	<strong>3. Назначения и перемещения</strong>
        <table border="1" style="width: 100%;">
            <thead>
            <tr>
                <th>Дата</th>
                <th>Филиал</th>
                <th>Департамент</th> 
                <th>Должность</th> 
                <th>Основание</th>
                <th>Подпись владельца трудовой</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($list_t2_inf_transf as $r => $t)
                {
            ?>
            <tr>
                <td><?php echo $t['EVENT_DATE']; ?></td>
                <td><?php echo $t['BRANCH_ID']; ?></td>
                <td><?php echo $t['DEP_NAME_RU']; ?></td>
                <td><?php echo $t['D_NAME']; ?></td>
                <td><?php echo $t['ORDER_NUM']; ?></td>
                <td></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
        </table>            
    </div>
    <br /><br /><br />
    <div align="center" style="float: left; width: 100%; margin-right: 10px; font-size: 14px; float: left; font-family: TimesNewRoman; font-style: normal;"/>
            	<strong>4. Отпуска</strong>
        <table border="1" style="width: 100%;">
            <thead>
            <tr>
                <th>За какой период</th>
                <th>Начало</th> 
                <th>Окончание</th> 
                <th>Календарных дней</th>
                <th>Основание</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach($list_t2_inf_holy as $u => $i)
                {
            ?>
            <tr>
                <td><?php echo $i['PERIOD_BEGIN']; ?> - <?php echo $i['PERIOD_END']; ?></td>
                <td><?php echo $i['DATE_BEGIN']; ?></td>
                <td><?php echo $i['DATE_END']; ?></td>
                <td><?php echo $i['CNT_DAYS']; ?></td>
                <td><?php echo $i['ORDER_NUM']; ?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
        </table>            
    </div><br /><br /><br />
    <div align="center" style="float: left; width: 100%; margin-right: 10px; font-size: 14px; float: left; font-family: TimesNewRoman; font-style: normal;"/>
        <strong>5. Дополнительные сведения</strong>
        _______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________<br /><br />
        <br /><br />
        <?php
            if($DATE_LAYOFF != '')
            {
        ?>
        <strong>Дата и причина увольнения:</strong> <?php echo $DATE_LAYOFF; ?>____________________________________________________________
        <?php
            }
        ?>
    </div>
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