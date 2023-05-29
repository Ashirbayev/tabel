<?php
    $page_title = 'Справочник сотрудников';
    $panel_title = 'Регистрация сотрудника';

    $breadwin[] = 'Справочник сотрудников';
    $breadwin[] = '<a href="clients_edit">Регистрация сотрудника</a>';

    $colaps = '';
    $load_page = 'search';

    array_push($js_loader,        
        'styles/js/inspinia.js',
        'styles/js/plugins/pace/pace.min.js',
        'styles/js/plugins/slimscroll/jquery.slimscroll.min.js',
        'styles/js/plugins/chosen/chosen.jquery.js',
        'styles/js/plugins/jsKnob/jquery.knob.js',
        'styles/js/plugins/jasny/jasny-bootstrap.min.js',
        'styles/js/plugins/dataTables/jquery.dataTables.js',
        'styles/js/plugins/dataTables/dataTables.bootstrap.js',
        'styles/js/plugins/dataTables/dataTables.responsive.js',
        'styles/js/plugins/dataTables/dataTables.tableTools.min.js',
        'styles/js/plugins/datapicker/bootstrap-datepicker.js',
        'styles/js/plugins/nouslider/jquery.nouislider.min.js',
        'styles/js/plugins/switchery/switchery.js',
        'styles/js/plugins/ionRangeSlider/ion.rangeSlider.min.js',
        'styles/js/plugins/iCheck/icheck.min.js',
        'styles/js/plugins/metisMenu/jquery.metisMenu.js',
        'styles/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
        'styles/js/plugins/clockpicker/clockpicker.js',
        'styles/js/plugins/cropper/cropper.min.js',
        'styles/js/plugins/fullcalendar/moment.min.js',
        'styles/js/plugins/daterangepicker/daterangepicker.js',
        'styles/js/plugins/Ilyas/addClients.js',
        'styles/js/demo/contracts_osns.js'
    );

    array_push($css_loader, 
        'styles/css/plugins/dataTables/dataTables.bootstrap.css',
        'styles/css/plugins/dataTables/dataTables.responsive.css',
        'styles/css/plugins/dataTables/dataTables.tableTools.min.css',
        'styles/css/plugins/iCheck/custom.css',
        'styles/css/plugins/chosen/chosen.css',
        'styles/css/plugins/colorpicker/bootstrap-colorpicker.min.css',
        'styles/css/plugins/cropper/cropper.min.css',
        'styles/css/plugins/switchery/switchery.css',
        'styles/css/plugins/jasny/jasny-bootstrap.min.css',
        'styles/css/plugins/nouslider/jquery.nouislider.css',
        'styles/css/plugins/datapicker/datepicker3.css',
        'styles/css/plugins/ionRangeSlider/ion.rangeSlider.css',
        'styles/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css',
        'styles/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
        'styles/css/plugins/clockpicker/clockpicker.css',
        'styles/css/plugins/daterangepicker/daterangepicker-bs3.css',
        'styles/css/plugins/select2/select2.min.css'
    );

    //Постоянные запросы
    $db = new My_sql_db();
    $sqlNationality = "select * from DIC_NATIONALITY order by id"; 
    $listNationality = $db -> Select($sqlNationality);

    //номер последнего ТД
    $sqlJOB_CONTR_NUM = 'select JOB_CONTR_NUM from JOB_CONTR_NUM where id = 1';
    $listJOB_CONTR_NUM = $db -> Select($sqlJOB_CONTR_NUM);

    $sqlFamily = "select * from DIC_FAMILY order by id";
    $listFamily = $db -> Select($sqlFamily);

    $sqlDoctype = "select * from DIC_DOCUMENT_TYPE order by id";
    $listDoctype = $db -> Select($sqlDoctype);

    $sqlDIC_DOLZH = "select * from DIC_DOLZH order by D_NAME";
    $listDIC_DOLZH = $db -> Select($sqlDIC_DOLZH);

    $sqlDIC_DEPARTMENT = "select * from DIC_DEPARTMENT order by NAME";
    $listDIC_DEPARTMENT = $db -> Select($sqlDIC_DEPARTMENT);

    //страны
    $sqlCountry = "select * from DIC_COUNTRY order by id";
    $listCountry = $db -> Select($sqlCountry);

    //филиалы
    $sqlBranch = "select * from DIC_BRANCH order by NAME";
    $listBranch = $db -> Select($sqlBranch);

    if(isset($_POST['BRANCHID_FOR_JOB_POSITION_BRANCH']))
    {
        //департаменты
        $sqlPosition = "select * from DIC_Dolzh where BRANCH_ID = ".$_POST['BRANCHID_FOR_JOB_POSITION_BRANCH'];
        $listPosition = $db -> Select($sqlPosition);
        echo '<option value="0"></option>';
        foreach($listPosition as $z => $x)
        {
            echo '<option value="'.trim($x['ID']).'">'.$x['D_NAME'].'</option>'; 
        }
        exit;
    }

    if(isset($_POST['BRANCHID_FOR_SP'])){
        //департаменты
        $sqlDepartments = "select * from DIC_DEPARTMENT order by id";
        $listDepartments = $db -> Select($sqlDepartments);
        echo '<option value="0"></option>';
        foreach($listDepartments as $z => $x)
        {
            echo '<option value="'.trim($x['ID']).'">'.$x['NAME'].'</option>'; 
        }
        exit;
    }

    if(isset($_POST['BRANCHID_FOR_POSITIONS']))
    {
        $ID_DEPARTMENT = $_POST['JOB_SP_FOR_POSITIONS'];
        //должности
        $sqlPosition = "select * from DIC_DOLZH where ID_DEPARTMENT = $ID_DEPARTMENT";
        $listPosition = $db -> Select($sqlPosition);
        ?>
        <select name="JOB_POSITION" id="JOB_POSITION" class="select2_demo_1 form-control">
        <option value="0"></option>
            <?php
                $positionId = trim($empInfo[0]['JOB_POSITION']);
                foreach($listPosition as $o => $p)
                {
            ?>
                <option value="<?php echo trim($p['ID']); ?>"><?php echo $p['D_NAME']; ?></option>
            <?php
                }
            ?>
        </select>
        <?php
        exit;
    }

    if(isset($_POST['lastname']))
    {
        $DATE_POST = trim($_POST['DATE_POST']);
        $lastname = trim($_POST['lastname']);
        $firstname = trim($_POST['firstname']);
        $middlename = trim($_POST['middlename']);
        $BIRTHDATE = trim($_POST['BIRTHDATE']);
        $SEX = trim($_POST['SEX']);
        $IIN = trim($_POST['iin']);
        $nationality = trim($_POST['nationality']);
        $born_place = trim($_POST['countrySel'].'/'.$_POST['regionSel'].'/'.$_POST['citySel']);
        $docTypeSelect = trim($_POST['docTypeSelect']);
        $getDATE = trim($_POST['getDATE']);
        $JOB_SP = trim($_POST['JOB_SP']);
        $JOB_POSITION = trim($_POST['JOB_POSITION']);
        $OKLAD = trim($_POST['OKLAD']);
        $FACT_ADDRESS_COUNTRY_ID = trim($_POST['FACT_ADDRESS_COUNTRY_ID']);
        $FACT_ADDRESS_CITY = trim($_POST['FACT_ADDRESS_CITY']);
        $FACT_ADDRESS_STREET = trim($_POST['FACT_ADDRESS_STREET']);
        $FACT_ADDRESS_BUILDING = trim($_POST['FACT_ADDRESS_BUILDING']);
        $FACT_ADDRESS_FLAT = trim($_POST['FACT_ADDRESS_FLAT']);
        $DOCNUM = trim($_POST['DOCNUM']);
        $DOCTYPE = trim($_POST['DOCTYPE']);
        $DOCDATE = trim($_POST['DOCDATE']);
        $DOCPLACE = NULL; //trim($_POST['DOCPLACE']);
        $BRANCHID = trim($_POST['BRANCHID']);
        $MOB_PHONE = trim($_POST['MOB_PHONE']);
        $LASTNAME2 = trim($_POST['LASTNAME2']);
        $FIRSTNAME2 = trim($_POST['FIRSTNAME2']);
        $PERSONAL_EMAIL = trim($_POST['PERSONAL_EMAIL']);
        $CONTRACT_JOB_NUM = trim($_POST['CONTRACT_JOB_NUM']);

        $sql_t2_card = "select * from EMPLOYEES";
        $list_t2_card = $db->Select($sql_t2_card);
        $lenth_t2_card = count($list_t2_card);
        $lenth_t2_card = $lenth_t2_card + 1;
        $sql = "insert into EMPLOYEES (ID, IIN, LASTNAME, FIRSTNAME, MIDDLENAME, BIRTHDATE, SEX, BIRTH_PLACE, NACIONAL, DATE_POST, STATE, JOB_SP, JOB_POSITION, OKLAD, DOCNUM, DOCTYPE, DOCDATE, DOCPLACE, FACT_ADDRESS_COUNTRY_ID, FACT_ADDRESS_CITY, FACT_ADDRESS_STREET, FACT_ADDRESS_BUILDING, FACT_ADDRESS_FLAT, BRANCHID, MOB_PHONE, PERSONAL_EMAIL, CONTRACT_JOB_NUM, EMAIL, COMPANY_ID) values
                                        ($lenth_t2_card,
                                        '$IIN', 
                                        '$lastname', 
                                        '$firstname',
                                        '$middlename',
                                        '$BIRTHDATE',
                                        '$SEX',
                                        '$born_place', 
                                        '$nationality', 
                                        '$DATE_POST',
                                        '2', 
                                        1, 
                                        '$JOB_POSITION', 
                                        '$OKLAD', 
                                        '$DOCNUM',
                                        '$DOCTYPE',
                                        '$DOCDATE',
                                        NULL,
                                        '$FACT_ADDRESS_COUNTRY_ID',
                                        '$FACT_ADDRESS_CITY',
                                        '$FACT_ADDRESS_STREET',
                                        '$FACT_ADDRESS_BUILDING',
                                        '$FACT_ADDRESS_FLAT',
                                        '$BRANCHID',
                                        '$MOB_PHONE',
                                        '$PERSONAL_EMAIL',
                                        '$CONTRACT_JOB_NUM',
                                        '$PERSONAL_EMAIL',
                                        '2')";
        echo $sql;
        $listEmployee = $db -> Execute($sql);


        $sql_history = "select * from T2_CARD";
        $list_history = $db->Select($sql_history);
        $lenth_history = count($list_history);
        $lenth_history = $lenth_history + 1;

        $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, BRANCH_ID, DEPARTMENT, POSITION, SALARY, ID_PERSON, ACT_ID) values ($lenth_history, '$DATE_POST', '$BRANCHID', '$JOB_SP', '$JOB_POSITION', '$OKLAD', $lenth_t2_card, '1')";
        $update_history = $db -> Execute($sql_update_history);

        $sql_update_last_JB_num = "update JOB_CONTR_NUM set JOB_CONTR_NUM = JOB_CONTR_NUM+1 where ID = 1";
        $list_update_last_JB_num = $db -> Execute($sql_update_last_JB_num);

        $sql_branch = "select * from DIC_BRANCH where RFBN_ID = $BRANCHID";
        $list_branch = $db -> Select($sql_branch);
        $branch_name = $list_branch[0]['NAME'];

        $sql_dep = "select * from DIC_DEPARTMENT where ID = $JOB_SP";
        $list_dep = $db -> Select($sql_dep);
        $dep_name = $list_dep[0]['NAME'];

        $sql_dolzh = "select * from DIC_DOLZH where ID = $JOB_POSITION";
        $list_dolzh = $db -> Select($sql_dolzh);
        $dolzh_name = $list_dolzh[0]['D_NAME'];

        //создаем табель для нового сотрудника
        $post_day_list = explode('.', $DATE_POST);
        $post_day = $post_day_list[0];
        //echo $post_day.'<br />';
        $sequance = 3561;
        $post_withuot_day = '.'.$post_day_list[1].'.'.$post_day_list[2];
        create_other_table("$post_withuot_day", $sequance, $post_day);

        for($i = $post_day_list[1]+1; $i <= 12; $i++)
        {
            if($i<10)
            {
                $post_withuot_day = '.0'.$i.'.'.$post_day_list[2];
                create_other_table_for_this_year("$post_withuot_day", $sequance, '01');
            }
                else
            {
                $post_withuot_day = '.'.$i.'.'.$post_day_list[2];
                create_other_table_for_this_year("$post_withuot_day", $sequance, '01');
            }
        }

      //  header('Location: all_employees');
    }

    if(isset($_POST['country']))
    {
        header( 'Location: http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=10' );
        exit;
    }

    if(isset($_POST['docType']))
    {
        switch($_POST['docType']) 
        {
            case 1:
                ?>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер поспорта</label>
                        <input id="DOCNUM" name="DOCNUM" type="text" placeholder="" class="form-control stepenViny" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Гражданство</label>
                        <select id="countrySel" name="countrySel " class="select2_demo_1 form-control" required="">
                            <option></option>
                                <?php
                                    foreach($listCountry as $k => $v){
                                        echo '<option value="'.$v['ID'].'">'.$v['RU_NAME'].'</option>';
                                    }
                                ?>
                        </select>
                    </div>
                    
                <?php
                break;
            case 2:
                ?>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер удостоверения личности</label>
                        <input data-mask="999999999" id="DOCNUM" name="DOCNUM" type="text" placeholder="" class="form-control stepenViny">
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Кем выдан</label>
                        <select id="DOCPLACE" name="DOCPLACE" class="select2_demo_1 form-control">
                            <option></option>
                            <option value="1">Министерство внутренних дел РК </option>
                            <option value="2">Министерство юстиции РК</option>
                        </select>
                    </div>
                <?php
                break;
            case 3:
                ?>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер вида на жительство</label>
                        <input id="DOCNUM" name="DOCNUM" type="text" placeholder="" class="form-control stepenViny">
                    </div>
                <?php
                break;
            case 4:
                ?>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер свидетельства о рождении</label>
                        <input id="DOCNUM" name="DOCNUM" type="text" placeholder="" class="form-control stepenViny">
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Кем выдан</label>
                        <select id="DOCPLACE" name="DOCPLACE" class="select2_demo_1 form-control">
                            <option></option>
                            <option value="1">Министерство внутренних дел РК</option>
                            <option value="2">Министерство юстиции РК</option>
                        </select>
                    </div>
                <?php
                break;
            case 5:
                ?>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер вида на жительство</label>
                        <input id="DOCNUM" name="DOCNUM" type="text" placeholder="" class="form-control stepenViny">
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Кем выдан</label>
                        <select id="DOCPLACE" name="DOCPLACE" class="select2_demo_1 form-control">
                            <option></option>
                            <option value="1">Министерство внутренних дел РК </option>
                            <option value="2">Министерство юстиции РК</option>
                        </select>
                    </div>
                <?php
                break;
        }
        exit;
    }

    if(isset($_POST['search_GBDFL']))
    {
        $LASTNAMEgbdfl = $_POST['LASTNAMEgbdfl'];
        $FIRSTNAMEgbdfl = $_POST['FIRSTNAMEgbdfl'];
        $MIDDLENAMEgbdfl = $_POST['MIDDLENAMEgbdfl'];
        $IIN = $_POST['iingbdfl'];
        $db = new My_sql_db();
        $sql_to_GBDFL = "select * from gbdfl.gbl_person_new where Upper(SURNAME) LIKE upper ('%$LASTNAMEgbdfl%') and firstname like upper ('%$FIRSTNAMEgbdfl%') and SECONDNAME like upper ('%$MIDDLENAMEgbdfl%') and rownum <= 100 order by ID";
        if($_POST['iingbdfl'] != '')
        {
            $sql_to_GBDFL = "select * from gbdfl.gbl_person_new where IIN = '$IIN'";
        }
        //echo $sql_to_GBDFL;
        $list_GBDFL = $db ->Select($sql_to_GBDFL);
        //print_r($list_GBDFL);
    ?>

    <script>
        function insert_emp(data){
            var str = data;
            var res = str.split("//");
            $('#lastname').val(res[0]);
            $('#firstname').val(res[1]);
            $('#middlename').val(res[2]);
            $('#iin').val(res[3]);
            if(res[4] == 1){
                $("#place_for_sex_id").html("<option></option><option selected value='1'>Мужской</option><option value='2'>Женский</option>");
            }else{
                $("#place_for_sex_id").html("<option></option><option value='1'>Мужской</option><option selected value='2'>Женский</option>");
            }
            $('#BIRTHDATEid').val(res[5]);
        }
    </script>  
                   <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>ИИН</th>
                            <th>Дата рождения</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($list_GBDFL as $k => $v){
                        ?>
                        <tr onclick='insert_emp("<?php echo $v['SURNAME'].'//'.$v['FIRSTNAME'].'//'.$v['SECONDNAME'].'//'.$v['IIN'].'//'.$v['SEX_ID'].'//'.$v['BIRTH_DATE'];?>");'>
                            <td><?php echo $v['SURNAME'].' '.$v['FIRSTNAME'].' '.$v['SECONDNAME']; ?></td>
                            <td><?php echo $v['IIN']; ?></td>
                            <td><span class="pie"><?php echo $v['BIRTH_DATE']; ?></span></td>
                        </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
    <?php
    exit;
    }
    //$emp = new Employee('88');
    //$t = $emp->getId();
    //echo $t;

    if(isset($_POST['iin_for_check']))
    {
        $IIN = $_POST['iin_for_check'];
        $sql_to_check_iin = "select * from EMPLOYEES where iin  = $IIN";
        //echo $sql_to_check_iin;
        $list_to_check_iin = $db ->Select($sql_to_check_iin);
        //print_r($list_to_check_iin);
        if(count($list_to_check_iin) > 0)
        {
            echo '0';
        }else{
            echo '1';
        }
        exit;
    }

    function create_other_table($date_my, $emp_id, $start_date)
    {
        for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++)
            {
                if($start_date < 10)
                {
                    $start_date = str_replace('0', '', $start_date);
                }
           //     echo 'start day '.$start_date.'<br>';
                $db = new My_sql_db();
                $weekend = date("w",strtotime($i.$date_my));
                if($i < $start_date)
                    {
                        $sql_table_other = "select * from TABLE_OTHER";
                        $list_table_other = $db->Select($sql_table_other);
                        $lenth_table_other = count($list_table_other);
                        $lenth_table_other = $lenth_table_other + 1;
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ($lenth_table_other, '$i', ' ', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
                else
                    {
                        if($weekend==0 || $weekend==6)
                            {
                                $sql_table_other = "select * from TABLE_OTHER";
                                $list_table_other = $db->Select($sql_table_other);
                                $lenth_table_other = count($list_table_other);
                                $lenth_table_other = $lenth_table_other + 1;
                                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ($lenth_table_other, '$i', 'В', '$emp_id', '$i$date_my', 1)";
                                $list_sql = $db->Execute($sql);
                            }
                        else 
                            {
                                $sql_table_other = "select * from TABLE_OTHER";
                                $list_table_other = $db->Select($sql_table_other);
                                $lenth_table_other = count($list_table_other);
                                $lenth_table_other = $lenth_table_other + 1;
                                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ($lenth_table_other, '$i', '8', '$emp_id', '$i$date_my', 1)";
                                $list_sql = $db->Execute($sql);
                            }
                    }
            }
         //  header('location: all_employees');
    }

    function create_other_table_for_this_year($date_my, $emp_id, $start_date)
    {
        for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++)
            {
                if($start_date < 10)
                {
                    $start_date = str_replace('0', '', $start_date);
                }
                $db = new My_sql_db();
                $weekend = date("w",strtotime($i.$date_my));
                
                if($weekend==0 || $weekend==6)
                    {
                        $sql_table_other = "select * from TABLE_OTHER";
                        $list_table_other = $db->Select($sql_table_other);
                        $lenth_table_other = count($list_table_other);
                        $lenth_table_other = $lenth_table_other + 1;
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ($lenth_table_other, '$i', 'В', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
                else 
                    {
                        $sql_table_other = "select * from TABLE_OTHER";
                        $list_table_other = $db->Select($sql_table_other);
                        $lenth_table_other = count($list_table_other);
                        $lenth_table_other = $lenth_table_other + 1;
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ($lenth_table_other, '$i', '8', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
            }
    }
?>
















