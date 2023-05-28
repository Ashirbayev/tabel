<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>АИС Кадры - система управления кадрами</title>

        <link href="styles/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="styles/font-awesome/css/font-awesome.css" rel="stylesheet"/>
        <link href="styles/css/plugins/sweetalert/sweetalert.css" rel="stylesheet"/>
        <link href="styles/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"/>
        <link href="styles/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet"/>
        <link href="styles/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet"/>
        <link href="styles/css/plugins/iCheck/custom.css" rel="stylesheet"/>
        <link href="styles/css/plugins/chosen/chosen.css" rel="stylesheet"/>
        <link href="styles/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>
        <link href="styles/css/plugins/cropper/cropper.min.css" rel="stylesheet"/>
        <link href="styles/css/plugins/switchery/switchery.css" rel="stylesheet"/>
        <link href="styles/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet"/>
        <link href="styles/css/plugins/nouslider/jquery.nouislider.css" rel="stylesheet"/>
        <link href="styles/css/plugins/datapicker/datepicker3.css" rel="stylesheet"/>
        <link href="styles/css/plugins/ionRangeSlider/ion.rangeSlider.css" rel="stylesheet"/>
        <link href="styles/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css" rel="stylesheet"/>
        <link href="styles/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet"/>
        <link href="styles/css/plugins/clockpicker/clockpicker.css" rel="stylesheet"/>
        <link href="styles/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet"/>
        <link href="styles/css/plugins/select2/select2.min.css" rel="stylesheet"/>
        <link href="styles/css/animate.css" rel="stylesheet"/>
        <link href="styles/css/style.css" rel="stylesheet"/>

        <script src="styles/js/jquery-2.1.1.js"></script>
        <script src="styles/js/bootstrap.min.js"></script>
        <script src="styles/js/others/jquery.cookie.js"></script>

    </head>

<body class="gray-bg back-change">
    <div class="middle-box loginscreen animated fadeInDown">
        <div class="text-center">
            <a href="/">
                <img src="../styles/img/logo.png"/>
            </a>
        </div>
        <form method="POST">
            <div class="form-group">
                <input disabled="" hidden="" class="form-control" value="KazImpex"/>
                <input style="display: none;" hidden="" class="form-control" name="company_id" value="10"/>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Почта" name="email"/>
            </div>
            <div class="form-group">
                <input onblur="check_old_pass();" onkeyup="return checkPassword(this);" id="new_pass" type="password" class="form-control" placeholder="Новый пароль" required=""/>
            </div>
            <div class="form-group">
                <input onblur="check_old_pass();" onkeyup="return checkPassword(this);" id="new_pass2" type="password" class="form-control" placeholder="Повторите пароль" name="password" required=""/>
            </div>
            <button id="change_pass_btn" disabled="" type="submit" class="btn btn-primary block full-width m-b"> Зарегистрироваться </button>
        </form>
        <p class="m-t text-center "> <small>Пароль защищен политикой безопасности</small> </p>
        <div class="col-lg-12">
            <fieldset>
                <div id="same_pass" class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox" class="checkcheck" class="checkcheck"/><label for="checkbox2">Пароли совпадают</label>
                </div>
                <div id="pass_lenght" class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox" class="checkcheck"/><label for="checkbox2">Не менее 8 символов</label>
                </div> 
                <div id="upper_case" class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox" class="checkcheck"/><label for="checkbox2"> Не менее одного символа в верхнем регистре</label>
                </div>
                <div id="numbers" class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox" class="checkcheck"/><label for="checkbox2"> Не менее 1 цифры (0 - 9)</label>
                </div>
                <div id="specials" class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox" class="checkcheck"/><label for="checkbox2"> Не менее 1 спецсимвола (!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~)</label>
                </div>
            </fieldset>
        </div>
        <p class="text-muted text-center"><small>Уже есть аккаунт?<a href="login"> просто войдите</a></small></p>
        <p class="m-t text-center"> <small>Разработано LetSoft.art &copy; 2018</small> </p>
