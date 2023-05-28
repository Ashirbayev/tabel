<div class="row">
    <div class="col-lg-12" id="osn-panel">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Добавить блок</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-primary btn-sm" data-toggle="modal" onclick='edit_block(0);' data-target="#add_standart_contracts"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-report">
        <?php
            $i = 0;
            foreach($danBlockWithSicid as $k => $v)
            {
                if($i == 0)
                {
                    echo '<div class="col-lg-12"></div>';
                }
                echo report_blocks($v['ID'], $v['NUM_PP'], $v['ID_OTCHET'], $v['POSITION'], $v['TITLE'], $v['HTML_TEXT']);
                $i += $v['NUM_PP'];
                if($i >= 12){$i = 0;}
            }
        ?>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="add_standart_contracts" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" style="float: left; left: 18%;">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span><span class="sr-only">Close</span></button>
                <div id="closeModal"><h4 class="modal-title">Форма добавления блока документа</h4></div>
                <small class="font-bold"></small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="text" class="form-control" name="TITLE_TEXT" id="TITLE_TEXT" placeholder="Название заголовка"/>
                    </div>                               
                    <div class="col-lg-6">         
                        <h4>Номер строки / позиции</h4>
                        <input type="number" class="form-control" name="POSITION"/>
                    </div>
                    <div class="col-lg-6">
                        <h4>Количество блоков на строке</h4>
                        <select class="select2_demo_1 form-control" name="NUM_PP" id="blockCount">
                            <option value="6">На пол строки</option>
                            <option value="12">На всю строку</option>                            
                        </select>
                    </div>                
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content no-padding editorsContent">
                        <div id="editor_content" class="summernote">
                        </div>
                    </div>
                </div> 
            </div>
            
            <div class="modal-footer">
                <input type="hidden" name="id_other" value="0"/>
                <button id="save" class="btn btn-success" data-dismiss="modal">Сохранить</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>                
            </div>                        
        </div>        
    </div>
</div>

<script>
$(document).ready(function()
{
    $('#editor_content').summernote
    ({
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
        fontNames: [
        'Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
        'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande',
        'Sacramento'
            ],
    });
    $('input[name=POSITION]').val('1');

    $('#save').click(function()
    {
        var pst = 
        {
            "HTML_TEXT": $('.note-editable').html(),
            "POSITION":$('input[name=POSITION]').val(),
            "NUM_PP":$('#blockCount').val(),
            "TITLE": $('#TITLE_TEXT').val(),
            "ID": $('input[name=id_other]').val()
        }
        var url = window.location.href;
        alert(url);
        $.post(url, {pst}, function(data)
        {
            $('.content-report').html(data);
            $('.note-editable').html('');
            $('#TITLE_TEXT').val('');
            $('input[name=id_other]').val('0');
        });                       
    });
});

$(document).ready(function()
{
    var t = document.getElementById('inputTextArea');
    var pos = $('input[name=position]:checked').val();
    var lang =  $('input[name=lang]:checked').val();
    $('#numberOfRows').change(function()
    {
        window.colcount = $('#blocksCount option:selected').val();
        console.log(colcount);
        window.numberOfRows = $('#numberOfRows option:selected').val();
        console.log(numberOfRows);
        window.lang = $('input[name=lang]:checked').val();
        console.log(lang);
    })
})

function deleteBlock(id)
{
    $.post('standart_contracts', {"deleteDocid": id},function(d)
    {
        console.log(d);
        alert('Блок удален! Обновите страницу');
    });
};

$('.del').click(function()
{
    var id = $(this).attr('data');
    console.log(id);    
});

function edit_block(ids)
{
    console.log(ids);
    var url = window.location.href;
    $.post(url, {"id_block": ids}, function(data)
    {
       var s = JSON.parse(data);

       $('.note-editable').html(s.HTML_TEXT);
       $('input[name=POSITION]').val(s.POSITION);
       $('#blockCount').val(s.NUM_PP);
       $('#TITLE_TEXT').val(s.TITLE);
       $('input[name=id_other]').val(ids); 
    });
}

function editBlockFunc(id, numPPedit, positionNum, editTitle)
{
    console.log('htmlEditorContentParam');
    $('#editModalId').val(id);
    $('#editTITLE_TEXT').val(editTitle);
    $("#editPOSITION [value='"+positionNum+"']").attr("selected", "selected");
    $("#editNUM_PP [value='"+numPPedit+"']").attr("selected", "selected");
    var blockId = id;
    $.post
    ('standart_contracts', {"blockId": blockId},
        function(d)
        {
            $('#editorsEditContent').html(d);
            $('#edittextAreaForDB').html(d);
        }
    )
}
</script>
