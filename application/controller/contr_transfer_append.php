<?php
    $db = new My_sql_db();

    //построение обьекта Employee
    $empId = $_GET['employee_id'];
    
    //создаем обьект Employee, в параметры передаем ID
    $employee = new Employee($empId);

    //функция get_emp_from_DB() возвращает массив с данными о работнике из базы
    $empInfo = $employee -> get_emp_from_DB_trivial();

    $sqlEmpInfo = "select * from EMPLOYEES where id = $empId";
    $empInfo = $db -> Select($sqlEmpInfo);

    $sqlJOB_CONTR_NUM = 'select JOB_CONTR_NUM from JOB_CONTR_NUM where id = 1';
    $listJOB_CONTR_NUM = $db -> Select($sqlJOB_CONTR_NUM);
    $JOB_CONTR_NUM = $empInfo[0]['CONTRACT_JOB_NUM'];
    $CONTRACT_JOB_DATE = $empInfo[0]['CONTRACT_JOB_DATE'];

    $name = $empInfo[0]['LASTNAME'];
    $lastname = $empInfo[0]['FIRSTNAME'];
    $middlename = $empInfo[0]['MIDDLENAME'];
    $DOCNUM = $empInfo[0]['DOCNUM'];
    $DOCDATE = $empInfo[0]['DOCDATE'];
    $country = $empInfo[0]['RU_NAME'];
    $cityname = $empInfo[0]['FACT_ADDRESS_CITY'];
    $fact_street = $empInfo[0]['FACT_ADDRESS_STREET'];
    $fact_address_building = $empInfo[0]['FACT_ADDRESS_BUILDING'];
    $fact_address_flat = $empInfo[0]['FACT_ADDRESS_FLAT'];
    $bossname = $_GET['bossname'];
    $bossname_kaz = $_GET['bossname_kaz'];

    $name_first_simb = mb_substr($lastname,0,1,"UTF-8");
    $middlename_first_simb = mb_substr($middlename,0,1,"UTF-8");
    $big_simb_lastname = mb_convert_case($name, MB_CASE_UPPER, "UTF-8");
    echo $big_simb_lastname;

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
    
    $DOCPLACE_ID = $empInfo[0]['DOCPLACE'];
    $sql_doc = "select NAME_KAZ, NAME from DIC_DOC_PLACE where ID = $DOCPLACE_ID";
    $emp_doc = $db -> Select($sql_doc);
    $DOCPLACE = $emp_doc[0]['NAME'];
    $DOCPLACE_KAZ = $emp_doc[0]['NAME_KAZ'];
    
    $DOCDATE = $empInfo[0]['DOCDATE'];
    $FACT_ADDRESS = $empInfo[0]['FACT_ADDRESS'];
    echo $FACT_ADDRESS;
    
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
    
    //transfer
    $transf_id = $_GET['transf_id'];
    $last_transf_id = $_GET['last_transf_id'];
    
    $sql_transf = "select CARD.ID_PERSON, CARD.EVENT_DATE, CARD.EVENT_START_DATE, CARD.ID, CARD.SALARY, DOLZH.D_NAME DOLZH, DOLZH.D_NAME_KAZ D_NAME_KAZ, BRANCH.NAME BRANCHNAME, BRANCH.NAME_KZ BRANCHNAME_KAZ, DEP.NAME DEP_NAME, DEP.NAME_KAZ DEP_NAME_KAZ
    from T2_CARD CARD, DIC_DOLZH DOLZH, DIC_BRANCH BRANCH, DIC_DEPARTMENT DEP
    where CARD.BRANCH_ID = BRANCH.RFBN_ID and CARD.DEPARTMENT = DEP.ID and CARD.POSITION = DOLZH.ID and CARD.id = $transf_id";
    $list_transf = $db -> Select($sql_transf);
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
    //transfer
    
    $html = '<div align="center">
            <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman;
            	font-size: 11px;
            	font-style: normal;
            	font-variant: normal;
            	font-weight: 400;">
                <div style="text-align:  center;">
                <strong>'.$CONTRACT_JOB_DATE.'  
                № '.$JOB_CONTR_NUM.' жеке еңбек шартына                                         
                ҚОСЫМША КЕЛІСІМ № ___</strong>
                <br />
                <br>
                </div>
                <div style="text-align:  center;">
                <strong>Астана қ.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                '.$EVENT_DATE.' ж.</strong>
                </div>
                <br>
                <p align="justify" style="text-indent: 10px;">
                <strong>Тараптар:</strong>
                </p>
                <p align="justify" style="text-indent: 10px;">
                <strong>ЖҰМЫС БЕРУШІ:</strong> “Мемлекеттік аннуитеттік компания” өмірді сақтандыру  компаниясы” акционерлік қоғамы, мемлекеттік  тіркеуі 15.06.2005 жылдан №19489-1901-АҚ, Жарғы негізінде әрекет ететін Басқарма Төрағасы тұлғасында Е. Хасенов, және
                </p>
                <p align="justify" style="text-indent: 10px;">
                <strong>ҚЫЗМЕТКЕР: '.$name.' '.$lastname.' '.$middlename.',</strong> жеке куәлік № '.$DOCNUM.' ҚР '.$DOCPLACE_KAZ.' '.$DOCDATE.' ж. берілген, мекен жайы: '.$cityname.' қ., '.$fact_street.' '.$fact_address_building.'-үй '.$fact_address_flat.' пәтер, одан әрі бірлесіп аталатын Тараптар '.$CONTRACT_JOB_DATE.' № '.$JOB_CONTR_NUM.' жеке еңбек шартына (одан әрі – Шарт) төменде айтылған шарттарда осы қосымша келісім жасасты (одан әрі – Қосымша келісім):
                </p>
                <p align="justify" style="text-indent: 10px;">
                1. Шарттың 1.1-тармағы келесі редакцияда жазылсын:
                </p>
                <p align="justify" style="text-indent: 10px;">
                «1.1. Жұмыс беруші '.$EVENT_START_DATE.' ж. бастап Жұмыскерді '.$BRANCHNAME_KAZ.' '.$DEP_NAME_KAZ.' '.$DOLZH_KAZ.' лауазымына  ауыстырады».
                </p>
                <p align="justify" style="text-indent: 10px;">
                1. Шарттың 4.1. пунктінің бірінші абзацын келесі редакцияда баяндау:
                </p>
                <p align="justify" style="text-indent: 10px;">
                «4.1. Жұмыскерге '.$EVENT_START_DATE.' ж. штаттық кестеге сәйкес '.$OKLAD.' ('.num3str($OKLAD, true).')  теңге мөлшерінде ай сайынғы лауазымдық айлық белгіленеді.».
                </p>
                <p align="justify" style="text-indent: 10px;">
                «Жұмыс беруші '.$EVENT_START_DATE.' ж. бастап 13 000 (он үш мың) теңге мөлшерінде лауазымдық қызметақысына үстемақы белгіленеді.».
                </p>
                <p align="justify" style="text-indent: 10px;">
                2. Осы Косымша келісіммен өзгертілмеген Шарттың өзге  шарттары өздерінің түрінде қалады және Тараптар өздерінің міндеттерін растайды.
                </p>
                <p align="justify" style="text-indent: 10px;">
                3. Осы Косымша келісім өзінің күшіне Тараптар қол қойған сәттен бастап енеді, сонымен қатар Шарттың бөлінбес бөлігі болып табылады.
                </p>
                <p align="justify" style="text-indent: 10px;">
                4. Осы Косымша келісім бірдей заңи күшіне ие болатын екі данада жасалған, Тараптардың әр-қайсысына біреуден.
                </p>
                
                <strong>ТАРАПТАРДЫҢ ДЕРЕКТЕМЕЛЕРІ МЕН ҚОЛДАРЫ</strong>
                
                <strong>ЖҰМЫС БЕРУШІ: “Мемлекеттік аннуитеттік компания” өмірді сақтандыру  компаниясы” акционерлік қоғамы</strong><br />
                Заңды және нақты мекенжайы: Астана қ. Иманов көшесі, 11-үй.<br />
                РНН 620300259355<br />
                Телефондары: 916-333.<br /><br />
                
                _____________________ <strong>Е. Хасенов</strong><br /><br />
                
                <strong>ҚЫЗМЕТКЕР: '.$name.' '.$lastname.' '.$middlename.',</strong> жеке куәлік № '.$DOCNUM.' '.$DOCPLACE_KAZ.' '.$DOCDATE.' ж. берілген, мекен жайы: '.$cityname.' қ., '.$fact_street.' '.$fact_address_building.'-үй.
                <br /><br />
                ____________________ <strong>'.$name_first_simb.'. '.$big_simb_lastname.'</strong>
                <br />
            
            </div>
    <div align="justify" style="float: left; width: 3%; margin-right: 10px; font-size: 10px; border-style:solid; border: 1px; border-color: white" float: right;>
    </div>
    <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman;
            	font-size: 11px;
            	font-style: normal;
            	font-variant: normal;
            	font-weight: 400;">
                <div style="text-align:  center;">
                <strong>ДОПОЛНИТЕЛЬНОЕ СОГЛАШЕНИЕ № ___
                к Трудовому договору № '.$JOB_CONTR_NUM.' 
                от '.$CONTRACT_JOB_DATE.'</strong>
                <br />
                <br>
                </div>
                <div style="text-align:  center;">
                <strong>г. Астана &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                '.$EVENT_DATE.' г. </strong>
                </div>
                <br>
                <p align="justify" style="text-indent: 10px;">
                <strong>Стороны:</strong>
                </p>
                <p align="justify" style="text-indent: 10px;">
                <strong>РАБОТОДАТЕЛЬ:</strong> Акционерное  общество  «Компания  по  страхованию  жизни «Государственная  аннуитетная  компания»,  государственная регистрация № 19489–1901-АО от 15.06.2005 года, в лице председателя Правления Е. Хасенов, действующего на основании Устава, и
                </p>
                <p align="justify" style="text-indent: 10px;">
                <strong>РАБОТНИК: '.$name.' '.$lastname.' '.$middlename.',</strong> удостоверение личности  № '.$DOCNUM.' выдано '.$DOCPLACE.' РК '.$DOCDATE.' года,  проживающая по адресу: г. '.$cityname.', '.$fact_street.' д. '.$fact_address_building.' кв. '.$fact_address_flat.', далее совместно именуемые Стороны, заключили настоящее дополнительное   соглашение к трудовому договору № '.$JOB_CONTR_NUM.' от '.$CONTRACT_JOB_DATE.' года (далее – Договор) на нижеследующих условиях (далее - дополнительное соглашение):
                </p>
                <p align="justify" style="text-indent: 10px;">
                1. Пункт 1.1. Договора изложить в следующей редакции:
                </p>
                <p align="justify" style="text-indent: 10px;">
                «1.1. Работодатель переводит Работника с '.$EVENT_START_DATE.' г. на должность '.$DOLZH.' '.$DEP_NAME.' '.$BRANCHNAME.'.
                </p>
                <p align="justify" style="text-indent: 10px;">
                1. Абзац первый пункта 4.1. Договора изложить в следующей редакции:
                </p>
                <p align="justify" style="text-indent: 10px;">
                «4.1. Работнику с '.$EVENT_START_DATE.' г. устанавливается  ежемесячный должностной оклад согласно штатному расписанию в размере '.$OKLAD.' ('.num2str($OKLAD, true).') тенге.».
                </p>
                <p align="justify" style="text-indent: 10px;">
                «Работнику с '.$EVENT_START_DATE.' г. устанавливается персональная надбавка в размере 13 000 (тринадцать тысяч) тенге.».
                </p>
                <p align="justify" style="text-indent: 10px;">
                2. Все остальные условия Договора, не затронутые настоящим Дополнительным соглашением, остаются в неизменном виде и Стороны подтверждают по ним свои обязательства.
                </p>
                <p align="justify" style="text-indent: 10px;">
                3. Настоящее Дополнительное соглашение вступает в силу с момента подписания Сторонами и является неотъемлемой частью Договора.
                </p>
                <p align="justify" style="text-indent: 10px;">
                4. Настоящее Дополнительное соглашение составлено в двух экземплярах, имеющих одинаковую юридическую силу, по одному экземпляру для каждой из Сторон.
                </p>

                <strong>РЕКВИЗИТЫ И ПОДПИСИ СТОРОН</strong>

                <strong>РАБОТОДАТЕЛЬ: Акционерное общество «Компания по страхованию жизни «Государственная аннуитетная компания»</strong><br />
                Юридический и фактический адрес:  г. Астана, ул. Иманова 11<br />
                РНН 620300259355<br />
                Телефоны: 916-333.<br /><br />
                
                _____________________ <strong>Е. Хасенов</strong><br /><br />
                
                <strong>РАБОТНИК: '.$name.' '.$lastname.' '.$middlename.',</strong> удостоверение личности № '.$DOCNUM.' выдано '.$DOCPLACE.' '.$DOCDATE.' года,  проживающая по адресу: г. '.$cityname.', '.$fact_street.' д. '.$fact_address_building.'.
                <br /><br />
                ____________________ <strong>'.$name_first_simb.'. '.$big_simb_lastname.'</strong>
                <br />
            
            </div>';
    
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