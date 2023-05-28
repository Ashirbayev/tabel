<?php
    $db = new My_sql_db();

    if(isset($_POST['comp_name']))
    {
        $comp_name = $_POST['comp_name'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $oked = $_POST['oked'];

        $sql_oked = "INSERT INTO `DIC_COMPANY`(`ID`, `NAME`, `COUNTRY`, `CITY`, `OKED`, `STATE`) VALUES ('', '$comp_name', '$country', '$city', '$oked', '1')";
        $emp_oked = $db -> Execute($sql_oked);
        echo '<div class="alert alert-info alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                Компания успешно добавлена <a class="alert-link" href="register">Зарегистрировать сотрудника</a>
            </div>';
    }

    $sql_oked = "SELECT * FROM DIC_OKED ORDER BY ID";
    $emp_oked = $db -> Select($sql_oked);
?>


