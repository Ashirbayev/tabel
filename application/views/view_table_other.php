<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <div class="ibox-tools">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group date ">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input value="<?php echo $timesheet_date_start_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_start" data-mask="99.99.9999" id="timesheet_date_start" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group date ">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input value="<?php echo $timesheet_date_end_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_end" data-mask="99.99.9999" id="timesheet_date_end" required=""/>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-10">
                                <dl class="dl-horizontal">
                                    <dt>Департамент:</dt>
                                <dd>
                                <select onchange="set_null();" name="dep_id_for_table" id="dep_id_for_table" class="select2_demo_1 form-control">
                                <option></option>
                                    <?php
                                        foreach($listDepartments as $u => $i)
                                        {
                                    ?>
                                <option <?php if(trim($i['ID']) == "$dep_id_for_table") {echo "selected";} ?> value="<?php echo trim($i['ID']); ?>"><?php echo $i['NAME']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                </dd>
                                </dl>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Показать</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive" id="table_with_data">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table_head" style="vertical-align: bottom !important;">
                                    <th style="vertical-align: bottom;">ФИО</th>
                                    <th style="vertical-align: bottom;">Должность</th>
                                    <?php
                                    foreach ($list_guy as $b => $d) {
                                        if (is_array($d)) {
                                            echo '<th style="vertical-align: bottom;">'.$d['WEEK_DAY'].'</th>';
                                        }
                                    }
                                    ?>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Дней</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Сутки</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Кол-во часов</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Очередой отпуск</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Отп в связи с родами</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Болезнь</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Без уважительной причины</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Разрешение админинистрации</span></th>
                                    <th class="vertical_header_th" style="text-rotate: 90; vertical-align: bottom;"><span class="vertical_text">Командировка</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($list_guys as $k => $v)
                                {
                                    $sql_timesheet_test = "select * from TABLE_OTHER where EMP_ID = ".$v['ID']." and DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' order by DAY_DATE";
                                    $list_timesheet_test = $db -> Select($sql_timesheet_test);
                                    
                                    $hours = 0;
                                    $days = 0;
                                    $eighteen = 0;
                                    $holi = 0;                                    
                                    $hosp = 0;
                                    $absent = 0;
                                    $holi_without = 0;
                                    $trip = 0;
                                    $with_approve = 0;
                                    $name = $v['FIRSTNAME'];
                                    $name_first_simb = mb_substr($name,0,1,"UTF-8");
                                    $middlename = $v['MIDDLENAME'];
                                    $middlename_first_simb = mb_substr($middlename,0,1,"UTF-8");

                                    echo '<tr class="gradeX">';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$v['LASTNAME'].'. '.$name_first_simb.'. '.$middlename_first_simb.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$v['D_NAME'].'</td>';
                                    foreach($list_timesheet_test as $x => $z)
                                    {
                                            if
                                            ($z['VALUE'] == 'А'){$holi_without = $holi_without+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689; background-color:#dff0d8'";}else if
                                            ($z['VALUE'] == 'О'){$holi = $holi+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689; background-color:#fcf8e3'";}else if
                                            ($z['VALUE'] == 'Б'){$hosp = $hosp+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689; background-color:#d9edf7'";}else if
                                            ($z['VALUE'] == 'П'){$absent = $absent+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689; background-color:#bce8f1'";}else if
                                            ($z['VALUE'] == 'С'){$hours = $hours+18; $eighteen = $eighteen+1;$color = " style='color: white; cursor: pointer; border: 1px solid white; background-color:#23c6c8'";}else if
                                            ($z['VALUE'] == 'Р'){$with_approve = $with_approve+1; $color = " style='color: white; cursor: pointer; border: 1px solid white; background-color:#23c6c8'";}else if
                                            ($z['VALUE'] == 'К'){$trip = $trip+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689; background-color:#d1dade'";}else if
                                            ($z['VALUE'] == ' '){$color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689; background-color:#2f4050'";}else if
                                            ($z['VALUE'] == '4'){$hours = $hours+4; $days = $days+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689'";}else if
                                            ($z['VALUE'] == '5'){$hours = $hours+5; $days = $days+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689'";}else if
                                            ($z['VALUE'] == '12'){$hours = $hours+12; $days = $days+1; $color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689'";}else if
                                            ($z['VALUE'] == 'В'){$color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689; background-color:#9cdacd'";}else
                                            {$hours = $hours+8; $days = $days+1;$color = " style='color: #18a689; cursor: pointer; border: 1px solid #18a689'";}
                                            echo '<td class="td_table" data-toggle="modal" data-target="#edit_table" onclick="set_id('.$z['ID'].');"'.$color.'>'.$z['VALUE'].'</td>';
                                    }
                                    echo '<td style="border: 1px solid #8E8DA2">'.$days.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$eighteen.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$hours.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$holi.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$holi_without.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$hosp.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$absent.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$with_approve.'</td>';
                                    echo '<td style="border: 1px solid #8E8DA2">'.$trip.'</td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <style>
                    .table_head
                    {
                        height: 200px;
                    }

                    .vertical_header_th
                    {
                        border-top: 0;
                        padding: 3px 0;
                        height: 100px;
                        font-size: 22px;
                        font-size: 1.22222rem;
                    }

                    th
                    {
                        vertical-align: bottom !important;
                    }

                    .vertical_text
                    {
                        display: inline-block;
                        width: 20px;
                        height: 20px;
                        transform: rotate(-90deg);
                        font-size: 20px;
                        font-size: 1.11111rem;
                        white-space: nowrap;
                    }
                </style>
            <form target="_blank" id="table_form" method="post" action="print_timesheet">
                <input name="dep_id" value="<?php //echo $dep_id; ?>" style="display: none;"/>
                <div hidden="" id="head_of_doc">
                <div style="text-align: right;">
                Утверждаю<br />
                АО "KazImpex"<br /><br /><br />
                <div id="chef_name"></div><br />
                <div style="text-align: center;"><strong><h3>ТАБЕЛЬ УЧЕТА РАБОЧЕГО ВРЕМЕНИ С <?php echo $timesheet_date_start_orig; ?> ПО <?php echo $timesheet_date_end_orig; ?></h3></strong></div>
                <div style="text-align: center;"><strong><h3><?php echo $dep_name; ?></h3></strong></div>
                <hr/>
                </div>
                </div>
                <div hidden="" id="foot_of_doc">
                <hr/><br /><br /><br /><br />
                    Специалист по управлению персоналом
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    А. О. Садыкова
                </div>
                
                <textarea hidden="" name="content" id="area_for_print">
                    
                </textarea>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <a data-toggle="modal" data-target="#choose_chef" class="btn btn-primary pull-right"><i class="fa fa-check-square-o"></i> Утвердить и отправить на печать</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-lg-12 fadeInRight">
        <div class="mail-box-header">
            <h2>
                Добавить опреденное значение всем
            </h2>
        </div>
        <div class="mail-box">
            <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                <div class="mail-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Значение</label>
                        <div class="col-sm-10">
                            <select onchange="" name="holyday_val" id="holyday_val" class="select2_demo_1 form-control pos_btn">
                                <option></option>
                                <option value="8">8 часовой день</option>
                                <option value="4">4 часовой день</option>
                                <option value="5">5 часовой день</option>
                                <option value="12">12 часовой день</option>
                                <option value="О">В отпуске</option>
                                <option value="А">В декретном отпуске</option>
                                <option value="А">Отпуск без сохранения</option>
                                <option value="Б">На больничном</option>
                                <option value="У">Уволен</option>
                                <option value="Б">Больничный в связи с беременностью и родами</option>
                                <option value="П">Прогул</option>
                                <option value="В">Выходной</option>
                                <option value=" ">Пусто</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Заменяемое значение</label>
                        <div class="col-sm-10">
                            <select onchange="" name="change_val" id="change_val" class="select2_demo_1 form-control pos_btn">
                                <option></option>
                                <option value="8">8 часовой день</option>
                                <option value="4">4 часовой день</option>
                                <option value="5">5 часовой день</option>
                                <option value="12">12 часовой день</option>
                                <option value="О">В отпуске</option>
                                <option value="А">В декретном отпуске</option>
                                <option value="А">Отпуск без сохранения</option>
                                <option value="Б">На больничном</option>
                                <option value="У">Уволен</option>
                                <option value="Б">Больничный в связи с беременностью и родами</option>
                                <option value="П">Прогул</option>
                                <option value="В">Выходной</option>
                                <option value=" ">Пусто</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата выходного</label>
                        <div class="col-sm-10">
                            <div class="input-group date ">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="holyday_date" data-mask="99.99.9999" id="holyday_date" required=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mail-body">
                    <button type="submit" onclick=""  class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Добавить"> Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 fadeInRight">
        <div class="mail-box-header">
            
            <h2>
                Создать табель на определенного человека
            </h2>
        </div>
            <div class="mail-box">
                <div class="mail-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Сотрудник:</label>
                            <div class="col-sm-10">
                                <select name="CREATE_TABLE_FOR_ONE_PERS_ID" data-placeholder="" class="chosen-select col-lg-12" multiple tabindex="4" required="">
                                    <option></option>
                                    <?php
                                        foreach($list_persons as $k => $v)
                                        {
                                    ?>
                                        <option value="<?php echo $v['ID']; ?>"><?php echo $v['LASTNAME'].' '.$v['FIRSTNAME'].' '.$v['MIDDLENAME']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Дата начала работы</label>
                            <div class="col-sm-10">
                                <div class="input-group date ">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control dateOform" name="work_start_day" data-mask="99.99.9999" id="work_start_day" required/>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="mail-body">
                    <button type="submit" onclick=""  class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Добавить"> Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 fadeInRight">
        <div class="mail-box-header">
            <h2>
                Добавить значение между двумя датами
            </h2>
        </div>
            <div class="mail-box">
                <div class="mail-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                    <div hidden="" class="col-md-2">
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_start_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_start" data-mask="99.99.9999" id="timesheet_date_start" required/>
                        </div>
                    </div>
                    <div hidden="" class="col-md-2"> 
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_end_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_end" data-mask="99.99.9999" id="timesheet_date_end" required/>
                        </div>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $dep_id_for_table; ?>" type="text" class="form-control dateOform" name="dep_id_for_table_up" id="dep_id_for_table_up"/>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $branch_id; ?>" type="text" class="form-control dateOform" name="branch_id_up" id="branch_id_up"/>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Сотрудник:</label>
                        <div class="col-sm-10">
                            <select name="UPDATE_TABLE_FOR_ONE_PERS_ID" data-placeholder="" class="chosen-select col-lg-12" multiple tabindex="4" required="">
                                <option></option>
                                <?php
                                    foreach($list_persons as $k => $v)
                                    {
                                ?>
                                    <option value="<?php echo $v['ID']; ?>"><?php echo $v['LASTNAME'].' '.$v['FIRSTNAME'].' '.$v['MIDDLENAME']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Значение</label>
                        <div class="col-sm-10">
                            <select name="val_between" id="val_between" class="select2_demo_1 form-control pos_btn">
                                <option></option>
                                <option value="8">8 часовой день</option>
                                <option value="4">4 часовой день</option>
                                <option value="5">5 часовой день</option>
                                <option value="12">12 часовой день</option>
                                <option value="О">В отпуске</option>
                                <option value="А">В декретном отпуске</option>
                                <option value="А">Отпуск без сохранения</option>
                                <option value="Б">На больничном</option>
                                <option value="У">Уволен</option>
                                <option value="Б">Больничный в связи с беременностью и родами</option>
                                <option value="П">Прогул</option>
                                <option value="В">Выходной</option>
                                <option value=" ">Пусто</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата начала значения</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="val_start_day" data-mask="99.99.9999" id="work_start_day" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата конца значения</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="val_end_day" data-mask="99.99.9999" id="work_start_day" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Проставить выходные</label>
                        <div class="col-sm-10">
                            <div class="i-checks"><input name="holi_set" type="checkbox" value="1"/></div>
                        </div>
                    </div>
                </div>
                <div class="mail-body">
                    <button type="submit" onclick=""  class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Добавить"> Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 fadeInRight">
        <div class="mail-box-header">
            <h2>
                Добавить график 2 на 2
            </h2>
        </div>
            <div class="mail-box">
                <div class="mail-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                    <div hidden="" class="col-md-2">
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_start_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_start" data-mask="99.99.9999" id="timesheet_date_start" required/>
                        </div>
                    </div>
                    <div hidden="" class="col-md-2"> 
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_end_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_end" data-mask="99.99.9999" id="timesheet_date_end" required/>
                        </div>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $dep_id_for_table; ?>" type="text" class="form-control dateOform" name="dep_id_for_table_up" id="dep_id_for_table_up"/>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $branch_id; ?>" type="text" class="form-control dateOform" name="branch_id_up" id="branch_id_up"/>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Сотрудник:</label>
                        <div class="col-sm-10">
                            <select name="UPDATE_TABLE_FOR_ORIGIN_GRAPH" data-placeholder="" class="chosen-select col-lg-12" multiple tabindex="4" required="">
                                <option></option>
                                <?php
                                    foreach($list_persons as $k => $v)
                                    {
                                ?>
                                    <option value="<?php echo $v['ID']; ?>"><?php echo $v['LASTNAME'].' '.$v['FIRSTNAME'].' '.$v['MIDDLENAME']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата начала значения</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="val_start_day" data-mask="99.99.9999" id="work_start_day" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата конца значения</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="val_end_day" data-mask="99.99.9999" id="work_start_day" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Проставить выходные</label>
                        <div class="col-sm-10">
                            <div class="i-checks"><input name="holi_set" type="checkbox" value="1"/></div>
                        </div>
                    </div>
                </div>
                <div class="mail-body">
                    <button type="submit" onclick=""  class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Добавить"> Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 fadeInRight">
        <div class="mail-box-header">
            <h2>
                Добавить график день/ночь
            </h2>
        </div>
            <div class="mail-box">
                <div class="mail-body">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                    <div hidden="" class="col-md-2">
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_start_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_start" data-mask="99.99.9999" id="timesheet_date_start" required/>
                        </div>
                    </div>
                    <div hidden="" class="col-md-2"> 
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_end_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_end" data-mask="99.99.9999" id="timesheet_date_end" required/>
                        </div>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $dep_id_for_table; ?>" type="text" class="form-control dateOform" name="dep_id_for_table_up" id="dep_id_for_table_up"/>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $branch_id; ?>" type="text" class="form-control dateOform" name="branch_id_up" id="branch_id_up"/>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Сотрудник:</label>
                        <div class="col-sm-10">
                            <select name="UPDATE_TABLE_FOR_DAY_NIGHT" data-placeholder="" class="chosen-select col-lg-12" multiple tabindex="4" required="">
                                <option></option>
                                <?php
                                    foreach($list_persons as $k => $v)
                                    {
                                ?>
                                    <option value="<?php echo $v['ID']; ?>"><?php echo $v['LASTNAME'].' '.$v['FIRSTNAME'].' '.$v['MIDDLENAME']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата начала значения</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="val_start_day" data-mask="99.99.9999" id="work_start_day" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата конца значения</label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="val_end_day" data-mask="99.99.9999" id="work_start_day" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Проставить выходные</label>
                        <div class="col-sm-10">
                            <div class="i-checks"><input name="holi_set" type="checkbox" value="1"/></div>
                        </div>
                    </div>
                </div>
                <div class="mail-body">
                    <button type="submit" onclick=""  class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Добавить"> Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="edit_table" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Редактирование табеля</h4>
                <small class="font-bold">выберите статус из выпадающего списка</small>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div hidden="" class="col-md-2">
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_start_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_start" data-mask="99.99.9999" id="timesheet_date_start" required/>
                        </div>
                    </div>
                    <div hidden="" class="col-md-2"> 
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $timesheet_date_end_orig; ?>" type="text" class="form-control dateOform" name="timesheet_date_end" data-mask="99.99.9999" id="timesheet_date_end" required/>
                        </div>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $dep_id_for_table; ?>" type="text" class="form-control dateOform" name="dep_id_for_table_up" id="dep_id_for_table_up"/>
                    </div>
                    <div class="input-group" style="display: none;">
                        <input value="<?php echo $branch_id; ?>" type="text" class="form-control dateOform" name="branch_id_up" id="branch_id_up"/>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID table</label>
                        <input name="id_table" type="text" placeholder="" class="form-control" id="id_table" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <select onchange="" name="table_state" id="table_state" class="select2_demo_1 form-control pos_btn">
                            <option value="8">8 часовой день</option>
                            <option value="4">4 часовой день</option>
                            <option value="5">5 часовой день</option>
                            <option value="12">12 часовой день</option>
                            <option value="О">В отпуске</option>
                            <option value="А">В декретном отпуске</option>
                            <option value="А">Отпуск без сохранения</option>
                            <option value="Б">На больничном</option>
                            <option value="У">Уволен</option>
                            <option value="Б">Больничный в связи с беременностью и родами</option>
                            <option value="П">Прогул</option>
                            <option value="В">Выходной</option>
                            <option value="С">Сутки</option>
                            <option value=" ">Пусто</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="choose_chef" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Выбор соглающего</h4>
                <small class="font-bold">выберите соглающего из выпадающего списка</small>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group" id="data_1">
                        <select name="chef_fot_table" id="chef_fot_table" class="select2_demo_1 form-control">
                            <option value="Е. Хасенов">Е. Хасенов</option>
                            <option value="Е. Хасенов2">Е. Хасенов2</option>
                            <option value="Е. Хасенов3">Е. Хасенов3</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="submit_and_print" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                    <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function set_id(id)
    {
        $('#id_table').val(id);
    }

    $('.td_table').mouseover(function()
    {
        $(this).css('box-shadow', '0 5px 7px rgba(0, 0, 0, 0.60) inset');
    });

    $('.td_table').mouseout(function() 
    {
        $(this).css('border-color', '#18a689');
        $(this).css('box-shadow', 'none');
    });

    $('#submit_and_print').click(function() 
    {
        var chef_fot_table = $('#chef_fot_table').val();
        $('#chef_name').html(chef_fot_table+'_______________');
        var head_of_doc = $('#head_of_doc').html();
        var foot_of_doc = $('#foot_of_doc').html();
        
        var table_with_data = $('#table_with_data').html();
        $('#area_for_print').html(head_of_doc+table_with_data+foot_of_doc);
        $('#table_form').submit();
    })
</script>

