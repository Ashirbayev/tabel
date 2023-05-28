var result_json;
$(document).ready(function(){
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Ничего не найдено'},
        '.chosen-select-width'     : {width:95}
    }
    
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
        
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    
    var 
        cs_list,
        cs_res,
        res,
        list_okeds;
                            
    $('#btn_search').click(function(){
        var text = $('#search_contr_agent').val();        
        $.post(window.location.href, {"search_contragent": text}, function(data){
            var j = JSON.parse(data);            
            cs_list = j;
            $('#search_result').html('');
            $.each(j, function(i, t){                      
                $('#search_result').append('<a class="list-group-item set_client" data="'+t.ID+'" href="javascript:;">'+t.NAME+' ('+t.BIN+')</a>');                
            });             
        });
        $('#okeds').css('display', 'none');
    });
    
    $('#search_contr_agent').keypress(function(e){
        if (e.which == 13) {
            $('#btn_search').click();
        }
    });
    
    $('body').on('click', '.set_client', function(){
       var id = $(this).attr('data');        
       $.each(cs_list, function(i, t){                      
            if(t.ID == id){                
                cs_res = t;
            }
       });
       
       $('#search_result').html('');
       $('#okeds').css('display', 'block');
       $('#oked').val(cs_res.OKED);  
       $('#oked_id').val(cs_res.OKED_ID);
       $('#strah_name').val(cs_res.NAME);
       $('#BIN').val(cs_res.BIN);       
       $('#id_insur').val(cs_res.ID); 
       $('#vd').val(cs_res.OKED_NAME_OTHER);
       $('#NAME_OKED').val(cs_res.NAME_OKED);
       $('#risk').val(cs_res.RISK_ID);
       $('#AFFILIR').val(cs_res.AFFILIR);
       $('.pril2_naimen').append('<option value="0">Страхователь</option>');
       $('.ns_naimen').append('<option value="0">Страхователь</option>');       
       $('.pril2_risk').val(cs_res.RISK_ID);
       
       if(cs_res.FILIALS.length > 0){
          $.each(cs_res.FILIALS, function(i, k){
             $('.pril2_naimen').append('<option value="'+k.ID+'">'+k.NAME+'</option>');
             $('.ns_naimen').append('<option value="'+k.ID+'">'+k.NAME+'</option>');
          });
       }       
    });
    
    $('#btn_search_oked').click(function(){
        var text = $('#search_oked_text').val(); 
        $.post(window.location.href, {"search_oked":text}, function(data){                        
            var j = JSON.parse(data); 
            list_okeds = j;
            $('#list_okeds').html('');
            $.each(j, function(i, t){                      
                $('#list_okeds').append('<a class="list-group-item set_oked" data="'+t.ID+'" href="javascript:;">'+t.OKED+' - '+t.NAME_OKED+' </a>');                
            });            
        });
    });        
    
    $('#search_oked_text').keypress(function(e){
        if (e.which == 13) {
            $('#btn_search_oked').click();
        }
    });
    
    $('body').on('click', '.set_oked', function(){
        var id = $(this).attr('data');
        $.post(window.location.href, {"oked_dan": id}, function(data){
           var j = JSON.parse(data);
           $('#vd').val(j.OKED_NAME_OTHER);
           $('#NAME_OKED').val(j.NAME_OKED);
           $('#oked_id').val(j.ID);
           $('#oked').val(j.OKED);
           $('#risk').val(j.RISK_ID);                                            
           $('.close').click();
           $('#list_okeds').html('');
        });
    });
    
    $('#DATE_BEGIN').change(function(){ 
        var dt = $(this).val();
        $.post(window.location.href, {"date_add_year":dt}, function(data){
          $('#DATE_END').val(data.trim());  
        })        
    });
    
    $('.chosen-container').css('width', '100%');
    
    $('#AGENT').change(function(){
        var id = $(this).val();
        $.each(agents, function(i, v){
           if(v.KOD == id){                
              $('#komis').val(v.PERCENT_OSNS+' %');
              $('#osnov').val('Договор № '+v.CONTRACT_NUM+' от '+v.CONTRACT_DATE_BEGIN+' г.');
              if(v.PERCENT_OSNS == '0'){
                $('#panel_agent').css('display', 'none');  
              }else{
                $('#panel_agent').css('display', 'block');
              }
                            
           } 
        });        
    });  
    
    var ids = 0;        
    $('#save_pril2').click(function(){  
        var
          pril2_chisl = $('.pril2_chisl').val(),
          pril2_gfot = $('.pril2_gfot').val(),
          pril2_strsum = $('.pril2_strsum').val();
                  
        if(pril2_chisl.trim() == ''){
            alert('Численность не может быть меньше либо равна нулю');
            return;
        }
        if(parseInt(pril2_chisl) <= 0){
            alert('Численность не может быть меньше либо равна нулю');
            return;
        }
        
        if(pril2_gfot.trim() == ''){
            alert('ГФОТ не может быть меньше либо равна нулю');
            return;
        }
        if(parseInt(pril2_gfot) <= 0){
            alert('ГФОТ не может быть меньше либо равна нулю');
            return;
        }
        
        if(pril2_strsum.trim() == ''){
            alert('Страховая сумма не может быть меньше либо равна нулю');
            return;
        }
        if(parseInt(pril2_strsum) <= 0){
            alert('Страховая сумма не может быть меньше либо равна нулю');
            return;
        }
        /*Несчастные случаи*/
        var ns = {};
        var c = 0;
        $('.istat_bad_sluch').each(function(){
            var val = $(this).val();
            var sp = val.split(';');
            var obj = {};
            for(var i=0;i<sp.length;i++){
                var ds = sp[i];
                var ps = ds.split(':');
                obj[ps[0]] = ps[1];
            }
            ns[c] = obj;
            c++;
        });
        
        var oked = $('#oked').val();
                
        /*Приложение 2*/   
        var dan = "id_insur:"+$(".pril2_naimen").val()+';'+
            "dolgnost:"+    $('.pril2_name').val()+";"+
            "count:"+       $('.pril2_chisl').val()+";"+
            "risk:"+        $('.pril2_risk').val()+";"+
            "oklad:"+       $('.pril2_oklad').val()+";"+
            "smzp:"+        $('.pril2_smzp').val()+";"+
            "gfot:"+        $('.pril2_gfot').val()+";"+
            "str_sum:"+     $('.pril2_strsum').val()+";"+
            "str_sum_koef:"+$('.pril2_strsum').val();
        
        var c = 0;
        var pril2 = {};        
        $('.pril2').each(function(){
            var val = $(this).val();
            var sp = val.split(';');
            var obj = {};
            for(var i=0;i<sp.length;i++){
                var ds = sp[i];
                var ps = ds.split(':');
                obj[ps[0]] = ps[1];
            }
            pril2[c] = obj;
            c++;
        });
                
        var sp = dan.split(';');
        var obj = {};
        for(var i=0;i<sp.length;i++){
            var ds = sp[i];
            var ps = ds.split(':');
            obj[ps[0]] = ps[1];                
        }
        pril2[c] = obj;        
                
        var id_insur_main = $('#id_insur').val();
        var contract_date = $('input[name=CONTRACT_DATE]').val();
        var id_head = $('#id_head').val();
        
        $.post(window.location.href, {
            "calc_pril2":pril2, 
            "ns":ns,
            "id_insur_main": id_insur_main,
            "contract_date": contract_date,
            "id_head": id_head,
            "oked": oked
        }, function(data){
            result_json = data;
            var j = JSON.parse(data);  
            if(j.message !== ''){
                $('#pril2').append(j.message);
            }else{
                $('#pril2').html(j.pril2_html);    
            }
            console.log(data);
        });        
        
        
        if($('#dont-close').prop('checked') == false){
          $('.close').click();
        }
        /*        
        $('.pril2_name').val('');
        $('.pril2_chisl').val('1');        
        $('.pril2_oklad').val("0");
        $('.pril2_smzp').val('0');
        $('.pril2_gfot').val('0');
        $('.pril2_strsum').val('0');
        $('.pril2_strsum').val('0');
        */
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
    
    $('body').on('click', '.del_pril2, .del_ns, .del_transh', function(){
       var id = $(this).attr('data');       
       $(id).remove(); 
       var h = $('#pril2').html();
       if(h.trim() == ''){
        return;
       }
       
       /*Несчастные случаи*/
        var ns = {};
        var c = 0;
        $('.istat_bad_sluch').each(function(){
            var val = $(this).val();
            var sp = val.split(';');
            var obj = {};
            for(var i=0;i<sp.length;i++){
                var ds = sp[i];
                var ps = ds.split(':');
                obj[ps[0]] = ps[1];
            }
            ns[c] = obj;
            c++;
        });
        
        var oked = $('#oked').val();
        var id_insur_main = $('#id_insur').val();
        var contract_date = $('input[name=CONTRACT_DATE]').val();
        var id_head = $('#id_head').val();
        
        var c = 0;
        var pril2 = {};        
        $('.pril2').each(function(){
            var val = $(this).val();
            var sp = val.split(';');
            var obj = {};
            for(var i=0;i<sp.length;i++){
                var ds = sp[i];
                var ps = ds.split(':');
                obj[ps[0]] = ps[1];
            }
            pril2[c] = obj;
            c++;
        });
        
        $.post(window.location.href, {
            "calc_pril2":pril2, 
            "ns":ns,
            "id_insur_main": id_insur_main,
            "contract_date": contract_date,
            "id_head": id_head,
            "oked": oked
        }, function(data){
            result_json = data;
            var j = JSON.parse(data);              
            $('#pril2').html(j.pril2_html);
        });
       
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
       
       if(chisl == null){chisl  = 0;}
       if(upt_s == null){upt_s  = 0;}
       if(upt_not_s == null){upt_not_s  = 0;}
       if(death == null){death  = 0;}
       if(ns_postr == null){ns_postr  = 0;}       
       
       var ist = 0;
       ist = parseInt(chisl)+parseInt(upt_s)+parseInt(upt_not_s)+parseInt(death)+parseInt(ns_postr);
       
       if(ist == 0){
          alert('Все поля не могут равняться нулю');
          return;
       }       
       
       var txt = "n_id:"+n_id+';god:'+god+';chisl:'+chisl+';upt_s:'+upt_s+';upt_not_s:'+upt_not_s+';death:'+death+';ns_postr:'+ns_postr;
       var html = '<div class="col-lg-3 list_ns" id="ns_inc'+ids+'"><div class="ibox float-e-margins">'+
        '<input type="hidden" name="istat_bad_sluch[]" class="istat_bad_sluch" value="'+txt+'">'+
        '<div class="ibox-title"><button class="label label-danger pull-right del_ns" data="#ns_inc'+ids+'"><i class="fa fa-trash"></i></button>'+
        '<h5 class="p_strah">'+god+'</h5></div><div class="ibox-content">'+
        '<h5>'+naimen+'</h5><ul class="list-group clear-list m-t">'+
        '<li class="list-group-item fist-item">'+
        '<span class="pull-right">'+chisl+'</span>Численность</li>'+
        '<li class="list-group-item"><span class="pull-right">'+upt_s+'</span>УПТ со сроком</li>'+
        '<li class="list-group-item"><span class="pull-right">'+upt_not_s+'</span>УПТ без срочно</li>'+
        '<li class="list-group-item"><span class="pull-right">'+death+'</span>Смертность</li>'+
        '<li class="list-group-item"><span class="pull-right">'+ns_postr+'</span>Численность пострадавших</li>'+        
        '</ul></div></div></div>'; 
       
       $('#list_ns').append(html);  
        if($('#dont-close-ns').prop('checked') == false){
            $('.close').click();
        }
        ids++;        
    });
    
    var transh_inc = 0;
        
    $('#save_transh').click(function(){
        transh_inc++; 
        var transh_summa = $('.transh_summa').val();
        var transh_data = $('.transh_data').val();
        var txt = "id:"+transh_inc+";data:"+transh_data+';paysum:'+transh_summa+';';
        
        var html = '<div class="col-lg-3 transh" id="transh'+transh_inc+'"><div class="ibox float-e-margins">'+
        '<input type="hidden" name="transh[]" class="transh_inp" value="'+txt+'">'+
        '<div class="ibox-title"><button class="label label-danger pull-right del_transh" data="#transh'+transh_inc+'"><i class="fa fa-trash"></i></button>'+
        '<h5>Транш № '+transh_inc+'</h5></div><div class="ibox-content">'+        
        '<li class="list-group-item fist-item">'+
        '<span class="pull-right">'+transh_data+'</span>Дата</li>'+
        '<li class="list-group-item"><span class="pull-right">'+transh_summa+'</span>Сумма</li>'+                
        '</ul></div></div></div>';                 
        
        $('#list_transh').append(html);
        
        $('.transh_summa').val('');
        $('.transh_data').val('');
        
        if($('#dont-close-transh').prop('checked') == false){
            $('.close').click();
        }        
    });
    
    var calc_osns = function(){        
        var oked = $('#oked_id').val();
        var id_insur = $('#id_insur').val();
        var id_head = $('#id_head').val();
        
        var pril2 = [];
        var ns = [];
        $('.pril2').each(function(){pril2.push($(this).val());});        
        $('.istat_bad_sluch').each(function(){ns.push($(this).val()); });
    }    
    
    $('.next').click(function(){
       var id = $(this).attr('id');        
       if(id == '1'){nextpage('2');}
       
       if(id == '2'){
            if($('#DATE_BEGIN').val() == ''){
                alert('Период страхования не может быть пустым!');
                return;
            }
            var ns = $('input[name=NS_BOOL]').prop('checked');
            if(ns == true){
                nextpage('3');    
            }else{
                nextpage('4');
            }            
       }
       
       if(id == '3'){
            var h = $('#pril2').html(); 
            if(h.trim() == ''){
                alert('Список сотрудников не может быть пустым!');
                return;
            }
            var periodich = $('input[name=periodich]').prop('checked');
            if(periodich == true){
                nextpage('6');
            }else{
                nextpage('5');
            }
       }
       
       if(id == '4'){
            var ht = $('#list_ns').html();
            if(ht.trim() == ''){
                alert('Статистика несчастных случаем не может быть пустой!');
                return;
            }
            nextpage('3');
       }
       
       if(id == "5"){
          nextpage("6");
       } 
       
    });
    
    $('.prev').click(function(){
       var ns = $('input[name=NS_BOOL]').prop('checked');
       var periodich = $('input[name=periodich]').prop('checked');
       
       var id = $(this).attr('id'); 
       if(id == "2"){nextpage("1");}       
       if(id == "3"){
            if(ns == false){
                nextpage("4");
            }else{
                nextpage("2");   
            }
       }
       if(id == "4"){nextpage("2");}
       if(id == "5"){nextpage("3");}
       if(id == "6"){
            if(periodich == true){
                nextpage("3");    
            }else{
                nextpage("5");   
            }            
       }       
    });
            
});

function nextpage(id)
{
    $('.page').css('display', 'none');
    $('#panel'+id).css('display', 'block');
}