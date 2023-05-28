<?php
    $db = new DB();

    $emp_mail = $_SESSION['insurance']['other']['mail'][0];
    
    $sql_pos_id = "select JOB_POSITION from sup_person where EMAIL = '$emp_mail'";
    $list_pos_id = $db -> Select($sql_pos_id);
    $emp_pos_id = $list_pos_id[0]['JOB_POSITION'];        
    
    $sql_inbox_didnt_open_menu = "select rec.DESTINATION, doc.DOC_LINK, rec.READ, DOC.DATE_START, KIND.NAME_KIND, STATE.STATE_NAME, DOC.SHORT_TEXT, rec.ID, doc.ID MAIL_ID, REC.COMMENT_TO_DOC, REC.SENDER_MAIL from DOC_RECIEPMENTS rec, DOCUMENTS doc, DIC_DOC_STATE state, DIC_DOC_KIND kind where rec.RECIEP_MAIL = '$emp_mail' and REC.STATE = STATE.ID and REC.MAIL_ID = DOC.ID and KIND.ID = DOC.KIND and rec.STATE = 0";
    $list_inbox_didnt_open_menu = $db -> Select($sql_inbox_didnt_open_menu);
    $didnt_open_count = count($list_inbox_didnt_open_menu);
    
    $sql_at_work_didnt_open_menu = "select * from DOC_RECIEPMENTS where RECIEP_MAIL = '$emp_mail' and STATE = 1";
    $list_at_work_didnt_open_menu = $db -> Select($sql_at_work_didnt_open_menu);
    $didnt_at_work_open_count = count($list_at_work_didnt_open_menu);
    
    $sql_outbox = "select 
                        doc.DATE_END, 
                        doc.REG_NUM, 
                        doc.HEAD_TEXT, 
                        doc.REG_NUM, 
                        doc.SENDER, 
                        doc.DATE_START, 
                        doc.DATE_END, 
                        doc.SHORT_TEXT, 
                        DOC_KIND.NAME_KIND, 
                        doc.id MAIL_ID,
                        doc.DOC_LINK
                    from 
                        DOCUMENTS doc, 
                        DIC_DOC_KIND doc_kind 
                    where 
                        doc.SENDER_MAIL = '$emp_mail' and 
                        DOC.KIND = DOC_KIND.ID
                    order by doc.ID DESC";
    $list_outbox_menu = $db -> Select($sql_outbox);
    $outbox = count($list_outbox_menu);
    
    $sql_delegated_open_menu = "select * from DOC_RECIEPMENTS where SENDER_MAIL = '$emp_mail' and (STATE = 1 or STATE = 2)";
    $list_delegated_didnt_open_menu = $db -> Select($sql_delegated_open_menu);
    $didnt_delegated_open_count = count($list_delegated_didnt_open_menu);
    
    $sql_completed_didnt_open_menu = "select * from DOC_RECIEPMENTS rec, DOCUMENTS doc, DIC_DOC_STATE state, DIC_DOC_KIND kind where KIND.ID = DOC.KIND and REC.MAIL_ID = DOC.ID and REC.STATE = STATE.ID and rec.MAIL_ID IN ( select DISTINCT (MAIL_ID) from DOC_RECIEPMENTS where (SENDER_MAIL =  '$emp_mail' or RECIEP_MAIL =  '$emp_mail')) and (rec.STATE = 3 or rec.STATE = 5 or rec.STATE = 8)";
    $list_completed_didnt_open_menu = $db -> Select($sql_completed_didnt_open_menu);
    $didnt_completed_open_count = count($list_completed_didnt_open_menu);
    
    $sql_trash_menu = "select * from DOC_RECIEPMENTS rec, DOCUMENTS doc, DIC_DOC_STATE state, DIC_DOC_KIND kind where KIND.ID = DOC.KIND and REC.MAIL_ID = DOC.ID and REC.STATE = STATE.ID and rec.MAIL_ID IN ( select DISTINCT (MAIL_ID) from DOC_RECIEPMENTS where (SENDER_MAIL =  '$emp_mail' or RECIEP_MAIL =  '$emp_mail')) and rec.STATE = 4";
    $list_trash_menu = $db -> Select($sql_trash_menu);
    $trash = count($list_trash_menu);
?>

    <div class="ibox float-e-margins">
        <div class="ibox-content mailbox-content">
            <div class="file-manager">
                <div class="input-group-btn">
                    <a class="btn btn-block btn-primary compose-mail dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span> Создать </a>
                    <ul class="dropdown-menu">
                        <?php
                            $mail_menu = new MailMenu();
                            $mail_menu->show_menu_btn($emp_pos_id);
                        ?>
                        <li><a href="create_mail_output">Исходящий документ</a></li>
                        <!--<li><a href="create_statement_for_pay">Заявление на выплату(в разработке)</a></li>-->
                    </ul>
                </div>
                <div class="space-25"></div>
                <h5>Папки</h5>
                <ul class="folder-list m-b-md" style="padding: 0">
                    <?php
                        $mail_menu->show_menu_item($emp_pos_id, $didnt_open_count, $didnt_at_work_open_count, $outbox, $didnt_delegated_open_count, $didnt_completed_open_count, $trash);
                    ?>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    