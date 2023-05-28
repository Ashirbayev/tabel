<?php
    class MailMenu{
        
        //выпадающие пункты кнопки создания
        public function show_menu_btn($emp_id)
        {
            $db = new DB();
            $sql_events = "select event.EVENT_NAME from EVENT_POSIOTION pos, EVENTS event where event.ID = pos.EVENT_ID and TYPE = 1 and POS_ID = '$emp_id' order by id";
            $list_events = $db -> Select($sql_events);
            foreach($list_events as $k => $v){
                $this->$v['EVENT_NAME']();
            }
        }
        
        //кнопки в нижней части письма
        public function show_all_reject_btns($emp_id, $doc_id, $rec_id, $dest_id, $step_id, $next_step_id, $prev_step_id)
        {
            $db = new DB();
            echo '<a data-toggle="modal" data-target="#accept_btn" class="btn btn-sm btn-primary"><i class="fa fa-check-square-o"></i> Завершить и отправить в архив </a>&nbsp;';
            echo '<a class="btn btn-sm btn-info" href="create_mail?mail_id='.$doc_id.'&rec_id='.$rec_id.'&step_id='.$step_id.'&next_step_id='.$step_id.'&prev_step_id='.$prev_step_id.'"><i class="fa fa-arrow-right"></i> Внедрить корректировки и повторить </a>&nbsp;';
        }
        
        //кнопки в нижней части письма
        public function show_menu_btn_func($emp_id, $doc_id, $rec_id, $dest_id, $step_id, $next_step_id, $prev_step_id)
        {
            $db = new DB();
            //$sql_events = "select event.EVENT_NAME from EVENT_POSIOTION pos, EVENTS event where event.ID = pos.EVENT_ID and TYPE = 3 and POS_ID = '$emp_id' order by id";
            $sql_events =   "select 
                                event.ITEM_NAME, 
                                event.EVENT_NAME 
                            from 
                                EVENT_POSIOTION pos, 
                                EVENTS event, 
                                EVENT_AND_DESTINATION dest 
                            where 
                                event.ID = pos.EVENT_ID and 
                                TYPE = 3 and 
                                POS_ID = '$emp_id' and 
                                event.ID = dest.EVENT_ID and 
                                dest.DEST_ID = '$step_id' 
                            order by 
                                event.id";
            $list_events = $db -> Select($sql_events);
            foreach($list_events as $k => $v){
                $title = $v['ITEM_NAME'];
                $this->$v['EVENT_NAME']($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id);
            }
        }
        
        private function create_reception_mail()
        {
            echo '<li><a href="create_mail_reception">Внешний документ</a></li>';
        }
        
        private function create_inner_mail()
        {
            //echo '<li><a href="create_mail_output">На исполнение</a></li>';
        }
        
        private function create_resolution_mail()
        {
            echo '<li><a href="create_inner_doc">Внутренний документ</a></li>';
        }
        
        private function show_reject_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#reject" class="btn btn-sm btn-danger"><i class="fa fa-hand-paper-o"></i> '.$title.'</a>&nbsp;';
        }
        
        private function show_accept_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#accept_btn" class="btn btn-sm btn-primary"><i class="fa fa-check-square-o"></i> '.$title.' </a>&nbsp;';
        }
        
        private function show_lets_work_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a class="btn btn-sm btn-info" href="create_mail?mail_id='.$doc_id.'&rec_id='.$rec_id.'&step_id='.$next_step_id.'&next_step_id=0&prev_step_id='.$prev_step_id.'"><i class="fa fa-arrow-right"></i> '.$title.'</a>&nbsp;';
        }
        
        private function show_lets_work_dep_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a class="btn btn-sm btn-info" href="create_mail_department?mail_id='.$doc_id.'&rec_id='.$rec_id.'&step_id='.$next_step_id.'&next_step_id=0&prev_step_id='.$prev_step_id.'"><i class="fa fa-arrow-right"></i> '.$title.' </a>&nbsp;';
        }
        
        private function show_approve_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#approve" class="btn btn-sm btn-primary"> '.$title.'</a>&nbsp;';
        }
        
        private function show_affirm_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#affirm" class="btn btn-sm btn-primary"> '.$title.'</a>&nbsp;';
        }
        
        private function show_answer_with_file_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#answer_with_file" class="btn btn-sm btn-primary"> '.$title.' </a>&nbsp;';
        }
        
        private function show_add_reg_num($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#add_reg_num" class="btn btn-sm btn-primary"> '.$title.' </a>&nbsp;';
        }
        
        private function show_got_it($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#got_it" class="btn btn-sm btn-info"> '.$title.' </a>&nbsp;';
        }
        
        private function show_approve_tech_support($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#tech_support" class="btn btn-sm btn-info"> '.$title.' </a>&nbsp;';
        }
        
        private function show_send_to_affirm_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#send_to_accept" class="btn btn-sm btn-info"> '.$title.' </a>&nbsp;';
        }
        
        private function show_affirm_order_btn($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#affirm_order" class="btn btn-sm btn-info"> '.$title.' </a>&nbsp;';
        }
        
        private function show_add_reg_order_num($doc_id, $rec_id, $title, $step_id, $next_step_id, $prev_step_id)
        {
            echo '<a data-toggle="modal" data-target="#add_reg_order_num" class="btn btn-sm btn-info"> '.$title.' </a>&nbsp;';
        }
    }
?>