$(document).ready(function(){
    
    $('.jstree1').jstree({
        'core' : {
            'check_callback' : true
        },
        'plugins' : [ 'types', 'dnd' ],
        'types' : {
            'default' : {
                'icon' : 'fa fa-folder'
            },
            'fl':{
                'icon' : 'fa fa-filter'
            },
        }
    });
    
    $('.set_filter_date').each(function(){
        var html = $(this).children('a').html();
		html = html.replace('<i class="jstree-icon jstree-themeicon fa fa-filter jstree-themeicon-custom" role="presentation"></i>', '');
		if(html == $('#filter_text').html()){
		    $("#jstree1").jstree("select_node", $(this).attr('id'));
		}
    });
    
    $('body').on('click', '.view_table', function(){
        var id = $(this).attr('data');
        var st = $('#'+id).css('display');
        if(st == 'block'){
            $('#'+id).css('display', 'none');
        }else{
            $('#'+id).css('display', 'block');
        }
    });
    
    /*
    $('.set_filter_date').mouseup(function(){        
        var html = $(this).children('a').html();
		html = html.replace('<i class="jstree-icon jstree-themeicon fa fa-filter jstree-themeicon-custom" role="presentation"></i>', '');
        var i = $("#jstree1").jstree("get_selected");
        console.log(i);
        if(i.length > 1){
            $('#filter_text').append(','+html);
        }else{
            $('#filter_text').html(html);
        }
    });
    */
    
    $('body').on('click', '.mdl', function(){
        ClickMapRegion($(this).attr('data'), $(this).attr('id'));        
    });        
});

function ClickMapRegion(data, id)
{
    var sql = data+" = '"+id+"'";
    $.post(window.location.href, {"sql":sql}, function(data){
        $('#mdl_text').html(data);
        $('#mdl_btn').click();
    })
}