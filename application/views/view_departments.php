<div class="row">
    <div class="col-lg-12" id="osn-panel">
        <div class="ibox-content">
            <a data-toggle="modal" data-target="#add_sp" class="btn btn-primary btn-xs">Добавить департамент</a>
            <table class="table table-striped table-bordered table-hover" id="editable" >
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название (каз)</th>
                        <th>Название</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($list_dep as $k => $v)
                        {
                    ?>
                    <tr class="gradeX view_user_dan" data="<?php ?>" style="cursor: default;">
                        <td><?php echo $v['ID'];?></td>
                        <td><?php echo $v['NAME_KAZ'];?></td>
                        <td><?php echo $v['NAME'];?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <br />
            <!--<a href="employee" type="button" class="btn btn-primary btn-xs">Добавить нового сотрудника</a>-->
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="add_sp" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Новый департамент</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                    <div class="row">
                        <div style="display: none;" class="col-lg-12">
                            <label class="font-noraml">Компания</label>
                            <input name="COMPANY_ID" id="COMPANY_ID" type="text" class="form-control" value="<?php echo $_SESSION['COMPANY_ID']; ?>"/>
                        </div>
                        <div style="display: none;" class="col-lg-12">
                            <label class="font-noraml">Филиал</label>
                            <input name="BRANCH_ID" id="BRANCH_ID" type="text" class="form-control" value="2"/>
                        </div>
                        <div class="col-lg-12">
                            <label class="font-noraml">Название (каз)</label>
                            <input name="NAME_KAZ" id="NAME_KAZ" type="text" placeholder="" class="form-control"/>
                        </div>
                        <div class="col-lg-12">
                            <label class="font-noraml">Название</label>
                            <input name="NAME" id="NAME" type="text" placeholder="" class="form-control"/>
                        </div>
                        <div hidden="" class="col-lg-12">
                            <input name="DIC_DEPARTMENT_NEW" id="DIC_DEPARTMENT_NEW" type="text" placeholder="" class="form-control" value="test"/>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="save_pos" type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
            </div>
            </form>
        </div>
    </div>
</div>

