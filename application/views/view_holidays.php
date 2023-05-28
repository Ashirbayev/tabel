<div class="ibox-content">
    <div class="ibox-title">
        <div class="ibox-tools">
            <form method="POST">
                <div class="row m-b-sm m-t-sm">
                    <div class="col-md-4">
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $date_start; ?>" type="text" class="form-control dateOform" name="date_start" data-mask="99.99.9999" id="date_start" required=""/>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="input-group date ">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input value="<?php echo $date_end; ?>" type="text" class="form-control dateOform" name="date_end" data-mask="99.99.9999" id="date_end" required=""/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Показать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Дата выходного</th>
            <th>Функции</th>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach($list_history as $k => $v)
                {
                    $last_pos = $list_history[$k-1]['ID'];
            ?>
            <tr>
                <td><?php echo $v['DATE_HOL']; ?></td>
                <td>
                    <form method="post">
                        <input hidden="" value="<?php echo $date_start; ?>" name="date_start"/>
                        <input hidden="" value="<?php echo $date_end; ?>" name="date_end"/>
                        <input hidden="" name="DATE_HOL_FOR_DELETE" value="<?php echo $v['DATE_HOL']; ?>"/>
                        <button type="submit" class="btn btn-primary btn-xs">Удалить</button>
                    </form>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <a data-toggle="modal" data-target="#edit_table" class="btn btn-primary"><i class="fa fa-plus"></i> Добавить выходной</a>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="edit_table" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавить выходной</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div class="form-group" id="data_1">
                    <input hidden="" value="<?php echo $date_start; ?>" name="date_start"/>
                    <input hidden="" value="<?php echo $date_end; ?>" name="date_end"/>
                    <label class="font-noraml">Дата (приказа)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="ADDING_HOLY" data-mask="99.99.9999" id="ADDING_HOLY" required=""/>
                    </div>
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