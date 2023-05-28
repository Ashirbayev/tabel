<?php
    session_start();	
    define("CSS", 'styles/css/');                            //Путь для подключения CSS
    define("JS", 'styles/js/');                              //Путь для подключения JS
    define("IMAGE_PATH", 'styles/img/');                     //Путь для картинок

    define("UNITS", 'application/units/');    
    define("MODELS", 'application/blocks/');                
    define("MODULES", 'application/module/');

    /*clients paths*/
    define("VIEWS", 'application/views/');                  
    define("CONTR", 'application/controller/');                   

    /*Страницы ошибок*/
    define("Error404", 'application/errors/404.php');
    define("NotLogin", 'application/errors/not_login.php');
    define("ClosedPage", 'application/errors/pageclosed.php');

    /*Изображения*/
    define("HTTP_NO_IMAGE_USER", IMAGE_PATH."no_avatar.png");    //Если нет аватарки
    define("LOGO_IMG", IMAGE_PATH."logo gak min.png");               //Логотип предприятия    
    define('HTTP_IMAGE', IMAGE_PATH.'/loader/');                 //Папка для сохранения картинок

    define('SALT', 'insurance_test');                           //Соль для кодировки пароля
    define('URL', 'http://192.168.5.9/');            //здесь прописывется полный URL сайта
    define('SITE_NAME', 'АИС кадры - система управления кадрами"');
    define('USER_SESSION', 'insurance');

    define("MAIL_SERVER", "{192.168.5.210:143/imap/novalidate-cert}");
    define("MAIL_SERVER_IP", "192.168.5.210:143");

    //define("MAIL_SERVER", "{192.168.5.212:143/imap/novalidate-cert}");
    //define("MAIL_SERVER_IP", "192.168.5.212:143");

    //Данные к к файлам сайта
    define("FTP_SITE_SERVER", '192.168.5.46');
    define("FTP_SITE_USER", 'root');
    define("FTP_SITE_PASS", 'tashenova25');

    /*Данные для FTP подключения*/
    define("FTP_SERVER", '192.168.5.2');
    define("FTP_USER", "upload");
    define("FTP_PASS", "Astana2014");

    //база данных UTF-8
    define('DB_USERNAME', 'user');
    define('DB_PASS', 'Thr*nexp02011');
    define('DB_DATABASE', 'person');
    define('DB_HOST', 'localhost');
    //define('DB_HOST', '192.168.5.97');
    define("DB_CHARSET", "AL32UTF8");//AL32UTF8    CL8MSWIN1251

    //Данные для подключения к базе 192,168,5,3
    define('DB_USERNAME2', 'insurance');
    define('DB_PASS2', 'insurance');
    define('DB_DATABASE2', 'orcl');
    define('DB_HOST2', '192.168.5.3');
    define("DB_CHARSET2", "AL32UTF8");

    $msg = '';         
    $page = 'index';  
    $title = 'АИС кадры - система управления кадрами';
    $othersJs = '';
    $othersJs2 = '';

    $js_loader_header = array(); //Загрузка других JavaScript файлов в шапку
    $js_loader = array(); //Загрузка других JavaScript файлов 
    $css_loader = array(); //Загрузка других CSS файлов

    $label = array();  
    $POSTS = array(); 
    $GETS = array();

    $page_title = 'Главная страница';       //Имя страницы
    $breadwin = array();    //В main_menu вставляется для красивых ссылок
?>