</div>
<script>
    $('.checkcheck').change
    (
        function(){
            check_checkbox();
        }
    )

    function check_checkbox()
    {
        var i = 0;
        $('.checkcheck').each(function(){if($(this).prop("checked")){
            i++;            
        }});
        
        if(i == 5){
            $('#change_pass_btn').removeAttr('disabled');
        }else{
            $('#change_pass_btn').attr('disabled','disabled');
        }
    }

    function check_old_pass()
    {
        check_checkbox();
        var new_pass1 = $('#new_pass').val();
        var new_pass2 = $('#new_pass2').val();
        console.log(new_pass1+' '+new_pass2);
        check_checkbox();
        if(new_pass1 != '' && new_pass2 != ''){
            if(new_pass1 == new_pass2){
                $('#same_pass').html('<input type="checkbox" class="checkcheck" checked=""/><label for="checkbox2">Пароли совпадают</label>');
            }else{
                $('#same_pass').html('<input type="checkbox" class="checkcheck"/><label for="checkbox2">Пароли совпадают</label>');
            }
        }else{
             $('#same_pass').html('<input type="checkbox" class="checkcheck"/><label for="checkbox2">Пароли совпадают</label>');
        }
    }

    function check_lenght()
    {
        check_checkbox();
        var new_pass1 = $('#new_pass').val();
        if(new_pass1.length >= 8){$('#pass_lenght').html('<input type="checkbox" class="checkcheck" checked=""/><label for="checkbox2">Не менее 8 символов</label>')}
        else{$('#pass_lenght').html('<input type="checkbox" class="checkcheck"/><label for="checkbox2">Не менее 8 символов</label>')}
    }

    function checkPassword(form) 
    {
        check_old_pass();
        check_lenght();
        var password = $('#new_pass').val(); // Получаем пароль из формы
        var s_letters = "qwertyuiopasdfghjklzxcvbnmабвгдеёжзийклмнопрстуфхцчшщъыьэюяәіңғүұқө"; // Буквы в нижнем регистре
        var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNMАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯӘІҢҒҮҰҚӨ"; // Буквы в верхнем регистре
        var digits = "0123456789"; // Цифры
        var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы
        var is_s = false; // Есть ли в пароле буквы в нижнем регистре
        var is_b = false; // Есть ли в пароле буквы в верхнем регистре
        var is_d = false; // Есть ли в пароле цифры
        var is_sp = false; // Есть ли в пароле спецсимволы
        $('#specials').html('<input type="checkbox" class="checkcheck" id="inlineCheckbox2" value="option1"/>');
        $('#upper_case').html('<input type="checkbox" class="checkcheck"/><label for="checkbox2"> Не менее одного символа в верхнем регистре</label>');
        $('#numbers').html('<input type="checkbox" class="checkcheck" id="inlineCheckbox2" value="option1"/>');
        for (var i = 0; i < password.length; i++) {
          /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
          if (!is_b && b_letters.indexOf(password[i]) != -1) {is_b = '<input type="checkbox" class="checkcheck" checked=""/><label for="checkbox2"> Не менее одного символа в верхнем регистре</label>';}
          else if (!is_d && digits.indexOf(password[i]) != -1) {is_d = '<input type="checkbox" class="checkcheck" checked=""/><label for="checkbox2"> Не менее 1 цифры (0 - 9)</label>';}
          else if (!is_sp && specials.indexOf(password[i]) != -1) {is_sp = '<input type="checkbox" class="checkcheck" checked=""/><label for="checkbox2"> Не менее 1 спецсимвола (!"#$%&()*+,-./:;<=>?@[\]^_`{|}~)</label>';}
        }
        var text = is_b+' '+is_d+' '+is_sp;
        $('#specials').html(is_sp);
        $('#upper_case').html(is_b);
        $('#numbers').html(is_d);
        if(is_sp == false){$('#specials').html('<input type="checkbox" class="checkcheck"/><label for="checkbox2"> Не менее 1 спецсимвола (!"#$%&()*+,-./:;<=>?@[\]^_`{|}~)</label>')}
        if(is_b == false){$('#upper_case').html('<input type="checkbox" class="checkcheck" /><label for="checkbox2"> Не менее одного символа в верхнем регистре</label>')}
        if(is_d == false){$('#numbers').html('<input type="checkbox" class="checkcheck"/><label for="checkbox2"> Не менее 1 цифры (0 - 9)</label>')}
        
        console.log(text); // Выводим итоговую сложность пароля
        return false; // Форму не отправляем
    }
</script>

</body>
</html>
    <script src="styles/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="styles/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="styles/js/plugins/pace/pace.min.js"></script>
    <script src="styles/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="styles/js/script.js"></script>
    <script src="styles/js/inspinia.js"></script>   
    <script src="styles/js/others/mail.js"></script>
    <script src="styles/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="styles/js/inspinia.js"></script>
    <script src="styles/js/plugins/pace/pace.min.js"></script>
    <script src="styles/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="styles/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="styles/js/plugins/jsKnob/jquery.knob.js"></script>
    <script src="styles/js/plugins/jasny/jasny-bootstrap.min.js"></script>
    <script src="styles/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="styles/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="styles/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="styles/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
    <script src="styles/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="styles/js/plugins/nouslider/jquery.nouislider.min.js"></script>
    <script src="styles/js/plugins/switchery/switchery.js"></script>
    <script src="styles/js/plugins/ionRangeSlider/ion.rangeSlider.min.js"></script>
    <script src="styles/js/plugins/iCheck/icheck.min.js"></script>
    <script src="styles/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="styles/js/plugins/clockpicker/clockpicker.js"></script>
    <script src="styles/js/plugins/cropper/cropper.min.js"></script>
    <script src="styles/js/plugins/fullcalendar/moment.min.js"></script>
    <script src="styles/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="styles/js/plugins/Ilyas/edit_employees_js.js"></script>
    <script src="styles/js/plugins/Ilyas/addClients.js"></script>
    <script src="styles/js/demo/contracts_osns.js"></script>
    <script src="styles/js/plugins/sweetalert/sweetalert.min.js"></script>     

    <script>
    if (navigator.appName == 'Microsoft Internet Explorer' ||  !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/rv:11/)) || (typeof $.browser !== "undefined" && $.browser.msie == 1))
    {
      alert("Не рекомендуется использование браузера Internet Explorer в данном портале! Это приведет к техническим ошибкам. Используйте альтернативные браузеры (рекомендуемые: Google Chrome, Mozilla Firefox, Opera, Safari)");
      window.close();
    }
    </script>
