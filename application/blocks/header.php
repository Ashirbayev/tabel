<?php

define('USER_STATE', 'USER_STATE'); // Define USER_STATE constant
define('USER_EMP_ID', 'USER_EMP_ID'); // Define USER_EMP_ID constant

$sql_check_user = "SELECT * FROM USERS WHERE LOGIN = '$_SESSION[LOGIN]' AND PASSWORD = '$_SESSION[PASSWORD]'";
//$emp_check_user = $db->Select($sql_check_user);
if (!empty($emp_check_user)) {
    $_SESSION['USER_SESSION'] = $emp_check_user[0]['LOGIN'];
    $_SESSION[USER_STATE] = $emp_check_user[0]['STATE'];
    $_SESSION[USER_EMP_ID] = $emp_check_user[0]['EMP_ID'];
}

//if ($_SESSION[USER_STATE] == '1') {
//    if ($page != 'employee') {
//        /*
//        echo
//        "<script>
//            alert('Для полноценной работы с программой, заполните личные данные!');
//            window.location.replace('employee?employee_id=".$_SESSION[USER_EMP_ID]."');
//        </script>";
//        */
//    }
//}

if ($_SESSION['USER_STATE'] == '1') {
    if ($page != 'employee') {
        /*
       echo
       "<script>
           alert('Для полноценной работы с программой, заполните личные данные!');
           window.location.replace('employee?employee_id=".$_SESSION[USER_EMP_ID]."');
       </script>";
       */
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
        echo $title; ?></title>

    <link href="styles/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="styles/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <?php
    if (count($css_loader) > 0) {
        foreach ($css_loader as $css) {
            echo "\n";
            echo '<link href="' . $css . '" rel="stylesheet">';
        }
    }
    ?>

    <link href="styles/css/animate.css" rel="stylesheet"/>
    <link href="styles/css/style.css" rel="stylesheet"/>

    <script src="styles/js/jquery-2.1.1.js"></script>
    <script src="styles/js/bootstrap.min.js"></script>
    <script src="styles/js/others/jquery.cookie.js"></script>

    <?php
    if (count($js_loader_header) > 0) {
        foreach ($js_loader_header as $vs) {
            echo "\n";
            echo '<script type="text/javascript" src="' . $vs . '"></script>';
        }
    }
    ?>
</head>
<body class="<?php
if (isset($_COOKIE['navbar'])) {
    echo $_COOKIE['navbar'];
}
?>">
<div id="wrapper">