///$('.summernote').summernote();
$('#editor_content').summernote({
    toolbar: [                            
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['font', ['fontname']],
        ['view', ['fullscreen', 'codeview']]                    
    ],
    fontNames: ['Times New Roman'],
});
/*
$('.note-toolbar').each(function(){
    $(this).attr('style', 'display: none;')
})
*/

function defPosition(event) {
	var x = y = 0;
	var d = document;
	var w = window;

	if (d.attachEvent != null) { // Internet Explorer & Opera
		x = w.event.clientX + (d.documentElement.scrollLeft ? d.documentElement.scrollLeft : d.body.scrollLeft);
		y = w.event.clientY + (d.documentElement.scrollTop ? d.documentElement.scrollTop : d.body.scrollTop);
	} else if (!d.attachEvent && d.addEventListener) { // Gecko
		x = event.clientX + w.scrollX;
		y = event.clientY + w.scrollY;
	}
    console.log(x+' - '+y);
    x = x / 2 + 30;
    y = y + 10;
	return {x:x, y:y};
}


function menu(event) {
  // Блокируем всплывание события contextmenu
	event = event || window.event;
	event.cancelBubble = true;

	// Задаём позицию контекстному меню
	var menu = $('.right-menu').css({
		top: defPosition(event).y + "px",
		left: defPosition(event).x + "px"
	});

	// Показываем собственное контекстное меню
	menu.show();

	// Блокируем всплывание стандартного браузерного меню
	return false;
}
var selection, range;
$(document).on('click', '.note-editable', function() {       
    selection = window.getSelection();    	
});

$('.note-editable').on('contextmenu', function(e){
    selection = window.getSelection();
    range =  selection.getRangeAt(0)    
    return menu(e);
})


$(document).on('click', function(){
    $('.right-menu').hide();
});

$('.sets_text').click(function(){
    var b = $(this);
    var dt = b.attr('data-table');
    var dc = b.attr('data-col'); 
    var m = b.attr('data');
    insertHTML('<span class="meta" contenteditable="false" data-table="'+dt+'" data-col="'+dc+'">'+m+'</span> &nbsp;');         
});

function insertHTML(html) {         
	try {		
		var	temp = document.createElement('div'),
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


$('#editorsContent').click(function(){
    var cl = $(this).attr('class');                        
});   

$('.note-editable').children('.meta').click(function(){   
    console.log($(this).attr('data-table'));
   //$(this).addClass('active'); 
});

$('body').on('click', '.meta', function(){
    var s = $(this).hasClass('active');
    if(s == false){
        $(this).addClass('active');
    }else{
        $(this).removeClass('active');
    } 
});

$('body').on('keyup', function(e){
    var s = $('.meta.active').attr('class');
    var clas = $('#add_standart_contracts').attr('class');
    if(clas == 'modal inmodal fade in'){
        if(e.keyCode == 46){
            $('.meta.active').remove();
        }     
    }               
});

$('#new_block').click(function(){
    var s = window.location.href;
    var p = s.split('=');
    var id = p[1];
    id = id.trim();
    $.post(window.location.href, {"new_id_block":id}, function(data){
        $('input[name=POSITION]').val(data.trim());
    });
    $('.note-editable').html('');
    $('#TITLE_TEXT').val('');
    $('#id_block').val('0');
})

$('#save').click(function(){
    var 
      id = $('#id_block').val(),
      id_rep = $('#add_standart_contracts').attr('data'),
      title = $('#TITLE_TEXT').val(),
      pos_num = $('input[name=POSITION]').val(),
      position = $('#blockCount').val(),
      html = $('.note-editable').html();
      
      /*
      var st = $('.note-editable').children('div').css('mso-element', 'frame');
      if(st !== ''){
        html = $('.note-editable').children('div').html();  
      }      
      console.log(html);
      return;
        */
    
    var list_meta = [];
    $(".note-editable").find('.meta').each(function(){
        var 
            id_table = $(this).attr('data-table'),
            id_col = $(this).attr('data-col');
        
        var meta_array = {
            "id_table":id_table,
            "id_col":id_col            
        };    
        console.log(meta_array);    
        list_meta.push(meta_array);                
    });
        
    $.post(window.location.href, {
        "set_bloc_report":id_rep, 
        "id":id, 
        "title":title, 
        "pos_num":pos_num, 
        "position":position, 
        "html":html, 
        "list_meta":list_meta}, 
    function(data){
        $('.content-report').html(data);
    });
    
    $('#TITLE_TEXT').val('');
    $('input[name=POSITION]').val(''),
    $('#blockCountb').val(''),
    $('.note-editable').html('');
        
});

function edit_block(id)
{
    $.post(window.location.href, {"edit_block":id}, function(data){
       var j = JSON.parse(data);
       $('#id_block').val(j.ID);
       $('#TITLE_TEXT').val(j.NAME);
       $('input[name=POSITION]').val(j.NUM_PP);
       $('#blockCount').val(j.WIDTH_BLOCK);
       $('.note-editable').html(j.HTML_TEXT);       
    });
}


function deleteBlock(id)
{
    var ids = $('#add_standart_contracts').attr('data');
    $.post(window.location.href, {"del_block":id, "id_report":ids}, function(data){
        console.log(data);
        $('.content-report').html(data);
    });
}

window.onscroll = function() {
  var scrolled = window.pageYOffset || document.documentElement.scrollTop;
  if(scrolled > 200){
	$('.head_panel').attr('style', 'position: fixed;top: 0px;z-index: 5000;width: 87%;');
  }else{
	$('.head_panel').attr('style', '');
  }  
}