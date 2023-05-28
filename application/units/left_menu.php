<?php
	class LEFT_MENU
    {
        private $db;
        private $email;

        public function __construct()
        {
            $this->db = new DB();
            $this->email =  $_SESSION[USER_SESSION];;
        }

        public function init()
        {
            //$sql = "select job_position id_DOLZH from sup_person where email = '$this->email'";
            //echo $sql;
            //$q = $this->db->Select($sql);
            
            //$menu_array = $this->gen_menu($q[0]['ID_DOLZH']);
            //return $this->html_menu($menu_array);
            return '<li class=""><a><i class="fa fa-vcard"></i> <span class="nav-label">Персонал</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="employee"><i class=""></i>Добавить сотрудника</a></li>
                            <li><a href="all_employees"><i class=""></i>Все сотрудники</a></li>
                            <li><a href="table_other"><i class=""></i>Табель для кадровой службы</a></li>
                            <li><a href="timesheet_for_dir"><i class=""></i>Табель для директоров СП</a></li>
                            <li><a href="timesheet_for_branch_dir"><i class=""></i>Табель для директоров филиала</a></li>
                            <li><a href="add_position"><i class=""></i>Позиции</a></li>
                            <li><a href="departments"><i class=""></i>Департаменты</a></li>
                            <li><a href="branches"><i class=""></i>Филиалы</a></li>
                            <li><a href="companies"><i class=""></i>Компании</a></li>
                            <li><a href="reports"><i class=""></i>Статистика по персоналу</a></li>
                            <li><a href="avail_holidays"><i class=""></i>Остатки отпускных дней</a></li>
                            <li><a href="holidays"><i class=""></i>Выходные</a></li>
                            <li><a href="list_sup_contracts"><i class=""></i>Документы</a></li>
                            <li><a href="create_timesheet"><i class=""></i>Создать табель</a></li>
                        </ul>
                    </li>
                    <!--
                    <li class=""><a><i class="fa fa-user-secret"></i>
                        <span class="nav-label">Админ</span>
                        <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                        <li class="" id="doc_syst"><a href="list_forms"><i class=""></i>Страницы системы</a></li>
                        <li><a href="set_roles"><i class=""></i>Настройка доступа</a></li></ul>
                    </li>
                    <li id="documentooborot" class=""><a><i class="fa fa-rocket"></i> <span class="nav-label">Документооборот</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" style=""><li class="doc_inbox" id="doc_inbox">
                        <a href="#">ВХОДЯЩИЕ<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level2 collapse">
                                <li class="on_inbox_new" id="on_inbox_new">
                                    <a href="on_inbox_new" data1="doc_inbox" data2="documentooborot">Новые <span class="label label-info pull-right">1</span></a>
                                </li>
                                <li>
                                    <a href="on_assignment" data1="doc_inbox" data2="documentooborot">Делегировано <span class="label label-info pull-right">1</span></a>
                                </li>
                                <li>
                                    <a href="on_my_control" data1="doc_inbox" data2="documentooborot">На контроле <span class="label label-info pull-right"></span></a>
                                </li>                    
                                <li>
                                    <a href="on_my_execution" data1="doc_inbox" data2="documentooborot">На исполнении <span class="label label-info pull-right">5</span></a>
                                </li>
                                <li>
                                    <a href="on_my_archive" data1="doc_inbox" data2="documentooborot">В архиве <span class="label label-info pull-right">2</span></a>
                                </li>
                                <li>
                                    <a href="on_my_rejection" data1="doc_inbox" data2="documentooborot">Отклоненные <span class="label label-info pull-right"></span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="doc_my_project" id="doc_my_project">
                        <a href="#">МОИ ПРОЕКТЫ (ВНУТРЕННИЕ)<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="on_my_project" data1="doc_my_project" data2="documentooborot">Проекты<span class="label label-info pull-right"></span></a>
                                </li>
                                <li>
                                    <a href="on_agreement" data1="doc_my_project" data2="documentooborot">На согласовании <span class="label label-info pull-right">3</span></a>
                                </li>
                                <li>
                                    <a href="on_rejection" data1="doc_my_project" data2="documentooborot">Отклоненные <span class="label label-info pull-right"></span></a>
                                </li>
                                <li>
                                    <a href="on_execution" data1="doc_my_project" data2="documentooborot">В работе <span class="label label-info pull-right">4</span></a>
                                </li>
                                <li>
                                    <a href="on_resulution" data1="doc_my_project" data2="documentooborot">Ожидает резолюции <span class="label label-info pull-right"></span></a>
                                </li>
                                <li>
                                    <a href="on_archive" data1="doc_my_project" data2="documentooborot">Завершенные <span class="label label-info pull-right"></span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="doc_outbox" id="doc_outbox">
                        <a href="#">МОИ ПРОЕКТЫ (ВНЕШНИЕ)<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="on_project" data1="doc_outbox" data2="documentooborot">Проекты<span class="label label-info pull-right"></span></a>
                                </li>
                                <li>
                                    <a href="on_agreement_out" data1="doc_outbox" data2="documentooborot">На согласовании/подписании<span class="label label-info pull-right"></span></a>
                                </li>
                                <li>
                                    <a href="on_registration" data1="doc_outbox" data2="documentooborot">Подписанные <span class="label label-info pull-right"></span></a>
                                </li>
                                <li>
                                    <a href="on_archive_outter" data1="doc_outbox" data2="documentooborot">Отправленные <span class="label label-info pull-right"></span></a>
                                </li>
                                <li>
                                    <a href="on_rejection" data1="doc_outbox" data2="documentooborot">Отклоненные <span class="label label-info pull-right"></span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="assign" id="assign">
                        <a href="#">ПОРУЧЕНИЯ<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="assign" data1="assign" data2="documentooborot">Действующие поручения<span class="label label-info pull-right"></span></a>
                                </li><li><a href="assign_accept" data1="assign" data2="documentooborot">Завершенные поручения<span class="label label-info pull-right"></span></a></li></ul>
                        </li>
                        <li class="doc_syst">
                            <a href="docsyst_report"><i class=""></i>Отчет по СЭД</a>
                        </li>
                        <li class="doc_search" id="doc_search">
                        <a href="#">ПОИСК <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="all_my_docs" data1="doc_search" data2="documentooborot">Все мои документы<span class="label label-info pull-right"></span></a>
                                </li>
                            </ul>
                        </li><li>
                                <a href="#">История всех писем <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse">
                                    <li>
                                        <a href="mail_history_of_employees">Документы сотрудников<span class="label label-info pull-right"></span></a>
                                    </li>
                                    <li>
                                        <a href="mail_history">Все письма<span class="label label-info pull-right"></span></a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Канцелярия (в разработке) <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse">
                                    <li>
                                        <a href="on_exec_from_reception">В работе <span class="label label-info pull-right"></span></a>
                                    </li>
                                    <li>
                                        <a href="on_reception">Отклоненные <span class="label label-info pull-right"></span></a>
                                    </li>
                                    <li>
                                        <a href="on_reception_archive">Архив <span class="label label-info pull-right"></span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="doc_syst">
                                <a href="office_report"><i class=""></i>Отчет по СЭД (канцелярия)</a>
                            </li></ul></li>-->';
        }

        private function gen_menu($id_dolzh)
        {
            $dan = array();

            $q = $this->db->Select("
            select 
              dm.id_num, 
              dm.id, 
              case  
                when (select name from dir_menu where id = dm.id_num) is null then dm.name
                else (select name from dir_menu where id = dm.id_num)
              end main_menu,   
              case  
                when (select name from dir_menu where id = dm.id_num) is null then null
                else dm.name
              end child_menu,               
              dm.icon,
              (select icon from dir_menu where id = dm.id_num) icon_main, 
              (select name_url from dir_forms where id = DM.ID_FORM) url
            from 
              dir_menu dm 
            where 
              DM.ID_FORM in(select d.id from DIR_FORM_DOLZH f, dir_forms d where F.ID_FORM = D.ID and F.ID_METHOD = 0 and F.ID_DOLZH = $id_dolzh)
              order by 1, 2
            ");
            return $q;
        }

        private function html_menu($dan)
        {
            $main = '';
            $html = '';
            $close_ul = '';

            $db = new DB();
            $emp_mail = $_SESSION['insurance']['other']['mail'][0];

            $sql_pos_id = "select JOB_POSITION from sup_person where EMAIL = '$emp_mail'";
            $list_pos_id = $db -> Select($sql_pos_id);
            $emp_pos_id = $list_pos_id[0]['JOB_POSITION'];        

            $sql_inbox_didnt_open_menu = "select rec.DESTINATION, doc.DOC_LINK, rec.READ, DOC.DATE_START, KIND.NAME_KIND, STATE.STATE_NAME, DOC.SHORT_TEXT, rec.ID, doc.ID MAIL_ID, REC.COMMENT_TO_DOC, REC.SENDER_MAIL from DOC_RECIEPMENTS rec, DOCUMENTS doc, DIC_DOC_STATE state, DIC_DOC_KIND kind where rec.RECIEP_MAIL = '$emp_mail' and REC.STATE = STATE.ID and REC.MAIL_ID = DOC.ID and KIND.ID = DOC.KIND and rec.STATE = 0";
            $list_inbox_didnt_open_menu = $db -> Select($sql_inbox_didnt_open_menu);
            $didnt_open_count = count($list_inbox_didnt_open_menu);
            if($didnt_open_count == 0){$didnt_open_count = '';}else{$didnt_open_count = '<span class="label label-danger">'.$didnt_open_count.'</span>';}

            $sql_at_work_didnt_open_menu = "select * from DOC_RECIEPMENTS where RECIEP_MAIL = '$emp_mail' and (STATE = 1 OR STATE = 5)";
            $list_at_work_didnt_open_menu = $db -> Select($sql_at_work_didnt_open_menu);
            $didnt_at_work_open_count = count($list_at_work_didnt_open_menu);
            if($didnt_at_work_open_count == 0){$didnt_at_work_open_count = '';}else{$didnt_at_work_open_count = '<span class="label label-info">'.$didnt_at_work_open_count.'</span>';}

            $sql_approved = "select * from DOC_RECIEPMENTS where reciep_mail = '$emp_mail' AND state = 5";
            $list_approved = $db -> Select($sql_approved);
            $didnt_approved = count($list_approved);
            if($didnt_approved == 0){$didnt_approved = '';}else{$didnt_approved = '<span class="label label-info">'.$didnt_approved.'</span>';}

            $sql_outbox = "select doc.* from DOCUMENTS doc, DIC_DOC_KIND doc_kind where doc.SENDER_MAIL = '$emp_mail' and DOC.KIND = DOC_KIND.ID order by doc.ID DESC";
            $list_outbox_menu = $db -> Select($sql_outbox);
            $outbox = count($list_outbox_menu);
            if($outbox == 0){$outbox = '';}else{$outbox = '<span class="label label-warning">'.$outbox.'</span>';}

            $sql_delegated_open_menu = "select *
                    from 
                        DOCUMENTS doc, 
                        DOC_RECIEPMENTS rec, 
                        DIC_DOC_KIND doc_kind, 
                        SUP_PERSON triv 
                    where 
                        rec.SENDER_MAIL = '$emp_mail' and 
                        REC.MAIL_ID = DOC.ID and 
                        DOC.KIND = DOC_KIND.ID and 
                        TRIV.EMAIL = rec.RECIEP_MAIL and 
                        (rec.STATE = 1 or rec.STATE = 2)";
            $list_delegated_didnt_open_menu = $db -> Select($sql_delegated_open_menu);
            $didnt_delegated_open_count = count($list_delegated_didnt_open_menu);
            if($didnt_delegated_open_count == 0){$didnt_delegated_open_count = '';}else{$didnt_delegated_open_count = '<span class="label label-info">'.$didnt_delegated_open_count.'</span>';}

            $sql_completed_didnt_open_menu = "select * from DOC_RECIEPMENTS rec, DOCUMENTS doc, DIC_DOC_STATE state, DIC_DOC_KIND kind where KIND.ID = DOC.KIND and REC.MAIL_ID = DOC.ID and REC.STATE = STATE.ID and rec.MAIL_ID IN ( select DISTINCT (MAIL_ID) from DOC_RECIEPMENTS where (SENDER_MAIL =  '$emp_mail' or RECIEP_MAIL =  '$emp_mail')) and (rec.STATE = 3 or rec.STATE = 8 or rec.STATE = 7 or rec.STATE = 9)";
            $list_completed_didnt_open_menu = $db -> Select($sql_completed_didnt_open_menu);
            $didnt_completed_open_count = count($list_completed_didnt_open_menu);
            if($didnt_completed_open_count == 0){$didnt_completed_open_count = '';}else{$didnt_completed_open_count = '<span class="label label-primary">'.$didnt_completed_open_count.'</span>';}

            $sql_trash_menu = "select * from DOC_RECIEPMENTS rec, DOCUMENTS doc, DIC_DOC_STATE state, DIC_DOC_KIND kind where KIND.ID = DOC.KIND and REC.MAIL_ID = DOC.ID and REC.STATE = STATE.ID and rec.MAIL_ID IN ( select DISTINCT (MAIL_ID) from DOC_RECIEPMENTS where (SENDER_MAIL =  '$emp_mail' or RECIEP_MAIL =  '$emp_mail')) and rec.STATE = 4";
            $list_trash_menu = $db -> Select($sql_trash_menu);
            $trash = count($list_trash_menu);
            if($trash == 0){$trash = '';}else{$trash = '<span class="label label-danger">'.$trash.'</span>';}

            foreach($dan as $k=>$v)
                {
                                        
                    if(trim($v['MAIN_MENU']) !== $main){
                        if($close_ul !== ''){
                            $html .= $close_ul."</li>";
                        }
                        $html .= "<li>";

                        if(trim($v['CHILD_MENU']) == ''){
                            $html .= '<a href="'.$v['URL'].'"><i class="'.$v['ICON'].'"></i> <span class="nav-label">'.$v['MAIN_MENU'].'</span></a>';
                            $close_ul = "</li>";
                        }else{                              
                           $html .= '<a><i class="'.$v['ICON_MAIN'].'"></i> <span class="nav-label">'.$v['MAIN_MENU'].'</span> <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">';
                           if($v['ID'] == 56){
                           $html .= '<li class="active">
                                            <a href="inbox"> <span class="nav-label">Входящие '.$didnt_open_count.' </span></a>
                                        </li>
                                        <li><a href="at_work"><i class=""></i>В работе'.$didnt_at_work_open_count.'</a></li>
                                        <li><a href="approved"><i class=""></i>Согласовано'.$didnt_approved.'</a></li>';
                           }else if($v['ID'] == 57){
                            $html .= '<li class="active">
                                            <a href="outbox"> <span class="nav-label">Исходящие '.$outbox.'</span></a>
                                          </li>
                                          <li><a href="delegated"><i class=""></i>Делегировано'.$didnt_delegated_open_count.'</a></li>
                                          <li><a href="completed"><i class=""></i>Завершено'.$didnt_completed_open_count.'</a></li>
                                          <li><a href="trash"><i class=""></i>Отклонено'.$trash.'</a></li>';
                            }else{
                                $html .= '<li><a href="'.$v['URL'].'"><i class="'.$v['ICON'].'"></i>'.$v['CHILD_MENU'].'</a></li>';
                            }                            
                            $close_ul = '</ul>';
                        }                        
                    }else{
                        if($v['ID'] == 56){
                                $html .= '<li class="active">
                                            <a href="inbox"> <span class="nav-label">Входящие '.$didnt_open_count.' </span></a>
                                        </li>
                                        <li><a href="at_work"><i class=""></i>В работе'.$didnt_at_work_open_count.'</a></li>
                                        <li><a href="approved"><i class=""></i>Согласовано'.$didnt_approved.'</a></li>';
                            }else if($v['ID'] == 57){
                                $html .= '<li class="active">
                                            <a href="outbox"> <span class="nav-label">Исходящие '.$outbox.'</span></a>
                                          </li>
                                          <li><a href="delegated"><i class=""></i>Делегировано'.$didnt_delegated_open_count.'</a></li>
                                          <li><a href="completed"><i class=""></i>Завершено'.$didnt_completed_open_count.'</a></li>
                                          <li><a href="trash"><i class=""></i>Отклонено'.$trash.'</a></li>';
                            }else{
                            if(trim($v['CHILD_MENU']) !== ''){
                                $html .= '<li><a href="'.$v['URL'].'"><i class="'.$v['ICON'].'"></i>'.$v['CHILD_MENU'].'</a></li>';
                            }
                        }
                    }                    

                    $main = trim($v['MAIN_MENU']);
                }
            return $html;
        }
    }
?>
