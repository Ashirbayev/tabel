<?php 
    header("Content-Type: text/html; charset=utf-8");
    error_reporting(0);
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
<div class="col-lg-12"><h3>Отчет</h3></div>
<?php	    
	define('MYSQL_USER', 'root');
    define('MYSQL_PASS', '');
    define('MYSQL_DATABASE', 'testes');
    define('MYSQL_HOST', 'localhost');
    
    $itable_db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
    if (!$itable_db) 
    {
        echo "Ошибка подключения к серверу MySQL";
        exit;
    }  
    mysql_set_charset("utf8");
    mysql_select_db(MYSQL_DATABASE); 
    
    function Query($sql)
    {        
        $query = mysql_query($sql);
        if(!$query)exit(mysql_error());
           
        $row = mysql_fetch_array($query, MYSQL_ASSOC);
        return $row;                
    }    
    
    function query_array($sql)
    {
        $q = mysql_query($sql);
        if(!$q)exit(mysql_error());
        
        $a = array();
        $i = 0;
        while($row = mysql_fetch_array($q, MYSQL_ASSOC))
        {
            foreach($row as $r=>$v)
            {
                $a[$i][$r] = $v;   
            }            
            $i++;              
        }
        return $a;
    }
    
    if(isset($_GET['id_user'])){
        require_once 'result.php';
    }else{
        $dan = array();
        $q = query_array("select * from users_test");
        foreach($q as $key=>$v){
            $ds = array();
            $ds['id'] = $v['id'];
            $ds['fio'] = $v['fio'];
            $ds['date_test'] = $v['date_test'];
            $ds['region'] = $v['region'];
            $ds['dolgnost'] - $v['dolgnost'];
            $id_user = $v['id'];
            
            $kolvo_all = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
                WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user");
    
            $kolvo_prav_otv = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
                WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet = q.answer");
    
            $kolvo_not_prav_otv = Query("SELECT COUNT(*) c FROM result_question rq, questions q, dir_type_quest dtq 
                WHERE dtq.id = q.id_type AND q.id = rq.id_test AND rq.id_user = $id_user AND rq.otvet <> q.answer");
    
            $procent = round(($kolvo_prav_otv['c'] / $kolvo_all['c']) * 100);
    
            $ds['prav'] = $kolvo_prav_otv['c']; 
            $ds['neprav'] = $kolvo_not_prav_otv['c'];
            $ds['proc'] = $procent;                        
            $dan[] = $ds;
        }
?>
<table class="table table-hover">
    <tr>
        <th>Фамилия Имя</th>
        <th>Дата</th>
        <th><center>Кол-во правильных</center></th>
        <th><center>Кол-во неправильных</center></th>
        <th><center>% (процент)</center></th>
    </tr>
<?php 
    foreach($dan as $k=>$v){
        echo '<tr onclick="window.location.href= '."'otchet.php?id_user=".$v['id']."'".'" style="cursor: pointer;">
        <td>'.$v['fio'].'</td>
        <td>'.$v['date_test'].'</td>        
        <td><center>'.$v['prav'].'</center></td>
        <td><center>'.$v['neprav'].'</center></td>
        <td><center>'.$v['proc'].'</center></td>
    </tr>';
    }
?>        
</table>
<?php        
    }
?>
</div>                    
    <script src="styles/js/bootstrap.min.js"></script>
</body>
</html>    