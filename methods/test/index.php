<?php   
    session_start();
    header("Content-Type: text/html; charset=utf-8");
    error_reporting(0);
        
	define('MYSQL_USER', 'root');
    define('MYSQL_PASS', '');
    define('MYSQL_DATABASE', 'testes');
    define('MYSQL_HOST', 'localhost');            
    define('MYSQL_PREFIX', '');
    define("USER_SESSION", 'users_test');                
    
    function LdapList($region = '')
    {   
        $ldap_domain = '@gak.local';
        $ldap_user = 'Администратор';
        $ldap_pass = '<fhsc2014';

        $ds=ldap_connect("192.168.5.201");  // must be a valid LDAP server!
        
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    
        //$dn = "dc=gak, dc=local";
        $dn = "dc=gak, dc=local";
        if($region !== ''){
            $dn = "ou=$region, ou=filialy, ".$dn;
        }else{ 
            $dn = "ou=gak_user, ".$dn;
        }
        $filter = "sn=*";
        $attr = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
        if ($ds) 
        {             
            $r=ldap_bind($ds, $ldap_user.$ldap_domain, $ldap_pass) or die("Ошибка авторизации пользователя");
            $result = ldap_search($ds, $dn, $filter, $attr);        
            $r_d = ldap_get_entries($ds, $result);
            ldap_unbind($ds);
        }
        $dan = array();            
        for($i = 0;$i<$r_d['count'];$i++)
        {   
            $ds = array();
            if ($r_d[$i]['useraccountcontrol'][0] !== '514'){
                if(isset($r_d[$i]['sn'][0])){
                    $ds['fio'] = $r_d[$i]['sn'][0]." ".$r_d[$i]['givenname'][0];
                    $ds['login'] = $r_d[$i]['samaccountname'][0];   
                }                        
            }                 
            $dan[] = $ds;
        } 
        return $dan;   
    }

    function LdapUserDan($login, $pass)
    {
        $ldap_domain = '@gak.local';
        $ldap_user = $login;
        $ldap_pass = $pass;

        $ds=ldap_connect("192.168.5.201");  // must be a valid LDAP server!
        
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    
        $dn = "dc=gak, dc=local";
        $filter = "sn=*";
        $attr = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
        if ($ds) 
        {             
            $r=ldap_bind($ds, $ldap_user.$ldap_domain, $ldap_pass);
            if(!$r){
                die('Ошибка авторизации пользователя <a href="index.php">Повторить</a>');
            } 
            $result = ldap_search($ds, $dn, $filter, $attr);        
            $r_d = ldap_get_entries($ds, $result);
            ldap_unbind($ds);
        }
        $dan = array();            
        for($i = 0;$i<$r_d['count'];$i++)
        {   
            $ds = array();
            if ($r_d[$i]['useraccountcontrol'][0] !== '514'){                
                if(isset($r_d[$i]['sn'][0])){
                    if($r_d[$i]['samaccountname'][0] == $login){
                        $dan['fio'] = $r_d[$i]['sn'][0]." ".$r_d[$i]['givenname'][0];
                        $dan['dolgnost'] = $r_d[$i]['title'][0];
                        $dan['region'] = $r_d[$i]['description'][0];
                        $dan['uid'] = $r_d[$i]['usncreated'][0];                                                
                    }                    
                }                        
            }
        } 
        return $dan;  
    }          
        
    $msg = '';
    $itable_db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
    if (!$itable_db) 
    {
        echo "Ошибка подключения к серверу MySQL";
        exit;
    }  
    mysql_set_charset("utf8");
    mysql_select_db(MYSQL_DATABASE); 
    
    function Query($sql)
    {        
        $query = mysql_query($sql);
        if(!$query)exit(mysql_error());
           
        $row = mysql_fetch_array($query, MYSQL_ASSOC);
        return $row;                
    }    
    
    function query_array($sql)
    {
        $q = mysql_query($sql);
        if(!$q)exit(mysql_error());
        
        $a = array();
        $i = 0;
        while($row = mysql_fetch_array($q, MYSQL_ASSOC))
        {
            foreach($row as $r=>$v)
            {
                $a[$i][$r] = $v;   
            }            
            $i++;              
        }
        return $a;
    }
        
    function Execute($sql)
    {        
        $query = mysql_query($sql);
        if(!$query){                                    
            return false;            
        }else return true;        
    }  
    
    if(isset($_GET['exit'])){
        if(isset($_GET['result'])){
            require_once 'result.php';
            exit;
        }
        unset($_SESSION[USER_SESSION]);
        header("Location: index.php");
    }
    
    if(isset($_POST['start'])){        
        if(isset($_POST['login_user'])){        
            $login = $_POST['login_user'];
            $password = '';
            if(isset($_POST['login_pass'])){
                $password = $_POST['login_pass'];
            }
            if($password == ''){
                $r = '';
                if(isset($_GET['region'])){
                    $r = '?region='.$_GET['region'];
                }
                echo 'Пустой пароль! <a href="index.php'.$r.'">Назад</a>'; 
                exit;
            }
            $dan_user = LdapUserDan($login, $password);            
        }
        
        $fio = $dan_user['fio'];
        $dolgnost = $dan_user['dolgnost'];
        $region = $dan_user['region'];
        $uid = $dan_user['uid'];        
        
        $c = Query("select count(*) c from users_test where login = '$login' and uid = '$uid'");
        IF($c['c'] > 0){
            $r = Query("select * from users_test where login = '$login' and uid = '$uid'");            
            if($r['closed_test'] == '1'){
                $_SESSION[USER_SESSION]['id_ses'] = $r['id'];
              require_once 'result.php';            
              exit;
            }else{
                $a = array();
                $id_user = $r['id'];
                $a['id_ses'] = $r['id'];
                $a['date_ses'] = $r['date_test'];
                $a['login'] = $r['login'];
                $a['fio'] = $r['fio'];
                $a['dolgnost'] = $r['dolgnost'];
                $a['region'] = $r['region'];
                
                
                
                $num_pp = 1;                
                $array_list = array();                
                $list_type = query_array("select * from dir_type_quest");                
                foreach($list_type as $d=>$v){
                    $id = $v['id'];
                    $limit = $v['kl'];
                    $qs = query_array("SELECT * FROM questions q WHERE q.id_type = $id and q.answer is not null ORDER BY RAND() LIMIT $limit");
                    foreach($qs as $q=>$s){
                        $id_test = $s['id'];
                        Execute("INSERT INTO result_question(id_user, id_test, num_pp) VALUES ($id_user, $id_test, $num_pp)");        
                        $num_pp++;                
                    }                                                                                                                                           
                }
                               
                $_SESSION[USER_SESSION] = $a;
            }
        }else{
            $sql = "INSERT INTO users_test (uid, fio, dolgnost, region, login) VALUES('$uid', '$fio', '$dolgnost', '$region', '$login')";
            if(Execute($sql)){
                $ss = "select * from users_test where uid = '$uid' and login = '$login'";
                                
                $r = Query($ss);
                $a = array();
                $id_user = $r['id'];
                $a['id_ses'] = $r['id'];
                $a['date_ses'] = $r['date_test'];
                $a['login'] = $r['login'];
                $a['fio'] = $r['fio'];
                $a['dolgnost'] = $r['dolgnost'];
                $a['region'] = $r['region'];
                
                $num_pp = 1;                
                $array_list = array();                
                $list_type = query_array("select * from dir_type_quest");                
                foreach($list_type as $d=>$v){
                    $id = $v['id'];
                    $limit = $v['kl'];
                    $qs = query_array("SELECT * FROM questions q WHERE q.id_type = $id and q.answer is not null ORDER BY RAND() LIMIT $limit");
                    foreach($qs as $q=>$s){
                        $id_test = $s['id'];
                        Execute("INSERT INTO result_question(id_user, id_test, num_pp) VALUES ($id_user, $id_test, $num_pp)");        
                        $num_pp++;                
                    }                                                                                                                                           
                }
                               
                $_SESSION[USER_SESSION] = $a;
                header("Location: index.php");
            }
        }
    }
        
    if(empty($_SESSION[USER_SESSION])){
        require_once 'login.php';
    }else{
        require_once 'test.php';
    }                        
?>



