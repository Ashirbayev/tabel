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
                                <label class="col-lg-2 control-label">ФИО</label>
                                <div class="col-lg-10">                                    
                                    <input type="text" name="fio" class="form-control" placeholder="ФИО полностью">
                                </div>
                            </div>                
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Должность</label>
                                <div class="col-lg-10">
                                    <input type="text" name="dolgnost" class="form-control" placeholder="Должность">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Регион</label>
                                <div class="col-lg-10">
                                    <input type="text" name="region" class="form-control" placeholder="Регион">
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
                        <p class="small">Все данные вводятся полностью</p>                    
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
</body>
</html>