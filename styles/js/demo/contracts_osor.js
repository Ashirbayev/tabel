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
});    