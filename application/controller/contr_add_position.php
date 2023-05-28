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
        'styles/js/plugins/metisMenu/jquery.metisMenu.js',
        'styles/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
        'styles/js/plugins/clockpicker/clockpicker.js',
        'styles/js/plugins/cropper/cropper.min.js',
        'styles/js/plugins/fullcalendar/moment.min.js',
        'styles/js/plugins/daterangepicker/daterangepicker.js',
        'styles/js/plugins/Ilyas/addClients.js',
        'styles/js/demo/contracts_pa.js'
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

    $othersJs = "<script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                'dom': 'lTfigt',
                'tableTools': {
                    'sSwfPath': 'js/plugins/dataTables/swf/copy_csv_xls_pdf.swf'
                }
            });

            /* Init DataTables */
            var oTable = $('#editable').DataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( '../example_ajax.html', {
                'callback': function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                'submitdata': function ( value, settings ) {
                    return {
                        'row_id': this.parentNode.getAttribute('id'),
                        'column': oTable.fnGetPosition( this )[2]
                    };
                },

                'width': '90%',
                'height': '100%'
            } );

        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                'Custom row',
                'New row',
                'New row',
                'New row',
                'New row' ] );

        }
    </script>";

    $db = new My_sql_db();

    $sql = "select
                triv.lastname||' '||triv.firstname||' '||triv.middlename fio,
                triv.ID PERS_ID,
                triv.OKLAD OKLAD,
                triv.NADBAVKA,
                triv.PREMIUM_PERIOD,
                triv.PREMIUM PERS_PREMIUM,
                triv.BRANCHID,
                branch.NAME BRANCH_NAME,
                dep.*,
                dolzh.*
            from 
                EMPLOYEES triv,
                DIC_DEPARTMENT dep,
                DIC_DOLZH dolzh,
                DIC_BRANCH branch
            where dep.ID = triv.JOB_SP
            and dolzh.ID = triv.JOB_POSITION
            and triv.STATE = 2
            and triv.BRANCHID = branch.RFBN_ID
            order by triv.ID";
    $listEmployee = $db -> Select($sql);
    //echo $sql;

    //echo '<pre>';
    //print_r($listEmployee);
    //echo '<pre>';

    $sqlState = "select * from DIC_PERSON_STATE order by id";
    $listState = $db -> Select($sqlState);

    //филиалы
    $sqlBranch = "select * from DIC_BRANCH order by NAME";
    $listBranch = $db -> Select($sqlBranch);

    //департаменты
    $sqlDepartments = "select * from DIC_DEPARTMENT order by id";
    $listDepartments = $db -> Select($sqlDepartments);

    //периоды премий
    $sql_prem_per = "select * from DIC_PREMIUM_PERIOD order by id";
    $list_prem_per = $db -> Select($sql_prem_per);

    //должностные группы
    $sql_pos_group = "select * from DIC_POS_GROUPS order by id";
    $list_pos_group = $db -> Select($sql_pos_group);

    if(isset($_POST['BRANCHID_FOR_SP']))
    {
        //департаменты
        $sqlDepartments = "select * from DIC_DEPARTMENT order by id";
        $listDepartments = $db -> Select($sqlDepartments);
        foreach($listDepartments as $z => $x)
        {
            echo '<option value="'.trim($x['ID']).'">'.$x['NAME'].'</option>'; 
        }
        exit;
    }

    if(isset($_POST['BRANCHID']))
    {
        $BRANCH_ID = $_POST['BRANCHID'];
        $JOB_SP = $_POST['JOB_SP'];
        $D_NAME = $_POST['D_NAME'];
        $D_NAME_KAZ = $_POST['D_NAME_KAZ'];
        $CNT = $_POST['CNT'];
        $sql_add_position = "insert into DIC_DOLZH (ID, D_NAME, D_NAME_KAZ, BRANCH_ID, CNT, ID_DEPARTMENT) VALUES ('', '$D_NAME', '$D_NAME_KAZ', '$BRANCH_ID', '$CNT', '$JOB_SP')";
        $list_add_position = $db -> Select($sql_add_position);
    }

    if(isset($_POST['fact']))
    {
        $pers_id = $_POST['pers_id'];
        $elem_name = $_POST['elem_name'];
        $this_val = $_POST['this_val'];
        $sql_upd_triv = "update EMPLOYEES set $elem_name = '$this_val' where ID = $pers_id";
        $list_upd_triv = $db -> Select($sql_upd_triv);
    }

    if(isset($_POST['potential']))
    {
        $dolzh_id = $_POST['dolzh_id'];
        $elem_name = $_POST['elem_name'];
        $this_val = $_POST['this_val'];
        $sql_upd_triv = "update DIC_DOLZH set $elem_name = '$this_val' where ID = $dolzh_id";
        $list_upd_triv = $db -> Select($sql_upd_triv);
    }
?>

