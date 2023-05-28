$(function () {
    "use strict";
    // for better performance - to avoid searching in DOM
    var content = $('.messages-box');    
    var input = $('.text_msg');
    
    var status = $('#status');
    var scr;
    var mes_form = $('.mes');
    var pech = 0;
    
    var myColor = false;
    var myName = page;
            
    window.WebSocket = window.WebSocket || window.MozWebSocket;    
    if (!window.WebSocket) {
        console.log('Sorry, but your browser doesn\'t support WebSockets.');
        input.hide();
        $('span').hide();
        return;
    }
    
    var connection = new WebSocket('wss://'+url+':8000');
    connection.onerror = function (error) {
        console.log('Sorry, but there\'s some problem with your connection or the server is down');        
    };
    
    connection.onclose = function(event) {
        if(event.wasClean) {
            console.log('Код: ' + event.code + ' причина: ' + event.reason);            
        } else {
            console.log('Код: ' + event.code + ' причина: ' + event.reason);            
        }        
    };
    
    connection.onopen = function () {        
        if(page !== false){
            connection.send(page);
        }else{            
            input.removeAttr('disabled').val('').focus();
            status.text('Choose name:');
        }
    };
        
    connection.onmessage = function(message) {        
        try {
            var json = JSON.parse(message.data);                        
        } catch (e) {
            console.log('Ошибка! не могу прочитать формат JSON: ', message.data);
            return;
        }
        $('.messages_box').append(message.data+'<br>');        
        return;                                   
    };
              
    $('body').on('click', '.send_msg', function(){        
        var msg = input.val();
        var sendmess = {
            "type":'message',
            "user_send":page,
            "user_from":"",
            "text":msg 
        };
        var js = JSON.stringify(sendmess);        
        connection.send(js);
    });       
    
    window.send_message = function(t, friend, msg){
        var sendmess = {
            "type":t,
            "usersend":myName,
            "userfrend":friend,
            "text":msg 
        };
        $.post('chat', sendmess, function(data){            
            connection.send(data);                
        }); 
    };     
    
    /*send_file*/    
    $('body').on('change', '#loadfilechat', function(){
        var files = this.files;   
        var furl = $('.messages').attr('id');                  
        if(files.length == 0){
            return false;
        }        
        event.stopPropagation();
        event.preventDefault();   
           
        var data = new FormData();
        $.each(files, function(key, value){
            data.append(key, value);                                
	    });        
        $.ajax({
            url : 'files',                
            type : 'POST',
            data : data,
            processData: false,
            contentType: false,
            xhr: function(){                
                $('.load-progress').attr('style', 'width: 0%;');
                $('.load-procent').html('Загрузка 0%');
                $('.progress').attr('style', 'display: block;');
                
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.addEventListener('progress', function(evt){                     
                    if(evt.lengthComputable) {
                        var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
                        $('.load-progress').attr('style', 'width: ' + percentComplete + '%;');
                        $('.load-procent').html(percentComplete + '%');                                            
                    }
                }, false);
                return xhr;
            },
            success: function(data_file){                
                $('.progress').attr('style', 'display: none;');
                $('.no_comment').remove(); 
                
                var sendmess = {
                    "type":"send_file",
                    "usersend":myName,
                    "userfrend":furl,
                    "text":data_file 
                };
                $.post('chat', sendmess, function(data){                                    
                    if(data !== '0'){
                        var sendmess = {
                            "type":"message",
                            "usersend":myName,
                            "userfrend":furl,
                            "text":data_file,
                            "file_name": true,
                            "idmsg": data 
                        };
                        var js = JSON.stringify(sendmess);                                    
                        connection.send(js);
                    }                    
                });
                                       
                $('.chat-text').html('');            
                input.attr('disabled', 'disabled');            
                if (myName === false) {myName = msg;}
                
                //MessageSend();
                $('.smile-box').attr('style', 'display:none;');
                                                            
            }                                
        }); 
    });
    
    /*write message*/
    $('body').on('keydown', '.chat-text', function(e) {     
        var b = false;
        if (e.keyCode == 13) {
            $('.chat-send-button').click();                        
        }else{            
            var ks = [9, 16, 17, 18, 20, 33, 34, 35, 36, 37, 38, 39, 40, 13];            
            for(var i=0; i<ks.length; i++){
                if(e.keyCode === ks[i]){
                    b = true;
                }
            }
            
            if(b == false){            
                var furl = $('.messages').attr('id');
                var  wst = {
                    "type": "writetext",
                    "usersend":page,
                    "userfrend":furl
                }  
                var js = JSON.stringify(wst);                        
                connection.send(js);
                b = true;
            }            
        }             
    });  
    
    
    function SendOpov(id_card, ttype){        
        var ts = ['other_type', 'like', 'comment', 'subscrib', 'frendship'];        
        var sendmess = {                
                "id_card": id_card,     
                "id_type": ttype,            
                "type":  ts[ttype]
            };            
            
            var js = JSON.stringify(sendmess);                        
            connection.send(js);
    }      
    
    $('body').on('click', '.main-tabs', function(){
        var sendmess = {
            "type":"imonline",
            "uid":myName
        };                                
        var js = JSON.stringify(sendmess);      
        $('.close-chat-button').click();      
        connection.send(js);       
    });
    
       
    
    
    $('body').on('click', '.pickup', function(){  
        var video_call = $('.videocalls-content');
        video_call.attr('style', 'display: none;');
        /*
        document.getElementById('player2').pause();
        document.getElementById('player2').currentTime = 0;
        */
        video_call.attr('style', 'display: none');          
    });
        
    setInterval(function() {
        if (connection.readyState !== 1) {
            status.text('Error');
            input.attr('disabled', 'disabled').val('Unable to comminucate '
                                                 + 'with the server.');
        }
    }, 5000);

    function strip_tags(input, allowed) {
       allowed = (((allowed || '') + '')
        .toLowerCase()
        .match(/<[a-z][a-z0-9]*>/g) || [])
        .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
      var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
      return input.replace(commentsAndPhpTags, '')
        .replace(tags, function($0, $1) {
          return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    }
    function vibration(){$('#player1').trigger('play');
        if(window.navigator && window.navigator.vibrate){navigator.vibrate(1000);}
    } 
    
    function MessageSend(){
        $('#player1').attr('src', 'loading/signal/1.mp3')
        vibration();
    }
    
    function ListUserMessangerAdd(user_page){                        
        $.ajax({
            url: 'dan_user='+user_page,
            success: function(data){                            
                var ds = JSON.parse(data);                                  
                if($('.mes #'+ds.page).length <= 0){
                    var msm = '<div class="messenger-message-box" id="'+ds.page+'">'+
                    '<div class="avatarus"><div class="echo-messenger-red state-user"></div><img src="'+ds.avatar+'" class="messenger-message-avatar"></div>'+
                    '<div class="messenger-welcome"><p class="messenger-message-user">'+ds.lastname+' '+ds.firstname+'</p>'+
                    '<p class="messenger-message-text messenger-new-message"></p></div></div>';                    
                    mes_form.append(msm);
                }
            }        
        });        
    }   
    

    function MinMessage(usersend, userfrend, text){            
        if(userfrend == page||usersend == page){            
            scr = document.querySelector('body').scrollTop;
            var pt = $('.messages').attr('id');                                               
            if(userfrend == page){
              $('#'+usersend).children('.messenger-welcome').children('.messenger-message-text').html(text);                                      
            }       
            
              
            if(usersend==pt||userfrend==pt){
                var txt = text.replace('<div><br></div>', '');
                
                var ds = '';
                if(usersend == page||userfrend == page){                    
                    $.ajax({
                        url: 'dan_user='+usersend,
                        success: function(data){                              
                            if(usersend == page){
                                var v = 'B';
                            }else{
                                var v = 'A';  
                            } 
            
                            var datetime = new Date(); 
                            var dst = (datetime.getHours() < 10 ? '0' + datetime.getHours() : datetime.getHours()) + ':'+ 
                                      (datetime.getMinutes() < 10 ? '0' + datetime.getMinutes() : datetime.getMinutes())+':'+ 
                                      (datetime.getSeconds() < 10 ? '0'+ datetime.getSeconds() : datetime.getSeconds());                  
                                       
                            ds = JSON.parse(data);
                            var msg = '<div class="chat-user">'+
                            '<div class="chat-user-time"><p>'+dst+'</p></div>'+
                            '<img class="chat-user-avatar" src="'+ds.avatar+'">'+
                            '<div class="chat-user-avatar-box"></div>'+
                            '<div class="chat-user-box'+v+'">'+
                            '<p class="chat-user-name">'+ds.lastname+' '+ds.firstname+'</p>'+
                            '<p class="chat-user-text">'+txt+'</p></div></div>';                                                     
                            content.prepend(msg);                               
                            document.querySelector('body').scrollTop = 0;//document.querySelector('body').scrollHeight;
                            MessagePost();                                                                                                                                                                                                                                                                                                                  
                        }
                    });                                                         
                }
              }                    
        }        
    }
        
    
    $('body').on('click', '.messenger-message-box, .friends-view-button, .myaccount-message-button', function(){           
        var usp = $(this).attr('id');                                               
        $.ajax({
            url: 'chat?id='+usp+"&&ns",
            success: function(data){
                document.querySelector('body').scrollTop = 0;
                $('.articles').attr('style', 'display: none;');
                $('.chat_form').html(data);
            }
        });           
    });
    
    $('body').on('click', '.close-chat-button', function(){               
        $('.articles').attr('style', 'display: block;');        
        $('.messages').attr('style', 'display: none;');        
        $('.messages-avatar').attr('src', '');
        $('.message-avatar-text').html('');
        $('.messages').attr('id', '');  
        $('.messages-box').html('');             
        //scrol(window.pst);           
        document.querySelector('body').scrollTop = window.pst;  
    });
        
//----------------------- Смайлики ---------------------------------------
    $('body').on('click', '.smiles-btn', function(){
        if($('.smile-box').attr('style') == 'display: block;'){
            $('.smile-box').attr('style', 'display: none;');
        }else{
            $('.smile-box').attr('style', 'display: block;');   
        }        
    })
    
    $('body').on('click', '.smile', function(){
        var src = $(this).attr('src');
        var t = '<img src="'+src+'" width="25">';
        var c = $('.chat-text');   
        
        c.trigger('focus');
		insertHTML(t);
    });
    
    
    function insertHTML(html) {
        try {
            var selection = window.getSelection(),
                range = selection.getRangeAt(0),
                temp = document.createElement('div'),
                insertion = document.createDocumentFragment();
                temp.innerHTML = html;

            while (temp.firstChild) {
                insertion.appendChild(temp.firstChild);
            }

            range.deleteContents();
            range.insertNode(insertion);
        } catch (z) {
            try {
                document.selection.createRange().pasteHTML(html);
            } catch (z) {}
        }
    }
    
//------------------------------------Видео-------------------------------    
    $('body').on('click', '.videocalls-close', function(){
        $('.videocalls-content').remove();
        /*
        document.getElementById('player2').pause();
        document.getElementById('player2').currentTime = 0;
        */
    });
    
    
    $('body').on('click', '.dont-call', function(){
        $('.videocalls-content').remove();
        /*
        document.getElementById('player2').pause();
        document.getElementById('player2').currentTime = 0;
        */    
        var id_call_user = $(this).attr('data');
         
        var jst = {
            "type": "dontcall",
            "calluserid": id_call_user,
            "calluserin": page
        };
        var js = JSON.stringify(jst);        
        connection.send(js);    
    });         
    
    $('body').on('click', '.video-call-button', function(){ 
        var ids = $(this).attr('data');
        var id_call_user;
        if(ids){
            id_call_user = ids;
        }else{
            id_call_user = $('.messages').attr('id');
        }                     
        var url_video = $(this).attr('href');     
        var jst = {
                "type": "calluser",
                "calluserid": id_call_user,
                "calluserin": page,
                "url": url_video
            };
                        
        var js = JSON.stringify(jst);                    
        connection.send(js);                                                                 
    });        
    
//------------------------------------------------------------------
$('body').on('click','.articles-like-icon', function(){
    $('.card-like').click();
})

$('body').on('click', '.card-like', function(){
    var id = $(this).attr('id');
    $.post('data?open_image',
    {
        "card_like": id
    }, function(data){
        var d = JSON.parse(data);
        
        $('.card-like').html(d.like_count);    
        $('.carts#'+id).children('.articles-header').children('.article-stat').children('.article-stat2').html(d.like_count);
        var jst = {
                "type": "notic",
                "userid": d.user_page,                
                "notic": d.notic_count
            };
                        
        var js = JSON.stringify(jst);                    
        connection.send(js);
    });
});


$('body').on('click', '.card-comment', function(){
   var text =  $('.text-comment').html();
   var id = $(this).attr('data');
   $.post('data?open_image',
   {
        "id_comment_card": id,
        "comment_card": text,
        "id_num_comment": 0
   }, function(data){
        $('.nocomment').remove();
        var d = JSON.parse(data);                               
        $('.myaccount-chat-box2').html(d.html);
        $('.card-comment').html(d.com_count)
        $('.text-comment').html('<div class="repl-com">Комментировать...</div>');
        $('.carts#'+id).children('.articles-header').children('.article-stat').children('.article-stat3').html(d.com_count);
        
        var jst = {
                "type": "notic",
                "userid": d.user_page,                
                "notic": d.notic_count
            };
                        
        var js = JSON.stringify(jst);                    
        connection.send(js);                
   });     
});


$('body').on('click', '.video-comment-send', function(){
   var idvideo = $(this).attr('data');
   var text_comment = $('.video-comment-text').html();
   if((text_comment !== '')||(text_comment !== '<div class="repl-com">Комментировать...</div>')){
        $.post("data?video",
        {
            "video_comment": text_comment,
            "video_com_id": idvideo
        },function(data){
            $('.nocomment').remove();
            var d = JSON.parse(data);
            var html = '<div class="chat-user"><div class="chat-user-time"><p>'+d.dt+'</p></div>'+
            '<img src="'+d.avatar+'" class="chat-user-avatar"><div class="chat-user-avatar-box"></div>'+
            '<div class="chat-user-boxB1"><p class="chat-user-name">'+d.lastname+' '+d.firstname+'</p>'+
            '<p class="chat-user-text">'+d.text+'</p></div></div>';
            $('.video-comment-list').append(html);
            $('.video-comment-text').html('<div class="repl-com">Комментировать...</div>');
            $(".article-stat3#"+d.idmd).html(d.count);                     
        }
        );
   } 
});

window.HuOnline = function()
{
    var jst = {
        "type": "huonline"        
    };
    var js = JSON.stringify(jst);                    
    connection.send(js);    
}


setInterval(function(){    
    if(pech <= 0){
        $('.writetext').css('style', 'display: none; opacity: 1;');    
        $('.printing-chat-img').remove();    
    }else{
       pech -= 1;
       $('.writetext').attr('style', 'opacity: '+pech);        
       $('.printing-chat-img').attr('style', 'opacity: '+pech);
    }        
},1000);                                                

                         
});