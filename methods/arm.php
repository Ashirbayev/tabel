<?php
	class ARM
    {
        private $db;    
        private $array;
        public $dan;
        
        public function __construct()
        {
            $this->db = new DB3();
            $method = $_SERVER['REQUEST_METHOD'];
            $this->$method();   
        }
        
        private function GET()
        {            
            if(count($_GET) <= 0){
                $this->index();                
            }else{            
                foreach($_GET as $k=>$v){
                    if(method_exists($this, $k)){
                        $this->$k($v);
                    }else{
                        $this->array[$k] = $v;
                    }
                }
            }                        
        }
        
        private function POST()
        {            
            if(count($_POST) > 0){                
                foreach($_POST as $k=>$v){
                    if(method_exists($this, $k)){                           
                        $this->array = $_POST;
                        unset($this->array[$k]);
                        $this->$k($v); 
                    }    
                }
                $this->GET();
            }
        }
                
        /**
         * Список всех форм отчетов
         */ 
        private function index()
        {
            $q = $this->db->Select("select id, name from strah_nadzor.S_REPORT order by name");            
            $this->dan = $q;
            return $q;
        }
        
        /**
         * POST
         * Отображение готовой формы отчета        
        */
        
        private function edit($id)
        {            
            $dan = array();
            
            $q = $this->db->Select("select id, name from strah_nadzor.S_REPORT where id = $id");                        
            $dan['head'] = $q[0]['ID']." (".$q[0]['NAME'].")";            
            
            $gl = $this->db->Select("select * from strah_nadzor.DATAFORSIGNATURE");
            $dan['main_ruk'] = $gl[0]['NAME_BOSS'];
            $dan['gl_buh'] = $gl[0]['NAME_BUH'];
            $dan['ispol'] = $gl[0]['NAME_USER'];
            $dan['num_phone'] = $gl[0]['PHONE'];
            
            $h = $this->db->Select("select strah_nadzor.list_table_maket.STRAH_TABLE($id) HTML from dual");
            $dan['html'] = $h[0]['HTML'];
            $dan['js'] = $this->GenerateArray($id, $this->array);
            $this->dan = $dan;
            return $dan;
        }
        
        /**
         * Генерация массива данных для отображения данных в ячейках где находятся SQL запросы
         * Используется в нутри класса
         */ 
        
        private function GenerateArray($id, $param)
        {
            $dan = array();
            //Находимо параметры которые должны входить в SQL запрос
            $params = $this->db->Select("select * from strah_nadzor.CELLS_PARAMS where id_otchet = $id");
            
            $html = '<script type="text/javascript">';
            $j = $this->db->Select("select id_cell, sqls from strah_nadzor.CELLS_SQL where id_otchet = $id");
            
            $i = 0;
            foreach($j as $k=>$v){
                $sql = $v['SQLS'];
                foreach($param as $id_sql=>$pr){
                    $sql = str_replace(":$id_sql", "'$pr'", $sql);
                }
                
                $d = $this->db->Select($sql);
                foreach($d as $t=>$h){
                    foreach($h as $s=>$r){
                        $dan[$i]['ID'] = $v['ID_CELL'];
                        $dan[$i]['DAN'] = $r;   
                        $i++;                         
                    }
                }
            }   
            
            $html .= " var list_array = '".json_encode($dan)."';"; 
            $html .= "</script>";
            return $html;            
        }
        
        /**
         * POST
         * Данная функция работает при клике на кнопку сформировать отчет         
         * В модальное окно передает все параметры  виде формы которые необходимы для формирования отчета
         * Форма index 
        */          
        private function form_params($id)
        {
            $dan = array();
            $html = '';
            $q = $this->db->Select("select * from strah_nadzor.CELLS_PARAMS where id_otchet = $id order by num_pp");
            foreach($q as $k=>$v){                
                $f = $v['TYP_PARAM'];
                $html .= '<div class="form-group">
                        <label class="col-lg-3">'.$v['N_PARAM_RUS'].'</label>
                        <div class="col-lg-9">'.$this->$f($v['N_PARAM'], $v['SQL_TEXT']).'                                              
                        </div>
                    </div>';
            }
            
            $othersJs = "<script>$('.input-group.date').datepicker({
                todayBtn: 'linked',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });</script>";
            $html .= $othersJs;
            $dan['ID'] = $id;
            $dan['HTML'] = $html;
            echo json_encode($dan);
            exit;
        }
                
        
        /**
         * Использвется в нутри класса 
         * Функция передает табличную часть всех необходимых параметров для формирования отчета
         * Предназначение: Административная панель формирования отчетов
        */
        
        private function AdminParams($id)
        {            
            $html = '<table class="table table-bordered">
                     <thead>
                        <tr>
                            <th>№ п/п</th>
                            <th>ID Параметра</th>
                            <th>Наименование</th>
                            <th>Тип параметра</th>
                            <th>SQL запрос</th>
                            <th></th>                            
                        </tr>
                     </thead>
                     <tbody>';                     
            $pr = $this->db->Select("select * from strah_nadzor.CELLS_PARAMS where id_otchet = $id order by num_pp");
            foreach($pr as $k=>$v){
                $html .= '<tr>
                <td>'.$v['NUM_PP'].'</td>
                <td>'.$v['N_PARAM'].'</td>
                <td>'.$v['N_PARAM_RUS'].'</td>
                <td>'.$v['TYP_PARAM'].'</td>
                <td>'.$v['SQL_TEXT'].'</td>
                <td><button class="btn btn-warning btn-xs delete_param" id="'.$v['NUM_PP'].'" data="'.$id.'"><i class="fa fa-trash"></i></button></td>
                </tr>
                ';
            }
            $html .= "</tbody></table>";
            return $html;
        }
        
        /**
         * POST
         * Функция для внесения енобходимых параметров для формирования отчета
         * Предназначение: Административная панель для формирования отчетов
         * На выходе выдает табличную часть параметров
        */
        
        private function set_param_new($id)
        {
            $num_pp = $this->array['num_pp'];
            $n_param_rus = $this->array['n_param_rus'];
            $n_param = $this->array['n_param'];
            $typ_param = $this->array['typ_param'];
            $sql_text = $this->array['sql_text'];
            
            if(!$this->db->Execute("INSERT INTO STRAH_NADZOR.CELLS_PARAMS (ID_OTCHET, NUM_PP, N_PARAM, N_PARAM_RUS, TYP_PARAM, SQL_TEXT
            ) VALUES ( $id, $num_pp, '$n_param', '$n_param_rus', '$typ_param', '$sql_text')")){
                echo $this->db->message;                
            }
            
            echo $this->AdminParams($id);
            exit;
        }
        
        /**
         * GET
         * Административная панель отчета для внесения SQL запросов
         */
        
        private function admin($id)
        {
            $dan = array();
            
            $q = $this->db->Select("select id, name from strah_nadzor.S_REPORT where id = $id");                        
            $dan['head'] = $q[0]['ID']." (".$q[0]['NAME'].")";            
                        
            $dan['params_html'] = $this->AdminParams($id);            
            $dan['params_list'] = $this->db->Select("select * from strah_nadzor.DIC_PARAMS");
            
            $dpr = $this->db->Select("select max(num_pp)+1 id from strah_nadzor.CELLS_PARAMS where id_otchet = $id");
            if($dpr[0]['ID'] == ''){
                $dan['max_num_pp'] = '1';
            }else{
                $dan['max_num_pp'] = $dpr[0]['ID'];
            }
                                    
            $gl = $this->db->Select("select * from strah_nadzor.DATAFORSIGNATURE");
            $dan['main_top_params'] = $gl[0];
            
                        
            $h = $this->db->Select("select strah_nadzor.list_table_maket.STRAH_TABLE($id, 1) HTML from dual");            
            $dan['html'] = $h[0]['HTML'];            
            $this->dan = $dan;
            return $dan;
        }
        
        /**
         * POST
         * Внесение SQL запросов в каждую ячейку
         * Если SQL запрос пустой тогда запись в БД удаляется
         */ 
        
        private function save_cell($id_otchet)
        {
            $id_cells = $this->array['cell'];
            $sqls = $this->array['sqls'];

            $ss = "delete from strah_nadzor.CELLS_SQL where id_otchet = $id_otchet and id_cell = $id_cells";
            $this->db->Execute($ss);
            
            if(trim($sqls) !== ''){
                $p['SQLSX'] = $sqls;            
                $s = "INSERT INTO STRAH_NADZOR.CELLS_SQL(ID_OTCHET, ID_CELL, SQLS) VALUES ($id_otchet, $id_cells, EMPTY_CLOB())
                RETURNING SQLS INTO :SQLSX";
                
                $this->db->AddClob($s, $p);    
            }      
                                    
            echo $this->db->message;
            exit;
        }
        
        /**
         * POST
         * Удаление параметров в административной панели      
         * Возврат: Табличная часть параметров   
         */ 
        
        private function del_param($id)
        {
            $num_pp = $this->array['num_pp'];
            $this->db->Execute("delete from STRAH_NADZOR.CELLS_PARAMS where id_otchet = $id and num_pp = $num_pp");
            echo $this->AdminParams($id);
            exit;
        }
        
        
        /**
         * Формирование форм         
        */
        
        private function D($name, $sql)
        {
            return '<div class="input-group date col-lg-12">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" name="'.$name.'" id="'.$name.'" class="form-control input-sm" data-mask="99.99.9999" value="">
            </div>';
        }
        
        private function T($name, $sql)
        {
            return '<input type="text" name="'.$name.'" id="'.$name.'" class="form-control input-sm" value="">';
        }
        
        private function C($name)
        {
            return '<input type="checkbox" class="form-control" name="'.$name.'" id="'.$name.'"/>';
        }
        
        private function S($name, $sql)
        {
            $html = '<select class="form-control" name="'.$name.'" id="'.$name.'">';
            $q = $this->db->Select($sql);
            foreach($q as $k=>$v){
                $html .= '<option value="'.$v['ID'].'">'.$v['NAME'].'</option>';   
            }            
            $html .= '</select>';
            return $html;
        }
        
        private function R($name, $sql)
        {
            if($sql !== ''){
                return '';
            }
            $html = '';
            $q = $this->db->Select($sql);
            foreach($q as $k=>$v){
                $html .= '<label><input type="radio" name="'.$name.'[]" value="'.$v['ID'].'" class="form-control"/>'.$v['NAME'].'</label>';
            }
            return $html;            
        }
    }