<?php
    echo '<h1>Права на создание табеля ограничены, обращайтесь в администрацию</h1>';
?>
<div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="ibox-tools">
                <div class="row m-b-sm m-t-sm">
                <form method="POST">
                    <div class="col-md-3">
                        <dl class="dl-horizontal">
                            <dt>Год:</dt>
                        <dd>
                        <select name="search_YEAR" id="search_YEAR" class="select2_demo_1 form-control" required/>
                        <?php
                            $YEAR = trim($create_year);
                        ?>
                            <option></option>
                            <option <?php if($YEAR == '2014'){echo 'selected';}?>>2014</option>
                            <option <?php if($YEAR == '2015'){echo 'selected';}?>>2015</option>
                            <option <?php if($YEAR == '2016'){echo 'selected';}?>>2016</option>
                            <option <?php if($YEAR == '2017'){echo 'selected';}?>>2017</option>
                            <option <?php if($YEAR == '2018'){echo 'selected';}?>>2018</option>
                            <option <?php if($YEAR == '2019'){echo 'selected';}?>>2019</option>
                            <option <?php if($YEAR == '2020'){echo 'selected';}?>>2020</option>
                            <option <?php if($YEAR == '2021'){echo 'selected';}?>>2021</option>
                            <option <?php if($YEAR == '2023'){echo 'selected';}?>>2023</option>
                        </select>
                        </dd>
                        </dl>
                    </div>
                    <div class="col-md-3"> 
                        <dl class="dl-horizontal">
                            <dt>Месяц:</dt> 
                        <dd>
                        <select name="search_month" id="search_month" class="select2_demo_1 form-control" required/>
                            <option></option>
                        <?php
                            $month = trim($_POST['search_month']);
                            foreach($listMonth as $k => $v)
                            {
                        ?>
                            <option <?php if(trim($v['ID']) == "$month") {echo "selected";} ?> value="<?php echo $v['ID'] ?>"><?php echo $v['NAME']; ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        </dd>
                        </dl>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                    <?php
                        if(isset($_POST['search_YEAR']))
                        {
                            if(isset($_POST['search_month']))
                            {
                                $create_year = $_POST['search_YEAR'];
                                $create_month = $_POST['search_month'];
                                $create_date = $create_year.'-'.$create_month.'-';
                                ?>
                                    <a onclick="" class="btn-white btn btn-xs" data-toggle="modal" data-target="#addEmp">Задать параметры за <?php echo $create_month.'.'.$create_year; ?> года</a>
                                <?php
                            }
                        }
                        $i = 0;
                        foreach($list_pers as $k => $v)
                        {
                            echo $v['ID'].'/'.$v['STATE'].'<br>';
                            echo $i.'<br>';
                            create_other_table($create_date, $v['ID']);
                            $i++;
                        }
                        weekend($create_date);
                    ?>
                </div>
                </form>
            </div>
        </div>
    <div class="ibox-content">
            
    </div>              
</div>


<?php
    function create_other_table($date_my, $emp_id)
    {
        echo $date_my.$emp_id;
        $db = new My_sql_db();
        $sql_pers = "select id, state from EMPLOYEES where state = 2 or state = 3 or state = 4 or state = 5 or state = 6 or state = 9 order by state";
        $list_pers = $db -> Select($sql_pers);
        for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++)
        {
            //$db = new DB();
            $weekend = date("w",strtotime($date_my.$i));
            echo '$weekend '.$weekend;
            if($weekend==0 || $weekend==6)
            {
                echo 'weekend';
                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ('', '$i', 'В', '$emp_id', '$date_my$i', 1)";
                $db -> Execute($sql);
                echo "$date_my$i".'B<br>';
            } 
                else 
            {
                echo 'budni';
                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ('', '$i', '8', '$emp_id', '$date_my$i', 1)";
                $db->Execute($sql);
                echo "$date_my$i".'8<br>';
            }
        }
    }    
?>

<script>
    function calc_day()
    {
        var i = 0;
        var z = 0;
        $('.state_sel option:selected').each
        (
            function()
            {
                var state = $(this).val();
                if($.isNumeric(state))
                {
                    var state_num = parseInt(state);
                    i += state_num;
                    z++;
                }
            }
        );
        $('#DAY_COUNT').val(z);
        $('#TIME_COUNT').val(i);
    }

    $(document).ready(
        function(){
            calc_day();
        }
    )
</script>

