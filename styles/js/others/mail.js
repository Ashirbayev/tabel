$(document).ready(function(){        
    var menu_path = '';     
    var body = $('body');
    var modal_head = $('#email-title');
    var subjects = $('#email-subjects');
    var mailbody = $('#email-body');

    body.on('click', '.mail', function(){
        var url = $(this).attr('data');        
        var head = $(this).children('.email_path').html();
        modal_head.html(head);
        
        //$.get("mail?"+url, function(data){            
        //    $('#email-subjects').html(data); 
        //    $('#email-body').html('');           
        //});                
    });       
    
    body.on('click', '.mail-body', function(){
       $('.mail-body').attr('class', 'mail-body');
       $(this).attr('class', 'mail-body warning-element');
       var url = $(this).attr('data');
       //$.get("mail?"+url, function(data){
       //     $('#email-body').html(data);            
       //}); 
    });    
});