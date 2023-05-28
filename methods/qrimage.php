<?php
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrcode/temp'.DIRECTORY_SEPARATOR;    
    if (!file_exists($PNG_TEMP_DIR)){
       mkdir($PNG_TEMP_DIR);        
    }
            
    if(count($_GET) <= 0){
        echo '';
        exit;
    }    
        
    require_once 'qrcode/qrlib.php';    
    $errorCorrectionLevel = 'Q';
    $matrixPointSize = 1;
    
    $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';    
    //QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            
    if(isset($_GET['type'])){
        QRcode::png($_REQUEST['data'], false, $errorCorrectionLevel, $matrixPointSize, 2);  
    }else{
        QRcode::jpg($_REQUEST['data'], false, 'H', 4, 4);
    }    
    //
    //Header("Content-type: image/png"); 
    //imagepng($q);              
    //echo '<img src="methods/qrcode/temp/'.basename($filename).'"/>';
           
    QRtools::timeBenchmark();
    exit;
?>