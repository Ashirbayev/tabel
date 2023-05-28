<?php
    /*
	class MENU
    {
        private $db;        
        public function __construct()
        {            
            $this->db = new DB();
        }
                
        public function GenMenu($id_role)
        {
            $html = '';
            $SQL = "SELECT funct FROM MENU_ROLE M, MENU_CLASSES C WHERE C.ID = M.ID_MENU AND ID_ROLE = $id_role ORDER BY NUM_PP";                        
            $row = $this->db->Select($SQL);
            foreach($row as $k=>$v)
            {
                $funct = $v['FUNCT'];
                $html .= $this->$funct();
            }
            return $html;
        }
        
        public function Contracts()
        {
            global $active_user_dan;
            if(isset($active_user_dan['role_type'])){
                if($active_user_dan['role_type'] !== '0')
                {
                    return '<li id="contracts">
                    <a href="#"><i class="fa fa-th-large"></i>
                        <span class="nav-label">Договора</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="search_contracts" data-active="contracts" id="search_contracts">Поиск</a>
                        </li>
                        <li>                        
                            <a href="new_contract?paym_code=0701000001" data-acive="contracts">Регистрация</a>                        
                        </li>                                                
                    </ul>
                </li>';
                }
            }
            $html = '<li id="contracts">
                    <a href="#"><i class="fa fa-th-large"></i> 
                        <span class="nav-label">Договора</span> 
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="search_contracts" data-active="contracts" id="search_contracts">Поиск</a>
                        </li>
                        <li>                        
                            <a data-toggle="modal" data-target="#new_contract" data-acive="contracts">Регистрация</a>                        
                        </li>                                                
                    </ul>
                </li>';
                
            $html .= '<div class="modal inmodal fade" id="new_contract" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                        </button>
                        <i class="fa fa-umbrella modal-icon"></i>
                        <h4 class="modal-title">Выбор продукта</h4>
                        <small class="font-bold">Выберите озин из продуктов страхования для заведения нового договора</small>
                    </div>
                    <div class="modal-body">
                    <p>';
            
            $this->db->ClearParams();
            $r = $this->db->Select("select p.id, p.code, p.name, p.id_parent, p.code code_v, p.name name_v, p.note from dic_payments p where p.type = 2 and p.in_prog = 1");    
            foreach($r as $k=>$v){
                $this->db->ClearParams();
                $s = $this->db->Select("select * from dic_reason where paym_code = '".$v['CODE']."'");
                if(count($s) > 0){
                    $html .= '<div class="btn-group btn-block"><button data-toggle="dropdown" class="btn btn-primary btn-block btn-outline dropdown-toggle">
                    '.$v['NAME'].'<span class="caret"></span></button> <ul class="dropdown-menu">';
                    
                    foreach($s as $f=>$st)
                    {
                        $html .= '<li><a href="new_contract?paym_code='.$v['CODE'].'?prichina='.$st['ID'].'">'.$st['NAME'].'</a></li>';                
                    }
                    $html .= '</ul></div>';
                    
                }else{
                    $html .= '<a href="new_contract?paym_code='.$v['CODE'].'" class="btn btn-primary btn-block btn-outline">'.$v['NAME'].'</a>';   
                }        
            }    
            $html .= '</p></div><div class="modal-footer"><button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button></div>
            </div></div></div>';
            return $html;            
        }
        
        public function Clients()
        {
            return '<li>
                    <a href="#"><i class="fa fa-users"></i> 
                        <span class="nav-label">Клиенты</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="search_clients">Поиск</a></li>
                        <li><a href="clients_edit?sicid=0">Регистрация</a></li>
                        <li><a href="#">Уведомления</a></li>                        
                    </ul>
                </li>';
        }
        
        public function Directorys()
        {
            global $active_user_dan;            
            if($active_user_dan['role'] == 21){
                return '<li>
                    <a href="#"><i class="fa fa-newspaper-o"></i> 
                        <span class="nav-label">Справочники </span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">                        
                        <li><a href="contragents">Контрагенты</a></li>
                        <li><a href="frm_terror">Террористы</a></li>                        
                    </ul>
                </li>';
            }
            return '<li>
                    <a href="#"><i class="fa fa-newspaper-o"></i> 
                        <span class="nav-label">Справочники </span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="prog_types">Программы страхования</a></li>
                        <li><a href="contragents">Контрагенты</a></li>
                        <li><a href="strah_agent">Страховые агенты</a></li>
                        <li><a href="act_terr">Территория действия агента</a></li>
                        <li><a href="annuit_status">Статус аннуитета</a></li>
                        <li><a href="banks">Банки</a></li>
                        <li><a href="regions">Регионы</a></li>
                        <li><a href="contracts_pref">Справочник префиксов договоров</a></li>
                        <li><a href="filial">Справочник филиалов и подразделений</a></li>
                        <li><a href="proxy">Доверенности</a></li>
                        <li><a href="mrsu">МРСУ</a></li>
                        <li><a href="frm_terror">Террористы</a></li>
                        <li><a href="country">Страны</a></li>
                        <li><a href="losses">Возмещение убытка от перестраховщика</a></li>
                        <li><a href="premium">Справочник премий по перестрахованию</a></li>
                        <li><a href="persons">Список сотрудников</a></li>
                    </ul>
                </li>';
        }
        
        public function Calculator()
        {
            return '<li>
                    <a href="#"><i class="fa fa-calculator"></i> 
                        <span class="nav-label">Калькуляторы</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="#">Обычный</a></li>
                        <li><a href="#">Пенсионный</a></li>
                        <li>
                            <a href="#">
                                <span class="nav-label">Кормилец</span>
                                <span class="fa arrow"></span>                            
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li><a href="#">Краткосрочный</a></li>
                                <li><a href="#">Долгосрочный</a></li>
                            </ul>
                        </li>
                        <li><a href="#">ОСНС</a></li>
                        <li><a href="#">Казахмыс</a></li>
                    </ul>
                </li>';
        }
        
        public function Segment()
        {
            return '<li>
                    <a href="#">
                        <i class="fa fa-briefcase"></i> 
                        <span class="nav-label">Сегментирование </span>
                        <span class="fa arrow"></span>    
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="#">Контрагенты</a></li>
                        <li><a href="curators">Кураторы</a></li>
                        <li><a href="#">Сегменты</a></li>
                        <li><a href="#">Запрос на смену</a></li>
                    </ul>
                </li>';
        }
        
        public function Admin()
        {
            return '<li>
                    <a href="#">
                        <i class="fa fa-gear"></i>
                        <span class="nav-label">Админ</span>
                        <span class="fa arrow"></span>    
                    </a>
                    <ul class="nav nav-second-level collapse"> 
                        <li>
                            <a href="#">Списки <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse" style="height: 0px;">
                                <li><a href="menu_classes">Главное меню</a></li>                                
                                <li><a href="dir_forms">Формы</a></li>                        
                                <li><a href="dir_role">Роли</a></li>
                                <li><a href="dir_method">Методы</a></li>                                    
                            </ul>
                        </li>                                           
                        
                        <li>
                            <a href="#">Назначение <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse" style="height: 0px;">
                                <li><a href="app_menu_role">Меню к Роли</a></li>
                                <li><a href="forms_method">Методов в Формы</a></li>                        
                                <li><a href="forms_role">Форм и методов к роли</a></li>
                            </ul>
                        </li>
                        <li><a href="admin_users">Пользователей</a></li>
                    </ul>
                </li>';
        }
        
        public function Surv()
        {
            return '
            <li>
                <a href="#">
                    <i class="fa fa-street-view"></i>
                    <span class="nav-label">СУРВ</span>
                    <span class="fa arrow"></span>    
                </a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="turniket">Турникеты</a></li>                    
                </ul>
            </li>';
        }
        
        public function StandDog()
        {
            return '<li>
                    <a href="list_standart_contracts"><i class="fa fa-info-circle"></i> <span class="nav-label">Типовые договора</span></a>
                </li>';
        }
                
    }
    */
?>

