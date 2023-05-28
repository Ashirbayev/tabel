$(document).ready(function(){
   var href = (window.location.href);
       console.log(href); 
       var lastSimb = href.substr(-1);
       console.log(lastSimb);
       switch(lastSimb){
        case '1':id = 1;
            break;
        case '2':id = 2;
            break;
        case '3':id = 3;
            break;
        case '7':id = 7;
            break;
        case '8':id = 8;
            break;
        case '9':id = 9;
            break;
        case '0':id = 0;
            break;
       }
       $.post('new_contract', {"categ": id}, function(d){
            $('#id_panel').html(d);
       }) 
   
   $('.reason').change(function(){
       var id = $(this).val();
       $.post('new_contract', {"categ": id}, function(d){
            $('#id_panel').html(d);
       })
   
   
   });
    
    
})