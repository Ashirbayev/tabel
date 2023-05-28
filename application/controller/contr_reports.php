<?php
    $db = new My_sql_db();

    $emp_id = $_SESSION[USER_EMP_ID];
    $sql_company = "SELECT COMPANY_ID FROM `EMPLOYEES` WHERE ID = '$emp_id'";
    $list_company = $db -> Select($sql_company);
    $company_id = $_SESSION[COMPANY_ID];

    array_push
    ($js_loader,        
        'styles/js/plugins/metisMenu/jquery.metisMenu.js',
        'styles/js/plugins/slimscroll/jquery.slimscroll.min.js',
        'styles/js/plugins/flot/jquery.flot.js',
        'styles/js/plugins/flot/jquery.flot.tooltip.min.js',
        'styles/js/plugins/flot/jquery.flot.spline.js',
        'styles/js/plugins/flot/jquery.flot.resize.js',
        'styles/js/plugins/flot/jquery.flot.pie.js',                                        
        'styles/js/plugins/peity/jquery.peity.min.js',
        'styles/js/inspinia.js',
        'styles/js/plugins/pace/pace.min.js',
        'styles/js/plugins/iCheck/icheck.min.js',
        'styles/js/demo/peity-demo.js',
        'styles/js/plugins/jquery-ui/jquery-ui.min.js',
        'styles/js/plugins/gritter/jquery.gritter.min.js',
        'styles/js/plugins/sparkline/jquery.sparkline.min.js',
        'styles/js/demo/sparkline-demo.js',
        'styles/js/plugins/chartJs/Chart.min.js',
        'styles/js/plugins/toastr/toastr.min.js'
    );        

    array_push
    ($css_loader, 
        'styles/font-awesome/css/font-awesome.css',
        'styles/css/plugins/iCheck/custom.css',
        'styles/css/animate.css'
    );

    $othersJs .= "<script>
                    $(document).ready(function(){
                        $('.i-checks').iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green',
                        });
                    });
                </script>";

    $year_array = array('2014', '2015', '2016', '2016_2', '2017');

    $today_year = date('Y');

    $sql = "select * from DIC_DEPARTMENT where COMPANY_ID = '$company_id' order by ID";
    $list_dep = $db -> Select($sql);

    $sql_branch = "select * from DIC_BRANCH where COMPANY_ID = '$company_id' order by RFBN_ID";
    $list_branch = $db -> Select($sql_branch);

    if(isset($_POST['DIC_DEPARTMENT_NEW']))
    {
        $NAME_KAZ = $_POST['NAME_KAZ'];
        $NAME = $_POST['NAME'];
        $COMPANY_ID = $_POST['COMPANY_ID'];
        $BRANCH_ID = $_POST['BRANCH_ID'];
        $sql = "insert into DIC_DEPARTMENT (ID, NAME_KAZ, NAME, BRANCH_ID, COMPANY_ID) values ('', '$NAME_KAZ', '$NAME', '$BRANCH_ID', '$COMPANY_ID')";
        $list_dep = $db -> Execute($sql);
    }
?>


