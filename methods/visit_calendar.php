<?php
	class VISIT_CALENDAR
    {
        public function __construct()
        {
            global $js_loader;
            global $css_loader;
            
            array_push($js_loader, 'styles/js/plugins/peity/jquery.peity.min.js', 'styles/js/demo/peity-demo.js',            
            'styles/js/plugins/fullcalendar/moment.min.js', 'styles/js/plugins/fullcalendar/fullcalendar.min.js',
            'styles/js/plugins/datapicker/bootstrap-datepicker.js', 'styles/js/plugins/fullcalendar/moment.min.js', 
            'styles/js/plugins/daterangepicker/daterangepicker.js', 'styles/js/others/datepicker.js');
              
            array_push($css_loader, 'styles/css/plugins/fullcalendar/fullcalendar.css', 'styles/css/plugins/daterangepicker/daterangepicker-bs3.css'); 
        }  
        
        public function init()
        {       
           
           global $breadwin;
           $breadwin[] = 'График переработки сотрудников согласно турникетам';  
           if(count($_GET) == 0){
              $this->main();
           } 
                      
           if(isset($_POST['oneday'])){
              $this->oneday($_POST['oneday']);
              exit;
           }
           
           if(isset($_POST['set_filter'])){
              echo $this->bodyhtml();
              exit;
           }
           
           if(isset($_POST['view_all_otdel'])){
              $this->ViewAllOtdel();
              exit;
           }
                                        
        }
        
        private function ViewAllOtdel()
        {
            $db = new DB();
            if(!isset($_POST['view_all_otdel'])){
                echo '';
            }
            $date_begin = $_POST['date_begin'];
            $date_end = $_POST['date_end'];
            $t_plus = $_POST['plus_time'];
            $color = $_POST['id_otdel'];
            
            $sql = "select * from z_turniket z, Z_TURNIKET_DEPARTMENTAS d
            where
            D.NAME_MIN = z.otdel
            and to_char(to_date(z.t1, 'HH24:MI:SS'), 'HH24:MI:SS') > to_char(to_date('18:30:00', 'HH24:MI:SS')+INTERVAL '$t_plus' MINUTE, 'HH24:MI:SS')
            and to_char(to_date(z.d1, 'DD.MM.YYYY'), 'DD.MM.YYYY') between to_date('$date_begin', 'DD.MM.YYYY') and to_date('$date_end', 'DD.MM.YYYY')
            and d.color = '#$color'";
            
            $r = $db->Select($sql);
            ?>                    
            <span class="btn btn-default" id="back_main_top"><i class="fa fa-backward"></i> Назад</span>                
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Должность</th>
                    <th>Подразделение</th>
                    <th>Дата и время</th>
                    <th>Направление</th>                    
                </tr>
            </thead>
            <tbody>
            <?php 
              foreach($r as $k=>$v){                
            ?>
              <tr>
                <td><?php echo $v['FIO']; ?></td>
                <td><?php echo $v['DOLGNOST']; ?></td>
                <td><?php echo $v['OTDEL']; ?></td>
                <td><?php echo $v['DATATTIME']; ?></td>
                <td><?php echo $v['NAPRAVLENIE']; ?></td>                
              </tr>
            <?php                        
              }
            ?>
            </tbody>            
            </table>            
            <?php
            
        }
        
        
        private function oneday($day)
        {
            $d = date("d.m.Y", strtotime($day));
            global $html;
            global $othersJs;                                                     
            $html .= $this->bodyhtml();
                                    
            $db = new DB();
            $r = $db->Select("
            select * from z_turniket where  d1 = '$d' and 
            to_char(to_date(t1, 'HH24:MI:SS'), 'HH24:MI:SS') > to_char(to_date('18:30:00', 'HH24:MI:SS'), 'HH24:MI:SS')
            and otdel is not null
            order by 3, 1");
            ?>                    
            <span class="btn btn-default" id="back_main"><i class="fa fa-backward"></i> Назад</span>                
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Должность</th>
                    <th>Подразделение</th>
                    <th>Дата и время</th>
                    <th>Направление</th>                    
                </tr>
            </thead>
            <tbody>
            <?php 
              foreach($r as $k=>$v){                
            ?>
              <tr>
                <td><?php echo $v['FIO']; ?></td>
                <td><?php echo $v['DOLGNOST']; ?></td>
                <td><?php echo $v['OTDEL']; ?></td>
                <td><?php echo $v['DATATTIME']; ?></td>
                <td><?php echo $v['NAPRAVLENIE']; ?></td>                
              </tr>
            <?php                        
              }
            ?>
            </tbody>            
            </table>                        
            <?php
            
        }
        
        private function main()
        {
            global $html;
            global $othersJs;                                                     
            $html .= $this->bodyhtml();
            
            $db = new DB();
            $r = $db->Select("
            select 
                otdel, to_char(to_date(d1), 'YYYY-MM-DD') d1, (select color from Z_TURNIKET_DEPARTMENTAS where name_min = z.otdel) color from z_turniket z
            where 
                to_char(to_date(t1, 'HH24:MI:SS'), 'HH24:MI:SS') > to_char(to_date('18:30:00', 'HH24:MI:SS'), 'HH24:MI:SS')
                and otdel is not null
                and napravlenie = 'Выход'
            group by otdel, d1");
            
            $rs = $db->Select("");
               
            $js .= "
            <script>
            $(document).ready(function() {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
    
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''/*'month,agendaWeek,agendaDay'*/
                },
                editable: false,
                selectable: true,
                select: function(start, end) {
                    var d = $.datepicker.formatDate('dd.mm.yy', new Date(start._d));                    
                    $.post('', {'oneday': d}, function(data){
                        $('#statistic').html(data); 
                        $('#calendar').attr('style', 'display: none;');
                        $('#statistic').attr('style', 'display: block;');                                               
                    });
                },
                droppable: false,
                events: [                
                ";
            $i = 0;            
            foreach($r as $k=>$v){
                if($i !== 0){
                    $js .= ',';
                }
                $d1 = date($v['D1'], strtotime("Y-m-d"));
                $js .= "
                {
                    title: '".$v['OTDEL']."',
                    start: '$d1',
                    color: '".$v['COLOR']."'
                }";
                $i++;
            }
            $js .= "]
            });
            
            var hg = $('#calendar').height();
            $('#statistic').attr('style', 'height: '+hg+'px; overflow-x: auto;');
            
            $('body').on('click', '#back_main', function(){                            
                $('#calendar').attr('style', 'display: block;');
                $('#statistic').attr('style', 'display: none;');
            });
            
            $('body').on('click', '#set_filter', function(){
                var 
                  db = $('input[name=date_begin]').val();
                  de = $('input[name=date_end]').val();
                  pt = $('input[name=plus_time]').val(); 
                $.post('', {'set_filter':'', 'date_begin': db, 'date_end': de, 'plus_time': pt}, function(data){
                    $('#label-title-main').html('График переработок по подразделениям за период с '+db+' по '+de+' г.');
                    $('#main_top').html(data);
                });
            });
            $('body').on('click', '.view_all_otdel', function(){
                var id = $(this).attr('id');
                    db = $('input[name=date_begin]').val();
                    de = $('input[name=date_end]').val();
                    pt = $('input[name=plus_time]').val();
                    
                $.post('', {'view_all_otdel':'', 'date_begin': db, 'date_end': de, 'plus_time': pt, 'id_otdel': id}, function(data){                    
                    $('#main_top').attr('style', 'display: none;');
                    $('#main_top_table').html(data);
                    $('#main_top_table').attr('style', 'display: block;');                    
                });                                 
            });
            
            $('body').on('click', '#back_main_top', function(){  
                $('#main_top_table').attr('style', 'display: none;');
                $('#main_top').attr('style', 'display: block;');
                $('#main_top_table').html('');
            });
                                    
            });</script>";
            
            $othersJs .= $js;
        }
        
        private function bodyhtml()
        {
            $date_begin = '01.01.2016';
            $date_end = '31.12.2016';
            $time_plus = 1;
            if(isset($_POST['date_begin'])){
                $date_begin = $_POST['date_begin'];
                $date_end = $_POST['date_end'];
                $time_plus = $_POST['plus_time'];
            }
            $db = new DB();
            $r = $db->Select("select round((sum(pn) / sum(cn)) * 100) pst, otdel, (select color from Z_TURNIKET_DEPARTMENTAS where name_min = otdel) color from(
            select 0 pn, sum(cn) cn, otdel from(
                select otdel, count(*) cn from(
                    select fio, otdel, d1 from z_turniket where otdel is not null and to_char(to_date(d1, 'DD.MM.YYYY'), 'DD.MM.YYYY') between to_date('$date_begin', 'DD.MM.YYYY') and to_date('$date_end', 'DD.MM.YYYY') group by fio, otdel, d1
                ) group by otdel, d1
            ) group by otdel
            union all
            select sum(cn) pn, 0 cn, otdel from(
                select otdel, count(*) cn from(
                    select fio, otdel, d1 from z_turniket where otdel is not null and to_char(to_date(d1, 'DD.MM.YYYY'), 'DD.MM.YYYY') between to_date('$date_begin', 'DD.MM.YYYY') and to_date('$date_end', 'DD.MM.YYYY')
                    and to_char(to_date(t1, 'HH24:MI:SS') + INTERVAL '$time_plus' MINUTE, 'HH24:MI:SS') > to_char(to_date('18:30:00', 'HH24:MI:SS'), 'HH24:MI:SS') 
                    and napravlenie = 'Выход'
                    group by fio, otdel, d1
                ) group by otdel, d1
            ) group by otdel
            ) group by otdel
            order by 2");
            
            $text = '                        
            <table class="table" width="100%">
            ';
                        
            foreach($r as $k=>$v){
                $ids = str_replace('#', '', $v['COLOR']);                
                $text .= '
                    <tr id="'.$ids.'" class="view_all_otdel">
                        <td width="15%"><span class="label" style="background-color: '.$v['COLOR'].';">&nbsp;</span> '.$v['OTDEL'].'</td>
                        <td width="5%">'.$v['PST'].'%</td>
                        <td width="80%">
                            <div class="progress">
                                <div style="width: '.$v['PST'].'%; background-color: '.$v['COLOR'].';" aria-valuemax="100" aria-valuemin="0" aria-valuenow="'.$v['PST'].'" role="progressbar" class="progress-bar">
                                    <span class="sr-only">'.$v['PST'].'% Complete (success)</span>
                                </div>
                            </div>
                        </td>                        
                    </tr>                    
                    ';
            }
            $text .= "</table>";
            
            if(isset($_POST['set_filter'])){
                return $text;
            }
            
            return '            
            <div class="col-lg-12">
                <div class="col-lg-12">&nbsp;</div>            
                <div class="col-lg-6">
                    <h4 id="label-title-main" class="pull-left">График переработок по подразделениям за период с '.$date_begin.' по '.$date_end.' г.</h4>
                </div>
                
                <div class="col-lg-3">
                    <div class="input-group">
                        <div id="reportrange" class="form-control">
                            <i class="fa fa-calendar"></i>
                            <span>'.$date_begin.' - '.$date_end.'</span> 
                            <b class="caret"></b>
                            <input type="hidden" name="date_begin" value="'.$date_begin.'">
                            <input type="hidden" name="date_end" value="'.$date_end.'">
                        </div>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-sm" id="set_filter"><i class="fa fa-filter"></i></button>                                            
                        </span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="col-lg-1 control-label" style="padding-top: 7px;text-align: right;">+</label>
                        <div class="col-lg-4">
                            <input type="number" class="form-control" name="plus_time" value="10">                         
                        </div>
                        <label class="col-lg-2 control-label" style="padding-top: 7px;text-align: right;"> минут</label>
                    </div>                
                </div>
                <div id="main_top">'.$text.'</div>
                <div id="main_top_table" style="display: none;"></div>
            </div>                                                        
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Календарь</h5>                        
                    </div>
                    <div class="ibox-content">                        
                        <div id="calendar"></div>
                        <div id="statistic" style="display: none;"></div>                        
                    </div>    
                </div>
            </div>';
                        
        }
    }
?>