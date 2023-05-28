var res;
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
    
    $('#id_user').click(function(){        
       $('.not_view').css('display', 'block'); 
    });
    
    $('.not_view').focusout(function(){
        $('.not_view').css('display', 'none');        
    })
    
    $('#search_user').keydown(function(){       
        var txt = $(this).val();
        console.log(txt);
        $('.search_result').html('');
        load_gif = false;
        $.post(window.location.href, {"search_user":txt}, function(data){
            var j = JSON.parse(data);                                                                  
            $.each(j, function(i, t){                    
                $('.search_result').append('<a href="javascript:;" class="list-group-item set_user" sets="#id_user" data="'+t.ID+'">'+t.NAME+'</a>');                           
            });                
        });
        load_gif = true;
    });
    
    $('body').on('click', '.set_user', function(){
        var 
            id_user = $(this).attr('data'),
            username = $(this).html();
            id = $(this).attr('sets');
        
        $(id).val(username);
        $(id).attr('data', id_user);
        $('.not_view').css('display', 'none');
        $('.search_result').html('');
    });
    /*
    $('#id_user_chosen .chosen-drop .chosen-search input').autocomplete({        
        source: function(request, response) {
            $.post(window.location.href, {"search_user":request.term}, function(data){
                var j = JSON.parse(data);
                $('#id_user').html('');
                $('#id_user_chosen .chosen-drop .chosen-results').html();                      
                $.each(j, function(i, t){
                    $('#id_user').append('<option value="'+t.ID+'">'+t.NAME+'</option>');
                    $('#id_user_chosen .chosen-drop .chosen-results').append('<li class="active-result" data-option-array-index="'+i+'">'+t.NAME+'</li>');       
                });                
            })            
        }
    });
    */
    //input date
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green'
    });
    
    var gi = 0;
    $('#CONTRACT_DATE').change(function(){
        if(gi == 0){
            gi++;
            return false;
        }
        var d = $(this).val();
        var paymcode = $(this).attr('data');
        var b = $('#branch').val();
        
        if(b == ''){alert('Не выбрано отделение');gi = 0; return false;}
        if(d == ''){alert('Не выбрана дата договора');gi = 0; return false;}
        
        if($('input[name="iCONTRACT_NUM"]').val() !== ''){
            return false;
        }
                                                
        $.post('new_contract', {
            "gen_contract_num":"", 
            "paym_code":paymcode,
            "contract_date":d,
            "branch":b 
        }, function(data){
            $('input[name="iCONTRACT_NUM"]').val($.trim(data));           
        });   
        gi = 0;               
    });
    
    //Генерация номера заявления
    var zd = 0;
    $('#IZV_DATE').change(function(){
        if(zd == 0){
            zd++;
            return false;
        }
                
        var paymcode = $(this).attr('data');
        var b = $('#branch').val();
        
        if(b == ''){alert('Не выбрано отделение');zd = 0; return false;}        
        if($('input[name="iZV_NUM"]').val() !== ''){
            return false;
        }                          
        $.post('new_contract', {
            "gen_zv_num":"", 
            "paym_code":paymcode,            
            "branch":b 
        }, function(data){            
            $('input[name="iZV_NUM"]').val($.trim(data));           
        });   
        zd = 0;
    }); 
    
    
    $('#calc_btn').click(function(){
       var id_user = $('#id_user').val(),
           gp = $('#gp_year').val(),
           periodich = $('#periodich').val(),
           pay_sym_gfss = $('#pay_sum_gfss').val();  
                                                     
       $.post(window.location.href, 
       {
            "calcUser":id_user, 
            "pay_sum_gfss":pay_sym_gfss, 
            "periodich":periodich, 
            "gp_year":gp
       }, function(data){
            var j = JSON.parse(data);
            res = j;
            if(j.error !== ''){ 
                $('#other_message').html(j.error);
            }            
            console.log(j);
       });       
    });
});    