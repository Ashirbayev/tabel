<?php
	$db = new My_sql_db();
    $rq = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(isset($_POST['TITLE_TEXT']))
    {
        $id = $_POST['id'];
        $titleText = $_POST['TITLE_TEXT']; 
        $dateAdd = $_POST['DATE_ADD'];
        $paymCode = $_POST['PAYM_CODE'];
        $dateBegin= $_POST['DATE_BEGIN'];
        $dateEnd = $_POST['DATE_END'];
        $dopNum= $_POST['ID_DOP_NUM'];

        if($id == 0)
        {
            $sql = "insert into REPORTS_HTML (ID, HTML_TEXT, TITLE_TEXT, DATE_ADD) values ('', '', '$titleText', '$dateAdd')";
        }
            else
        {
            $sql = "update REPORTS_HTML set TITLE_TEXT = '$titleText', DATE_ADD = '$dateAdd' where ID = $id";
        }
        $s = $db->Execute($sql);  
        if($s !== true)
        {
            $msg = ALERTS::ErrorMin($s);
        }
            else
        {
            Header("Location: $rq");
        }
    }

    if(isset($_POST['deleted']))
    {
        $sql = 'delete from REPORTS_HTML where id = '.$_POST['deleted'];
        $s = $db->Execute($sql);
        if($s !== true)
        {
            $msg = ALERTS::ErrorMin($s);
        }
            else
        {
            Header("Location: $rq");
        }
    }

    if(isset($_POST['reasonId']))
    {
        $sqlDicReason = "select * from dic_reason_dops where vid_dog = ".$_POST['reasonId']; //vid_dog =".$_POST['reasonId']);
        $dbDicReason = new My_sql_db();
        $sqlDicReason = $dbDicReason -> Select($sqlDicReason);
        echo '<option value="0">Основной договор</option>';
        foreach($sqlDicReason as $k => $v)
        {
            echo "<option value=".$v['ID'].">".$v['REASON']."</option>";
        }
        print_r($sqlDicReason);
        exit;
    }

    $sql = "select * from REPORTS_HTML order by id";

    if(isset($GETS['id']))
    {
        $sql .= " where id = ".$GETS['id'];
    }

    $dbReport_html_other = new My_sql_db();
    $sqlReport_html_other = "select * from REPORT_HTML_OTHER ORDER BY ID";
    $sqlReport_html_other_dan = $dbReport_html_other -> Select($sqlReport_html_other);

    $dan = $db->Select($sql);

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
        'styles/js/plugins/metisMenu/jquery.metisMenu.js',
        'styles/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
        'styles/js/plugins/clockpicker/clockpicker.js',
        'styles/js/plugins/cropper/cropper.min.js',
        'styles/js/plugins/fullcalendar/moment.min.js',
        'styles/js/plugins/daterangepicker/daterangepicker.js',
        'styles/js/plugins/Ilyas/addClients.js'
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