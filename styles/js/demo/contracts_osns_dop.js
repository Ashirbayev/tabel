var pril2_inc = 0;
var pril2_main_dan = [];
var pril2_main_strah = [];
$(document).ready(function(){
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Ничего не найдено'},
        '.chosen-select-width'     : {width:'95%'}
    }
    
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    
    //input date
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    
    $('.osnVidDeyatelnosty').change(function() {        
        var oked = $(this).val();        
        $.post('new_contract', {
            "osn_vid_deyatel": oked
        }, function(data){                    
            var j = JSON.parse(data);            
            $('#oked').val(j.OKED); 
            $('#vd').val(j.NAME);
            $('#risk').val(j.RISK_ID);                       
        });
    });
    
    $('#iPERIODICH').change(function(){
        var s = $(this).val();
        s = s.substr(0, 1);        
        if(s.trim() == '2'){
            $('#transh').attr('style', '');
        }else{
            $('#transh').attr('style', 'display: none;');
        }        
    });
    
    //checkbox
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });
    
    
    //Генерация номера заявления
    var zd = 0;
    $('#IZV_DATE').change(function(){
        var paymcode = $(this).attr('data');
        var b = $('#branch').val();
        
        if(b == ''){alert('Не выбрано отделение');zd = 0; return false;}                                          
        $.post(window.location.href, {             
            "paym_code":paymcode,            
            "branch":b,
            "gen_zv_num":""
        }, function(data){
            $('input[name="ZV_NUM"]').val($.trim(data));           
        });   
        zd = 0;
    });
    
    //Агентские данные
    $('#ISICID_AGENT').change(function(){
       var id = $(this).val();
       $.post('new_contract', {
            "agent_dan": id
        }, function(data){
            var j = JSON.parse(data);
            $('.osnov_agent').val(j.OSNOVANIE);
            $('.persent_agent').val(j.PERCENT_OSNS);
        });
    });      
    
    //АКТ N1    
    var i = $('input').size() + 1;    
                                                    
    $('#add').click(function() {
        var specCategor = $(".specCategor").val();
        var specCategortext = $(".specCategor option:selected").html();        
        var fio = $(".fio").val();
        var actNumber = $(".actNumber").val();
        var dateOform = $(".dateOform").val();
        var oformReason = $(".oformReason").val();
        var sredZarplata = $(".sredZarplata").val();
        var vozrast =  $(".vozrast").val();
        var stepenViny = $(".stepenViny").val();
                 
        $.post('new_contract', {
            "AKTN1TABLE":"",
            "DOLZHN": specCategor,
            "FIO":fio, 
            "ACT_NOM":actNumber, 
            "ACT_DATE":dateOform, 
            "REASON":oformReason, 
            "AVG_ZP":sredZarplata, 
            "AGE":vozrast, 
            "VINA":stepenViny, 
            "id":i
        }, function(data){
            console.log(data);  
            $('#aktn1 tbody').append(data);
        });                               
        i++;
    });
    //Удаление акта Н1
    $('body').on('click', '.del_act_n1', function(){
       var id = $(this).attr('data');
       $('.n1_'+id).remove(); 
    });
                        
                        
    $('.submit').click(function(){    
        var answers = [];
        $.each($('.field'), function() {
            answers.push($(this).val());
        });
        if(answers.length == 0){
            answers = "none";
        }   
                        
        alert(answers);
        return false;
    });
    
    //При Выборе Контрагента вставляем данные    
    $('#id_insur').change(function(){
        var id = $(this).val();               
        if(id !== ''){
            $.post('new_contract', 
                {"id_insur_dan": id},
            function(data){                
                var s = JSON.parse(data);                
                var id_oked = s.oked_id;
                
                //Если есть ОКЕД тогда вставляем его автоматически
                if(s.oked_id !== null){
                    $('.osnVidDeyatelnosty').val(id_oked);
                    $('.osnVidDeyatelnosty').change();
                    var osn_text = $('.osnVidDeyatelnosty :selected').html();
                    $('.osnVidDeyatelnosty').next('.chosen-container').children('a').children('span').html(osn_text)
                }
                
                //Вставляем Филиалы Контрагента
                var fl = $('.pril2_naimen');
                fl.html('');                
                var opt = '';
                var j = s.filials;
                
                //Вносим в переменную все филиалы включая саму организацию
                list_insur_filials = j;                
                
                for(var i=0; i< j.length; i++){
                    var p = j[i];
                    opt = opt+'<option value="'+p.ID+'">'+p.NAME+'</option>';
                }                    
                    
                fl.html(opt);
                
                $('.ns_naimen').html('');
                $('.ns_naimen').html(opt);                
                $('#pril2_table tbody').html('');
            });
        }
    });
    
    $('.pril2_naimen').change(function(){
        var id = $(this).val();
        if(id == ''){
            alert('Не Выбран филиал');
            return false;
        }else{        
            for(var i = 0; i < list_insur_filials.length; i++){
                if(list_insur_filials[i].ID == id){
                    $('.pril2_risk').val(list_insur_filials[i].RISK_ID);                    
                }
            }            
            $('.pril2_chisl').val('1');
            $('.pril2_oklad').val('0');
            $('.pril2_smzp').val('0');
            $('.pril2_gfot').val('0');
            $('.pril2_strsum').val('0');            
        }        
    });
    
    $('#add_pril2').click(function(){    
        $('.pril2_naimen').val('');
        $('.pril2_name').val('');
        $('.pril2_risk').val('');
        $('.pril2_chisl').val('');
        $('.pril2_oklad').val('');
        $('.pril2_smzp').val('');
        $('.pril2_gfot').val('');
        $('.pril2_strsum').val('');
                
        if(list_insur_filials.length <= 0){
            alert('Выберите страхователя');
            return false;
        }
        
        if(list_insur_filials[0].RISK_ID == null){
            if($('#risk').val() == ''){
                alert("У Страхователя не задан по умолчанию ОКЕД. Для Расчета необходимо выбрать из списка 'Основного вида деятельности'");
                return false;
            }else{
                list_insur_filials[0].RISK_ID = $('#risk').val();
            }            
        }
    });
    
    $('#add_ns').click(function(){    
        $('.nc_naimen').val('');
        $('.ns_god').val('');
        $('.ns_chisl').val('');
        $('.ns_upt_s').val('');
        $('.ns_upt_not_s').val('');
        $('.ns_death').val('');
        $('.ns_postr').val('');        
                
        if(list_insur_filials.length <= 0){
            alert('Выберите страхователя');
            return false;
        }                
    });
    
    $('#save_pril2').click(function(){
        var d = $('.pril2_naimen').val();
        var n = $('.pril2_name').val();
        var r = $('.pril2_risk').val();
        var c = $('.pril2_chisl').val();
        var o = $('.pril2_oklad').val();
        var s = $('.pril2_smzp').val();
        var g = $('.pril2_gfot').val();
        var m = $('.pril2_strsum').val();
        var naimen = $('.pril2_naimen option:selected').html();
        naimen = naimen.replace(/"/g, "'");
        
        if(d == ''){
            alert('Не выбрано Наименование(Страхователь или Филиал)');
            return false;
        }
        var txt = d+';'+n+';'+c+';'+r+';'+o+';'+s+';'+g+';'+m+';';                
        var txt2 = naimen+';'+txt+$('#oked').val()+';';
                
        pril2_main_dan[pril2_inc] = txt;
        pril2_main_strah[pril2_inc] = txt2;
                        
        var inp = '<input type="hidden" name="pril2[]" class="pril2_save" value="'+txt+'">';
        var inp2 = '<input type="hidden" class="pril2_edit" value="'+txt2+'">';
        
        var tabl = '<tr id="pril2_inc'+pril2_inc+'" class="pril2_list"><td>'+inp+inp2+'<span class="btn btn-danger btn-sm del_pril2" data="'+pril2_inc+'"><i class="fa fa-trash"></i></span></td>'+
        '<td>'+naimen+'</td><td>'+n+'</td><td>'+c+'</td><td>'+r+'</td><td>'+o+'</td>'+
        '<td>'+s+'</td><td>'+g+'</td><td>'+m+'</td></tr>';
        
        $('#pril2_table tbody').append(tabl);  
        if($('#dont-close').prop('checked') == false){
            $('.close').click();
        }
        
        $('.pril2_name').val('');        
        $('.pril2_chisl').val('1');
        $('.pril2_oklad').val('0');
        $('.pril2_smzp').val('0');
        $('.pril2_gfot').val('0');
        $('.pril2_strsum').val('0');
        
        pril2_inc++;          
    });
    
    $('#save_ns').click(function(){
       var n_id = $('.ns_naimen').val(); 
       var naimen = $('.ns_naimen option:selected').html(); 
       naimen = naimen.replace(/"/g, "'");
       
       var god = $('.ns_god').val();
       var chisl = $('.ns_chisl').val();
       var upt_s = $('.ns_upt_s').val();
       var upt_not_s = $('.ns_upt_not_s').val();
       var death = $('.ns_death').val();
       var ns_postr = $('.ns_postr').val();              
       
       var txt = n_id+';'+god+';'+chisl+';'+upt_s+';'+upt_not_s+';'+death+';'+ns_postr+';;;';  
       var inp = '<input type="hidden" name="istat_bad_sluch[]" class="stat_bad_sluch" value="'+txt+'">';  
       
       var tabl = '<tr id="ns_inc'+pril2_inc+'" class="hs_list">'+
       '<td>'+inp+'<span class="btn btn-danger btn-sm del_ns" data="'+pril2_inc+'"><i class="fa fa-trash"></i></span></td>'+
       '<td>'+naimen+'</td>'+
       '<td>'+god+'</td>'+
       '<td>'+chisl+'</td>'+
       '<td>'+upt_s+'</td>'+
       '<td>'+upt_not_s+'</td>'+
       '<td>'+death+'</td>'+
       '<td>'+ns_postr+'</td>'+
       '</tr>';
        
       $('#ns_table tbody').append(tabl);  
        if($('#dont-close-ns').prop('checked') == false){
            $('.close').click();
        }
        pril2_inc++;        
    });
    
    /*Транши*/
    $('#save_transh').click(function(){        
        transh_inc++; 
        var transh_summa = $('.transh_summa').val();
        var transh_data = $('.transh_data').val();
        var txt = transh_data+';'+transh_summa+';;;;;';
        
        var ht = '<tr id="transh_inc'+transh_inc+'" class="transh_list"><td><input type="hidden" name="transh[]" class="transh_save" value="'+txt+'">'+
        '<span class="btn btn-danger btn-sm del_transh" data="'+transh_inc+'"><i class="fa fa-trash"></i></span></td>'+
        '<td>'+transh_summa+'</td><td>'+transh_data+'</td><td></td><td></td><td></td></tr>'; 
        
        $('#table_transh tbody').append(ht);
        
        $('.transh_summa').val('');
        $('.transh_data').val('');
        
        if($('#dont-close-transh').prop('checked') == false){
            $('.close').click();
        }        
    });
    
    $('body').on('click', '.del_transh', function(){
        var d = $(this).attr('data');
        $('#transh_inc'+d).remove();
    });
    
    $('#calc_smzp').click(function(){        
        var c = $('.pril2_chisl').val();
        var o = $('.pril2_oklad').val();
                
        var smzp = c * o;
        var gfot = smzp * 12;
        $('.pril2_smzp').val(smzp);
        $('.pril2_gfot').val(gfot);
        $('.pril2_strsum').val(gfot);
    });
    
    
    $('body').on('click', '.del_pril2', function(){
       var id = $(this).attr('data');
       //pril2_main_dan.splice(pril2_main_dan.indexOf(id));
       //pril2_main_strah.splice(pril2_main_strah.indexOf(id));
       $('#pril2_inc'+id).remove(); 
    });
    
    $('body').on('click', '.del_ns', function(){
       var id = $(this).attr('data');
       $('#ns_inc'+id).remove(); 
    });
    
    $('#calculat').click(function(){        
        var pril2_edit = [];
        var ns = [];   
        var pril2_save = []; 
 
        $('.pril2_edit').each(function(){
            pril2_edit.push(this.value);                                    
        }); 
        
        if(pril2_edit.length == 0){
            $('#table_calc_osns tbody').html('');
            alert('Для Расчета необходимо заполнить таблицу в Приложении2');            
            return false;
        }
                
        $('.pril2_save').each(function(){
            pril2_save.push(this.value);                                    
        });

        
        $('.stat_bad_sluch').each(function(){
           ns.push(this.value); 
        });
        
        var head = $('input[name=ihead]').val();
        var icontr_num = $('input[name=CONTRACT_NUM]').val();
        var contr_dop_date = $('input[name=idate_begin]').val();
        
        $.post(window.location.href, {            
            "pril2_save": pril2_save,
            "ns": ns, 
            "head": head,
            "contr_num": icontr_num,
            "contr_date": contr_dop_date,
            "calc_osns_new": pril2_edit
        }, function(data){               
            var d = JSON.parse(data);
            console.log(d);
            
            
            $('#table_calc_osns tbody').html('');
            if(d.alert !== ''){
                window.alert(d.alert);
                return false;
            }   
            
            $('#pay_sum_v').val(d.pay_sum_v);
            $('#pay_sum_p').val(d.pay_sum_p);
            $('#koef_pp').val(d.pp_koef);
            $('#sgchp').val(d.sgchp);            
            $('#koef_uv').val(d.koef_uv);
            
            $('#table_calc_osns tbody').html(d.raschet_table_html);
               
            if(d.message !== ''){
                var alert = '<div class="alert alert-warning alert-dismissable">'+
                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+d.message+'</div>';
                $('#other_message').html(alert);
            }
            if(d.pril2_table !== null){
                $('#pril2_table tbody').html(d.pril2_table);    
            }   
            
            $('.dopki').css('display', 'block');
            $('input[name=ikol_d_year]').val(d.dop_dan['IKOL_D_YEAR']);
            $('input[name=ikol_prosh_d]').val(d.dop_dan['IKOL_PROSH_D']);
            $('input[name=ikol_ost_d]').val(d.dop_dan['IKOL_OST_D']);            
            $('input[name=izarab_p]').val(d.dop_dan['IZARAB_P']);
            $('input[name=inezarab_p]').val(d.dop_dan['INEZARAB_P']);
            $('input[name=sum_itog]').val(d.dop_dan['SUM_ITOG']);            
            $('input[name=prem_new1]').val(d.dop_dan['PREM_NEW1']);
            $('input[name=prem_new2]').val(d.dop_dan['PREM_NEW2']);
            $('.vozv_opl').html(d.dop_dan['vozv_opl'])
            var cl_l = 'label-danger'; 
            if(d.dop_dan['SUM_ITOG'] > 0){
                cl_l = 'label-info';
            }
            $('.vozv_opl').removeClass('label-danger');
            $('.vozv_opl').removeClass('label-info');
            $('.vozv_opl').addClass(cl_l);
            
        });        
    });   
    
    var dop_osns_ts = 0;
    $('#save_modal_dop_dan').click(function(){
        $('.i_osns_calc_new').each(function(){
            var txt = $(this).val().split(";");
            if(txt[0] == $('#dop_naimen').val()){
                txt[6] = $('#dop_uv').val();    
                txt[7] = $('#dop_pr').val();
                txt[8] = $('#dop_oklad').val();
                txt[9] = $('#dop_kateg').val();
                var s = '';
                for(var i=0;i<txt.length;i++){
                    s += txt[i]+';'; 
                }
                $(this).val(s);
            }
        });
        
        //var inp = '<input type="hidden" name="dop_table_dan[]" value="'+$('#dop_naimen').val()+';'+$('#dop_uv').val()+';'+$('#dop_pr').val()+';'+$('#dop_oklad').val()+';'+$('#dop_kateg').val()+'">';
        //var html = '<tr id="del_dop_tr'+dop_osns_ts+'"><td>'+inp+'<span id="'+dop_osns_ts+'" class="btn btn-warning del_dop_tb"><i class="fa fa-trash"></i></span></td>';
        var html = '<tr id="del_dop_tr'+dop_osns_ts+'"><td><span id="'+dop_osns_ts+'" class="btn btn-warning del_dop_tb"><i class="fa fa-trash"></i></span></td>';
        html += '<td>'+$('#dop_naimen option:selected').text()+'</td>';        
        html += '<td>'+$('#dop_uv').val()+'</td>';
        html += '<td>'+$('#dop_pr').val()+'</td>';
        html += '<td>'+$('#dop_oklad').val()+'</td>';
        html += '<td>'+$('#dop_kateg').val()+'</td>';
        html += '</tr>';
        
        $('#raschet_dop').append(html);
        dop_osns_ts++;
    });
    
    $(document).on('click', '.del_dop_tb', function(){        
        var id = $(this).attr('id');
        $('.i_osns_calc_new').each(function(){
            var txt = $(this).val().split(";");
            if(txt[0] == id){
                txt[6] = '0';    
                txt[7] = '0';
                txt[8] = '0';
                txt[9] = '0';
                var s = '';
                for(var i=0;i<txt.length;i++){
                    s += txt[i]+';'; 
                }
                $(this).val(s);
            }
        });
        $('#del_dop_tr'+id).remove();
    });
            
});

var flagTitle = 1;
    function showTitle(){
        if (flagTitle==0){
            document.getElementById('strahTitle').hidden='false';
            document.getElementById('statVkladka').style='visibility: hidden;';
            flagTitle =1;
        }else {
            document.getElementById('strahTitle').hidden='';
            document.getElementById('statVkladka').style='';
            flagTitle =0;
        }
    }
    
    
function SaveOsns()
{
    var answers = [];
        $.each($('.field'), function() {
            answers.push($(this).val());
        });
        if(answers.length == 0){
            answers = "none";
        }   
                        
        alert(answers);
        return false;
        
    var typ_dog = $('input[name="TYP_DOG"]').prop('checked');
}    

