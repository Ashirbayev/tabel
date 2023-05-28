<?php
	class CHART
    {        
        public function __construct()
        {
            global $js_loader;
            array_push($js_loader, 'styles/js/others/highcharts.js', 'styles/js/others/exporting.js', 'styles/js/demo/morris-demo.js');                                                    
        }                
                
        public function init()
        {            
            global $html;                                                     
            $html .= $this->bodyhtml();
            
            global $GETS;    
            if(isset($GETS['main'])){
                $db = new DB3();
                $rg = SQLS::BranchRegName(); //Список регионов
                
                $month_array = array("01"=>"Январь", "02"=>"Февраль", "03"=>"Март", "04"=>"Апрель", "05"=>"Май", "06"=>"Июнь", "07"=>"Июль", "08"=>"Август", "09"=>"Сентябрь", "10"=>"Октябрь", "11"=>"Ноябрь", "12"=>"Декабрь");
                $categories = '';
                $series_OSOR = "";
                $series_OSNS = "";
                $series_PA = "";
                $table_th = 'Регион';
                        
                /*Месяца*/
                $month = date("m");      
                $year = date("Y");//'2017';//
                if(isset($GETS['month'])){$month = $GETS['month'];}                
                if(isset($GETS['years'])){$year = $GETS['years'];}
                $d1 = "01.$month.$year";
                $chart_subtitle = $month_array[$month]." $year года";    
    
                $region = '15';
                if(isset($GETS['region'])){
                    $region = $GETS['region'];
                }
    
                foreach($rg as $k=>$v){
                    if($v['KOD'] == $region){
                        $reg_text = $v["MAIN_REG"];   
                    }        
                }                
        
                $sql = "select main_reg, kod_branch, pa, osor, osns, plan_PA, plan_osor, plan_osns, 
                    round(pa / case when plan_pa = 0 then 1 else plan_pa end * 100, 2) proc_pa, 
                    round(osor / case when plan_osor = 0 then 1 else plan_osor end  * 100, 2) proc_osor,        
                    round(osns / case when plan_osns = 0 then 1 else plan_osns end  * 100, 2) proc_osns
                    from(  
                        select 
                            main_reg, kod_branch, pa, osor, osns,   
                            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = kod_branch and PB.RFPM_ID = '01' and pb.period between trunc(to_date('$d1', 'dd.mm.yyyy'),'mm') and last_day('$d1')) plan_PA,
                            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = kod_branch and PB.RFPM_ID = '02' and pb.period between trunc(to_date('$d1', 'dd.mm.yyyy'),'mm') and last_day('$d1')) plan_OSOR,
                            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = kod_branch and PB.RFPM_ID = '07' and pb.period between trunc(to_date('$d1', 'dd.mm.yyyy'),'mm') and last_day('$d1')) plan_OSNS
                        from(
                            select 
                                main_reg, substr(db.RFBN_ID, 1, 2) kod_branch,
                                grafik_sotr(trunc(to_date('$d1', 'dd.mm.yyyy'),'mm'), last_day('$d1'), '01', substr(db.RFBN_ID, 1, 2)) pa,
                                grafik_sotr(trunc(to_date('$d1', 'dd.mm.yyyy'),'mm'), last_day('$d1'), '02', substr(db.RFBN_ID, 1, 2)) osor, 
                                grafik_sotr(trunc(to_date('$d1', 'dd.mm.yyyy'),'mm'), last_day('$d1'), '07', substr(db.RFBN_ID, 1, 2)) osns         
                                from dic_branch db where db.main_reg is not null
                                and db.asko is null
                                group by main_reg, substr(db.RFBN_ID, 1, 2)
                            order by 1
                    ))";                       
        
                    if(isset($GETS['filter'])){
                        if($GETS['filter'] == 'periods'){                                
                        $sql = "select mes main_reg, pa, osor, osns, plan_PA, plan_osor, plan_osns, 
                            round(pa / case when plan_pa = 0 then 1 else plan_pa end * 100, 2) proc_pa, 
                    round(osor / case when plan_osor = 0 then 1 else plan_osor end  * 100, 2) proc_osor,        
                    round(osns / case when plan_osns = 0 then 1 else plan_osns end  * 100, 2) proc_osns
                            from(
                            select mes, pa, osor, osns,   
                            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = '$region' and PB.RFPM_ID = '01' and pb.period = mes) plan_PA,
                            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = '$region' and PB.RFPM_ID = '02' and pb.period = mes) plan_OSOR,
                            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = '$region' and PB.RFPM_ID = '07' and pb.period = mes) plan_OSNS 
                            from(    
                                select trunc(kv.DATE_DOHOD,'mm') mes,  
                                round(sum(case when substr(d.paym_code,1,2) = '01' then kv.pay_sum_d  else 0 end) / 1000) pa,   
                                round(sum(case when substr(d.paym_code,1,2) = '02' then kv.pay_sum_d  else 0 end) / 1000) osor,
                                round(sum(case when substr(d.paym_code,1,2) = '07' then kv.pay_sum_d  else 0 end) / 1000) osns
                                from 
                                contracts d, gak_pay_doc pl, plat_to_1c kv
                                , dic_branch b    
                                where    
                                kv.DATE_DOHOD between '01.01.$year' and '31.12.$year'
                                and B.RFBN_ID = d.branch_id
                                and b.asko is null
                                and substr(d.branch_id, 1, 2) = '$region'
                                and kv.cnct_id = d.cnct_id
                                and pl.mhmh_id = kv.mhmh_id
                                group by trunc(kv.DATE_DOHOD,'mm')
                            ))order by 1";    
                        }
                        $table_th = 'Период';
                    }
                    
                    $row = $db->Select($sql);
                    
                    /*Созданием таблицы*/
                    $table = '<div class="table-responsive"><table class="table table-bordered dataTables-example"><thead><tr><th rowspan="2" style="text-align: center;">'.$table_th.'</th><th colspan="3" style="text-align: center;">ПА</th><th colspan="3" style="text-align: center;">ОСОР</th><th colspan="3" style="text-align: center;">ОСНС</th></tr><tr><th style="text-align: center;">План</th><th style="text-align: center;">Факт</th><th style="text-align: center;">%</th><th style="text-align: center;">План</th><th style="text-align: center;">Факт</th><th style="text-align: center;">%</th><th style="text-align: center;">План</th><th style="text-align: center;">Факт</th><th style="text-align: center;">%</th></tr></thead><tbody>';
                    
                    $pa = 0;
                    $osor = 0;
                    $osns = 0;
                    
                    $pa_plan = 0;
                    $osor_plan = 0;
                    $osns_plan = 0;
                    
                    
                    foreach($row as  $k=>$v){
                        $table .= '<tr class="gradeA"><td>'.$v['MAIN_REG'].'</td><td style="text-align: center;">'.$v['PLAN_PA'].'</td><td style="text-align: center;">'.$v['PA'].'</td><td style="text-align: center;">'.$v['PROC_PA'].'</td><td style="text-align: center;">'.$v['PLAN_OSOR'].'</td><td style="text-align: center;">'.$v['OSOR'].'</td><td style="text-align: center;">'.$v['PROC_OSOR'].'</td><td style="text-align: center;">'.$v['PLAN_OSNS'].'</td><td style="text-align: center;">'.$v['OSNS'].'</td><td style="text-align: center;">'.$v['PROC_OSNS'].'</td></tr>';
                        $pa += $v['PA'];
                        $osor += $v['OSOR'];
                        $osns += $v['OSNS'];
                           
                        $pa_plan += $v['PLAN_PA'];
                        $osor_plan += $v['PLAN_OSOR'];
                        $osns_plan += $v['PLAN_OSNS'];        
                    }
                    $table .= "<tfoot><tr><th></th><th>$pa_plan</th><th>$pa</th><th></th><th>$osor_plan</th><th>$osor</th><th></th><th>$osns_plan</th><th>$osns</th><th></th></tr></tfood>";
                    $table .= '</tbody></table></div>';  
                      
                    /*----------------*/
                            
                    $i = 0;            
                    foreach($row as $k=>$v){
                        if($i > 0){
                            $categories .= ",";
                            $series_OSOR .= ",";
                            $series_OSNS .= ",";
                            $series_PA .= ",";
                        }    
                        $categories .= "'".$v['MAIN_REG']."'";
                        $regions[] = array("name"=>$v['MAIN_REG'], "kod"=>$v['KOD_BRANCH']); 
                        $series_OSOR .= $v['PROC_OSOR'];
                        $series_OSNS .= $v['PROC_OSNS'];
                        $series_PA .= $v['PROC_PA'];    
                        $i++;
                    }    
                    $filter_other = '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#" style="color: black;"><i class="fa fa-calendar"></i></a><ul class="dropdown-menu dropdown-user"><li><a href="month=01" class="chart_view">Январь</a></li><li><a href="month=02" class="chart_view">Февраль</a></li><li><a href="month=03" class="chart_view">Март</a></li><li><a href="month=04" class="chart_view">Апрель</a></li><li><a href="month=05" class="chart_view">Май</a></li><li><a href="month=06" class="chart_view">Июнь</a></li><li><a href="month=07" class="chart_view">Июль</a></li><li><a href="month=08" class="chart_view">Август</a></li><li><a href="month=09" class="chart_view">Сентябрь</a></li><li><a href="month=10" class="chart_view">Октябрь</a></li><li><a href="month=11" class="chart_view">Ноябрь</a></li><li><a href="month=12" class="chart_view">Декабрь</a></li></ul>';

                    if(isset($_GET['filter'])){
                        $f = $_GET['filter']; 
                        if($f == 'periods'){              
                            $filter_other = '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#" style="color: black;"><i class="fa fa-map-marker"></i></a><ul class="dropdown-menu dropdown-user">';
                            foreach($rg as $k=>$v){
                                $filter_other .= '<li><a href="region='.$v['KOD'].'" class="chart_view">'.$v['MAIN_REG'].'</a></li>';   
                            }            
                            $filter_other .= '</ul>';
                            $chart_subtitle = 'Регион: '.$reg_text;
                        }
                    }        
                        
                    $chart_title = "График выполнения плана";
                        
                    $series = "{
                            name: 'ОСОР',
                            data: [$series_OSOR]
                
                        }, {
                            name: 'ОСНС',
                            data: [$series_OSNS]
                
                        }, {
                            name: 'ПА',
                            data: [$series_PA]
                
                        }";            
                        
                    $type_chart = "column";    
                    if(isset($GETS['type_chart'])){
                        $type_chart = $GETS['type_chart'];
                    }
                        
                    $js = "
                        $('#morris-bar-chart').highcharts({
                        chart: {
                            type: '$type_chart'
                        },
                        title: {
                            text: '$chart_title'
                        },
                        subtitle: {
                            text: '$chart_subtitle'
                        },
                        xAxis: {
                            categories: [$categories],
                            crosshair: true
                        },
                        yAxis: {            
                            min: 0,
                            title: {
                                text: 'Выполнение плана в %'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style=".'"font-size:10px"'.">{point.key}</span><table>',
                            pointFormat: '<tr><td style=".'"color:{series.color};padding:0"'.">{series.name}: </td>' +
                                '<td style=".'"padding:0"'."><b>{point.y:.1f} %</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0                
                            }
                        },
                        series: [$series]        
                    });               
                    ";
                    
                    $js .="$('#chart_filter_other').html('$filter_other');";
                    
                    $js .="$('#chart-table').html('$table');";
                                        
                    echo $js;                    
                    exit; 
                }            
        }
        
        private function bodyhtml()
        {
            return '<div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5 id="grafik_title"></h5>                
                <div class="ibox-tools" style="text-align: left;">
                    <div class="btn-group">                 
                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#" style="color: black;"><i class="fa fa-filter"></i></a>
                    <ul class="dropdown-menu dropdown-region">
                        <li><a href="filter=regions" class="chart_view">По регионам</a></li>
                        <li><a href="filter=periods" class="chart_view">По периодам</a></li>
                    </ul>                    
                    </div>
                    
                    <div class="btn-group" id="chart_filter_month">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#" style="color: black;"><i class="fa fa-area-chart"></i></a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="type_chart=column" class="chart_view">Колонки</a></li>
                            <li><a href="type_chart=areaspline" class="chart_view">Линии</a></li>                        
                        </ul>
                    </div>                    
                    <div class="btn-group" id="chart_filter_other"></div>                    
                    
                </div>
            </div>
            <div class="ibox-content">
                <div id="morris-bar-chart"></div>                
            </div>            
            
            <div class="ibox-content">
                <div id="chart-table"></div>                
            </div>
            </div>';
        }
        
    }
?>