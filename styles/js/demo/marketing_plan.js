$(document).ready(function(){
    var max_height = 0;
    $('.list_contr').each(function(){        
        var h = $(this).height();        
        if(h > max_height){
            max_height = h;
        }
    });
    
    $('.list_contr').each(function(){
        $(this).css('height', max_height+'px');
    });
    
    /*
    $.post(window.location.href, {"graphik_contracts":""}, function(data){
        if(data !== ''){
            eval(data);
        }        
    });
    */
    $('#list_region').change(function(){
       var id = $(this).val();
       var url = 'marketing_plan'; 
       if(id !== '0'){
           url = url+"?view_branch="+id;
       }
       window.location.href = url;
    });
    
    /*
    c3.generate({
        bindto: '#lineChart',
        data:{
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 50, 20, 10, 40, 15, 25]
            ],
            colors:{
                data1: '#1ab394',
                data2: '#BABABA'
            }
        }
    });
    */
})    