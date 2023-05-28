$(document).ready(function(){
    var link = 2;
    var link2 = 2;
    var htmlBodySem = $('#oneTabId').html();
   
    $('body').on('click', '#urLitsa tr', function(){
            $('.gradeX').removeClass('active');
            var tr = $(this);
            window.s = tr.attr('data');
            window.age = tr.attr('title');
            window.birthDate = tr.attr('contextmenu');
            $(this).addClass('active');
            console.log(s);
    });
    $('#addClientTest').click(
                function(){
                    console.log(s+'ssss');
                    addTab(s, age, birthDate);
                    });
    
    //принимает параметром ФИО
    function addTab(name, ageParam, birthDateParam){
            console.log('addtabStart');
            var active = 'active';
            if(link>2)active = '';
            var dbDisease = '';
            var dbProf = '';
            var dbSport = '';
            $('#namesTabId').append("<li class='list-group-item "+active+"'><a data-toggle='tab' href='#tab-"+link+"'><small class='pull-right text-muted'></small><strong id='nameTabId'>"+name+"</strong><div class='small m-t-xs'><p class='m-b-none'>Возраст: </p><strong>"+ageParam+" лет</strong></div></a></li>");
            $('#bodyContent').append("<div id='tab-"+link+"' class='tab-pane "+active+"'>"+
                                    "<div class='tab-content'>"+
                                    "<div class='panel-body'>"+
                                    "<div class='row'>"+
                                    "<div class='col-lg-6'>"+
                                    "<label class='font-noraml'>Застрахованный "+link+"</label>"+
                                    "<input id='zastrah' type='text' name='ICONTRACT_NUM' readonly placeholder='' class='form-control'/></div>"+
                                    "<div class='col-lg-3'>"+
                                    "<label class='font-noraml'>Расходы</label>"+
                                    "<select class='select2_demo_1 form-control'>"+
                                    "<option value='A'>0% - Минимальный</option><option value='B'>25% - Базовый</option>"+
                                    "<option value='B'>50% - Максимальный</option>"+
                                    "</select></div><div class='col-lg-1'>"+
                                    "<label class='font-noraml'>Рост</label>"+
                                    "<input type='number' class='form-control m1' required></div><div class='col-lg-1'><label class='font-noraml'>Вес</label><input type='number' class='form-control m1' required>"+
                                    "</div><div class='col-lg-1'><label class='font-noraml'>Возраст</label><input type='number' class='form-control m1' required></div></div><div class='hr-line-dashed'></div><div class='row' id='namesTabIdBodyRow2'>"+
                                    "<div class='col-lg-6'><label class='font-noraml'>Основное покрытие</label><select class='select2_demo_1 form-control'><option value='A'>0% - Минимальный</option><option value='B'>25% - Базовый</option><option value='B'>50% - Максимальный</option>"+
                                    "</select></div><div class='col-lg-6'><label class='font-noraml'>Доп. покрытие</label><select class='select2_demo_1 form-control'><option value='A'>0% - Минимальный</option><option value='B'>25% - Базовый</option><option value='B'>50% - Максимальный</option>"+
                                    "</select></div></div><div class='hr-line-dashed'></div><div class='row' id='namesTabIdBodyRow3'><div class='tabs-container'>"+
                                    "<ul class='nav nav-tabs testTable'>"+
                                        "<li class='active'><a data-toggle='tab' href='#tab-b2"+link+"'> Риски и надбавки </a></li>"+
                                        "<li class=''><a data-toggle='tab' href='#tab-b3"+link+"'> Выготоприобретатели </a></li>"+
                                        "<li class=''><a data-toggle='tab' href='#tab-b4"+link+"'> Расчет </a></li>"+
                                        "<li class=''><a data-toggle='tab' href='#tab-b5"+link+"'> Tab sheet 25 </a></li>"+
                                    "</ul>"+
                                    "<div class='tab-content testTableBody'>"+
                                                "<div id='tab-b2"+link+"' class='tab-pane active'>"+
                                                    "<div class='panel-body'>"+
                                                    "<div class='tabs-container'>"+
                                                        "<ul class='nav nav-tabs'>"+
                                                            "<li class='active'><a data-toggle='tab' href='#tab-c1"+link+"'> Заболевания </a></li>"+
                                                            "<li class=''><a data-toggle='tab' href='#tab-c2"+link+"'> Профессии </a></li>"+
                                                            "<li class=''><a data-toggle='tab' href='#tab-c3"+link+"'> Спорт </a></li>"+
                                                            "<li class=''><a data-toggle='tab' href='#tab-c4"+link+"'> Страна пребывание </a></li>"+
                                                        "</ul>"+
                                                        "<div class='tab-content'>"+
                                                            "<div id='tab-c1"+link+"' class='tab-pane active'>"+
                                                                "<div class='panel-body'>"+
                                                                    "<div class='col-lg-12'>"+
                                                                        "<div class='row'>"+
                                                                            "<div class='mutliSelect form-control' id='dbDisease'>"+
                                                                                $.post('new_contract', {"dbDisease": dbDisease}, function(d){
                                                                                    $('#dbDisease').html(d);
                                                                                })+
                                                                            "</div>"+
                                                                        "</div>"+
                                                                        "<div class='hr-line-dashed'></div>"+
                                                                        "<div class='row'>"+
                                                                            "<h4'>Заболевания: </h4><p class='multiSel'></p>"+
                                                                        "</div>"+
                                                                   "</div>"+
                                                                "</div>"+
                                                            "</div>"+
                                                            "<div id='tab-c2"+link+"' class='tab-pane'>"+
                                                                "<div class='panel-body'>"+
                                                                    "<div class='col-lg-12'>"+
                                                                        "<div class='mutliSelect2 form-control' id='dbProf'>"+
                                                                            $.post('new_contract', {"dbProf": dbProf}, function(d){
                                                                                    $('#dbProf').html(d);
                                                                                })+
                                                                        "</div>"+
                                                                        "<h4>Профессии: </h4><p class='multiSel2'></p>"+
                                                                   " </div>"+
                                                                "</div>"+
                                                            "</div>"+
                                                            "<div id='tab-c3"+link+"' class='tab-pane'>"+
                                                                "<div class='panel-body'>"+
                                                                    "<div class='col-lg-12'>"+
                                                                        "<div class='mutliSelect3 form-control' id='dbSport'>"+
                                                                            $.post('new_contract', {"dbSport": dbSport}, function(d){
                                                                                    $('#dbSport').html(d);
                                                                                    console.log('#dbSportLink2');
                                                                                })+
                                                                        "</div>"+
                                                                        "<h4>Спорт: </h4><p class='multiSel3'></p>"+
                                                                    "</div>"+
                                                                "</div>"+
                                                            "</div>"+
                                                            "<div id='tab-c4"+link+"' class='tab-pane'>"+
                                                                "<div class='panel-body'>"+
                                                                    "<div class='col-lg-6'>"+
                                                                            "<label class='font-noraml'>Страна пребывания</label>"+
                                                                                "<select class='select2_demo_1 form-control'>"+
                                                                               "</select>"+
                                                                            "</div>"+
                                                                    "<div class='col-lg-6'>"+
                                                                             "<label class='font-noraml'>Условия проживания</label>"+
                                                                                "<select class='select2_demo_1 form-control'>"+
                                                                                    "<option value='A'>1) A -<= 12 месяцев</option>"+
                                                                                    "<option value=''>2) A -> 12 месяцев</option>"+
                                                                                    "<option value=''>3) B1 -> 12 месяцев</option>"+
                                                                                    "<option value=''>4) B2 -<= 12 месяцев</option>"+
                                                                                    "<option value=''>5) C1 -> 12 месяцев</option>"+
                                                                                    "<option value=''>6) C3 -<= 12 месяцев</option>"+
                                                                                "</select>"+
                                                                    "</div>"+
                                                                "</div>"+
                                                            "</div>"+
                                                        "</div>"+
                                                    "</div>"+
                                                   
                                                "</div>"+
                                                "</div>"+
                                                
                                                "<div id='tab-b3"+link+"' class='tab-pane'>"+
                                                    "<a href='javascript:;' class='btn btn-primary ' id='addRowClientVigod' data-toggle='modal' data-target='#searchClientVigod'>Добавить клиента</a>"+
                                                    "<a href='javascript:;' class='btn btn-primary ' id='removeClientVigod'>Удалить текущего клиента</a>"+
                                                    
                                                    "<div class='panel-body'>"+
                                                        "<table class='table table-striped table-bordered table-hover ' id='editable' >"+
                                                        "<thead>"+
                                                       " <tr>"+
                                                            "<th>Rendering engine</th>"+
                                                            "<th>Browser</th>"+
                                                            "<th>Platform(s)</th>"+
                                                            
                                                        "</tr>"+
                                                        "</thead>"+
                                                        "<tbody>"+
                                                        "<tr class='gradeX'>"+
                                                            "<td>Trident</td>"+
                                                            "<td>Internet Explorer 4.0</td>"+
                                                            "<td>Win 95+</td>"+
                                                            
                                                        "</tr>"+
                                                        "</tbody>"+
                                                        "</table>"+
                                                    "</div>"+
                                               " </div>"+
                                                
                                                "<div id='tab-b4"+link+"' class='tab-pane'>"+
                                                    "<div class='panel-body'>"+
                                                    "<h4>Расчет</h4>"+
                                                       " <div class='col-lg-6 b-r'>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Периодичность</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Годовой доход</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Страховая сумма</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Срок страхования</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                        "</div>"+
                                                        "<div class='col-lg-6 b-r'>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Тариф</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Основное покрытие</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                       " </select>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Тариф по доп</label>"+
                                                                       " <select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Доп покрытие</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Страховая премия</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                            "<div class='col-lg-6'>"+
                                                                "<label class='font-noraml'>Сумма страховых премий</label>"+
                                                                        "<select class='select2_demo_1 form-control'>"+
                                                                            "<option value='A'>A</option>"+
                                                                            "<option value='B'>B</option>"+
                                                                        "</select>"+
                                                            "</div>"+
                                                        "</div>"+
                                                    "</div>"+
                                                "</div>"+
                                                "</div>"+
                                                "<div id='tab-b5"+link+"' class='tab-pane'>"+
                                                    "<div class='panel-body'>"+
                                                        "<table class='table table-striped table-bordered table-hover' id='editable' >"+
                                                         "b5"+
                                                        "</table>"+
                                                    "</div>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                               " </div>"+
                               "</div>"+
                            
                        "</div>"+
                    "</div>");
            console.log(link+'append');
            
            link++;
            }
//добавление пунктов с помощью чекбоксов
                                                    $(".dropdown dd ul li a").on('click', function() {
                                                      $(".dropdown dd ul").hide();
                                                    });
                                                    
                                                    function getSelectedValue(id) {
                                                      return $("#" + id).find("dt a span.value").html();
                                                    }
                                                    
                                                    $(document).bind('click', function(e) {
                                                      var $clicked = $(e.target);
                                                      if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
                                                    });
                                                    
                                                    $('.mutliSelect input[type="checkbox"]').on('click', function() {
                                                    
                                                      var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
                                                          title = $(this).attr('title') + ","+"<br>";
                                                    
                                                      if ($(this).is(':checked')) {
                                                        var html = '<span title="' + title + '">' + title + '</span>';
                                                        $('.multiSel').append(html);
                                                        $(".hida").hide();
                                                      } else {
                                                        $('span[title="' + title + '"]').remove();
                                                        var ret = $(".hida");
                                                        $('.dropdown dt a').append(ret);
                                                    
                                                      }
                                                    });
                                                    //prof
                                                    $(".dropdown dd ul li a").on('click', function() {
                                                      $(".dropdown dd ul").hide();
                                                    });
                                                    
                                                    function getSelectedValue(id) {
                                                      return $("#" + id).find("dt a span.value").html();
                                                    }
                                                    
                                                    $(document).bind('click', function(e) {
                                                      var $clicked = $(e.target);
                                                      if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
                                                    });
                                                    
                                                    $('.mutliSelect2 input[type="checkbox"]').on('click', function() {
                                                    
                                                      var title = $(this).closest('.mutliSelect2').find('input[type="checkbox"]').val(),
                                                          title = $(this).attr('title') + ","+"<br>";
                                                    
                                                      if ($(this).is(':checked')) {
                                                        var html = '<span title="' + title + '">' + title + '</span>';
                                                        $('.multiSel2').append(html);
                                                        $(".hida").hide();
                                                      } else {
                                                        $('span[title="' + title + '"]').remove();
                                                        var ret = $(".hida");
                                                        $('.dropdown dt a').append(ret);
                                                    
                                                      }
                                                    });
                                                    //sport
                                                    $(".dropdown dd ul li a").on('click', function() {
                                                      $(".dropdown dd ul").hide();
                                                    });
                                                    
                                                    function getSelectedValue(id) {
                                                      return $("#" + id).find("dt a span.value").html();
                                                    }
                                                    
                                                    $(document).bind('click', function(e) {
                                                      var $clicked = $(e.target);
                                                      if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
                                                    });
                                                    
                                                    $('.mutliSelect3 input[type="checkbox"]').on('click', function() {
                                                      var title = $(this).closest('.mutliSelect3').find('input[type="checkbox"]').val(),
                                                          title = $(this).attr('title') + ","+"<br>";
                                                      if ($(this).is(':checked')) {
                                                        var html = '<span title="' + title + '">' + title + '</span>';
                                                        $('.multiSel3').append(html);
                                                        $(".hida").hide();
                                                      } else {
                                                        $('span[title="' + title + '"]').remove();
                                                        var ret = $(".hida");
                                                        $('.dropdown dt a').append(ret);
                                                    
                                                      }
                                                    });
                                                
})