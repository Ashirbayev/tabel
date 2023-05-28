<div class="wrapper wrapper-content  animated fadeInRight">
    <!--
    <div class="row">
        <div class="col-lg-12" id="osn-panel">
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover" id="editable">
                    <thead>
                        <tr>
                            <th>Должность</th>
                            <th>Структурное подразделение</th>
                            <th>Должностная группа</th>
                            <th>Оклад min</th>
                            <th>Оклад max</th>
                            <th>Действующий оклад</th>
                            <th>Премия</th>
                            <th>Периодичность</th>
                            <th>Надбавка к должностному окладу</th>
                            <th>Действующая надбавка</th>
                            <th>ФИО</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($listEmployee as $k=> $v)
                            {
                        ?>
                        <tr class="gradeX">
                            <td>
                                <?php echo $v['D_NAME'];?>
                            </td>
                            <td>
                                <?php if($v['BRANCHID'] == '0000'){echo $v['NAME'];}else{ echo $v['BRANCH_NAME']; } ?>
                            </td>
                            <td>
                                <div class="input-group m-b">
                                    <select class="form-control m-b POS_GROUP" onchange="send_to_db('POS_GROUP', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" name="account">
                                        <option value=""></option>
                                        <?php
                                            foreach($list_pos_group as $f => $g){
                                        ?>
                                        <option value="<?php echo $g['ID']; ?>" <?php if($g['ID'] == $v['POS_GROUP']){echo 'selected';} ?>><?php echo $g['POS_NAME']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group m-b MIN_OKLAD"><span class="input-group-addon">₸</span>
                                    <input class="form-control inf_inp" type="text" onblur="send_to_db('MIN_OKLAD', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" value="<?php echo $v['MIN_OKLAD']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="input-group m-b MAX_OKLAD">
                                    <input class="form-control inf_inp" type="text" onblur="send_to_db('MAX_OKLAD', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" value="<?php echo $v['MAX_OKLAD']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="input-group m-b OKLAD">
                                    <input class="form-control inf_inp" type="text" onblur="send_to_db('OKLAD', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" value="<?php echo $v['OKLAD']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="input-group m-b PREMIUM">
                                    <input class="form-control inf_inp" type="text" onblur="send_to_db('PREMIUM', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" value="<?php echo $v['PERS_PREMIUM']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="input-group m-b">
                                    <select class="form-control m-b PREMIUM_PERIOD" onchange="send_to_db('PREMIUM_PERIOD', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" name="account">
                                        <option value=""></option>
                                        <?php
                                            foreach($list_prem_per as $f => $g){
                                        ?>
                                        <option value="<?php echo $g['ID']; ?>" <?php if($g['ID'] == $v['PREMIUM_PERIOD']){echo 'selected';} ?>><?php echo $g['NAME']; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group m-b INCREASE">
                                    <input class="form-control inf_inp" type="text" onblur="send_to_db('INCREASE', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" value="<?php echo $v['INCREASE']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="input-group m-b NADBAVKA">
                                    <input class="form-control inf_inp" type="text" onblur="send_to_db('NADBAVKA', <?php echo $v['ID'];?>, '<?php echo $v['PERS_ID'];?>', $( this ).val());" value="<?php echo $v['NADBAVKA']; ?>">
                                </div>
                            </td>
                            <td>
                                <?php echo $v[ 'FIO'];?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <br />
            </div>
        </div>
    </div>
    -->
    <div class="row">
        <div class="col-lg-12" id="osn-panel">
            <div class="ibox-content">
                    <form method="post">
                        <div style="display: none;" class="form-group">
                            <label class="font-noraml">Филиал</label>
                            <input name="BRANCHID" id="BRANCHID" value="2" readonly=""/>
                        </div>
                        <div class="form-group">
                            <label class="font-noraml">Департамент</label>
                            <select name="JOB_SP" id="JOB_SP" class="select2_demo_1 form-control chosen-select" required=""/>
                                <option></option>
                                <?php 
                                    foreach($listDepartments as $z => $x)
                                    {
                                        echo '<option value="'.trim($x['ID']).'">'.$x['NAME'].'</option>'; 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-noraml">Название должности рус</label>
                            <input name="D_NAME" type="text" placeholder="" class="form-control" id="D_NAME" required=""/>
                        </div>
                        <div class="form-group">
                            <label class="font-noraml">Название должности каз</label>
                            <input name="D_NAME_KAZ" type="text" placeholder="" class="form-control" id="D_NAME_KAZ" required=""/>
                        </div>
                        <div class="form-group">
                            <label class="font-noraml">Количество позиций в данном филиале</label>
                            <input name="CNT" type="text" placeholder="" class="form-control" id="CNT" required=""/>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
            </div>                
        </div>           
    </div>
</div>

<script>    
    $('#BRANCHID').change(
        function(){
            var BRANCHID = $('#BRANCHID').val();
            //correct_selects(BRANCHID);
        }
    )

    function correct_selects(BRANCHID)
    {
        if(BRANCHID == '0000')
        {
            $.post('add_position', {"BRANCHID_FOR_SP": "BRANCHID_FOR_SP"
                                }, function(d)
                                {
                                    $('#JOB_SP').html(d);
                                })
        }
        else
        {
            $('#JOB_SP').html('<option disabled="" value="0" selected="selected">Филиал</option>');
        }
    }

    function send_to_db(elem_name, id, pers_id, this_val)
    {
        if(elem_name == 'OKLAD' || elem_name == 'NADBAVKA' || elem_name == 'PREMIUM_PERIOD' || elem_name == 'PREMIUM'){
            $.post('add_position', 
            {
                "fact": "fact",
                "pers_id": pers_id,
                "elem_name": elem_name,
                "this_val": this_val
            }, function(d){
                console.log(d);
            })   
        }else{
            $.post('add_position', 
            {
                "potential": "potential",
                "dolzh_id": id,
                "elem_name": elem_name,
                "this_val": this_val
            }, function(d){
                console.log(d);
            })
        }
    }
    
    function show_branches(){
        var sp_id = $('#sp_list').val();
        alert(sp_id);
        if(sp_list == 0){
            console.log('1');
            $('#branches').show();
        }else{
            $('#branches').hide();
        }
    }
</script>






