<?php       
    if(isset($_POST['content'])){
        $html .= $_POST['content'];
    }else{
        echo 'Не выбран табель!';
        exit;
    }

    include("methods/mpdf/mpdf.php");

    $mpdf = new mPDF('','A4',8,'Times');
    $mpdf->AddPage('L');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    exit;
?>