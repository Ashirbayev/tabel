<?php
	class DIC_FORMS
    {
        private $db;
        public $array;
        public $html;
        public $message = '';
        
        
        public function __construct()
        {
            require_once 'application/units/database.php';
            $this->db = new DB();            
            $method = $_SERVER['REQUEST_METHOD'];            
            $this->$method();
        }
        
        
        private function GET()
        {
            if(count($_GET) <= 0){
                $this->html = $this->index();                
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
                foreach($_POST as $k=>$v);                                
                if(method_exists($this, $k)){                    
                    $this->array = $_POST;
                    $this->$k($v); 
                }
            }
            $this->GET();             
        }
        
        
        private function save_form_naimen($id)
        {
            $a = $this->array;
            unset($a['save_form_naimen']);
            if(trim($a['name']) == ''){
                $this->message = ALERTS::ErrorMin('Наименование не может быть пустым');
                return;
            }
            
            if(trim($a['url']) == ''){
                $this->message = ALERTS::ErrorMin('Ссылка URL не может быть пустым');
                return;
            }
            
            if($id == 0){
                $sql = "insert into DIR_FORMS(id, name_url, name_form) values(SEQ_DIR_FORMS.nextval, '".$a['url']."', '".$a['name']."')";    
            }else{
                $sql = "update DIR_FORMS set name_form = '".$a['name']."', name_url = '".$a['url']."' where id = $id";
            }
            
            $b = $this->db->Execute($sql); 
            if($b){
                $this->message = ALERTS::SuccesMin('Данные успешно сохранены');       
            }else{
                $this->message = ALERTS::SuccesMin($b);
            }                    
            return;            
        }
        
        
        public function forms()
        {                        
            $q = $this->db->Select("select * from dir_forms order by id");                        
            return $q;
        }
                        
        public function dir_menu_free_main($id_form)
        {
            $q = $this->db->Select("select * from dir_menu where id_num = 0 and (id_form is null or id_form = $id_form)");
            return $q;
        }
        
        public function dir_menu_free_child($id_main)
        {
            $q = $this->db->Select("select * from dir_menu where id = $id_main");
            return $q;
        }                
        
        private function edit_main_menu()
        {
            $id = $this->array['id'];
            $id_num = $this->array['id_num'];
            $name = $this->array['edit_main_menu'];                                                
            $id_form = $this->array['id_form'];            
            
            if($id == '0'){
                $sql = "insert into dir_menu(id, id_num, name, id_form) values(seq_dir_menu.nextval, $id_num, '$name', $id_form)";                
            }else{
                $sql = "update dir_menu set id_num = $id_num, name = '$name', id_form = $id_form where id = $id";
            }
                       
            $b = $this->db->Execute($sql);
            if($b !== true){
                $this->message = $b;
            } 
            header("Location: list_forms?form_id=$id");           
            return;            
        }
        
        private function child_menu()
        {
            if(trim($this->array['list_main_menu']) == '0'){
                echo ALERTS::ErrorMin('Не выбрано основное дерево');
                exit;
            }
            
            if(trim($this->array['list_main_menu']) == ''){
                echo ALERTS::ErrorMin('Не выбрано основное дерево');
                exit;
            }
            
            /*
            проверка дочерное меню по child_id
            если находит тогда
                заносим в переменную ID1
                
                проверка по сhild_name и id_form
                если находим тогда сверяем ID1 c ID2
                    Если совпадают тогда update
                    иначе insert
            иначе
                insert 
            */            
            $id_main = $this->array['list_main_menu'];
            $id_child = $this->array['id'];
            $name = $this->array['child_menu'];
            $id_form = $this->array['id_form'];
             
            if(trim($name) == ''){
                $this->db->Execute("update dir_menu set id_form = $id_form where id = $id_main");
                $this->message = ALERTS::SuccesMin("Данные успешно обновленны");
                header("Location: list_forms?form_id=$id_child");
                return;
                
            }
            if($id_child == 0){
                $this->db->Execute("update dir_menu set id_form = null where id = $id_main");
                $this->db->Execute("insert into dir_menu(id, id_num, name, id_form) 
                values(seq_dir_menu.nextval, $id_main, '$name', $id_form)");
                
                $this->message = ALERTS::SuccesMin("Данные успешно обновленны");
                header("Location: list_forms?form_id=$id_child");
                return;
            }else{                    
                $this->db->Execute("update dir_menu set name = '$name' where id = $id_child");
                $this->message = ALERTS::SuccesMin("Данные успешно обновленны");
                header("Location: list_forms?form_id=$id_child");
                return;
            }
            
            return;
        }
        
        public function form_id($id)
        {
            $dan = array();
            $f = $this->db->Select("select * from dir_forms where id = $id");
            if(count($f) > 0){            
                $dan = $f[0];
            }else{
                $dan['ID'] = 0;
            }
                        
            $dan['methods'] = $this->db->Select("select m.* from dir_method m where m.id_form = $id ");            
            $dan['main_menu_list'] = $this->dir_menu_free_main($id);
                        
            $dan['child_menu'] = array();
            $dan['main_menu'] = array();
            
            $menu = $this->db->Select("select * from dir_menu where id_form = $id");
            if(count($menu) > 0){            
                if($menu[0]['ID_NUM'] !== '0'){
                    $dan['child_menu'] = $menu[0];
                    $q = $this->db->Select("select * from dir_menu where id = ".$menu[0]['ID_NUM']);                                
                    $dan['main_menu'] = $q[0]; 
                }else{
                    $dan['main_menu'] = $menu[0];
                }            
            }                       
            
            $this->array = $dan;
            return;
        }
        
        private function index()
        {
            $this->form_id(0);
        }
        
        private function save_method()
        {
            $dan = $this->array;
            unset($dan['save_method']);
            $mn = $dan['method_name'];
            $ma = $dan['method_action'];
            $f = $dan['id_form'];
                        
            $b = $this->db->Execute("insert into dir_method(id, method_name, method_action, id_form) values(SEQ_DIR_METHOD.nextval, '$mn', '$ma', $f)");
            if($b !== true){
                $this->message = ALERTS::ErrorMin($b);
                return;
            }
            $this->message = ALERTS::SuccesMin('Метод добавлен успешно');
            return;
        }
        
        private function close_method($id)
        {
            $b = $this->db->Execute("update dir_method set state = 1 where id = $id");
            if($b == true){
                echo '';
            }else{
                echo ALERTS::ErrorMin($b);                
            }
            exit;
        }
        
        private function clear_menu($id)
        {
            $this->db->Execute("delete from dir_menu where id_form = $id and id_num > 0");
            $this->db->Execute("update dir_menu set id_num = null where id_form = $id");
            echo '';
            exit;
        }
            
        
    }
?>