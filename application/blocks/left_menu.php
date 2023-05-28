<?php
$db = new My_sql_db();
$emp_id = $_SESSION['USER_EMP_ID'];


$emp_inf_sql = "SELECT
                    trivial.LASTNAME, trivial.FIRSTNAME, trivial.MIDDLENAME,
                    dolzh.D_NAME
                FROM
                    `EMPLOYEES` trivial,
                    `DIC_DOLZH` dolzh
                WHERE
                    trivial.ID = '$emp_id'
                    AND trivial.JOB_POSITION = dolzh.ID";


$emp_inf = $db->Select($emp_inf_sql);
$emp_lastname = $emp_inf[0]['LASTNAME'];
$emp_name = $emp_inf[0]['FIRSTNAME'];
$emp_middlename = $emp_inf[0]['MIDDLENAME'];
$emp_position_name = $emp_inf[0]['D_NAME'];
?>
<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <!-- Здесь надо поставить генерацию меню -->
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            <img alt="<?php echo $active_user_dan['emp_name']; ?>" class="img-circle" src="styles/img/no_avatar.png" style="width: 60px;"/>
                        </span>
                        <span data-toggle="dropdown" class="dropdown-toggle">
                            <span class="clear"> 
                                <span class="block m-t-xs"> <strong class="font-bold"><?php echo $emp_lastname.' '.$emp_name.' '.$emp_middlename; ?></strong></span>
                                <a class="text-muted text-xs block"><?php echo $emp_position_name; ?></a>
                            </span> 
                        </span>
                        <!--
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="mypage">Личные данные</a></li>                                                   
                            <li class="divider"></li>
                            <li><a href="block">Установить блокировку</a></li>
                        </ul>
                        -->
                    </div>
                    <div class="logo-element">
                        <img class="img-circle" src="<?php //echo HTTP_NO_IMAGE_USER; ?>" style="width: 50px;"/>
                    </div>
                </li>
                
                <?php 
                    $menu = new LEFT_MENU();
                    echo $menu->init();
                ?>                
            </ul>
        </div>
    </nav>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message"><strong>KADROBOT</strong> - система управления кадрами</span>
                </li>
                <!--
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks"></i>  
                        <span class="label label-primary"><?php //if($didnt_open_count != 0){echo $didnt_open_count;} ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>Задачи <?php //echo $didnt_open_count; ?></li>
                        <li>
                            <a href="create_inner_doc">
                                <div>
                                    <i class="fa fa-plus fa-fw"></i> Создать
                                    <span href="" class="pull-right text-muted small">Создать новую задачу</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="inbox">
                                <div>
                                    <i class="fa fa-list-alt fa-fw"></i> Список
                                    <span class="pull-right text-muted small">Список задач</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="inbox">
                                <div>
                                    <i class="fa fa-inbox fa-fw"></i> Входящие
                                    <span class="pull-right text-muted small">Список входящих задач</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="outbox">
                                <div>
                                    <i class="fa fa-send fa-fw"></i> Исходящие
                                    <span class="pull-right text-muted small">Список исходящих задач</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-danger"><?php //if($didnt_open_count_trash != 0){echo $didnt_open_count_trash;} ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="trash">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> У Вас <?php //echo $didnt_open_count_trash; ?> отклоненных
                                    <span class="pull-right text-muted small"></span>
                                </div>
                            </a>
                        </li>                      
                    </ul>
                </li>
                -->
                <li>
                    <a href="exit">
                        <i class="fa fa-sign-out"></i> Выйти
                    </a>
                </li>
            </ul>
        </nav>
        </div>        
        <div class="articles">

