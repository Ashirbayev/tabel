<?php
    $db = new My_sql_db();
    $sql_company = "SELECT * FROM `EMPLOYEES`";
    $list_company = $db -> Select($sql_company);
    $tab_num = 1;
    foreach($list_company as $k => $v)
    {
        /*$current_tabnum = $tab_num;
        $iin = $v['iin'];
        //$new_iin = substr($iin, 0, -1);
        $firstname = $v['firstname'];
        $surname = $v['surname'];
        $patronymic = $v['meddlename'];
        $DOC_NUM = $v['DOC_NUM'];
        $SALARY = $v['SALARY'];
        $IBAN = $v['IBAN'];
        $BANK_ID = $v['BANK_ID'];
        //$emp_id = $v['ID'];
        $sql_company =
        "INSERT INTO `USERS`
        (`ID`, `LASTNAME`, `FIRSTNAME`, `MIDDLENAME`, `IIN`, `DOCNUM`, `OKLAD`, `ACCOUNT`, `BANK_CODE`, `DOCPLACE`, `REG_ADDRESS_COUNTRY_ID`, `DOCTYPE`, `REG_ADDRESS_CITY`, `FACT_ADDRESS_CITY`, `NACIONAL`, `FAMILY`, `FACT_ADDRESS_COUNTRY_ID`, `JOB_SP`, `BRANCHID`, `JOB_POSITION`, `EMAIL`, `ACCOUNT_TYPE`, `STATE`, `PERSONAL_EMAIL`, `COMPANY_ID`, `TAB_NUM`, `CONTRACT_JOB_NUM`, `SEX`) VALUES
        ('', '$firstname', '$surname', '$patronymic', '$iin', '$DOC_NUM', '$SALARY', '$IBAN', '$BANK_ID', '1', '105', '2', 'Астана', 'Астана', '131', '2', '105', '2', '2', '2', 'corp_mail@kazimpex.kz', '1', '2', 'personal_mail@kazimpex.kz', '10', '$current_tabnum', '$current_tabnum', '2')";
        */
        $emp_id = $v['ID'];
        $iin = $v['IIN'];
        $doc_num = $v['DOCNUM'];
        $sql_company =
        "INSERT INTO `USERS`(`ID`, `EMP_ID`, `LOGIN`, `PASSWORD`, `STATE`, `ROLE`) VALUES
        ('', '$emp_id', '$iin', '$doc_num', '1', '3')";
        echo $sql_company.'<br /><br />';
        //$list_company = $db -> Select($sql_company);
        //$tab_num++;
    }
    exit;
?>