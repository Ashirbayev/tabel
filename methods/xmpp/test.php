<?php
/* UTF-8 
XMPP webi
http://webi.ru/webi_files/xmpp_webi.html
*/

//if(count($_POST) > 0){    
    include_once(__DIR__."/xmpp/xmpp.class.php");
    $webi = new XMPP($webi_conf);
    
    $user = "a.saleev@gak.kz";//$_POST['user'];
    $msg = "soobshenie test";//$_POST['msg'];
        
    $webi->connect(); // установка соединения...
    $webi->sendMessage($user, $msg);
    //$webi->sendStatus('text status','chat'); // установка статуса
    //$webi->sendMessage("a.saleev@gak.kz", "soobshenie"); // отправка сообщения
    echo 'Yes';
/*    
}else{
    echo 'NO!';
}
*/
// так можно зациклить
/*

while($webi->isConnected)
{
	$webi->getXML();
}

*/


?>
