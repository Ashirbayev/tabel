<?php
    foreach($list_dep as $k => $v)
    {
?>
<div class="row wrapper wrapper-content">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                    <form method="POST">
                        <div class="row">
                            <div class="col-lg-3">
                                <select id="dep_select" class="select2_demo_1 form-control">
                                <?php
                                    foreach($list_dep_list as $k=>$v)
                                    {
                                ?>
                                    <option <?php if($dep_id == $v['ID']){echo 'selected';}?> value="<?php echo $v['ID']; ?>"><?php echo $v['NAME']; ?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <script>
                                $('#dep_select').change
                                (
                                    function()
                                    {
                                        var dep_id = $('#dep_select').val();
                                        $(location).attr('href','dep_page?dep_id='+dep_id);
                                    }
                                )
                            </script>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-lg-3">
                                <input name="DEP_ID" type="text" placeholder="" class="form-control" id="DEP_ID" value="<?php echo $dep_id;?>" style="display: none;">
                                <label class="font-noraml">Название (каз)</label>
                                <input name="NAME_KAZ" id="NAME_KAZ" type="text" placeholder="" class="form-control" value="<?php echo $list_dep[0]['NAME_KAZ'];?>">
                            </div>
                            <div class="col-lg-3">
                                <label class="font-noraml">Название</label>
                                <input name="NAME" id="NAME" type="text" placeholder="" class="form-control" value="<?php echo $list_dep[0]['NAME'];?>">
                            </div>
                            <div class="col-lg-3">
                                <label class="font-noraml">Филиал</label>
                                <input name="BRANCH_ID" id="BRANCH_ID" type="text" placeholder="" class="form-control" value="<?php echo $list_dep[0]['BRANCH_ID'];?>">
                            </div>
                            <div hidden="" class="col-lg-3">
                                <input name="DIC_DEPARTMENT" id="DIC_DEPARTMENT" type="text" placeholder="" class="form-control" value="test">
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-primary">Изменить название</button>
                            </div>
                        </div>
                    </form>
                        <hr />
                    <form method="POST">
                    <h4>Назначить куратора</h4>
                    <div class="row">
                        <input name="DEP_ID" type="text" placeholder="" class="form-control" id="DEP_ID" value="<?php echo $dep_id;?>" style="display: none;">
                        <div class="col-lg-3">
                            <select name="CURATORS_ID" id="CURATORS_ID" class="select2_demo_1 form-control">
                                <option value="0"></option>
                            <?php
                                foreach($list_chiefs as $k=>$v)
                                {
                            ?>    
                                <option <?php if($list_cur[0]['CURATORS_ID'] == $v['ID']){echo 'selected';}?> value="<?php echo $v['ID']; ?>"><?php echo $v['FIO']; ?></option>
                            <?php
                                }
                            ?>
                            </select>                            
                        </div>
                        <div hidden="" class="col-lg-3">
                            <label class="font-noraml">ID</label>
                            <input name="ID" id="ID" type="text" placeholder="" class="form-control" value="<?php echo $list_cur[0]['ID']; ?>">
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary">Назначить</button>
                        </div>
                    </div>
                    </form>
                    <form method="POST">
                    <h4>Назначить директора</h4>
                    <div class="row">
                        <input name="DEP_ID" type="text" placeholder="" class="form-control" id="DEP_ID" value="<?php echo $dep_id;?>" style="display: none;">
                        <div class="col-lg-3">
                            <select name="DIRECTOR_ID" id="DIRECTOR_ID" class="select2_demo_1 form-control chosen-select">
                                <option value="0"></option>
                            <?php
                                foreach($list_pers as $k=>$v){
                            ?>    
                                <option <?php if($list_dir[0]['ID'] == $v['ID']){echo 'selected';}?> value="<?php echo $v['ID']; ?>"><?php echo $v['FIO']; ?></option>
                            <?php
                                }
                            ?>
                            </select>                            
                        </div>
                        <div hidden="" class="col-lg-3">
                            <label class="font-noraml">ID</label>
                            <input name="ID" id="ID" type="text" placeholder="" class="form-control" value="<?php echo $list_dir[0]['ID_CHIEF_TABLE']; ?>">
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary">Назначить</button>
                        </div>
                    </div>
                    </form>
                    <hr />
            </div>
        </div>
    </div>
</div>
<?php
    }
?>
