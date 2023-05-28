$(function() {
    var chart_url = "?main&&ns";    
    $.getScript(chart_url).fail(function(jqxhr, settings, exception) {
        console.log(jqxhr.responseText);
        console.log(settings);
        console.log(exception);
        console.log("Ошибка выполения скрипта");
    });
        
    var filter = '';
    var chart_view = '';
                 
    $('body').on('click', '.chart_view', function(e){        
        var s = $(this).attr('href');   
        var ar = s.split("=");
        if(ar[0] == 'type_chart'){chart_view = '&&'+s;}
        if(ar[0] == 'filter'){filter = '&&'+s}                
         
        var url = chart_url+'&&'+s+chart_view+filter;          
        if(s !== '#'){
            $.getScript(url)
            .fail(function(jqxhr, settings, exception) {console.log("Ошибка выполения скрипта");});            
        }
        e.preventDefault();
        //return false;   
    });    
});
