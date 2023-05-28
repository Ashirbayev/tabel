<?php
    $db = new My_sql_db();

    if(isset($_POST['date_start']))
    {
        $date_start = date('Y-m-d', strtotime($_POST['date_start']));
        $date_end = date('Y-m-d', strtotime($_POST['date_end']));

        $sql_history = "select
                            DATE_HOL
                        from
                            HOLIDAYS
                        where DATE_HOL between '$date_start' and '$date_end'
                        order by DATE_HOL";
        $list_history = $db -> Select($sql_history);
    }

    if(isset($_POST['DATE_HOL_FOR_DELETE']))
    {
        $date_start = date('Y-m-d', strtotime($_POST['date_start']));
        $date_end = date('Y-m-d', strtotime($_POST['date_end']));
        $DATE_HOL_FOR_DELETE = date('Y-m-d', strtotime($_POST['DATE_HOL_FOR_DELETE']));

        $sql_del = "delete
                            HOLIDAYS
                        where DATE_HOL = '$DATE_HOL_FOR_DELETE'";
        $list_del = $db -> Execute($sql_del);

        $sql_history = "select
                            DATE_HOL
                        from
                            HOLIDAYS
                        where DATE_HOL between '$date_start' and '$date_end'
                        order by DATE_HOL";
        $list_history = $db -> Select($sql_history);
    }

    if(isset($_POST['ADDING_HOLY']))
    {
        $date_start = date('Y-m-d', strtotime($_POST['date_start']));
        $date_end = date('Y-m-d', strtotime($_POST['date_end']));
        $ADDING_HOLY = date('Y-m-d', strtotime($_POST['ADDING_HOLY']));

        $sql_add_holy = "insert
                            into
                                HOLIDAYS
                            (DATE_HOL)
                            values
                                ('$ADDING_HOLY')
                        ";
        $list_add_holy = $db -> Execute($sql_add_holy);

        $sql_history = "select
                            DATE_HOL
                        from
                            HOLIDAYS
                        where DATE_HOL between '$date_start' and '$date_end'
                        order by DATE_HOL";
        $list_history = $db -> Select($sql_history);
    }

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