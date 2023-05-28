<?php

    $db = new My_sql_db();

    if(count($POSTS) > 0)
    {
        if(isset($POSTS['login']))
        {
            $login = SqlInject(trim($POSTS['login']));
            $_SESSION[LOGIN] = $login;
            $password = trim($POSTS['password']);
            $_SESSION[PASSWORD] = $password;
            $sql_check_user = "SELECT USERS.EMP_ID USER_EMP_ID, USERS.STATE USER_STATE, USERS.*, TRIVIAL.* FROM USERS USERS, EMPLOYEES TRIVIAL WHERE USERS.LOGIN = '$login' AND USERS.PASSWORD = '$password' AND TRIVIAL.ID = USERS.EMP_ID";
            $emp_check_user = $db -> Select($sql_check_user);
            //echo $sql_check_user;
            //echo '<pre>';
            //print_r($emp_check_user);
            //echo '<pre>';

            if(!empty($emp_check_user))
            {
                $_SESSION[USER_SESSION] = $emp_check_user[0]['LOGIN'];
                $_SESSION[USER_STATE] = $emp_check_user[0]['STATE'];
                $_SESSION[USER_EMP_ID] = $emp_check_user[0]['USER_EMP_ID'];
                $_SESSION[COMPANY_ID] = $emp_check_user[0]['COMPANY_ID'];
                $user_state = $emp_check_user[0]['USER_STATE'];
                //echo $user_state;
                //echo $_SESSION[USER_EMP_ID];
                if(isset($_POST['url_request']))
                {
                    $url = $_POST['url_request'];
                }
                if($user_state == '2')
                {
                    header("Location: all_employees");
                }
                    else
                {
                    header("Location: all_employees");
                }
            }
        }
    }
?>

