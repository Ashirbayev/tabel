<?php         
    if(empty($_SESSION[USER_SESSION])){header("Location: index.php");}
    
        
    if(isset($_GET['id'])){
        $vopros_num = $_GET['id'];
    }else{
        $vopros_num = 1;
    }
    $id_user = $_SESSION[USER_SESSION]['id_ses'];
    
    if($vopros_num == 0){
        header("Location: index.php?id=1");
    }
    /*
    if($vopros_num == 0){
        require_once "result.php";
        exit;
    }
    */
    //Количество отвеченных вопросов
    $otv = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
    WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet IS NOT NULL"); 
    $otvet_kolvo = $otv['c'];
        
    //Номер следующего вопроса
    $sql = "select ifnull(min(num_pp), 0) num_pp from result_question where id_user = $id_user and num_pp > $vopros_num and otvet is null";
    if($vopros_num >= 30){
        $sql = "select ifnull(min(num_pp), 0) num_pp from result_question where id_user = $id_user and otvet is null";
    }
    
    $ns = Query($sql);
    $next_vopros = $ns['num_pp'];    
                       
        
    if($vopros_num > 30){
        $v = Query("select min(propusk) propusk from result_question where id_user = $id_user and propusk = 1");
    }
    
    
     
    //Пропуск
    if(isset($_POST['next'])){
        if(isset($_POST['q'])){
            $id_test = $_POST['id_test'];
            $otvet = $_POST['q'];
            $sql = "update result_question Set otvet = $otvet, propusk = 0 where id_user = $id_user and id_test = $id_test";
            if(!Execute($sql)){
                echo 'Ошибка на Сервере';
            }
        }else{    
            $id_test = $_POST['id_test'];        
            Execute("update result_question set propusk = 1 where id_user = $id_user and id_test = $id_test");
        }
    }
               
    // Количество не отвеченых
    $not_otv = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
    WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet IS NULL");
    $not_otvet_kolvo = $not_otv['c'];    
    
    $sql = "SELECT q.id, q.text_answer, q.q1, q.q2, q.q3, q.q4, dtq.naimen, rq.num_pp, rq.otvet, q.answer 
            FROM result_question rq, questions q, dir_type_quest dtq 
            WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.num_pp = $vopros_num LIMIT 1";
            
    $q = Query($sql);            
    $otvechen = $q['otvet'];            
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
<link rel="stylesheet" href="styles/css/flipclock.css"/>
<script src="styles/js/jquery.min.js"></script>
</head>
<body>    
<div class="container">
    <div class="col-lg-12">&nbsp;</div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">№ сессии <?php echo $_SESSION[USER_SESSION]['id_ses']; ?></h3>
            </div>
            <div class="panel-body">
                <div class="col-lg-8">
                <table border=0 width="100%">
                    <tr>
                        <td>ФИО</td>
                        <td style="font-size: 25px;"><?php echo $_SESSION[USER_SESSION]['fio']; ?></td>
                    </tr>
                    
                    <tr>
                        <td>Должность</td>
                        <td style="font-size: 25px;"><?php echo $_SESSION[USER_SESSION]['dolgnost']; ?></td>
                    </tr>
                    
                    <tr>
                        <td>Регион</td>
                        <td style="font-size: 25px;"><?php echo $_SESSION[USER_SESSION]['region']; ?></td>
                    </tr>                                        
                </table>
                </div>
                <div class="col-lg-4">
                    <div class="clock"></div>
                </div>
            </div>
        </div>        
    </div>
    <div class="col-lg-3" style="height: 550px;overflow-x: auto;">
        <div class="list-group table-of-contents">
            <?php                             
                for($i = 1;$i< 31;$i++){
                    $qps = Query("select * from result_question where id_user = $id_user and num_pp = $i");
                    $badg = '';
                    if($qps['propusk'] !== '0'){
                        $badg = '<span class="badge" style="color: #DD0A08;"><i class="fa fa-close"></i></span>';
                    }
                    
                    if(strlen($qps['otvet']) > 0){
                        $badg = '<span class="badge"><i class="fa fa-flag"></i></span>';
                    }
                    $activ = '';
                    if($vopros_num == $i){
                        $activ = ' active';
                    }
                    echo '<a href="index.php?id='.$i.'" class="list-group-item '.$activ.'">'.$badg.' Вопрос № '.$i.'</a>'; 
                }
            ?>               
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Вопрос № <?php echo $vopros_num; ?></h3>
            </div>
            <div class="panel-body">
                <label class="label label-info">НПА</label> <?php echo $q['naimen']; ?> 
                <hr />
                <label class="label label-primary">Вопрос</label><br /> <?php echo $q['text_answer']; ?>                               
            </div>
        </div>
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Варианты ответов</h3>
            </div>
            <form method="post" action="index.php?id=<?php echo $next_vopros; ?>" id="submit_otvet">
            <div class="panel-body">
            <?php                                    
                $ch1 = ''; 
                $ch2 = '';
                $ch3 = '';
                $ch4 = '';
                if(trim($otvechen) == '1'){$r1 = 'class="text-success"'; $ch1 = 'checked="checked"';}else{ $r1 = '';}
                if(trim($otvechen) == '2'){$r2 = 'class="text-success"'; $ch2 = 'checked="checked"';}else{ $r2 = '';}
                if(trim($otvechen) == '3'){$r3 = 'class="text-success"'; $ch3 = 'checked="checked"';}else{ $r3 = '';}
                if(trim($otvechen) == '4'){$r4 = 'class="text-success"'; $ch4 = 'checked="checked"';}else{ $r4 = '';}            
            ?>
                <div class="radio">
                    <label <?php echo $r1; ?>>
                    <input type="radio" name="q" value="1" <?php echo $ch1; ?> >
                        <?php echo $q['q1']; ?>
                    </label>
                </div>                
                <br />
                <div class="radio">
                    <label <?php echo $r2; ?>>
                    <input type="radio" name="q" value="2" <?php echo $ch2; ?> >
                        <?php echo $q['q2']; ?>
                    </label>
                </div>                
                <br />
                <div class="radio">
                    <label <?php echo $r3; ?>>
                    <input type="radio" name="q" value="3" <?php echo $ch3; ?> >
                        <?php echo $q['q3']; ?>
                    </label>
                </div>                
                <br />
                <div class="radio">
                    <label <?php echo $r4; ?>>
                    <input type="radio" name="q" value="4" <?php echo $ch4; ?> >
                        <?php echo $q['q4']; ?>
                    </label>                
                </div>                                           
            </div>            
            <br />                        
            <blockquote>            
                <input type="submit" name="next" class="btn btn-sm btn-primary" value="Далее"/>
                <input type="hidden" name="id_test" value="<?php echo $q['id']; ?>"/>                                                               
            </blockquote>                                 
            </form>
        </div>
    </div>        
    
    <div class="col-lg-12" style="text-align: right;">        
        <label class="label label-warning">Количество оставшихся вопросов: <?php echo $not_otvet_kolvo; ?></label>
        <a href="index.php?exit&&result" class="btn btn-danger btn-sm">Завершить тестирование</a>        
    </div>        
</div>                    
    <script src="styles/js/bootstrap.min.js"></script>
    <script src="styles/js/flipclock.js"></script>
    <script>
        var clock;
			
			$(document).ready(function() {
				// Set dates.
                var ds = '<?php
                    $dend = date("Y-m-d H:i:s", strtotime("+40 minutes", strtotime($_SESSION[USER_SESSION]['date_ses']))); 
                    echo $dend; 
                ?>';
				var futureDate  = new Date(ds);
				var currentDate = new Date();

				// Calculate the difference in seconds between the future and current date
				var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

				// Calculate day difference and apply class to .clock for extra digit styling.
				function dayDiff(first, second) {
					return (second-first)/(1000*60*60*24);
				}

				if (dayDiff(currentDate, futureDate) < 100) {
					$('.clock').addClass('twoDayDigits');
				} else {
					$('.clock').addClass('threeDayDigits');
				}

				if(diff < 0) {
					diff = 0;
				}
                
                if(diff == 0){
                    document.location.href = 'index.php?exit&&result';
                }

				// Instantiate a coutdown FlipClock
				clock = $('.clock').FlipClock(diff, {
					clockFace: 'MinuteCounter',
					countdown: true
				});
			});
    </script>        
</body>
</html>