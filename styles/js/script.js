var cnct;
var load_gif = true;
$(function() {  
    var body = $('body');    
    $('input[type=password]').val('');  
    
    var url = window.location.href;
    var urls = url.split('/');
    var act_url = urls[3].split('?');
    var active_li = act_url[0];
    
    $('#side-menu').children('li').each(function(){
        var b = false;
        $(this).children('ul').children('li').each(function(){            
            var a = $(this).children('a').attr('href');
            if(a == active_li){
                b = true;
                $(this).attr('class', 'active');
            }                  
        });
        if(b == true){
            $(this).attr('class', 'active');
        }
    });
      
    var dogtabs = $('#contract-tabs li');
    dogtabs.click(function(){
       cnct = $(this).children('a').attr('href');
       cnct = cnct.substr(1);       
       //history.pushState({}, '', "contracts?CNCT_ID="+cnct_id);       
       //return false;       
    });   
    
    var loading = $('#loading_pic');    
    $.ajaxSetup({        
        beforeSend: function(){
            if(load_gif){
                body.attr('style', 'opacity: 0.5;');
                loading.attr('style', 'opacity: 1;');
            }            
        },
        complete: function() {                
            body.attr('style', 'opacity: 1;');
            loading.attr('style', 'opacity: 0;display:none;');            
        }
    });
            
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
        
    // MetsiMenu
    $('#side-menu').metisMenu();        
    
    // Collapse ibox function
    body.on('click', '.collapse-link', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    body.on('click', '.close-link', function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    body.on('click', '.fullscreen-link', function() {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function() {
            $(window).trigger('resize');
        }, 100);
    });

    // Close menu in canvas mode
    body.on('click', '.close-canvas-menu', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
        $.cookie('navbar', body.attr('class'));
    });

    // Open close right sidebar
    body.on('click', '.right-sidebar-toggle', function () {
        $('#right-sidebar').toggleClass('sidebar-open');
    });

    // Initialize slimscroll for right sidebar
    $('body .sidebar-container').slimScroll({
        height: '100%',
        railOpacity: 0.4,
        wheelStep: 10
    });

    // Open close small chat
    body.on('click', '.open-small-chat', function () {
        $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
        $('.small-chat-box').toggleClass('active');
    });

    // Initialize slimscroll for small chat
    $('body .small-chat-box .content').slimScroll({
        height: '234px',
        railOpacity: 0.4
    });

    // Small todo handler
    body.on('click', '.check-link', function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // Append config box / Only for demo purpose
    // Uncomment on server mode to enable XHR calls
    
    // Minimalize menu
    body.on('click', '.navbar-minimalize', function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
        $.cookie('navbar', body.attr('class'));
    });

    // Tooltips demo
    $('body .tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    // Move modal to body
    // Fix Bootstrap backdrop issu with animation.css
    $('body .modal').appendTo("body");

    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if (navbarHeigh > wrapperHeigh) {
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if (navbarHeigh < wrapperHeigh) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
        }

    }

    fix_height();

    // Fixed Sidebar
    
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });
    

    // Move right sidebar top after scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 0 && !$('body').hasClass('fixed-nav')) {
            $('#right-sidebar').addClass('sidebar-top');
        } else {
            $('#right-sidebar').removeClass('sidebar-top');
        }
    });


    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    $("[data-toggle=popover]")
        .popover();

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    });
    
    
/*-----tabs scroll--------------*/
/*
var hidWidth;
var scrollBarWidths = 40;

var widthOfList = function(){
  var itemsWidth = 0;
  $('.list li').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
  return itemsWidth;
};

var widthOfHidden = function(){  
    console.log((($('.indented_text').outerWidth())- widthOfList()-getLeftPosi())-scrollBarWidths);
    
  return (($('.indented_text').outerWidth())- widthOfList()-getLeftPosi())-scrollBarWidths;
};

var getLeftPosi = function(){
  return $('.list').position().left;
};

var reAdjust = function(){
  if (($('.indented_text').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  }
  else {
    $('.scroller-right').hide();
  }
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show();
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	$('.scroller-left').hide();
  }
}

reAdjust();

$(window).on('resize',function(e){  
  	reAdjust();
});

$('.scroller-right').click(function() {
  
  $('.scroller-left').fadeIn('slow');
  $('.scroller-right').fadeOut('slow');
  
  $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){

  });
});

$('.scroller-left').click(function() {
  
	$('.scroller-right').fadeIn('slow');
	$('.scroller-left').fadeOut('slow');
  
  	$('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
  	
  	});
});        
    
*/


window.alert=function(txt){
    swal({
        type: "warning",
        title: "Предупреждение!",        
        text: txt        
    });
    return false;
} 
/*
$('.right-button').click(function(){
    $('.right-sidebar-toggle').click();
});


$('.spin-icon').click(function(){
   var v = $('#right-panel').css('display');
   if(v == 'block'){
        $('#right-panel').css('display', 'none');
        $('#osn-panel').attr('class', 'col-lg-12');
   }else{
        $('#right-panel').css('display', 'block');
        $('#osn-panel').attr('class', 'col-lg-10');
   }    
});     
*/     
});    

function showmodal()
{
    $.get('contracts_block', function(data){$('body').append(data);});
}