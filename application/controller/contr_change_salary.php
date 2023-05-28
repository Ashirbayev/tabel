<?php
    $db = new My_sql_db();

    $transf_id = $_GET['transf_id'];
    $last_transf_id = $_GET['last_transf_id'];

    $sql_transf = "select
                        CARD.ID_PERSON,
                        CARD.EVENT_DATE,
                        CARD.EVENT_START_DATE,
                        CARD.ID,
                        CARD.SALARY,
                        DOLZH.D_NAME DOLZH,
                        DOLZH.D_NAME_KAZ D_NAME_KAZ,
                        BRANCH.NAME BRANCHNAME,
                        BRANCH.NAME_KZ BRANCHNAME_KAZ,
                        DEP.NAME DEP_NAME,
                        DEP.NAME_KAZ DEP_NAME_KAZ
                   from
                        T2_CARD CARD,
                        DIC_DOLZH DOLZH,
                        DIC_BRANCH BRANCH,
                        DIC_DEPARTMENT DEP
                   where
                        CARD.BRANCH_ID = BRANCH.RFBN_ID
                        and CARD.DEPARTMENT = DEP.ID
                        and CARD.POSITION = DOLZH.ID
                        and CARD.ID = $transf_id";
    $list_transf = $db -> Select($sql_transf);
    //echo $sql_transf.'<br>';
    //print_r($list_transf);
    $empId = $list_transf[0]['ID_PERSON'];
    $EVENT_DATE = $list_transf[0]['EVENT_DATE'];
    $SALARY = $list_transf[0]['SALARY'];
    $DOLZH = $list_transf[0]['DOLZH'];
    $DOLZH_KAZ = $list_transf[0]['D_NAME_KAZ'];
    $BRANCHNAME = $list_transf[0]['BRANCHNAME'];
    $BRANCHNAME_KAZ = $list_transf[0]['BRANCHNAME_KAZ'];
    $DEP_NAME = $list_transf[0]['DEP_NAME'];
    $DEP_NAME_KAZ = $list_transf[0]['DEP_NAME_KAZ'];
    $EVENT_START_DATE = $list_transf[0]['EVENT_START_DATE'];

    /*
    echo $EVENT_DATE;
    echo $SALARY;
    echo $DOLZH;
    echo $BRANCHNAME;
    echo $DEP_NAME;
    echo '<br>';
    */

    $sql_transf2 = "select CARD.EMP_ID, CARD.EVENT_DATE, CARD.ID, CARD.SALARY, DOLZH.D_NAME DOLZH, DOLZH.D_NAME_KAZ D_NAME_KAZ, BRANCH.NAME BRANCHNAME, BRANCH.NAME_KZ BRANCHNAME_KAZ, DEP.NAME DEP_NAME, DEP.NAME_KAZ DEP_NAME_KAZ from T2_CARD CARD, DIC_DOLZH DOLZH, DIC_BRANCH BRANCH, DIC_DEPARTMENT DEP where CARD.BRANCH_ID = BRANCH.RFBN_ID and CARD.DEPARTMENT = DEP.ID and CARD.POSITION = DOLZH.ID and CARD.ID = $last_transf_id";
    //$list_transf2 = $db -> Select($sql_transf2);
    //echo '<pre>';
    //echo $sql_transf2;
    //print_r($list_transf2);
    //echo '<pre>';
    $LAST_SALARY = $list_transf2[0]['SALARY'];
    $LAST_DOLZH = $list_transf2[0]['DOLZH'];
    $LAST_DOLZH_KAZ = $list_transf[0]['D_NAME_KAZ'];
    $LAST_BRANCHNAME = $list_transf2[0]['BRANCHNAME'];
    $LAST_BRANCHNAME_KAZ = $list_transf[0]['BRANCHNAME_KAZ'];
    $LAST_DEP_NAME = $list_transf2[0]['DEP_NAME'];
    $LAST_DEP_NAME_KAZ = $list_transf[0]['DEP_NAME_KAZ'];
    
    /*
    echo $EVENT_DATE;
    echo $LAST_SALARY;
    echo $LAST_DOLZH;
    echo $LAST_BRANCHNAME;
    echo $LAST_DEP_NAME;
    */
    
    //создаем обьект Employee, в параметры передаем ID
    $employee = new Employee($empId);
    
    //функция get_emp_from_DB() возвращает массив с данными о работнике из базы
    $empInfo = $employee -> get_emp_from_DB_trivial();
    
    $sqlEmpInfo = "select * from EMPLOYEES where id = $empId";
    $empInfo = $db -> Select($sqlEmpInfo);
    //echo $sqlEmpInfo;
    //print_r($empInfo);
    
    $sqlJOB_CONTR_NUM = 'select JOB_CONTR_NUM from JOB_CONTR_NUM where id = 1';
    $listJOB_CONTR_NUM = $db -> Select($sqlJOB_CONTR_NUM);
    $JOB_CONTR_NUM = $empInfo[0]['CONTRACT_JOB_NUM'];
    $CONTRACT_JOB_DATE = $empInfo[0]['CONTRACT_JOB_DATE'];
    
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
    $bossname = $_GET['bossname'];
    $bossname_kaz = $_GET['bossname_kaz'];
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
    $last = substr($DATE_POST, -1);
    $last_rep = $last+1;
    $DATE_POST_PLUS_YEAR = substr_replace($DATE_POST, $last_rep,-1);
    
    $html = '<br><br><br><br><br><br><br><br><br><br><br><br /><br />
    <div border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: "Times New Roman", Times, serif; 
                text-align: justify;
                font-size: 14pt;
                margin-left: 20px;
                margin-right: 10px;
                font-weight: normal;
                line-height: 1.0;">
                    <p>
                        <div style="font-size: 14pt; text-align: justify;">
                        <font face="verdana">
                            <strong>'.$name_first_simb.'. '.$middlename_first_simb.'. '.$lastname.' лауазымдық
    қызметақысын өсіру туралы</strong><br>
                        </font>
                        </div>
                        </p><div align="justify" style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                «Мемлекеттік аннуитеттік компания» өмірді сақтандыру компаниясы» АҚ  Жарғысының 14-Тарауы 116-тармағының 5)-тармақшасына сәйкес, <strong>БҰЙЫРАМЫН:</strong><br>
                            </font>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                1. '.$depName_kaz.' '.$posNameKaz.' '.$branch_name_kaz.' '.$name.' '.$middlename.' '.$lastname.' '.$EVENT_START_DATE.' ж. бастап '.$OKLAD.' ('.num3str($OKLAD).') теңге мөлшерінде лауазымдық қызметақы белгіленсін.
                            </font>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                2. Қызметкерді басқару бойынша бас маман '.$name_first_simb.'. '.$middlename_first_simb.'. '.$lastname.' Еңбек шартына тиісті өзгерістерді енгізсін.
                            </font>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                3. Осы бұйрықпен '.$name_first_simb.'. '.$middlename_first_simb.'. '.$lastname.' таныстырылсын.
                            </font>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                Негіздеме: '.$depName_kaz.' '.$branch_name_kaz.' қызметтік жазбасы.
                            </font>
                        </div>
                        
                        <br><br>
                        <div style="text-indent: 30px; font-size: 14pt;">
                            <font face="verdana">
                                <strong>Басқарма төрағасы &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Е. Хасенов</strong>
                            </font>
                        
    </div>
    <br><br />
    
    <div border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: "Times New Roman", Times, serif; 
                text-align: justify;
                font-size: 14pt;
                margin-left: 20px;
                margin-right: 10px;
                font-weight: normal;
                line-height: 1.0;">
                        <div style="font-size: 14pt; ">
                           <font face="verdana">
                                <strong>О повышении должностного оклада '.$lastname.' '.$name_first_simb.'. '.$middlename_first_simb.'.</strong><br><br> 
                            </font>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                В соответствии с подпунктом 5) пункта 116 главы 14 Устава АО «Компания по страхованию жизни «Государственная аннуитетная компания», <strong>ПРИКАЗЫВАЮ:</strong>
                            </font>        
                        <br>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                1. '.$lastname.' '.$name.' '.$middlename.' - '.$DOLZH.' '.$DEP_NAME.' '.$BRANCHNAME.' с '.$EVENT_START_DATE.' г. установить должностной оклад  в размере '.$OKLAD.' ('.num2str($OKLAD, true).') тенге.
                            <font face="verdana">
                        </font></font></div><font face="verdana"><font face="verdana"> 
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                2. Главному специалисту по управлению персоналом внести соответствующие изменения в Трудовой договор с '.$lastname.' '.$name_first_simb.'. '.$middlename_first_simb.'.
                            </font>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                3. Ознакомить с настоящим приказом '.$lastname.' '.$name_first_simb.'. '.$middlename_first_simb.'.
                            </font>
                        </div>
                        <div style="text-indent: 30px; font-size: 14pt; text-align: justify;">
                            <font face="verdana">
                                Основание: служебная записка '.$DEP_NAME.' '.$BRANCHNAME.'.
                            </font>
                        </div>
                        <br><br>
                        <div style="text-indent: 30px; font-size: 14pt;">
                            <font face="verdana">
                                <strong>Председатель Правления &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    Е. Хасенов</strong>
                            </font>
                            </div><br><br>
                            <div style="font-size: 14pt;">
                            <font face="verdana">
                                Бұйрықпен таныстырылды:
                            </font>
                                    <br><br>
                            <font face="verdana">
                                '.$name_first_simb.'. '.$middlename_first_simb.'. '.$lastname.' _____________ 2017 жылғы «___» _________
                            </font>
                            </div><br><br>
                        </div>
                    <p></p>
    </font></font></div>
            ';
        
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
            $hundred=array('','жүз','екі жүз','үш жүз','төрт жүз','бес жүз','алты жүз', 'жеті жүз','сегіз жүз','тоғыз жүз');
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