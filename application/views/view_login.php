<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>KADROBOT - система управления кадрами</title>

    <link href="styles/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="styles/font-awesome/css/font-awesome.css" rel="stylesheet"/>
    <link href="styles/css/animate.css" rel="stylesheet"/>
    <link href="styles/css/style.css" rel="stylesheet"/>
    <link href="styles/css/plugins/select2/select2.min.css" rel="stylesheet"/>
</head>
<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
            <a href="/">
                <img src="../styles/img/logo.png"/>
            </a>
            <p>Для входа в информационную систему, необходимо ввести Логин и Пароль от Вашей учетной записи</p>
            <form class="m-t" role="form" method="post" autocomplete="off">
                <div class="form-group">      
                    <input type="text" <?php //echo $s; ?> autocomplete="on" class="form-control" placeholder="Ваш Логин" name="login"/>
                </div>                
                <div class="form-group">
                    <input type="password" style="background-color: #fff;" <?php echo $s; ?> class="form-control" name="password" placeholder="Пароль"/>
                </div>
                <input type="hidden" name="url_request" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                <input type="submit" class="btn btn-primary block full-width m-b" value="Войти"/>
            </form>
            <a href="remind_pass"><small>Забыли пароль?</small></a>
            <p class="text-muted text-center"><small>Не создали аккаунт?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="register">Создать аккаунт</a>
            <!--
            <p class="m-t"> <small>Разработано LetSoft.art &copy; 2018</small> </p>
            -->
    </div>
    <script src="styles/js/jquery-2.1.1.js"></script>
    <script src="styles/js/bootstrap.min.js"></script>
</body>
</html>

