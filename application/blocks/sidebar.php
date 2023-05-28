<script>
var mylogin = '<?php echo $_SESSION[USER_SESSION]['login']; ?>';
</script>
<div class="cssload-thecube" id="loading_pic" style="opacity: 0;display:none;">
	<div class="cssload-cube cssload-c1"></div>
	<div class="cssload-cube cssload-c2"></div>
	<div class="cssload-cube cssload-c4"></div>
	<div class="cssload-cube cssload-c3"></div>
</div>   


<!--сайдбар-->    
<div class="modal inmodal fade" id="email-form" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 85%;float: left;left: 12%;">
        <div class="modal-content">
            <div class="modal-header" id="email-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="email-title">Modal title</h4>                
            </div>                                     
            <div class="modal-body" style="float: left;width: 100%; padding: 0px 30px 30px 15px; background: #fff;">
                <div class="col-lg-4" id="email-subjects"></div>
                <div class="col-lg-8" id="email-body"></div>
            </div>
        </div>
    </div>
</div>   

                    <!--сайдбар-->
<!--                    
<div class="right-button">
    <div class="spin-icon">
        <a class="right-sidebar-toggle"><i class="fa fa-cogs"></i></a>        
    </div>
</div>
-->
                    
                    <!--chat-->
<!--                    
<div id="small-chat">
    <span class="badge badge-warning pull-right">5</span>
    <a class="open-small-chat"><i class="fa fa-comments"></i></a>
</div>
                        
<div class="small-chat-box fadeInRight animated">                        
    <div class="heading" draggable="true">
        <small class="chat-date pull-right"><?php //echo date("m/d/Y");?></small>
        Чат
    </div>
    <div class="content">
        <div class="left">
            <div class="author-name">
                Ахметов Ильяс <small class="chat-date">10:02 am</small>
            </div>
            <div class="chat-message active">
                Lorem Ipsum is simply dummy text input.
            </div>                        
        </div>
        <div class="right">
                                        <div class="author-name">
                                            Ахметов Ильяс
                                            <small class="chat-date">
                                                11:24 am
                                            </small>
                                        </div>
                                        <div class="chat-message">
                                            Lorem Ipsum is simpl.
                                        </div>
                                    </div>
                                    <div class="left">
                                        <div class="author-name">
                                            Ахметов Ильяс
                                            <small class="chat-date">
                                                08:45 pm
                                            </small>
                                        </div>
                                        <div class="chat-message active">
                                            Check this stock char.
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="author-name">
                                            Ахметов Ильяс
                                            <small class="chat-date">
                                                11:24 am
                                            </small>
                                        </div>
                                        <div class="chat-message">
                                            The standard chunk of Lorem Ipsum
                                        </div>
                                    </div>
                                    <div class="left">
                                        <div class="author-name">
                                            Ахметов Ильяс
                                            <small class="chat-date">
                                                08:45 pm
                                            </small>
                                        </div>
                                        <div class="chat-message active">
                                            I belive that. Lorem Ipsum is simply dummy text.
                                        </div>
                                    </div>
                        
                        
                                </div>
                                <div class="form-chat">
                                    <div class="input-group input-group-sm"><input type="text" class="form-control"> <span class="input-group-btn"> <button
                                            class="btn btn-primary" type="button">Отправить
                                    </button> </span></div>
                                </div>
                        
</div>
-->
<!--chat-->                                     
                        
