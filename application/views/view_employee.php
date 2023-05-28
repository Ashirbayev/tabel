<?php
    $contract_job_num = $listJOB_CONTR_NUM[0]['JOB_CONTR_NUM']+1;
?>

<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" id="osn-panel">
            <div class="ibox-content">
                <!--<a data-toggle="modal" data-target="#addEmp" class="btn btn-sm btn-primary"><i class="fa fa-plus">Принять на работу</i></a>-->
                    <form method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="font-noraml">Фамилия *</label>
                                <input name="lastname" type="text" placeholder="" class="form-control" id="lastname" required=""/>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Имя *</label>
                                <input name="firstname" type="text" placeholder="" class="form-control" id="firstname" required=""/>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Отчество</label>
                                <input name="middlename" type="text" placeholder="" class="form-control" id="middlename">
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Фамилия латинскими буквами *</label>
                                <input onblur="create_mail();" onchange="create_mail();" onkeypress="create_mail();" name="LASTNAME2" type="text" placeholder="" class="form-control" id="LASTNAME2" required=""/>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Имя латинскими буквами *</label>
                                <input onblur="create_mail();" onchange="create_mail();" onkeypress="create_mail();" name="FIRSTNAME2" type="text" placeholder="" class="form-control" id="FIRSTNAME2" required=""/>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Корпоративная почта *</label>
                                <input readonly="" name="PERSONAL_EMAIL" type="text" placeholder="" class="form-control" id="PERSONAL_EMAIL" required=""/>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">ИИН *</label>
                                <input onblur="check_iin();" name="iin" data-mask="999999999999" id="iin" type="text" placeholder="" class="form-control" required=""/>
                                <div id="place_for_check_iin">
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Дата Рождения (дд.мм.гггг) *</label>
                            <div class="input-group date ">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control dateOform" name="BIRTHDATE" data-mask="99.99.9999" id="BIRTHDATEid" required=""/>
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Пол *</label>
                                <select name="SEX" id="place_for_sex_id" class="select2_demo_1 form-control" required="">
                                    <option></option>
                                    <option value="1">Мужской</option>
                                    <option value="2">Женский</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Дата начала работы (дд.мм.гггг)</label>
                                <div class="input-group date ">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input name="DATE_POST" type="text" class="form-control dateOform" data-mask="99.99.9999" id="DATE_POST" required=""/>
                                </div>
                            </div>
                            <div class="form-group" hidden="">
                                <label class="font-noraml">Филиал *</label>
                                <input name="BRANCHID" type="text" class="form-control" id="BRANCHID" value="2"/>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Департамент *</label>
                                <select onchange="get_positions();" name="JOB_SP" id="JOB_SP" class="select2_demo_1 form-control chosen-select">
                                    <option></option>
                                    <?php
                                        foreach($listDIC_DEPARTMENT as $k => $v)
                                        {
                                            echo '<option value="'.$v['ID'].'">'.$v['NAME'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Должность *</label>
                                <div id="place_for_job_pos">
                                    <select name="JOB_POSITION" id="JOB_POSITION" class="select2_demo_1 form-control">
                                    <option></option>
                                    <?php
                                        foreach($listDIC_DOLZH as $k => $v)
                                        {
                                            echo '<option value="'.$v['ID'].'">'.$v['D_NAME'].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Номер трудового договора *</label>
                                <input name="CONTRACT_JOB_NUM" type="number" placeholder="" class="form-control" id="CONTRACT_JOB_NUM" value="<?php echo $contract_job_num; ?>" required=""/>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Оклад (вводить без запятых и пробелов) *</label>
                                <input name="OKLAD" type="number" placeholder="" class="form-control" id="OKLAD" required=""/>
                            </div>
                            <div class="form-group" id="regionPlace" style="display: none;">
                            <label class="font-noraml">Область</label>
                                <select name="regionSel " class="select2_demo_1 form-control" >
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group" id="cityPlace" style="display: none;">
                                <label class="font-noraml">Населенный пункт *</label>
                                <select id="citySel" name="citySel" class="select2_demo_1 form-control" >
                                    <option></option>
                                </select>    
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Национальность *</label>
                                <select name="nationality" class="select2_demo_1 form-control chosen-select">
                                    <option></option>
                                    <?php
                                        foreach($listNationality as $k => $v){
                                            echo '<option value="'.$v['ID'].'">'.$v['RU_NAME'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Страна проживания *</label>
                                <select name="FACT_ADDRESS_COUNTRY_ID" class="select2_demo_1 form-control chosen-select">
                                    <option value="105">Казахстан</option>
                                    <?php
                                        foreach($listCountry as $k => $v)
                                        {
                                            echo '<option value="'.$v['ID'].'">'.$v['RU_NAME'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Город проживания (только название города!) *</label>
                                <input name="FACT_ADDRESS_CITY" type="text" placeholder="Астана (пример)" class="form-control" id="FACT_ADDRESS_REGION_ID" required=""/>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Улица проживания (только название улицы!) *</label>
                                <input name="FACT_ADDRESS_STREET" type="text" placeholder="Кабанбай (пример)" class="form-control" id="FACT_ADDRESS_STREET" required=""/>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Строение проживания *</label>
                                <input name="FACT_ADDRESS_BUILDING" type="text" placeholder="12 (пример)" class="form-control" id="FACT_ADDRESS_BUILDING" required=""/>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Квартира проживания *</label>
                                <input name="FACT_ADDRESS_FLAT" type="number" placeholder="77 (пример)" class="form-control" id="FACT_ADDRESS_FLAT" required=""/>
                            </div>
                            <div class="form-group">
                            <label class="font-noraml">Номер телефона *</label>
                                <input data-mask="+9-999-999-99-99" name="MOB_PHONE" placeholder="" class="form-control" id="MOB_PHONE" required=""/>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Тип документа *</label>
                                <select name="DOCTYPE" id="docTypeSelect" class="select2_demo_1 form-control" >
                                    <option></option>
                                    <?php
                                        foreach($listDoctype as $l => $d){
                                            echo '<option value="'.$d['ID'].'">'.$d['RU_NAME'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-noraml">Дата выдачи (дд.мм.гггг) *</label>
                                <div class="input-group date ">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control dateOform" name="DOCDATE" data-mask="99.99.9999" id="DOCDATE" required=""/>
                                </div>
                            </div>
                            <div id="placeForDoInf">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Сохранить</button>             
                    </div>
                    </form>
            </div>                
        </div>           
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="search_pers" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Поиск человека в ГБДФЛ</h4>
                <small class="font-bold">(Государственная база данных физических лиц)</small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Фамилия</label>
                        <input name="LASTNAMEgbdfl" type="text" placeholder="" class="form-control fio_place" id="LASTNAMEgbdfl" value="" required=""/>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Имя</label>
                        <input name="FIRSTNAMEgbdfl" type="text" placeholder="" class="form-control fio_place" id="FIRSTNAMEgbdfl" value="" required=""/>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Отчество</label>
                        <input name="MIDDLENAMEgbdfl" type="text" placeholder="" class="form-control fio_place" id="MIDDLENAMEgbdfl" value="" required=""/>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">ИИН</label>
                        <input name="iingbdfl" data-mask="999999999999" id="iingbdfl" type="text" placeholder="" class="form-control iin_place" required=""/>
                    </div>
                    <div class="form-group" id="search_pers_btn">
                        <a onclick="get_table_from_GBDFL();" type="button" class="btn btn-primary"><i class="fa fa-search"></i> Поиск</a>
                        <small>Поиск займет некоторое время...</small>
                    </div>
                    <div id="place_for_table_eith_GBDFL">
                    
                    </div>
            </div>
            <div class="modal-footer">
                <a onclick="check_iin();" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#docTypeSelect').change(
        function(){
            var docType = $('#docTypeSelect').val();
                    $.post("employee", {"docType": docType},
                    function(data){
                            $('#placeForDoInf').html(data);
                        });
        }
    )
</script>

<script>
    $('#countrySel').change(function(){
        $('#regionPlace').css("display","block");
        $('#regionSel').html('');
        var countryId = $('#countrySel').val();
                $.ajax({
                 url:"http://api.vk.com/method/database.getRegions?v=5.5&need_all=1&offset=0&count=1000&country_id="+countryId,
                 dataType: 'jsonp', // Notice! JSONP <-- P (lowercase)
                 success:function(json){
                     // обработка json
                     console.log(json);
                     var response = jQuery(json).attr('response');
                     console.log(response);
                     var items = jQuery(response).attr('items');
                     for(var i=0;i<items.length;i++){
                        $('#regionSel').append('<option value="'+items[i].id+'"'+'>'+items[i].title+'</option>');
                        console.log(items[i].id+' '+items[i].title);   
                     }
                     
                     
                 },
                 error:function(){
                     alert("Error");
                 }
            });
  
    })
</script>


<!---->

<script>
    $('#regionSel').change(function(){
        $('#cityPlace').css("display","block");
        $('#citySel').html('');
        var countryId = $('#countrySel').val();
        var regionSel = $('#regionSel').val();
                $.ajax({
                 url:"http://api.vk.com/method/database.getCities?v=5.5&country_id="+countryId+"&region_id="+regionSel+"&offset=0&need_all=1&count=1000",
                 dataType: 'jsonp', // Notice! JSONP <-- P (lowercase)
                 success:function(json){
                     // обработка json
                     console.log(json);
                     var response = jQuery(json).attr('response');
                     console.log(response);
                     var items = jQuery(response).attr('items');
                     for(var i=0;i<items.length;i++){
                        $('#citySel').append('<option value="'+items[i].id+'"'+'>'+items[i].title+'</option>');
                        console.log(items[i].id+' '+items[i].title);   
                     }
                     
                     
                 },
                 error:function(){
                     alert("Error");
                 }
            });
  
    })
</script>

<script>    
    $('#BRANCHID').change
    (
        function()
        {
            var BRANCHID = $('#BRANCHID').val();
            correct_selects(BRANCHID);
        }
    )

    function correct_selects(BRANCHID){
        if(BRANCHID == '0'){
            $('#JOB_SP').html('<option value="0" selected="selected"></option>');
            $('#JOB_POSITION').html('<option value="0" selected="selected"></option>');
        }
        else if(BRANCHID == '0000')
        {
            $.post('employee', {"BRANCHID_FOR_SP": "BRANCHID_FOR_SP"
                                }, function(d){
                                    $('#JOB_SP').html(d);
                                    $('#JOB_POSITION').html('<option value="0" selected="selected"></option>');
                                })
        }
        else
        {
            $('#JOB_SP').html('<option value="0" selected="selected">Филиал</option>');
            $.post('employee', {"BRANCHID_FOR_JOB_POSITION_BRANCH": BRANCHID
                                }, function(d){
                                    $('#JOB_POSITION').html(d);
                                })
        }
    }

    function get_positions()
    {
        var BRANCHID = $('#BRANCHID').val();
        var JOB_SP = $('#JOB_SP').val();
        if(JOB_SP != 0)
        {
            $.post('employee',
                    {"BRANCHID_FOR_POSITIONS": BRANCHID,
                     "JOB_SP_FOR_POSITIONS": JOB_SP
                    }, 
                        function(d)
                    {
                        $('#place_for_job_pos').html(d);
                    })
        }
            else
        {
            $("#JOB_POSITION [value='0']").attr("selected", "selected");
        }
    }

    function get_table_from_GBDFL(){
        var LASTNAMEgbdfl = $('#LASTNAMEgbdfl').val();
        var FIRSTNAMEgbdfl = $('#FIRSTNAMEgbdfl').val();
        var MIDDLENAMEgbdfl = $('#MIDDLENAMEgbdfl').val();
        var iingbdfl = $('#iingbdfl').val();
        
        if(LASTNAMEgbdfl == '' && FIRSTNAMEgbdfl == '' && MIDDLENAMEgbdfl == '' && iingbdfl == ''){
            alert('Введите ФИО или ИИН');
        }else{
            $.post('employee', 
                {"search_GBDFL": "search_GBDFL",
                 "LASTNAMEgbdfl": LASTNAMEgbdfl,
                 "FIRSTNAMEgbdfl": FIRSTNAMEgbdfl,
                 "MIDDLENAMEgbdfl": MIDDLENAMEgbdfl,
                 "iingbdfl": iingbdfl
                }, 
                    function(d)
                {
                    $('#place_for_table_eith_GBDFL').html(d);
                })
        }
    }
</script>

<script>
    function check_iin(){
        var iin = $('#iin').val();
        $.post('employee', 
                    {"iin_for_check": iin
                    }, 
                        function(d)
                    {
                        if(d == 0){
                            $('#place_for_check_iin').html('<p class="text-danger">ИИН уже есть в базе</p>');
                            $('#iin').val('');
                        }else{
                            $('#place_for_check_iin').html('<p class="text-info">ИИН свободен</p>');
                        }
                    }
                )
    }
</script>

<script>
    function create_mail()
    {
        var firstname = $('#FIRSTNAME2').val().toLowerCase();
        var lastname = $('#LASTNAME2').val().toLowerCase();
        var firstnames_firs_simb = firstname.charAt(0);
        $('#PERSONAL_EMAIL').val(firstnames_firs_simb+'.'+lastname+'@kazimpex.kz');
    }
</script>

<script>
    $('.fio_place').keydown(
        function(){
            $('.iin_place').val('');
            $('.iin_place').prop('disabled', true);
            $('.fio_place').prop('disabled', false);
        }
    )
    $('.iin_place').keydown(
        function(){
            $('.fio_place').val('');
            $('.iin_place').prop('disabled', false);
            $('.fio_place').prop('disabled', true);
        }
    )
    $('.fio_place').blur(
        function(){
            $('.iin_place').prop('disabled', false);
            $('.fio_place').prop('disabled', false);
        }
    )
    $('.iin_place').blur(
        function(){
            $('.iin_place').prop('disabled', false);
            $('.fio_place').prop('disabled', false);
        }
    )
</script>





















