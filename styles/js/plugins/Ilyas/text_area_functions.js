    //случайный цвет
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    //убирает подсвечивание
    function showCommentFalse(id) {
        $('#' + id + '').css({
            boxShadow: '0px 0px 0px #444'
        });
    }

    //подсвечивает коммент
    function showComment(id) {
        $('#' + id + '').css({
            boxShadow: '0px 0px 10px #1ab394'
        });
    }

    //
    function saveComment() {
        var editedText = $('#partOfText').val();
        var partForComment = $('#partForComment').val();
        addCommentBlock(' редактировал: ', editedText, partForComment);
    }

    //возвращает перечеркнутый текст
    function replaceTextForStrikethrough() {
        var textForStrike = $('#partOfText').val();
        var color = getRandomColor();
        var name = $('#name').val();
        window.selectedMeta = '<strike style="color:black;">' + textForStrike + '</strike>';
        $('#partOfText').val(textForStrike);
        var c = $('.editorsContent');
        c.trigger('focus');
        insertHTML(selectedMeta);
    }

    //возвращает цвет с фоном
    function replaceTextForColor() {
        var id = 777;
        var textForStrike = $('#partOfText').val();
        var name = $('#name').val();
        window.selectedMeta = '<span onmouseover="showComment(' + id + ');" onmouseout="showCommentFalse(' + id + ');" style="background-color: red">' + textForStrike + '</span>';
        $('#partOfText').val(textForStrike);
        var c = $('.editorsContent');
        c.trigger('focus');
        insertHTML(selectedMeta);
    }

    //добавляет комментарий
    function addComment() {
        var txt = '';
        if (window.getSelection) {
            txt = window.getSelection();
            $('#partOfText').val(txt);
            var theParent = txt.getRangeAt(0).deleteContents();
        } else if (document.getSelection) {
            txt = document.getSelection();
            alert(txt);
            var theParent = txt.getRangeAt(0).deleteContents();
        } else if (document.selection) {
            txt = document.selection.createRange().text;
            $('#partOfText').val(txt);
            var theParent = txt.getRangeAt(0).deleteContents();
        }
        var theParent = txt.getRangeAt(0).deleteContents();
        replaceTextForColor();
    }

    //вставляет определенный элемент после каретки
    function insertHTML(html) 
    {
        try 
        {
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
        } 
            catch (z) 
        {
            try {
                document.selection.createRange().pasteHTML(html);
            } catch (z) {}
        }
    }

    //добавляет блок комментария
    function addCommentBlock(functionWithText, editedText, comment) {
        Data = new Date();
        //document.write(Data);
        var name = $('#name').val();
        $('#comments_list').append('<div class="social-footer" id="777">' +
            '<div class="social-comment">' +
            '<a href="#" class="pull-left">' +
            '</a>' +
            '<div class="media-body">' +
            ' <a href="#">' +
            name +
            '</a>' +
            functionWithText +
            '<span style="color: black;">' + editedText + '</span>' +
            '<br/>' +
            '<div class="hr-line-dashed"></div>' +
            '<div class="media-body">' +
            '<textarea autofocus class="form-control" id="partForNewCommentAns" placeholder="Write comment..."></textarea>' +
            '</div>' +
            '<br/>' +
            '<small class="text-muted">' + Data + '</small>' +
            '<button class="btn btn-white btn-xs"><i class="fa fa-share"></i>Добавить комментарий</button>' +
            '</div>' +
            '</div>' +
            '</div>')
    }
    
    //возвращает предыдущий символ
    function getLastChar() {
        var range = window.getSelection().getRangeAt(0);
        text = range.startContainer.textContent.substring(0, range.startOffset);
        word = text.split(/\b/g).pop();
        var last_simb = text.substr(-1);
        return last_simb;
    }
    
    //показывает кнопку добавления коммента
    function show_comment_btn(e){
        var $txt = '';
        $('.note-current-color-button').click();
            check_color("white");
            var xPos = e.pageX - 23;
            var yPos = e.pageY - 20;
            if (window.getSelection) {
                $txt = window.getSelection();
            } else if (document.getSelection) {
                $txt = document.getSelection();
            } else if (document.selection) {
                $txt = document.selection.createRange().text;
            } else return;
            if ($txt != '') {
                $('#popUpBox').css({
                    'display': 'block',
                    'left': e.pageX + 0 + 'px',
                    'top': e.pageY + 0 + 'px'
                });
            }
    }
    
    //скрывает кнопку добавления коммента
    function hide_comment_btn(){
        $('#popUpBox').css
        ({
            'display': 'none'
        });
    }
    
    //нажатие на кнопку добавления коммента
    function comment_function(){
        var $txt = '';
        $('#replytext').val($txt);
        addComment();
        saveComment();
    }
    
    //выбираем цвет фона текста
    function check_color(color){
        $('.summernote').summernote();
        $(".summernote").summernote("backColor", color);
        console.log('color checked '+color);
    }

    $('#editorsContent').bind("mouseup", function(e) {
        show_comment_btn(e);
    });

    $(document).bind("mousedown", function() {
        var $txt = '';
        hide_comment_btn();
    });

    $('#popUpBox').bind("mousedown", function() {
        comment_function();
    });

    $(document).ready(function() {
        check_color("white");
    });
    var edit = function() {
        $('.click2edit').summernote({
            focus: true
        });
    };
    var save = function() {
        var aHTML = $('.click2edit').code();
        $('.click2edit').destroy();
    };
    
    $('#editorsContent').on('click',function(e) {
        getLastChar();
        check_color("white");
    });
    
    var i = 1;
    
    $(document).ready(function() {
        $(".editorsContent").keydown(function(e) {
            //выбираем цвет фона текста
            check_color("white");
            //если backspace или delete
            if (e.which == 8 || e.which == 46) 
            {
                var txt = window.getSelection();
                //если чтото выделено
                if(txt.anchorOffset == 0)
                {
                    check_color("red");
                    e.preventDefault();
                }
                //если ничего не выделено
                else
                {
                    //при нажатии на delete отменяем действие
                    if(e.which == 46){
                        e.preventDefault();
                    }
                    //при нажатии на backspace
                    else
                    {
                        var range = window.getSelection().getRangeAt(0);
                        text = range.startContainer.textContent.substring(0, range.startOffset);
                        var last_simb = getLastChar();
                        //если пробел
                        if(last_simb == ' ')
                        {
                            insertHTML('-');
                        }
                            else
                        {
                            var deleteKeyCode = 8,
                            value = $(this).val(),
                            length = value.length,
                            lastChar = value.substring(length, length);
                            insertHTML('<strike style="color: black; background-color: red;">' + last_simb + '</strike>');
                        }
                    }
                }
                if (window.getSelection) {
                    $('#partOfText').val(txt);
                    var theParent = txt.getRangeAt(0).deleteContents();
                } else if (document.getSelection) {
                    $('#partOfText').val(txt);
                    var theParent = txt.getRangeAt(0).deleteContents();
                } else if (document.selection) {
                    $('#partOfText').val(txt);
                    var theParent = txt.getRangeAt(0).deleteContents();
                }
                var theParent = txt.getRangeAt(0).deleteContents();
                replaceTextForStrikethrough();
                $('#deleteFragment').click();
                $('#partOfText').val(txt);
            }
            //остальные кнопки
            else
            {
                check_color("red");
                var txt = window.getSelection();
                //если чтото выделено\
                console.log('i '+i);
                i++;
                if(txt.anchorOffset == 0)
                {
                    console.log('чтото выделено');
                    var code = e.which ? e.which : e.keyCode;
                    var simb = console.log( String.fromCharCode(code) );
                    var txt = window.getSelection();
                    $('#deleted_text').val(txt);
                    var txt_from_div = $('#deleted_text').val();
                    if(i>1){
                        //insertHTML('<strike style="color: black;">'+txt_from_div+'</strike>');
                    }
                    //insertHTML('<strike style="color: black;">'+txt+'</strike>');
                }
            }
        });
    });
    
    