<!-- Правая выбегающая панель-->
<div id="right-sidebar">
    <div class="sidebar-container">
        <ul class="nav nav-tabs navs-3">
            <li class="active"><a data-toggle="tab" href="#tab-users">Персонал</a></li>
            <!--
            <li><a data-toggle="tab" href="#tab-mail">Почта</a></li>
            <li><a data-toggle="tab" href="#tab-config"><i class="fa fa-gear"></i></a></li>
            -->
        </ul>
        
        <div class="tab-content">
            <div id="tab-users" class="tab-pane active">  
                <div class="sidebar-title">                
                <select class="select2_demo_1 form-control" id="departments">
                <?php 
                    /*                                    
                    $list_department = ACTION::LdapListForDepartments();
                    foreach($list_department as $k=>$v){
                        echo '<option value="'.$k.'">'.$k.'</option>';
                    } 
                    */                   
                ?>
                </select>
                </div>  
                
                <div>                                     
            <?php   
                /*                                
                $lists = ACTION::LdapAllList();
                for($i = 0; $i< $lists['count']; $i++){
                    if($lists[$i]['useraccountcontrol'][0] !== '514'){
                        if($lists[$i]['samaccountname'][0] !== $_SESSION[USER_SESSION]['login']){
            ?>
                <div class="chat-user" data="<?php echo $lists[$i]['department'][0]; ?>" id="<?php echo str_replace('.', '', $lists[$i]['samaccountname'][0]); ?>">
                    <img class="chat-avatar img-circle" style="margin-top: 15px;" src="styles/img/no_avatar.png" alt="">
                    <span class="user-state-online label-danger"></span>
                    <div class="chat-user-name" id="<?php echo $lists[$i]['samaccountname'][0]; ?>">                                    
                        <a href="#"><?php echo $lists[$i]['sn'][0]." ".$lists[$i]['givenname'][0];?></a><br />                                    
                        <span class="btn btn-success btn-xs"><i class="fa fa-comment"></i></span>                                        
                        <span class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></span>
                        <span class="btn btn-success btn-xs"><i class="fa fa-video-camera"></i></span>                                    
                    </div>                                
                </div>
            <?php }}} */ ?>
            
                </div>
            </div>
            
            <div id="tab-mail" class="tab-pane">
                <div class="sidebar-title">
                    <a class="btn btn-block btn-xs btn-primary compose-mail" href="#">Написать письмо</a>                                
                    <ul class="folder-list m-b-md" style="padding: 0">
                    <?php
                        /*
                        $mailbox = new IMAPMAIL(MAIL_SERVER_IP, $_SESSION[USER_SESSION]['mail'], base64_decode($_SESSION[USER_SESSION]['password']));
                        $path = $mailbox->paths();
                        
                        for($i = 0; $i < count($path); $i++){
                            echo '<li>
                            <a id="'.$path[$i]['path_name'].'" data-toggle="modal" data-target="#email-form" class="mail" data="path='.$path[$i]['path_name'].'">
                            <i class="fa '.$path[$i]['icon'].'"></i>
                            <span class="label pull-right">'.$path[$i]['count_unread'].'</span>
                            <span class="email_path">'.$path[$i]['name'].'</span></a></li>';
                        }
                        */
                    ?>                      
                    </ul>                                        
                </div>
                
                <div>
                    <div class="sidebar-message">
                        <a href="#">
                            <div class="pull-left text-center">
                            <img alt="image" class="img-circle message-avatar" src="styles/img/no_avatar.png">
                                <div class="m-t-xs">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                There are many variations of passages of Lorem Ipsum available.
                                <br>
                                <small class="text-muted">Today 4:21 pm</small>
                            </div>
                        </a>
                    </div>                            
                </div>
            </div>
            

            

                    <div id="tab-config" class="tab-pane">

                        <div class="sidebar-title">
                            <h3><i class="fa fa-gears"></i> Settings</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <div class="setings-item">
                    <span>
                        Show notifications
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                                    <label class="onoffswitch-label" for="example">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Disable Chat
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
                                    <label class="onoffswitch-label" for="example2">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Enable history
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                                    <label class="onoffswitch-label" for="example3">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Show charts
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                                    <label class="onoffswitch-label" for="example4">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Offline users
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                                    <label class="onoffswitch-label" for="example5">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Global search
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                                    <label class="onoffswitch-label" for="example6">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Update everyday
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                                    <label class="onoffswitch-label" for="example7">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-content">
                            <h4>Settings</h4>
                            <div class="small">
                                I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                            </div>
                        </div>

                    </div>
                </div>

            </div>     
</div>
<!--<script src="styles/js/node_script.js"></script>-->