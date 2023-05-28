<?php
    $db = new DB();
    $file_name = $_GET['file_name'];

    $sql_meta = "select * from DIC_META order by id";
    //$list_meta = $db -> Select($sql_meta);
    if(isset($_POST['doc_list']))
    {
        $html = $_POST['doc_list'];
    }
    
    if(isset($_POST['content'])){
        $html .= $_POST['content'];
        if(isset($_POST['holi_id'])){
            $p['CONTENT'] = $_POST['content'];
            $holi_id = $_POST['holi_id'];
            
            $item_name = $_POST['ITEM_NAME'];
            $sqlHoli = "UPDATE PERSON_HOLIDAYS SET DOC_CONTENT = EMPTY_CLOB() WHERE ID = $holi_id
                            RETURNING DOC_CONTENT INTO :CONTENT";
            //$t = $db->AddClob($sqlHoli, $p);
        }
    }
    /*include("methods/mpdf/mpdf.php");
    
    $mpdf = new mPDF('UTF-8', 'A4', '8', 'timesnewroman', 20, 10, 7, 7, 10, 10);
    $mpdf->charset_in = 'UTF-8';
    $mpdf->WriteHTML($stylesheet, 1);
    
    $mpdf->list_indent_first_level = 0; 
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output("$file_name.pdf", 'I');*/
    
    ob_clean();
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="321"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    include("methods/mpdf2/mpdf.php");

    $mpdf = new mPDF('UTF-8', 'A4', '8', 'timesnewroman', 20, 10, 7, 7, 10, 10);
    $mpdf->WriteHTML($html);
    $mpdf->debug = true;
    $output = $mpdf->Output();
    exit();
?>
