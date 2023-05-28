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

    /*
    $sqlJOB_CONTR_NUM = 'select JOB_CONTR_NUM from JOB_CONTR_NUM where id = 1';
    $listJOB_CONTR_NUM = $db -> Select($sqlJOB_CONTR_NUM);
    $JOB_CONTR_NUM = $empInfo[0]['CONTRACT_JOB_NUM'];
    $CONTRACT_JOB_DATE = $empInfo[0]['CONTRACT_JOB_DATE'];
    */

    $name = $empInfo[0]['LASTNAME'];
    $lastname = $empInfo[0]['FIRSTNAME'];
    $middlename = $empInfo[0]['MIDDLENAME'];
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

    /*
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
    */

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
    
    $html = '<div align="center">
            <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman;
            	font-size: 11px;
            	font-style: normal;
            	font-variant: normal;
            	font-weight: 400;">
                <div style="text-align:  right;">
                '.$CONTRACT_JOB_DATE.'<br />
                № '.$JOB_CONTR_NUM.' Еңбек шартына<br /> 
                қосымша <br />
                <br>
                </div>
                <div style="text-align:  center;">
                <strong>«КазИмпекс» АҚ-да 
                құпия ақпаратты жарияламау туралы 
                КЕЛІСІМ</strong>
                </div>
                <br>
                <p align="justify" style="text-indent: 10px;">
                Мен, '.$name.' '.$lastname.' '.$middlename.',
                «КазИмпекс» АҚ (бұдан әрі –Қоғам) Жұмыскері бола отырып, Қоғаммен еңбек (қызмет) қарым-қатынастары  кезеңінде, менімен жасалған Еңбек шартының шарттарына сәйкес және ол аяқталғаннан кейін 3 (үш) жыл мерзім ішінде:
                </p>
                <p align="justify" style="text-indent: 10px;">
                Жариялануы (беруі, жайылуы) қаржылық жоғалтуларға, материалдық зиянға, сондай-ақ Қоғам имиджіне зор шығын келтіруге әкелетін, Қоғамның құпия ақпаратына жатқызылған, Қоғамдағы еңбек қызметім барысында маған сеніп тапсырылған немесе белгілі болған  деректерді жарияламауға.
                </p>
                <p align="justify" style="text-indent: 10px;">
                Мен танысып шыққан, Қоғамның ішінде, сондай-ақ оның аумағынан тыс жерлерде құпиялылық режимін сақтауға қатысты Қазақстан Республикасының қолданыстағы заңнамасының, Қоғамның ішкі құжаттарының маған қатысты талаптарын қатаң орындауға.
                </p>
                <p align="justify" style="text-indent: 10px;">
                Қоғамның құпия ақпаратына жатқызылған ақпаратты менен бөгде тұлғалардың  алу әрекеттері болған жағдайда бұл туралы құрылымдық бөлімшенің басшысына, Қоғамның жетекшілік ететін басшысына дереу хабарлауға.
                </p>
                <p align="justify" style="text-indent: 10px;">
                Менімен Еңбек шарты тоқтатылған немесе бұзылған жағдайда, осы Келісімнің талаптарын сақтауға және оларды бұзғаным үшін Қазақстан Республикасының заңнамасымен бекітілген тәртіпте жауапты болуға міндеттенемін.
                </p>
                <p align="justify" style="text-indent: 10px;">
                Мен осы  Келісім менімен бұзылған жағдайда:
                </p>
                <p align="justify" style="text-indent: 10px;">
                менімен Еңбек шартын бұзуға шейін мені тәртіптік жауапкершілікке тарта алатындығымен;
                </p>
                <p align="justify" style="text-indent: 10px;">
                бұл келісімнің деректерін сақтамауға байланысты менің әрекеттерімнің салдарынан Қоғамға келтірілген шығындарды өтеуге менің міндетті болатындығым туралы хабарландым.  
                </p><br />
                Таныстым _______________________________________________________<br />
                                               <div style="text-align: right;">
                                               (Аты-жөні, тегі)(қолы)<br /><br />
                                               </div>
            
            </div>
    <div align="justify" style="float: left; width: 3%; margin-right: 10px; font-size: 10px; border-style:solid; border: 1px; border-color: white" float: right;>
    </div>
    <div align="justify" style="float: left; width: 48%; margin-right: 10px; font-size: 10px; float: left; font-family: TimesNewRoman;
            	font-size: 11px;
            	font-style: normal;
            	font-variant: normal;
            	font-weight: 400;">
                <div style="text-align:  right;">
                Приложение <br />
                к Трудовому договору <br />
                № '.$JOB_CONTR_NUM.' от '.$CONTRACT_JOB_DATE.'<br /><br />
                </div>
                <div style="text-align:  center;">
                <strong>СОГЛАШЕНИЕ<br /></strong>
                </div>
                <div style="text-align:  center;">
                <strong>о  неразглашении  конфиденциальной информации 
                 в АО «КазИмпекс»</strong>
                </div>
                <p align="justify" style="text-indent: 10px;">
                Я, '.$name.' '.$lastname.' '.$middlename.',
                являясь работником АО «КазИмпекс»(Далее - «Общество»), в период действия трудовых (служебных) отношений с Обществом, в соответствии с условиями заключенного со мной  Трудового договора и в течение 3 (трех) лет после его окончания, обязуюсь:
                </p>
                <p align="justify" style="text-indent: 10px;">
                Не разглашать  сведения, отнесенные к конфиденциальной информации   Общества, доверенные мне или ставшие известными в процессе трудовой деятельности в Обществе, разглашение (передача, утечка) которых приведет к финансовым потерям, материальному ущербу, а также к нанесению урона имиджу Общества.
                </p>
                <p align="justify" style="text-indent: 10px;">
                Строго выполнять относящиеся ко мне требования действующего законодательства Республики Казахстан, внутренних документов Общества, касающиеся соблюдения режима  секретности как внутри Общества, так и за его пределами, с которыми я ознакомлен (а).
                </p>
                <p align="justify" style="text-indent: 10px;">
                В случае попытки посторонних лиц получить от меня информацию, отнесенную к конфиденциальной информации Общества, немедленно сообщить об этом руководителю структурного подразделения, курирующему руководителю Общества.
                </p>
                <p align="justify" style="text-indent: 10px;">
                В случае прекращения или расторжения со мной Трудового договора, соблюдать требования настоящего Соглашения и нести ответственность за их нарушение в установленном законодательством Республики Казахстан порядке.
                </p>
                <p align="justify" style="text-indent: 10px;">
                Я уведомлен, что в случае нарушения мной данного Соглашения:
                </p>
                <p align="justify" style="text-indent: 10px;">
                меня могут привлечь  к дисциплинарной ответственности, вплоть до расторжения со мной  Трудового договора;
                </p>
                <p align="justify" style="text-indent: 10px;">
                5.2. я буду обязан (а) возместить убытки, понесенные Обществом, вследствие моих действий по несоблюдению данного соглашения.
                </p><br />
                Ознакомлен _______________________________________________________<br />
                                               <div style="text-align: right;">
                                               (подпись) (Ф.И.О.)<br />
                                               </div>
                <br />
                

            </div>
            </div>';
    
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