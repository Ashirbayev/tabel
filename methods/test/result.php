<?php 
    if(isset($_GET['id_user'])){
        $id_user = $_GET['id_user'];     
    }else{
        $id_user = $_SESSION[USER_SESSION]['id_ses'];
    }
    
    $q = Query("select * from users_test where id = $id_user");
    if(isset($_SESSION[USER_SESSION])){
    if($q['closed_test'] == 0){
        Execute("update users_test set closed_test = 1 where id = $id_user");
    }
    }
    $kolvo_all = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
    WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user");
    
    $kolvo_otvet = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
    WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet IS not null");
    
    $kolvo_not_otvet = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
    WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet IS null");
    
    $kolvo_prav_otv = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
    WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet = q.answer");
    
    $kolvo_not_prav_otv = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
    WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet <> q.answer");
    
    $procent = round(($kolvo_prav_otv['c'] / $kolvo_all['c']) * 100);
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
    <div class="col-lg-12">  
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Данные пользователя</h3>
            </div>
            <div class="panel-body">
                <table border=0 width="100%">
                    <tr>
                        <td><label>№ Сессии</label></td>
                        <td><?php echo $q['id'];?></td>
                    </tr>
                    
                    <tr>
                        <td><label>ФИО</label></td>
                        <td><?php echo $q['fio']; ?></td>
                    </tr>
                    <tr>
                        <td><label>Должность</label></td>
                        <td><?php echo $q['dolgnost']; ?></td>
                    </tr>                      
                    <tr>
                        <td><label>Регион</label></td>
                        <td><?php echo $q['region']; ?></td>
                    </tr>                                                                              
                </table>
            </div>
        </div>                   
    </div>
    
    <div class="col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Результат тестирования</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item"><span class="badge"><?php echo $kolvo_all['c']; ?></span>Количество вопросов</li>                    
                    <li class="list-group-item"><span class="badge"><?php echo $kolvo_otvet['c']; ?></span>Отвеченных</li>
                    <li class="list-group-item"><span class="badge"><?php echo $kolvo_not_otvet['c']; ?></span>Не отвеченных</li>
                    <li class="list-group-item"><span class="badge"><?php echo $kolvo_prav_otv['c']; ?></span>Правильные ответы</li>
                    <li class="list-group-item"><span class="badge"><?php echo $kolvo_not_prav_otv['c']; ?></span>Не правильные ответы</li>
                    <li class="list-group-item"><span class="badge"><?php echo $procent; ?>%</span>Процент</li>                    
                </ul>
                <?php 
                    if(isset($_SESSION[USER_SESSION])){
                ?>
                    <a href="index.php?exit" class="btn btn-danger btn-block">Завершить тестирование</a>
                <?php }else{ ?>
                    <a href="otchet.php" class="btn btn-success btn-block">Назад</a>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Отчет</h3>
            </div>
            <div class="panel-body">                
                <?php 
                    $list = query_array("SELECT rq.num_pp, dtq.naimen, q.*, rq.otvet  
                        FROM result_question rq, questions q, dir_type_quest dtq 
                        WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user ORDER BY rq.num_pp");
                    foreach($list as $k=>$v){
                        $icon = '<i class="fa fa-flag" style="color: green;"></i>';
                        if($v['answer'] !== $v['otvet']){
                            $icon = '<i class="fa fa-warning" style="color: red;"></i>';
                        }
                ?>
                
                <blockquote>
                    <p><?php echo $icon; ?> Вопрос № <?php echo $v['num_pp']; ?> <br/><?php echo $v['text_answer']; ?></p>
                    <small>Ваш ответ <cite title="Source Title"><label for="inputLarge"><?php $uid_otv = $v['otvet']; echo $v['q'.$uid_otv]; ?></label></cite></small>
                    <small>Правильный ответ <cite title="Source Title"><label for="inputLarge"><?php $uid_prv = $v['answer']; echo $v['q'.$uid_prv]; ?></label></cite></small>
                </blockquote>                
                <?php        
                    }
                ?>                
            </div>
        </div>
    </div>
    <footer class="col-lg-12" style="position: relative; bottom: 0px; width: 98%; left: 0px; text-align: center;">
        <p class="small">Данное приложение разработано АО "КСЖ "ГАК" <b>Государственная аннуитетная "Компания по страхованию жизни"</b></p>            
    </footer>
</div>    
    <script src="styles/js/bootstrap.min.js"></script>    
</body>
</html>        