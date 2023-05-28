<?php
	class ACTION
    {
        function ActiveUser()
        {
            global $active_user_dan;                         
            $dbUserDan = ACTION::UserdanBase($_SESSION[USER_SESSION]['login']);                        
            $dbrole = ACTION::UserRole($_SESSION[USER_SESSION]['login']);
                    
            if(count($dbUserDan) > 0){
                $active_user_dan = array();
                $active_user_dan['brid'] = $dbUserDan[0]['BRANCH_ID'];               //код региона
                $active_user_dan['emp'] = $dbUserDan[0]['EMP_ID'];                       //id пользователя            
                $active_user_dan['brname_id'] = $dbUserDan[0]['SHORT_NAME'];               //Название филиала или региона
            }   
        
            if(count($dbrole) > 0){     
                $active_user_dan['role'] = $dbrole[0]['ROLE'];                //id текущей роли
                $active_user_dan['role_type'] = $dbrole[0]['ID_TYPE'];         //тип роли ГАК АСКО или КОС
            }

            $active_user_dan['emp_name'] = $_SESSION[USER_SESSION]['fio'];                          //ФИО
            $active_user_dan['dolgnost'] = $_SESSION[USER_SESSION]['dolgnost'];                     //Должность
            $active_user_dan['department'] = $_SESSION[USER_SESSION]['region'];                     //Департамент                
        }
        
        
        function ProvUserPage()
        {
            global $active_user_dan;
            global $page;
                                    
            $b = ACTION::PublicPages();   
            $b = true; 
            if(!$b){                
                $db = new DB();
                $db->ClearParams();
                $rc = $db->Select("select count(*) c from view_form_role v, dir_forms d where D.ID = v.id_form 
                and upper(trim(D.NAME_URL)) = trim(upper('$page'))
                and v.id_role = ".$active_user_dan['role']);
                
                if($rc[0]['C'] == 0){
                    require_once ClosedPage;
                    exit;
                }
            }
        }
        
        function PublicPages()
        {
            global $page;
            $ps = array("/", 'index', 'mypage', 'mail', 'contracts_files', 'help');                                    
            return in_array($page, $ps);
        }
        
        function UserdanBase($login)
        {
            $db = new DB3();
            $list_users = array();            
            $sql = "select u.emp_id, u.branch_id, u.lastname, u.firstname, u.vcmail, u.avatar, u.login, d.name, d.short_name from gs_emp u, dic_branch d where u.branch_id = d.rfbn_id and login = '$login'";                        
            $list_users = $db->Select($sql);            
            return $list_users;
        }
    
        function UserRole($login)
        {
            $db = new DB();
            $role = array();
            $db->ClearParams();
            $us = $db->Select("select * from gs_emp where login  = '$login'");
            if(count($us) <= 0){
                return $role;
            }
        
            $sql = "select * from emp_role u, dir_role d where d.id = u.role and u.emp_id = ".$us[0]['EMP_ID'];
            $db->ClearParams();
            $role = $db->Select($sql);
            return $role;
        }
        
        function LdapAllList()
        {
            $ldap_domain = '@gak.local';
            $ldap_user = 'ldap';
            $ldap_pass = 'Astana2016';

            $ds=ldap_connect("192.168.5.200");  // must be a valid LDAP server!
        
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    
            $dn = "dc=gak, dc=local";
            //$dn = "OU=gak_user, dc=gak, dc=local";
        
            $filter = "givenname=*";//"sn=*";
            $attr = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
            if ($ds)
            {
                $r=ldap_bind($ds, $ldap_user.$ldap_domain, $ldap_pass) or die("Ошибка! Сервер отключен!");
                $result = ldap_search($ds, $dn, $filter, $attr);
                $r_d = ldap_get_entries($ds, $result);
                ldap_unbind($ds);
            }
            $dan = $r_d;
            return $dan;
        }
        
        function LdapAllListGAK()
        {
            $ldap_domain = '@gak.local';
            $ldap_user = 'ldap';
            $ldap_pass = 'Astana2016';

            $ds=ldap_connect("192.168.5.200");  // must be a valid LDAP server!
        
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    
            //$dn = "dc=gak, dc=local";
            $dn = "OU=gak_user, dc=gak, dc=local";
        
            $filter = "sn=*";
            $attr = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
            if ($ds)
            {
                $r=ldap_bind($ds, $ldap_user.$ldap_domain, $ldap_pass) or die("Ошибка! Сервер отключен!");
                $result = ldap_search($ds, $dn, $filter, $attr);
                $r_d = ldap_get_entries($ds, $result);
                ldap_unbind($ds);
            }
            $dan = $r_d;
            return $dan;
        }
        
        function LdapOnePerson($login)
        {
            $ldap_domain = '@gak.local';
            $ldap_user = 'ldap';
            $ldap_pass = 'Astana2016';
            
            $ds=ldap_connect("192.168.5.200");  // must be a valid LDAP server!
        
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    
            $dn = "dc=gak, dc=local";
            //$dn = "mail=".$login.", dc=gak, dc=local";
        
            $filter = "sn=*";
            $attr = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
            if ($ds) 
            {             
                $r=ldap_bind($ds, $ldap_user.$ldap_domain, $ldap_pass) or die("Ошибка! Сервер отключен!");
                $result = ldap_search($ds, $dn, $filter, $attr);        
                $r_d = ldap_get_entries($ds, $result);
                ldap_unbind($ds);
            }
        
            for($i = 0;$i<$r_d['count'];$i++)
            {   
                $ds = array();
                if ($r_d[$i]['useraccountcontrol'][0] !== '514'){                
                    if(isset($r_d[$i]['sn'][0])){
                        if($r_d[$i]['samaccountname'][0] == "$login"){
                            $dan['login'] = $r_d[$i]['samaccountname'][0];
                            $dan['fio'] = $r_d[$i]['sn'][0]." ".$r_d[$i]['givenname'][0];
                            $dan['dolgnost'] = $r_d[$i]['title'][0];
                            $dan['region'] = $r_d[$i]['description'][0];
                            $dan['uid'] = $r_d[$i]['usncreated'][0];                            
                            $dan['mail'] = $r_d[$i]['userprincipalname'][0];
                            $dan['mobile'] = $r_d[$i]['mobile'][0];
                            $dan['telephoneNumber'] = $r_d[$i]['telephoneNumber'][0];
                            //$dan['other'] = $r_d[$i];                                                
                        }                    
                    }                        
                }
            } 
            $db = new DB();             
            $b = self::UserdanBase($login);
            $dan['base'] = $b[0];      
            return $dan;
        }
        
        function LdapListForDepartments()
        {
            $ldap_domain = '@gak.local';
            $ldap_user = 'ldap';
            $ldap_pass = 'Astana2016';

            $ds=ldap_connect("192.168.5.200"); 
             // must be a valid LDAP server!
        
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    
            //$dn = "dc=gak, dc=local";
            $dn = "OU=gak_user, dc=gak, dc=local";
        
            $filter = "sn=*";
            $attr = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
            if ($ds) 
            {             
                $r=ldap_bind($ds, $ldap_user.$ldap_domain, $ldap_pass) or die("Ошибка! Сервер отключен!");
                $result = ldap_search($ds, $dn, $filter, $attr);        
                $r_d = ldap_get_entries($ds, $result);
                ldap_unbind($ds);
            }
            $dan = array();
            for($i = 0; $i < $r_d['count']; $i++){                                
                if($r_d[$i]['useraccountcontrol'][0] !== '514'){
                    $d = array();
                    
                    if($r_d[$i]['department'][0] == ''){
                        $depart = 'Неизвестный';
                    }else{
                        $depart = $r_d[$i]['department'][0];    
                    }
                    $d['department'] = $r_d[$i]['department'][0];
                    
                    $d['emailAddress'] = $r_d[$i]['emailAddress'][0];
                    $d['login'] = $r_d[$i]['samaccountname'][0];
                    $d['fio'] = $r_d[$i]['sn'][0]." ".$r_d[$i]['givenname'][0];
                    $dan[$depart][] = $d;
                    //array_push($dan, $d);
                }                 
            }
            
            /*
            function cmp($a, $b)
            {
                return strcmp($a["department"], $b["department"]);
            }
            usort($dan, "cmp"); 
            */
            asort($dan);                               
            return $dan;
        }
                        
        function LdapUserDan($login, $pass)
        {
            $server = $_SERVER['SERVER_NAME'];
            $dan = array();
            
            $ldap_domain = '@gak.local';
            $ldap_user = trim($login);
            $ldap_pass = trim($pass);
            //header("Content-Type: text/html; charset=utf-8");

            $ds=ldap_connect("192.168.5.200");
                            
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
    
            $dn = "dc=gak, dc=local";
            if ($ldap_user !== 'a.saleev'){
            if($server == 'ins.gak.kz'){
                $dn = "ou=kos, dc=gak, dc=local";
            } 
            }
                       
            $filter = "sn=*";
            $attr = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
            if ($ds) 
            {             
                $r = ldap_bind($ds, $ldap_user.$ldap_domain, $ldap_pass);// or die('Ошибка авторизации пользователя <a href="/">Повторить</a>');
                if(!$r){                    
                    return false;
                }
                $result = ldap_search($ds, $dn, $filter, $attr);        
                $r_d = ldap_get_entries($ds, $result);
                ldap_unbind($ds);
            }
                    
            for($i = 0;$i<$r_d['count'];$i++)
            {   
                $ds = array();
                if ($r_d[$i]['useraccountcontrol'][0] !== '514'){                
                    //if(isset($r_d[$i]['sn'][0])){
                        if($r_d[$i]['samaccountname'][0] == $login){
                            $dan['login'] = $login;
                            $dan['fio'] = $r_d[$i]['sn'][0]." ".$r_d[$i]['givenname'][0];
                            $dan['dolgnost'] = $r_d[$i]['title'][0];
                            $dan['region'] = $r_d[$i]['description'][0];
                            $dan['uid'] = $r_d[$i]['usncreated'][0];
                            $dan['password'] = base64_encode($pass);
                            $dan['mail'] = $r_d[$i]['userprincipalname'][0];
                            $dan['other'] = $r_d[$i];                                                
                        }                    
                    //}                        
                }
            } 
            $db = new DB();
            $db->OpenSession();            
            return $dan;  
        }
        
        function check_deleted_pers()
        {
            $db = new DB();
            $sql = "select * from SET_DELETED_PERSONS where STATE = 0";
            $list = $db -> Select($sql);
            $today_date = date('d.m.Y');
            if(isset($list))
            {
                foreach($list as $k => $v)
                {
                    $id = $v['ID'];
                    $emp_ID = $v['EMP_ID'];
                    $delete_date = $v['DELETE_DATE'];
                    $BRANCH_IDholi = $v['BRANCHID'];
                    $DEPARTMENTholi = $v['JOB_SP'];
                    $POSITIONholi = $v['JOB_POSITION'];
                    
                    if(strtotime($today_date) >= strtotime($delete_date))
                    {
                        $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ID_PERSON, BRANCH_ID, DEPARTMENT, POSITION, ACT_ID) values (SEQ_T2_CARD.nextval, '$delete_date', '$emp_ID', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '5')";
                        $update_history = $db -> Execute($sql_update_history);
                        
                        $sql = "update SUP_PERSON set STATE = 7, DATE_LAYOFF = '$delete_date' where ID = $emp_ID";
                        $list = $db -> Execute($sql);
                        
                        $sql = "update SET_DELETED_PERSONS set STATE = 1 where ID = $id";
                        $list = $db -> Execute($sql);
                    }
                }
            }
        }
    }
?>