$(function(){
    /*
    $('.ibox-title').click(function(){
        var toggle = $(this).attr('data-toggle'); 
        if(toggle == 'false'){
            return false;
        }
            var ibox = $(this).closest('div.ibox');
            var button = $(this).find('i');
            var content = ibox.find('div.ibox-content');
            content.slideToggle(200);
            button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
            ibox.toggleClass('').toggleClass('border-bottom');
            setTimeout(function () {
                ibox.resize();
                ibox.find('[id^=map-]').resize();
                }, 
            50);        
    })
    */
    
    
    
    var body = $('body');    
    
    body.on('click', '.input-group.date', function(){
        $(this).datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
    });
    
    
    function setHtml(text){$('#result').html(text);}
    
    body.on('click', '.btn_href', function(e){
        e.preventDefault();
        var get = $(this).attr('href');        
        //var url = window.location.href+'?'+get;
        if(get == '#'){
            return;
        }else{
            $.get(get, function(data){setHtml(data);}); 
        }
    });
    
    body.on('click', 'input', function(e){
        var type = $(this).attr('type');
                                
        if(type == 'submit'){
            e.preventDefault();
            var id = $(this).attr('data');
            var res_div = $(this).attr('data-result');
            $.post('bi', $('#'+id).serialize(), function(data){
                if(res_div !== ''){
                    $('#'+res_div).html(data);
                }else{
                    setHtml(data);
                }
            });
        }        
    });
    
    body.on('click', '.btn_reports', function(){
        $('.btn_reports').each(function(){
            $(this).removeClass('active');
        });
        $(this).addClass('active');
    });
    
    body.on('click', '#edit_report', function(){
        var id = $('.btn_reports.active').attr('data');
        if(id == '')return;
        $.get('bi?edit_report='+id, function(data){setHtml(data);});
    });        


/**********************************************************************/

    var chart = 0;
    var active_table;
    var active_cell;
    
    body.on('click', '.set_chart', function(){
        chart = $(this).attr('id');    
        $('.set_chart').removeClass('btn-danger');
        $('.set_chart').removeClass('btn-info');    
        $('.set_chart').addClass('btn-info');
        $(this).removeClass('btn-info');
        $(this).addClass('btn-danger');
        //$('#tab2').click();
    });
    
    function uniqId() {
      return Math.round(new Date().getTime() + (Math.random() * 100));
    }
    
    body.on('click', '#set_table', function(){
        var col = $('#columns').val(); 
        var row = $('#rows').val();
        var id = uniqId();
        
        if(col == ''){
            alert('Количество колонок не может быть пустым');
            return false;
        }
        
        if(row == ''){
            alert('Количество строк не может быть пустым');
            return false;
        }
        
        $.post(window.location.href, {"cols":col, "rows":row, "create_table":id}, function(data){
            $('.list_tables').append(data);
            $('.close').click();
        });              
    });
    
    body.on('click', '#exesSql', function(){
        var params = {};
        var sql = sql_editor.getValue();
        $.post(window.location.href, {"proverka_sql":sql}, function(data){
            var j = JSON.parse(data);
            if(j.params.length > 0){
                $('#list_params_sql_exec').html(j.html);
                $('.modal_sql_params').click();
            }else{
                $.post('bi', {"execSql":j.sql}, function(data){
                    $('#sql_result').html(data);
                });
            }
        });        
    });  
    
    body.on('click', '#set_table_sql', function(){
        var sql = sql_editor.getValue();
        var id = uniqId();
        var type = $(this).attr('data');
        $.post(window.location.href, {"set_table_sql":sql, "id":id, "type":type}, function(data){
            //console.log(data);
            var j = JSON.parse(data);
            $('.list_tables').append(j.html);
            $('#tab-3').children('.panel-body').html('<form id="form_'+id+'" method="post">'+j.params+'</form>');
            $('.close').click();
        })
    });
        
    body.on('change', '.set_params_sql_text', function(){
       var id = $(this).attr('data'); 
       var val = $(this).val();
       switch(val){
          case 'D':             
            $('#set_value_div_'+id).html('<label>Значение</label><input type="text" class="form-control" name="value['+id+']" data-mask="99.99.9999"/>');
            $('.sqltext#'+id).attr('readonly', 'true');
            $('.sqltext#'+id).val('');
            break;
          case 'S':            
            $('#set_value_div_'+id).html('<label>Значение</label><select class="form-control" name="value['+id+']"></select>');
            $('.sqltext#'+id).removeAttr('readonly');
            break;
          default:             
            $('#set_value_div_'+id).html('<label>Значение</label><input type="text" class="form-control" name="value['+id+']"/>');
            $('.sqltext#'+id).attr('readonly', 'true');
            $('.sqltext#'+id).val('');
       }
    });
    
    body.on('click', '.execute_sql', function(){        
        $.post(window.location.href, $('.form_execute_sql').serialize(), function(data){
            //console.log(data);
            var j = JSON.parse(data);                        
            $('#sql_result').html(j.table);            
            $('#tab-3').children('.panel-body').html(j.params);
            $('#sql_params_set div div div').children('.close').click();
            $('#list_params_sql_exec').html('');            
        })
    });
    
    body.on('click', '.set_value_exes_sql', function(){
        var id = $(this).attr('id');
        var sql = $('.sqltext#'+id).val();
        if(sql == ''){
            alert('SQL запрос не может быть пустым!');
            return;
        }else{
            $.post(window.location.href, {"exesSQLJSON":sql}, function(data){
                var j = JSON.parse(data);
                //console.log(j);
                $.each(j, function(i, e){
                    $('#set_value_div_'+id).children('select').append('<option value="'+e.ID+'">'+e.NAME+'</option>');
                });
            });
        }
    })
    
    var input_text = function(id){
        return '<input type="text" name="'+id+'" class="form-control input_sql_params" value="" />';
    }
    var input_date = function(id){
        return '<div class="input-group date">'+
        '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>'+
        '<input type="text" name="'+id+'" class="form-control  input-sm" data-mask="99.99.9999" value=""></div>';
    }
    
    var input_select = function(id){
        return '';
    }
        
    body.on('click', '.table', function(){
        active_table = $(this).attr('id');
        //console.log(active_table);
    });
    
    body.on('click', '.cr', function(){
        active_cell = $(this).attr('id');
        //console.log(active_cell);
    });    
    
    body.on('click', '.delete', function(){
        var id = $(this).attr('data');
        $('#'+id+'.panel_table').remove();
        $('#tab-3').children('.panel-body').html('');
    });
      
    body.on('click', '.block_col', function(){
        var s = active_cell.split(':');
        s = s[0].substr(1);
        
        var cl = $('#'+active_table+' thead tr td.c'+s).hasClass('danger');
        //console.log(cl);
        if(cl){
            $('#'+active_table+' thead tr td.c'+s).removeClass('danger');
        }else{
            $('#'+active_table+' thead tr td.c'+s).addClass('danger');    
        }    
    });
    body.on('click', '.align_center', function(){
        $('.cr').each(function(i, e){
            if($(this).attr('id') == active_cell){
                $(this).css('text-align', 'center');
            }
        });
    });
    
    body.on('click', '.align_left', function(){
        $('.cr').each(function(i, e){
            if($(this).attr('id') == active_cell){
                $(this).css('text-align', 'left');
            }
        });
    });
    
    body.on('click', '.align_right', function(){
        $('.cr').each(function(i, e){
            if($(this).attr('id') == active_cell){
                $(this).css('text-align', 'right');
            }
        });    
    });
    
    /*
    $(document).ready(function() {
      $('table.highchart')
      .bind('highchartTable.beforeRender', function(event, highChartConfig) {    
        highChartConfig.colors = ['#146f57', '#7c2727', '#104c4c', '#CCFFFF', '#00CCCC', '#3399CC'];
      })
      .highchartTable();
    });
    */
    
    
    function getParams(id)
    {        
        var params = {};
        if($('body').is('#form_'+id)){
            $('input[name=getParams]').remove();
            $('#form_'+id).append('<input type="hidden" name="getParams" />');
            $.post(window.location.href, $('#form_'+id).serialize(), function(data){
                params = JSON.parse(data);
                $('input[name=getParams]').remove();
                return params;
            });
        }else{
            return params;
        }
    }
    
    body.on('click', '.view_result', function(){
        $('#panel_result').html('');
        var id_chart = 0;        
        $('.set_chart').each(function(){
            if($(this).hasClass('btn-danger')){
                id_chart = $(this).attr('id');
            }
        });
        $('.panel_table').each(function(){
            var id = $(this).attr('id');            
            var sql = $(this).children('.others_dan').children('.sql_text_area').val();
			var thead = [];
            var tbody = [];
            
            $('#T'+id+' thead tr').each(function(){
                var tr = [];
                $(this).children('td').each(function(){
                    var d = $(this).attr('id');
                    var p = d.split(':');
                    var block = false;
                    if($(this).hasClass('danger')){
                        block = true;
                    }                    
                    var td = {
                        "col":p[0],
                        "row":p[1],
                        "block":block,
                        "text":$(this).html(),
                        "style":$(this).attr('style'),
                        "colspan":"0",
                        "rowspan":"0"
                    };
                    tr.push(td);                    
                });
                thead.push(tr);
            });
            
            $('#T'+id+' tbody tr').each(function(){
                var tr = [];
                $(this).children('td').each(function(){
                    var d = $(this).attr('id');
                    var p = d.split(':');
                    var block = false;
                    if($(this).hasClass('danger')){
                        block = true;
                    }                    
                    var td = {
                        "col":p[0],
                        "row":p[1],
                        "block":block,
                        "text":$(this).html(),
                        "style":$(this).attr('style'),
                        "colspan":"0",
                        "rowspan":"0"
                    };
                    tr.push(td);                    
                });
                tbody.push(tr);
            });
                        
            
            var parameters = '';
            
            if($('body').has('#form_'+id).length > 0){
                parameters = $('#form_'+id).serializeArray();//decodeURIComponent($('#form_'+id).serialize());
            }
            var view_table = $('#view_table_check').prop('checked');
            var id_block = $('#id_block').val();
            var res = {
				"id":id,
                "id_block":id_block,
            	"chart":id_chart,
            	"sql":sql,
                "params": parameters,
                "dont_view_table":view_table,
            	"table":{
					"thead":thead,
					"tbody":tbody
				}                
            }
                        
            var rst = JSON.stringify(res);            
			$.post(window.location.href, {"view_result_chart":rst}, function(data){
                //console.log(data);
            	$('#panel_result').html(data);
        	})                    
        });
    });

    
    body.on('click', '.save_result', function(){
        var id_report = $('.btn_reports.active').attr('data');
        var data = $('input[name=save_result_chart_block]').val();
        var size_panel = $('.size_block.active').attr('data');
        
        if(data == undefined){
            alert('Нажмите кнопку "Показать отчет"');
            return false;
        }
        
        var j = JSON.parse(data);
        var return_dan = {
            "save_block_report":id_report,
            "size_panel_report":size_panel,
            "data":j
        }         
        $.post(window.location.href, return_dan, function(data){
            var j = JSON.parse(data);
            if(j.id == '0'){
                alert('Что то пошло не так!');
                return false;
            }
            $('.btn_href.active').click();            
        })
        //result_dan_array = get_json_table();
    });
    
    body.on('click', '.size_block', function(){
        var lg = $(this).attr('data');
        $('#panel_result').attr('class', 'col-lg-'+lg);
        $('.size_block').removeClass('active');
        $(this).addClass('active');   
        if($('#panel_result').html() !== ''){
            $('.view_result').click();
        }     
    })
    
    var sqls_list_params = {};
    
    body.on('click', '.sql_lists', function(){
        var id_cell = active_cell;
        $.post(window.location.href, {"get_blocks_sql":""}, function(data){            
            var j = JSON.parse(data);
            sqls_list_params = j;
            var html = '<option value="0">--Не выбрано</option>';
            $.each(j.block, function(i, e){
                html += '<option value="'+e.ID+'">'+e.TITLE+'</option>';
            });
            
            $('#sql_blocks_lists').html(html);
        });
    });
    
    body.on('change', '#sql_blocks_lists', function(){
        var id = $(this).val();
        $.each(sqls_list_params.block, function(i, e){
            //console.log(e);            
            if(e.ID == id){                
                $('#sql_blocks_sqls').html('select sum(colname) summa from ({%'+e.ID+'%}) where colname = 1');
                $('#sql_blocks_cols').html('');
                $.each(e.cols, function(y, c){
                    $('#sql_blocks_cols').append('<input type="text" class="form-control block_columns" value="'+c.NAME+'" readonly/>');
                })
                $('#sql_block_vls').css('display', 'block');
                $('#sql_blocks_sqls').css('height', $('#sql_blocks_cols').css('height'));
                $('#sql_block_sql_text').html(e.SQL);
            }            
        });
    });
    
    body.on('click', '#view_sql_text_block', function(){
        var ds = $('#sql_block_sql_text').css('display');
        if(ds == 'none'){
            $('#sql_block_sql_text').css('display', 'block');
        }else{
            $('#sql_block_sql_text').css('display', 'none');
        }
    })
    
    
    body.on('click', '#set_from_sql_block', function(){
        var t = active_table;
        var c = active_cell.replace(':', '.');
        var sql = $('#sql_blocks_sqls').val();
        $('.'+c).html('{&'+sql+'&}');
        $('.close').click();
    });
    
    body.on('click', '#view_table', function(){
        var ds = $('#panel_result').children('table').attr('style');
        if(ds == undefined){
            $('#panel_result').children('table').attr('style', 'display: none;');
        } 
        if(ds == 'display: none;'){
            $('#panel_result').children('table').removeAttr('style');
        }
        
        if(ds == 'display: block;'){
            $('#panel_result').children('table').attr('style', 'display: none;');
        }
    });
    
    body.on('click', '#view_table_rest', function(){
        var id = $(this).attr('data');
        console.log(id);
        var ds = $('.'+id).css('display');
        if(ds == 'none'){
            $('.'+id).css('display','block');
        }else{
            $('.'+id).css('display','none');        
        } 
    });
    
})

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
    //console.log(x+' - '+y);
    x = x / 2 + 30;
    y = y + 10;
	return {x:x, y:y};
}

