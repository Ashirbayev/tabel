<?php
	function SqlInject($param){
        $param = stripslashes($param); 
        //$param = mysql_real_escape_string($param); 
        $param = trim($param); 
        $param = htmlspecialchars($param); 
        return $param; 
    }
    
    function SetTextGetArray($arrayname){
        if(isset($_GET[$arrayname])){
            return $_GET[$arrayname];
        }else{
            return '';
        }
    }
    
    function SetBoolGetArray($arrayname, $params)
    {
        if(isset($_GET[$arrayname])){
            if($_GET[$arrayname] == $params){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function StrToFloat($s){
        return floatval(str_replace(",", ".", $s));
    }
    
    function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb"); 
        $data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($data[1])); 
        fclose($ifp); 
        return $output_file; 
    }
    
    function BoolTostrRus($b){
        if($b == false){
            return 'Нет';
        }else{
            return 'Да';
        }
    }
    
    function BoolToInt($b)
    {
        if($b == false){
            return 0;
        }else{
            return 1;
        }
    }
    
    Function HTTP_URL_image_user($text)
    {
        if ($text == ''){
            return HTTP_NO_IMAGE_USER;
        }else{
            $txt = substr($text, 1, 4);        
            if($txt = 'http'){
                if (@fopen($text, "r")) {
                    return $text;
                }else return HTTP_NO_IMAGE_USER;
            }else {
                if (@fopen(HTTP_IMAGE.$text, "r")){
                    return HTTP_IMAGE.$text;    
                }else return HTTP_NO_IMAGE_USER;
            }
        }
    }
    
    function str_replace_kaz($text)
    {
        $kz1 = array("ј", "і", "ѕ", "є", "ї", "ў", "ќ", "ґ", "ћ", "Ј", "І", "Ѕ", "Є", "Ї", "Ў", "Ќ", "Ґ", "Ћ");
        $kz2 = array("ә", "і", "ң", "ғ", "ү", "ұ", "қ", "ө", "һ", "Ә", "І", "Ң", "Ғ", "Ү", "Ұ", "Қ", "Ө", "Һ");
        $txt = str_replace($kz1, $kz2, $text);
        //јіѕєїўќґћ ЈІЅЄЇЎЌҐЋ
        //әіңғүұқөһ ӘІҢҒҮҰҚӨҺ
        return $txt;        
    }
    
    function nvl($p1, $p2)
    {
        if(trim($p1) == ''){
            return $p2;
        }
        return $p1;    
    }
    
    function SetChecked($id)
    {
        if($id == 1){
            echo 'checked';
        }else{
            if($id == ''){
                echo  'checked';
            }else
            echo '';
        }
    }
    
    function OnToNumber($s, $on, $off)
    {
        if($s == 'on'){
            return $on;
        }else{
            return $off;
        }
    }
    
    function consolExit($dan)
    {
        echo '<pre>';
        print_r($dan);
        echo '</pre>';
        exit;
    }
?>