<?php
    $db = new My_sql_db();

    function report_blocks($ID, $NUM_PP, $ID_OTCHET, $POSITION, $TITLE, $HTML_TEXT)
    {
        return "
            <div class='col-lg-$NUM_PP' data='$ID_OTCHET'>
                <div class='ibox float-e-margins'>
                    <div class='ibox-title'>
                        <h5>№ п\п: $POSITION. Название блока: $TITLE</h5>
                        <div class='ibox-tools'>
                            <a class='dropdown-toggle' data-toggle='modal' onclick='edit_block($ID);' data-target='#add_standart_contracts'><i class='fa fa-edit'></i></a>
                            
                        </div>
                    </div>
                    
                    <div class='ibox-content'>
                        <div id='blockContent'>".base64_decode($HTML_TEXT)."</div>
                    </div>
                </div>
            </div>";
    }

    if(isset($_POST['pst']))
    {
        $html_text = '';
        if(!isset($_GET['sicid']))
        {
            $html .= "<script>alert('Не выбран отчет для сохранения блока');</script>";
        }

        $id_otchet = $_GET['sicid'];        
        $dan = $_POST['pst'];

        $id = $dan['ID'];
        $title = $dan['TITLE']; 
        $p['HTML_TEXT'] = base64_encode($dan['HTML_TEXT']);
        $HTML_TEXT = base64_encode($dan['HTML_TEXT']);
        $pos = $dan['POSITION'];
        $num = $dan['NUM_PP'];

        if($dan['ID'] == 0)
        {
            $sql = "INSERT INTO REPORT_HTML_OTHER (ID, HTML_TEXT, POSITION, NUM_PP, TITLE, ID_OTCHET) 
                    VALUES (NULL, '$HTML_TEXT', '$pos', '$num', '$title', '$id_otchet')";
            
        }
            else
        {
            $sql = "UPDATE REPORT_HTML_OTHER
            SET   
            HTML_TEXT = '$HTML_TEXT',
            POSITION  = '$pos',
            NUM_PP    = '$num',
            TITLE     = '$title'        
            where ID = $id";
            $al = $db->Execute($sql);
        }
        $al = $db->Execute($sql);

        /*
        if($al[''] !== true){
            $html .= "<script>alert('$al');</script>";            
        }
        */
        $ht = $db->Select("select * from REPORT_HTML_OTHER where id_otchet = $id_otchet order by position");
        $i = 0;
        foreach($ht as $k=>$v)
        {
            if($i == 0)
            {
                $html .= '<div class="col-lg-12"></div>';
            }
            $html .= report_blocks($v['ID'], $v['NUM_PP'], $v['ID_OTCHET'], $v['POSITION'], $v['TITLE'], $v['HTML_TEXT']);
            $i += $v['NUM_PP'];
            if($i >= 12){$i = 0;}
        }

        echo $html;

        exit;
    }

    if(isset($_POST['id_block']))
    {
        $ht = $db->Select("select * from REPORT_HTML_OTHER where id = ".$_POST['id_block']);
        $dan = $ht[0];
        $dan['HTML_TEXT'] = base64_decode($dan['HTML_TEXT']);
        echo json_encode($dan);
        exit;
    }

    if(isset($_POST['TITLE_TEXT']))
    {
        echo 'test2';
            exit;
        $q = new My_sql_db();
        $text = $_POST['textAreaForDB'];
        $position = $_POST['POSITION'];
        $numpp = $_POST['NUM_PP'];
        $titleText = $_POST['TITLE_TEXT'];
        $idOtchet = $_GET['sicid'];
        $HTML_TEXT = base64_encode($dan['HTML_TEXT']);

        $sql = "INSERT INTO REPORT_HTML_OTHER (ID, CYCLE, HTML_TEXT, ID_LANG, POSITION,  NUM_PP, TITLE, ID_OTCHET)
        VALUES (NULL, 0, '$HTML_TEXT', 1, '$position', $numpp, '$titleText', $idOtchet)";
        $bool = $q->Execute($sql);
        header('location: standart_contracts?sicid='.$_GET['sicid']);
    }

    $rq = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    if(isset($_POST['editTITLE_TEXT']))
    {
        echo $_POST['editTITLE_TEXT'];
        $id = $_POST['ID'];
        $q = new My_sql_db();
        $text = $_POST['edittextAreaForDB'];
        $position = $_POST['editPOSITION'];
        $numpp = $_POST['editNUM_PP'];
        $titleText = $_POST['editTITLE_TEXT'];
        $idOtchet = $_GET['sicid'];

        $array = array('html'=>$text);    

        $sql = "update REPORT_HTML_OTHER set HTML_TEXT = '$text', position = '$position', num_pp = $numpp, title = '$titleText', id_otchet = '$idOtchet' where id = $id";
        $q->ClearParams();
        $bool = $q->ExecProc($sql, $array);
        header('location: standart_contracts?sicid='.$_GET['sicid']);
    }

    if(isset($_POST['deleteDocid']))
    {
        $dbDocidNorm = new My_sql_db();
        $sqlDocidNorm = 'delete from REPORT_HTML_OTHER where id = '.$_POST['deleteDocid'];
        $danDocidNorm = $dbDocidNorm->Execute($sqlDocidNorm);
        echo $_POST['deleteDocid'];
        exit;
    }

    if(isset($_POST['blockId']))
    {
        $dbBlockWithSicid = new My_sql_db();
        $sql = "select HTML_TEXT from REPORT_HTML_OTHER where id = ".$_POST['blockId'];
        $danBlockForEdit = $dbBlockWithSicid -> Select($sql);
        foreach($danBlockForEdit as $k => $v)
        {
            echo $v['HTML_TEXT'];
        }
        exit;
    }

    $dbBlockWithSicid = new My_sql_db();
    $sqlBlockWithSicid = "select * from REPORT_HTML_OTHER where id_otchet = ".$_GET['sicid']." order by position" ;
    $danBlockWithSicid = $dbBlockWithSicid -> Select($sqlBlockWithSicid);

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
        'styles/js/plugins/summernote/summernote.min.js',
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
        'styles/css/plugins/select2/select2.min.css',
        'styles/css/plugins/summernote/summernote-bs3.css',
        'styles/css/plugins/summernote/summernote.css',
        'styles/font-awesome/css/font-awesome.css'
    );

    /*
    $othersJs = "<script>
                tinymce.init({
                    selector: 'textarea',
                    height: 500,
                    theme: 'modern',
                    plugins: [
                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                        'insertdatetime nonbreaking save table contextmenu directionality',
                        'template paste textcolor colorpicker textpattern imagetools'
                    ],
                    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    toolbar2: 'print preview media | forecolor backcolor emoticons',
                    image_advtab: true,
                    templates: [
                        { title: 'Test template 1', content: 'Test 1' },
                        { title: 'Test template 2', content: 'Test 2' }
                    ]       
                })</script>";
    */
?>
