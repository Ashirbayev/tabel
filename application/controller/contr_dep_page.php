<?php
    $db = new My_sql_db();

    $emp_id = $_SESSION[USER_EMP_ID];
    $sql_company = "SELECT COMPANY_ID FROM `EMPLOYEES` WHERE ID = '$emp_id'";
    $list_company = $db -> Select($sql_company);
    $company_id = $list_company[0]['COMPANY_ID'];

    if(isset($_POST['CURATORS_ID']))
    {
        $id = $_POST['ID'];
        $dep_id = $_POST['DEP_ID'];
        $curators_id = $_POST['CURATORS_ID'];
        
        if($id == '')
            {
                $sql = "insert into CURATORS (ID, DEP_ID, CURATORS_ID) values (SEQ_CURATORS.nextval, '$dep_id', '$curators_id')";
                $list_dep = $db -> Execute($sql);
            }
                else
            {
                $sql = "update CURATORS set CURATORS_ID = '$curators_id' where id = $id";
                $list = $db -> Execute($sql);
            }
    }

    if(isset($_POST['DIRECTOR_ID']))
    {
        $id = $_POST['ID'];
        echo $id;
        $dep_id = $_POST['DEP_ID'];
        $DIRECTOR_ID = $_POST['DIRECTOR_ID'];

        if($id == ''){
            $sql = "insert into DIC_CHIEFS (ID, ID_DEPARTMENT, ID_DIR) values (SEQ_DIC_CHIEFS.nextval, '$dep_id', '$DIRECTOR_ID')";
            echo $sql;
            $list_dep = $db -> Execute($sql);
        }else{
            $sql = "update DIC_CHIEFS set ID_DIR = '$DIRECTOR_ID' where id = $id";
            echo $sql;
            $list = $db -> Execute($sql);
        }
    }

    if(isset($_POST['DIC_DEPARTMENT']))
    {
        $dep_id = $_GET['dep_id'];
        $NAME_KAZ = $_POST['NAME_KAZ'];
        $NAME = $_POST['NAME'];
        $BRANCH_ID = $_POST['BRANCH_ID'];
        $sql = "update DIC_DEPARTMENT set NAME_KAZ = '$NAME_KAZ', NAME = '$NAME', BRANCH_ID = '$BRANCH_ID' where ID = $dep_id";
        $list_dep = $db -> Execute($sql);
    }

    if(isset($_GET['dep_id']))
    {
        $dep_id = $_GET['dep_id'];
        $sql_dep = "select DEP.NAME, DEP.NAME_KAZ, DEP.BRANCH_ID from DIC_DEPARTMENT DEP where DEP.ID = $dep_id";
        $list_dep = $db -> Select($sql_dep);

        $sql_cur = "select SUBSTR(SUP.FIRSTNAME, 1, 1) || '. ' || SUBSTR(SUP.MIDDLENAME, 1, 1) || '. ' || SUP.LASTNAME FIO, SUP.ID EMP_ID, cur.ID, cur.CURATORS_ID, cur.DEP_ID from CURATORS cur, EMPLOYEES SUP where SUP.ID = cur.CURATORS_ID and cur.dep_id = $dep_id";
        $list_cur = $db -> Select($sql_cur);

        $sql_dir = "select chiefs.ID id_chief_table, sup.ID, sup.LASTNAME FIO from sup_person sup, DIC_CHIEFS chiefs where chiefs.ID_DIR = SUP.ID and chiefs.ID_DEPARTMENT = $dep_id";
    }
    /*
    $sql = "select ID, SUBSTR(FIRSTNAME, 1, 1) || '. ' || SUBSTR(MIDDLENAME, 1, 1) || '. ' || LASTNAME FIO from sup_person where JOB_SP = 14 order by id";
    //$list_chiefs = $db -> Select($sql);

    $sql = "select ID, SUBSTR(FIRSTNAME, 1, 1) || '. ' || SUBSTR(MIDDLENAME, 1, 1) || '. ' || LASTNAME FIO from sup_person order by id";
    //$list_pers = $db -> Select($sql);

    $sql = "select * from DIC_DEPARTMENT order by id";
    //$list_dep_list = $db -> Select($sql);
    */
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
?>

