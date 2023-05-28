<?php
    array_push
    ($js_loader,
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
        'styles/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
        'styles/js/plugins/clockpicker/clockpicker.js',
        'styles/js/plugins/cropper/cropper.min.js',
        'styles/js/plugins/fullcalendar/moment.min.js',
        'styles/js/plugins/daterangepicker/daterangepicker.js',
        'styles/js/plugins/Ilyas/edit_employees_js.js',
        'styles/js/plugins/Ilyas/addClients.js',
        'styles/js/demo/contracts_osns.js',
        'styles/js/plugins/sweetalert/sweetalert.min.js'
    );

    array_push
    ($css_loader,
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

    $db = new My_sql_db();

    //компании
    $sql_comp_name = "select * from DIC_COMPANY order by ID";
    $list_comp_name = $db->Select($sql_comp_name);

    //филиалы
    $sql_branch_name = "select * from DIC_BRANCH order by RFBN_ID";
    $list_branch_name = $db->Select($sql_branch_name);

    //департаменты
    $sqlDepartments = "select * from DIC_DEPARTMENT order by NAME";
    $listDepartments = $db -> Select($sqlDepartments);

    //статусы сотрудников
    $sqlState = "select * from DIC_PERSON_STATE order by id";
    $listState = $db -> Select($sqlState);

    //сотрудники
    $sql_persons = "select
                        s.*
                    from
                        EMPLOYEES s
                    order by s.ID";
    $list_persons = $db -> Select($sql_persons);
    print_r($list_persons);
echo $_POST['UPDATE_TABLE_FOR_DAY_NIGHT'];
    //статус день/ночь
    if($_POST['UPDATE_TABLE_FOR_DAY_NIGHT'])
    {

        $dep_id_for_table = $_POST['dep_id_for_table_up'];
        $comp_id = '10';
        $branch_id = '';
        $timesheet_date_start_orig = $_POST['timesheet_date_start'];
        $timesheet_date_end_orig = $_POST['timesheet_date_end'];

        $timesheet_date_start = date('Y-m-d', strtotime($timesheet_date_start_orig));
        $timesheet_date_end = date('Y-m-d', strtotime($timesheet_date_end_orig));
        $pers_id = $_POST['UPDATE_TABLE_FOR_DAY_NIGHT'];
        $val_start_day = date('Y-m-d', strtotime($_POST['val_start_day']));
        $val_end_day = date('Y-m-d', strtotime($_POST['val_end_day']));
        $days = getDates($val_start_day, $val_end_day);
        //print_r($days);
        $i = 0;
        $z = 2;
        $state = 'С';
        foreach ($days as $key => $value)
        {
            $sql_upd_val = "update TABLE_OTHER SET VALUE = '$state' where EMP_ID = '$pers_id' and DAY_DATE = '$value'";
            //echo $sql_upd_val.'<br />';
            $list_upd_val = $db -> Select($sql_upd_val);
            $i++;
            if($i == $z)
            {
                $i=0;
                if($state == 'С')
                {
                    $state = 'В';
                    $z = 5;
                }
                    else
                {
                    $state = 'С';
                    $z = 2;
                }
            }
        }

        if(isset($_POST['holi_set']))
        {
            set_all_holi($pers_id, $val_start_day, $val_end_day);
        }

        $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        if($dep_id_for_table == '')
        {
            $branch_id = $_POST['branch_id_up'];
            $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        }
        $list_guys = $db -> Select($sql_guys);
        //echo '<pre>';
        //print_r($list_guys);
        //echo '<pre>';

        $sql_guy = "select WEEK_DAY from TABLE_OTHER where DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' and emp_id = 398 order by DAY_DATE";
        $list_guy = $db -> Select($sql_guy);
    }

    //статус 2 на 2
    if($_POST['UPDATE_TABLE_FOR_ORIGIN_GRAPH'])
    {
        $dep_id_for_table = $_POST['dep_id_for_table_up'];
        $comp_id = '10';
        $branch_id = '';
        $timesheet_date_start_orig = $_POST['timesheet_date_start'];
        $timesheet_date_end_orig = $_POST['timesheet_date_end'];

        $timesheet_date_start = date('Y-m-d', strtotime($timesheet_date_start_orig));
        $timesheet_date_end = date('Y-m-d', strtotime($timesheet_date_end_orig));
        $pers_id = $_POST['UPDATE_TABLE_FOR_ORIGIN_GRAPH'];
        $val_start_day = date('Y-m-d', strtotime($_POST['val_start_day']));
        $val_end_day = date('Y-m-d', strtotime($_POST['val_end_day']));
        $days = getDates($val_start_day, $val_end_day);
        //print_r($days);
        $i = 0;
        $state = 8;
        foreach ($days as $key => $value)
        {
            $sql_upd_val = "update TABLE_OTHER SET VALUE = '$state' where EMP_ID = '$pers_id' and DAY_DATE = '$value'";
            //echo $sql_upd_val.'<br />';
            $list_upd_val = $db -> Select($sql_upd_val);
            $i++;
            if($i == 2)
            {
                
                $i=0;
                if($state == 8)
                {
                    $state = 'В';
                }
                    else
                {
                    $state = 8;
                }
            }
        }

        if(isset($_POST['holi_set']))
        {
            set_all_holi($pers_id, $val_start_day, $val_end_day);
        }

        $sql_guys = "select trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        if($dep_id_for_table == '')
        {
            $branch_id = $_POST['branch_id_up'];
            $sql_guys = "select trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        }
        $list_guys = $db -> Select($sql_guys);

        $sql_guy = "select WEEK_DAY from TABLE_OTHER where DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' and emp_id = 398 order by DAY_DATE";
        $list_guy = $db -> Select($sql_guy);
    }

    function getDates($startTime, $endTime)
    {
        $day = 86400;
        $format = 'Y-m-d';
        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        $numDays = round(($endTime - $startTime) / $day) + 1;
        //$numDays = round(($endTime - $startTime) / $day); // без +1
    
        $days = array();
    
        for ($i = 0; $i < $numDays; $i++) { 
            $days[] = date($format, ($startTime + ($i * $day)));
        }
    
        return $days;
    }

    //update between date
    if($_POST['UPDATE_TABLE_FOR_ONE_PERS_ID'])
    {
        $dep_id_for_table = $_POST['dep_id_for_table_up'];
        $comp_id = '10';
        $branch_id = '';
        $timesheet_date_start_orig = $_POST['timesheet_date_start'];
        $timesheet_date_end_orig = $_POST['timesheet_date_end'];

        $timesheet_date_start = date('Y-m-d', strtotime($timesheet_date_start_orig));
        $timesheet_date_end = date('Y-m-d', strtotime($timesheet_date_end_orig));
        $pers_id = $_POST['UPDATE_TABLE_FOR_ONE_PERS_ID'];
        $table_val = $_POST['val_between'];
        $val_start_day = date('Y-m-d', strtotime($_POST['val_start_day']));
        $val_end_day = date('Y-m-d', strtotime($_POST['val_end_day']));
        $sql_upd_val = "update TABLE_OTHER SET VALUE = '$table_val' where EMP_ID = '$pers_id' and DAY_DATE between '$val_start_day' and '$val_end_day'";
        $list_upd_val = $db -> Select($sql_upd_val);

        if(isset($_POST['holi_set']))
        {
            set_all_holi($pers_id, $val_start_day, $val_end_day);
        }

        $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        if($dep_id_for_table == '')
        {
            $branch_id = $_POST['branch_id_up'];
            $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        }
        $list_guys = $db -> Select($sql_guys);

        $sql_guy = "select WEEK_DAY from TABLE_OTHER where DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' and emp_id = 398 order by DAY_DATE";
        $list_guy = $db -> Select($sql_guy);
    }

    //guys at depart
    if(isset($_POST['dep_id_for_table']))
    {
        $dep_id_for_table = $_POST['dep_id_for_table'];
        $comp_id = '10';
        $branch_id = '';

        $timesheet_date_start_orig = $_POST['timesheet_date_start'];
        $timesheet_date_end_orig = $_POST['timesheet_date_end'];

        $timesheet_date_start = date('Y-m-d', strtotime($timesheet_date_start_orig));
        $timesheet_date_end = date('Y-m-d', strtotime($timesheet_date_end_orig));

        //место редактирования, чтото с скюэль
        $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        if($_POST['comp_id'] != '')
        {
            $comp_id = $_POST['comp_id'];
            $branch_id = $_POST['branch_id'];
            $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        }
        $list_guys = $db -> Select($sql_guys);

        $list_guy = $db -> Select("select WEEK_DAY from TABLE_OTHER where DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' and emp_id = 398 order by DAY_DATE");
    }

    if(isset($_POST['id_table']))
    {
        //обновляем данные
        $table_id = $_POST['id_table'];
        $table_val = $_POST['table_state'];
        $sql_upd_val = "update TABLE_OTHER SET VALUE = '$table_val' where id = $table_id";
        $list_upd_val = $db -> Select($sql_upd_val);

        $dep_id_for_table = $_POST['dep_id_for_table_up'];
        $comp_id = '10';
        $branch_id = '';

        $timesheet_date_start_orig = $_POST['timesheet_date_start'];
        $timesheet_date_end_orig = $_POST['timesheet_date_end'];

        $timesheet_date_start = date('Y-m-d', strtotime($timesheet_date_start_orig));
        $timesheet_date_end = date('Y-m-d', strtotime($timesheet_date_end_orig));

        $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        if($dep_id_for_table == '')
        {
            $branch_id = $_POST['branch_id_up'];
            $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from EMPLOYEES trivial, DIC_DOLZH dolzh where trivial.COMPANY_ID = '$comp_id' and trivial.JOB_SP = '$dep_id_for_table' AND dolzh.ID = trivial.JOB_POSITION order by JOB_POSITION";
        }
        $list_guys = $db -> Select($sql_guys);

        $sql_guy = "select WEEK_DAY from TABLE_OTHER where DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' and emp_id = 398 order by DAY_DATE";
        $list_guy = $db -> Select($sql_guy);
    }
/*
    //create table
    if(isset($_POST['CREATE_TABLE_FOR_ONE_PERS_ID'])){
        //создаем табель для нового сотрудника
        $CREATE_TABLE_FOR_ONE_PERS_ID = $_POST['CREATE_TABLE_FOR_ONE_PERS_ID'];
        $work_start_day = $_POST['work_start_day'];
        
        $post_day_list = explode('.', $work_start_day);
        $post_day = $post_day_list[0];
        
        $post_withuot_day = '.'.$post_day_list[1].'.'.$post_day_list[2];
        create_other_table("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, $post_day);
        
        for($i = $post_day_list[1]+1; $i <= 12; $i++){
            if($i<10){
                $post_withuot_day = '.0'.$i.'.'.$post_day_list[2];
                create_other_table_for_this_year("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, '01');
            }else{
                $post_withuot_day = '.'.$i.'.'.$post_day_list[2];
                create_other_table_for_this_year("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, '01');
            }
        }
    }
    
    //holidays
    if(isset($_POST['holyday_date'])){
        $holyday_date = $_POST['holyday_date'];
        $change_val = $_POST['change_val'];
        $value = $_POST['holyday_val'];
        $sql_holy = "update table_other set value = '$value' where EMP_ID in (select ID from sup_person where state = 2) and DAY_DATE = '$holyday_date' and value = '$change_val'";
        $list_upd_val = $db -> Select($sql_holy);
    }
    
    //functions
    function create_other_table($date_my, $emp_id, $start_date)
    {
        for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++)
            {
                if($start_date < 10){
                    $start_date = str_replace('0', '', $start_date);
                }
                $db = new DB();
                $weekend = date("w",strtotime($i.$date_my));
                if($i < $start_date)
                    {
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES (SEQ_TABLE_OTHER.NEXTVAL, '$i', ' ', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
                else
                    {
                        if($weekend==0 || $weekend==6)
                            {
                                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES (SEQ_TABLE_OTHER.NEXTVAL, '$i', 'В', '$emp_id', '$i$date_my', 1)";
                                $list_sql = $db->Execute($sql);
                            }
                        else 
                            {
                                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES (SEQ_TABLE_OTHER.NEXTVAL, '$i', '8', '$emp_id', '$i$date_my', 1)";
                                $list_sql = $db->Execute($sql);
                            }
                    }
            }
    }
    
    function create_other_table_for_this_year($date_my, $emp_id, $start_date)
    {
        for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++)
            {
                if($start_date < 10){
                    $start_date = str_replace('0', '', $start_date);
                }
                $db = new DB();
                $weekend = date("w",strtotime($i.$date_my));
    
                if($weekend==0 || $weekend==6)
                    {
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES (SEQ_TABLE_OTHER.NEXTVAL, '$i', 'В', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
                else 
                    {
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES (SEQ_TABLE_OTHER.NEXTVAL, '$i', '8', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
            }
    }
*/
    //добавляет выходные
    function set_all_holi($emp_id, $date_event_start, $date_event_end)
    {
        $db = new DB();
        $sql_all_holi_between_two_date = "select DATE_HOL from HOLIDAYS where DATE_HOL between '$date_event_start' and '$date_event_end'";
        $list_all_holi_between_two_date = $db -> Select($sql_all_holi_between_two_date);

        foreach($list_all_holi_between_two_date as $k => $v)
        {
            $DATE_HOL = $v['DATE_HOL'];
            $sql_change_day_state = "update TABLE_OTHER set VALUE = 'В' where EMP_ID = '$emp_id' and DAY_DATE = '$DATE_HOL'";
            $list_change_day_state = $db -> Execute($sql_change_day_state);
        }
    }
?>

