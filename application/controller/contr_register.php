<?php
    $db = new My_sql_db();

    if(isset($_POST['email']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $company_id = $_POST['company_id'];

        $sql_emp = "INSERT INTO `EMPLOYEES`(`ID`, `PERSONAL_EMAIL`, `COMPANY_ID`) VALUES ('', '$email', '$company_id')";
        $emp_emp = $db -> Execute($sql_emp);

        $sqlEmpInfo = $db -> Select("SELECT ID FROM EMPLOYEES ORDER BY ID DESC LIMIT 1");
        $last_user_id = $sqlEmpInfo[0]['ID'];

        $sql_user = "INSERT INTO `USERS`(`ID`, `EMP_ID`, `LOGIN`, `PASSWORD`, `STATE`, `ROLE`) VALUES ('', '$last_user_id', '$email', '$password', '1', '3')";
        $emp_user = $db -> Execute($sql_user);

        $sql_emp_sel = "SELECT ID FROM `EMPLOYEES` where COMPANY_ID = ".$company_id;
        $list_emp_sel = $db -> Select($sql_emp_sel);

        if(count($list_emp_sel) < 2)
        {
            $sqlUpdateEduId = "update DIC_COMPANY set FIRST_EMP = '$last_user_id' where id = ".$company_id;
            $listUpdateEduId = $db -> Select($sqlUpdateEduId);

            $sqlUpdateUser = "update USERS set ROLE = '3' where EMP_ID = ".$last_user_id;
            $listUpdateUser = $db -> Select($sqlUpdateUser);
        }

        header("Location: login");
    }

    $sql_comp = "SELECT * FROM DIC_COMPANY ORDER BY ID";
    $emp_comp = $db -> Select($sql_comp);
?>