var result_dan_array;

function get_json_table()
{
    var table = $('.edit_table').children('table');     
        
    var tr_head = [];
    $('.edit_table thead tr').each(function(i, e){
        var trd = [];
        $(this).children().each(function(){
            trd.push({
                "type":this.localName,
                "id":this.id,
                "class":this.className,
                "style":$(this).attr('style'),
                "value":this.innerHTML,
                "sql":""                
            });	
        });  
        tr_head.push({
    	   "tr":trd
        });
    });
    
    var tr_body = [];
    $('.edit_table tbody tr').each(function(i, e){
        var trd = [];
        $(this).children().each(function(){
            trd.push({
                "type":this.localName,
                "id":this.id,
                "class":this.className,
                "style":$(this).attr('style'),
                "value":this.innerHTML,
                "sql":""                
            });	
        });  
        tr_body.push({
    	   "tr":trd
        });
    });
    
    var sql = '';
    if($('.sql_text_area').length > 0){
        var id_t = table.attr('id').substr(1);
        sql = $('#'+id_t+'.sql_text_area').val();
    }
    
    var id_chart = 0;
    $('.set_chart').each(function(){
        if($(this).hasClass('btn-danger')){
            id_chart = $(this).attr('id');
        }
    });
    
    var t_json = { 
        "table":{
            "others":{
                "id":table.attr('id'),
                "class":table.attr('class'),
                "style":table.attr('style'),            
                "sql":sql,
                "params":""   
            },
            "thead":tr_head,
            "tbody":tr_body
        },
        "chart":id_chart,
        "javascript":""
    };    
    return t_json;    
}