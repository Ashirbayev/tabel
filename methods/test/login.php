<?php
    $userList = array();
    $region = '';
    if(isset($_GET['region'])){
	   $userList = LdapList($_GET['region']);
       $region = $_GET['region'];     
    }else{
        $userList = LdapList('');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Тестирование сотрудников</title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta charset="utf-8"/>
<link rel="stylesheet" href="styles/css/bootstrap.css"/>
<link rel="stylesheet" href="styles/css/bootstrap.min.css"/>
<link rel="stylesheet" href="styles/css/font-awesome.min.css"/>
<link rel="stylesheet" href="styles/css/css.css"/>
<script src="styles/js/jquery-1.10.2.min.js"></script>
</head>
<body>    
<div class="container">
    
    <div class="row">
        <div class="col-lg-12">        
            <center>
            <h1 id="containers">Авторизация</h1>
            <p class="small">Для сдачи тестов необходимо авторизоваться</p>
            </center>
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
            
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Личные данные</h3>
                    </div>
                    <div class="panel-body">                        
                        <form method="POST" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Регион</label>
                                <div class="col-lg-10">
                                    <select id="region" class="form-control">                                        
                                        <option value="">Головной офис</option>
                                        <option value="AST" <?php if($region == 'AST'){ echo 'selected';} ?>>Астанинский</option>
                                        <option value="Almaty" <?php if($region == 'Almaty'){ echo 'selected';} ?>>Алматинский</option>
                                        <option value="Akmola" <?php if($region == 'Akmola'){ echo 'selected';} ?>>Акмолинский</option>
                                        <option value="Aktobe" <?php if($region == 'Aktobe'){ echo 'selected';} ?>>Актюбенский</option>                                                                                                                        
                                        <option value="Atyrau" <?php if($region == 'Atyrau'){ echo 'selected';} ?>>Атырауский</option>
                                        <option value="Karaganda" <?php if($region == 'Karaganda'){ echo 'selected';} ?>>Карагандинский</option>
                                        <option value="Kostanai" <?php if($region == 'Kostanai'){ echo 'selected';} ?>>Костанайский</option>
                                        <option value="Kyzylorda" <?php if($region == 'Kyzylorda'){ echo 'selected';} ?>>Кызылардинский</option>
                                        <option value="Mangistau" <?php if($region == 'Mangistau'){ echo 'selected';} ?>>Мангистауский</option>
                                        <option value="Pavlodar" <?php if($region == 'Pavlodar'){ echo 'selected';} ?>>Павлодарский</option>
                                        <option value="SKO" <?php if($region == 'SKO'){ echo 'selected';} ?>>Северо-Казахстанский</option>
                                        <option value="UKO" <?php if($region == 'UKO'){ echo 'selected';} ?>>Южно-Казахстанский</option>
                                        <option value="VKO" <?php if($region == 'VKO'){ echo 'selected';} ?>>Восточно-Казахстанский</option>
                                        <option value="Zhambyl" <?php if($region == 'Zhambyl'){ echo 'selected';} ?>>Жамбыльский</option>
                                        <option value="ZKO" <?php if($region == 'ZKO'){ echo 'selected';} ?>>Западно-Казахстанский</option>                                                                                
                                    </select>                                
                                </div>
                            </div>
                                        
                            <div class="form-group">
                                <label class="col-lg-2 control-label">ФИО</label>
                                <div class="col-lg-10">
                                    <select name="login_user" class="form-control">
                                    <?php 
                                        if(count($userList) > 0){
                                        foreach($userList as $k=>$v){
                                        if(isset($v['login'])){
                                                echo '<option value="'.$v['login'].'">'.$v['fio'].'</option>';
                                            }    
                                        } 
                                        }
                                    ?>
                                    </select>                                    
                                </div>
                            </div>                
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Пароль</label>
                                <div class="col-lg-10">
                                    <input type="password" name="login_pass" class="form-control">
                                </div>
                            </div>  
                            <div class="form-group">                                
                                <div class="col-lg-12" style="text-align: center;">
                                    <input type="submit" name="start" class="btn btn-success" value="Начать тестирование">
                                </div>
                            </div>                                                      
                        </form>
                    </div>
                    <div class="panel-footer">
                        <p class="small">Ваш персональный пароль при входе в Windows</p>                    
                    </div>
                </div>
                            
            </div>
        </div>
                
    </div>    
    <?php 
            if($msg !== ''){
        ?>
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Ошибка!</h4>
            <p><?php echo $msg; ?></p>
        </div>
    <?php
            }
    ?>
        
    
    <footer style="position: absolute; bottom: 0px; width: 98%; left: 0px; text-align: center;">
        <p class="small">Данное приложение разработано АО "КСЖ "ГАК" <b>Государственная аннуитетная "Компания по страхованию жизни"</b></p>            
    </footer>

</div>                    
    <script src="styles/js/bootstrap.min.js"></script>
    <script>
        $('#region').change(function(){
            var id = $(this).val();
            if(id !== ''){
                window.location.href = "index.php?region="+id;
            }else{
                window.location.href = "index.php";
            }                        
        });
    </script>
</body>
</html>