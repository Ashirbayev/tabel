$(function(){    
    
    var code_editor = CodeMirror.fromTextArea(
        document.getElementById("code_res"), 
        {
            mode: "text/x-plsql",
            indentWithTabs: true,
            smartIndent: true,
            lineNumbers: true,
            matchBrackets : true, 
            autofocus: true, 
            extraKeys: {
                "Ctrl-Space": "autocomplete",
                "Ctrl-Enter": "execSql"
            },
            hintOptions: {
                tables: tbls
            }
        }
    );
    
    
    $('#sql_example').click(function(){        
        var sql = code_editor.getValue();
        var params_div = $('#sql_params');
        var cols = $('#sql_cols');
        var prms = [];
        
        $.post(window.location.href, {"execSql_block":sql}, function(data){
            var j = JSON.parse(data);
            if(j.params.length !== 0){
                var html = '';
                html += '<center><h3>Список параметров</h3></center>';
                html += '<center><h4 class="text-warning">Для определения колонок необходимо забить значение в поля параметров</h4></center>';
                html += '<table class="table table-bordered">';
                html += '<thead><tr><td>Параметр в БД</td><td>Имя для показа</td><td>Тип параметра</td><td>SQL для выбора<br /><span class="text-danger">(select <b>id</b>, <b>name</b> from dual)</span></td><td>Данные для определения колонок</td></tr></thead><tbody>';
                
                $.each(j.params, function(i, p){
                    if(prms.indexOf(p) == -1){
                        prms.push(p);
                        html += '<tr>';
                        html += '<td><input class="form-control pname" value="'+p+'" readonly></td>';
                        html += '<td><input class="form-control" name="ptext_'+p+'" value=""></td>';
                        html += '<td><select class="form-control set_params" data="'+p+'" name="ptype_'+p+'"><option value="T">Текст</option><option value="D">Дата</option><option value="S">Выбор</option></select></td>';
                        html += '<td><input type="text" name="sql_'+p+'" class="form-control sql_value" value=""></td>';
                        html += '<td id="text_'+p+'"><input type="text" name="'+p+'" class="form-control params_value" value=""></td>';
                        html += '</tr>';
                    }
                });                
                html += '</tbody></table>';
                html += '<button class="btn btn-success executeSQLParams">Выполнить</button>';
                params_div.html(html);
            }
            
            cols.html('<center><h3>Список колонок</h3></center>');
            if(j.columns.length > 0){
                $.each(j.columns, function(i, p){
                    cols.append('<input type="text" class="form-control" value="'+p+'" readonly><br />');
                });
            }
            
            $('#sql_result').html(j.result);
            
        });              
    });
    
    $('body').on('change', '.set_params', function(){
       var id = $(this).attr('data'); 
       var val = $(this).val();
       if(val == 'D'){
            $('#text_'+id).html('<input type="text" name="'+id+'" class="form-control params_value" data-mask="99.99.9999" value="">');            
       }else{
            $('#text_'+id).html('<input type="text" name="'+id+'" class="form-control params_value" value="">');
       }       
    }); 
    
    $('body').on('click', '.executeSQLParams', function(){
        var sql = code_editor.getValue();
        var params = [];
        var cols = $('#sql_cols');
        $('.params_value').each(function(){
            var ss = {
                "name":$(this).attr('name'),
                "value":$(this).val(),
                "sql":$('input[name=sql_'+name+']').val()
            };          
            params.push(ss);
        });
        
        $.post(window.location.href, {"exesSQlParams":sql, "params":params}, function(data){
            var j = JSON.parse(data);
            cols.html('<center><h3>Список колонок</h3></center>');
            if(j.columns.length > 0){
                $.each(j.columns, function(i, p){
                    cols.append('<input type="text" class="form-control" value="'+p+'" readonly><br />');
                });
            }
            $('#sql_result').html(j.result);
       });
    });
    
    $('#save_examples').click(function(){
        /*Проверяем все данные*/
        var title = $('input[name=title_block]').val();
        if(title.trim() == ''){
            set_alert('Название блока не может быть пустым');
            return false;
        }
        
        var sql = code_editor.getValue();
        if(sql.trim() == ''){
            set_alert('SQL запрос не может быть пустым');
            return false;
        }
        
        var params = [];
        var cols = [];
        var txt = $('#sql_cols').html();
        if(txt.trim() == ''){
            set_alert('Не определены колонки!');
            return false;
        }
        
        $('#sql_cols').children('input').each(function(){
            cols.push($(this).val()); 
        });
        
        if($('#sql_params').html().trim() !== ''){
            var pn = $('.pname');            
            pn.each(function(){
              var id = $(this).val();
              var ttl = $('input[name=ptext_'+id+']').val(),
                  type = $('select[name=ptype_'+id+']').val(),
                  sqls = $('input[name=sql_'+id+']').val();
              if(ttl.trim() == ''){
                set_alert('Имя для показа параметра <b>'+id+'</b> пустое');
                return false;
              }
              params.push({"name":id, "title":ttl, "type":type, "sql":sqls});
            });
        }
        var id_block = $('#id_block').val();
        $.post(window.location.href, {"set_block":id_block, "title":title, "sql":sql, "cols":cols, "params":params}, function(data){            
            $('#id_block').val(data);
            alert(data);
        });
        
    });
    
    var set_alert = function(text)
    {
        $('#result').prepend('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+text+'</div>');
    }
})