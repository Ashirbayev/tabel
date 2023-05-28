<div class="row">
    <div class="col-lg-12" id="osn-panel">
        <div class="ibox-content">
            <table class="table table-striped table-bordered table-hover" id="editable">
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Количество отпускных дней</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($listEmployee as $k=> $v)
                        {
                            $empId = $v['ID'];
                            $sql_holy_period = "select DAY_COUNT_USED_FOR_TODAY, PERIOD_START, PERIOD_END, DIDNT_ADD from PERSON_HOLYDAYS_PERIOD where PERSON_ID = $empId and PERIOD_START < '$today_date' order by id";
                            $list_holy_period = $db -> Select($sql_holy_period);
                            $avail_day_for_today = 30;
                            $used = 0;
                            $didnt_add = 0;
                            foreach($list_holy_period as $z => $x)
                            {
                                if(strtotime($today_date) < strtotime($x['PERIOD_END']))
                                {
                                    $day_from_period_start = floor((strtotime($today_date) - strtotime($x['PERIOD_START']))/ 86400);
                                    $avail_day_for_today = $day_from_period_start/365*30;
                                }
                                $used = $x['DAY_COUNT_USED_FOR_TODAY'];
                                $didnt_add = $x['DIDNT_ADD'];
                                $PERIOD_START = $x['PERIOD_START'];
                                $PERIOD_END = $x['PERIOD_END'];
                                $avail_day = round($avail_day_for_today - $used - $didnt_add);
                                $total_avial_days_count  = $avail_day + $total_avial_days_count;
                                //echo "empId = $empId;  $avail_day_for_today - $didnt_add - $used / $total_avial_days_count / $PERIOD_START - $PERIOD_END </br>";
                            }
                    ?>
                    <tr ondblclick="$(location).attr('href','doc_detail?doc_id=<?php echo $v['ID']; ?>');" class="gradeX view_user_dan" data="<?php ?>" style="cursor: default;">
                        <td>
                            <?php echo $v['FIO'];?>
                        </td>
                        <td>
                            <?php echo $total_avial_days_count;?> дн.
                        </td>
                    </tr>
                    <?php
                        $total_avial_days_count = 0;
                        }
                    ?>
                </tbody>
            </table>
            <br />
            <form id="form_send_html" method="POST" action="just_print" target="_blank">
                <input hidden="" name="holi_id" value="<?php echo $holi_id; ?>"/>
                <textarea hidden="" name="content">
                        <table class="table table-striped table-bordered table-hover" id="editable">
                            <thead>
                                <tr>
                                    <th>ФИО</th>
                                    <th>Количество отпускных дней</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($listEmployee as $k=> $v)
                                    {
                                        $empId = $v['ID'];
                                        $sql_holy_period = "select DAY_COUNT_USED_FOR_TODAY, PERIOD_START, PERIOD_END, DIDNT_ADD from PERSON_HOLYDAYS_PERIOD where PERSON_ID = $empId and PERIOD_START < '$today_date' order by id";
                                        $list_holy_period = $db -> Select($sql_holy_period);
                                        $avail_day_for_today = 30;
                                        $used = 0;
                                        $didnt_add = 0;
                                        foreach($list_holy_period as $z => $x)
                                        {
                                            if(strtotime($today_date) < strtotime($x['PERIOD_END']))
                                            {
                                                $day_from_period_start = floor((strtotime($today_date) - strtotime($x['PERIOD_START']))/ 86400);
                                                $avail_day_for_today = $day_from_period_start/365*30;
                                            }
                                            $used = $x['DAY_COUNT_USED_FOR_TODAY'];
                                            $didnt_add = $x['DIDNT_ADD'];
                                            $PERIOD_START = $x['PERIOD_START'];
                                            $PERIOD_END = $x['PERIOD_END'];
                                            $avail_day = round($avail_day_for_today - $used - $didnt_add);
                                            $total_avial_days_count  = $avail_day + $total_avial_days_count;
                                        }
                                ?>
                                <tr ondblclick="$(location).attr('href','doc_detail?doc_id=<?php echo $v['ID']; ?>');" class="gradeX view_user_dan" data="<?php ?>" style="cursor: default;">
                                    <td>
                                        <?php echo $v['FIO'];?>
                                    </td>
                                    <td>
                                        <?php echo $total_avial_days_count;?> дн.
                                    </td>
                                </tr>
                                <?php
                                    $total_avial_days_count = 0;
                                    }
                                ?>
                            </tbody>
                        </table>
                </textarea>
            <div class="mail-body text-right tooltip-demo">
                <button type="submit" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-reply"></i> Конвертировать в PDF</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php 
foreach($listEmployee as $k=> $v)
    {
?>
<div class="modal inmodal fade" id="order<?php echo $v['ID'];?>" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Приказ</h4>
            </div>
            <div class="modal-body">
                <?php echo $v['DOC_CONTENT'];?>
            </div>
            <form method="POST" action="edit_doc">
                <textarea hidden="" name="text_for_edit"><?php echo $v['DOC_CONTENT'];?></textarea>
                <input hidden="" name="holi_id" value="<?php echo $v['ID'];?>"/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Редактировать</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php 
    }
?>