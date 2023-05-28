<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <!-- Здесь надо поставить генерацию меню -->
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="<?php echo $active_user_dan['emp_name']; ?>" class="img-circle" src="<?php echo HTTP_NO_IMAGE_USER; ?>" style="width: 60px;"/>
                             </span>
                        <span data-toggle="dropdown" class="dropdown-toggle">
                            <span class="clear">
                                <span class="block m-t-xs"> <strong class="font-bold"><?php echo $active_user_dan['emp_name']; ?></strong></span>
                                <a class="text-muted text-xs block"><?php echo $active_user_dan['dolgnost']; ?> <b class="caret"></b></a>
                            </span>
                        </span>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="mypage">Личные данные</a></li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Сменить роль</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="fa fa-check"></i> Главный специлист</a></li>
                                    <li><a href="#">Ведущий специалист</a></li>
                                </ul>
                            </li>
                            <li class="divider"></li>
                            <li><a href="block">Установить блокировку</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        <img class="img-circle" src="<?php echo HTTP_NO_IMAGE_USER; ?>" style="width: 50px;"/>
                    </div>
                </li>
                <li class="">
                    <a><i class="fa fa-th-large"></i> <span class="nav-label">СУП</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="employee">Добавить сотрудника</a></li>
                        <li><a href="all_employees">Все сотрудники</a></li>
                        <li><a href="chief_page">Страница шефа</a></li>
                        <li><a href="sysadmins_page">Страница сис.админа</a></li>
                        <li><a href="timesheet_for_dir">Табель</a></li>
                        <li><a href="create_timesheet2">Создать табель</a></li>
                        <li><a href="list_sup_contracts">Документы</a></li>
                        <li><a href="departments">Департаменты</a></li> 
                    </ul>
                </li>
                <li class="">
                    <a><i class="fa fa-th-large"></i> <span class="nav-label">Справочники</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="add_position">Должности</a></li>
                    </ul>
                </li>
                
                <li class="">
                    <a><i class="fa fa-th-large"></i> <span class="nav-label">СУР</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="create_test">Добавить опросник</a></li>
                        <li><a href="manage_test">Управление опросами</a></li>
                    </ul>
                </li>
                <li class="">
                    <a><i class="fa fa-th-large"></i> <span class="nav-label">Договоры</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="search_contracts">Поиск</a></li>
                        <li><a href="contracts">Регистрация</a></li>
                    </ul>
                </li>
                <li class="">
                    <a>
                        <i class="fa fa-th-large"></i> 
                        <span class="nav-label">Документооборот</span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="inbox">Канцелярия</a></li>
                    </ul>
                </li>                                
                <?php                                                             
                    if(isset($active_user_dan['role'])){
                        $menu = new MENU();
                        echo $menu->GenMenu($active_user_dan['role']);
                    }                    
                ?>
                <!--
                <li>
                    <a href="#"><i class="fa fa-info-circle"></i> <span class="nav-label">Помощь</span></a>
                </li>
                -->
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>                
                <ul class="nav navbar-top-links navbar-left">
                    <li>
                        <span class="m-r-sm text-muted welcome-message"><h4>Информационная система АО "КСЖ "ГАК"<?php if(DB_HOST == '192.168.5.171'){echo ' Тестовая база';} ?></h4></span>
                    </li>
                </ul>                                
            </div>
            <ul class="nav navbar-top-links navbar-right">                
                            
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>                       
                    </ul>
                </li>
                <li>
                    <a href="exit">
                        <i class="fa fa-sign-out"></i> Выйти
                    </a>
                </li>
            </ul>

        </nav>
        </div>
        
    
        
        <div class="articles">