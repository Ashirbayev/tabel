<?php
    class Document
    {
        //возращает следующий шаг
        public function get_next_and_prev_step($trip_id, $step_id)
        {
            $db = new DB();
            $sql_steps = "select
                            step.*,
                            DEST.NAME,
                            nvl((select max(id) from DOC_TRIP_STEPS where TRIP_ID = '$trip_id' and id < step.id), 0) id_prev,
                            nvl((select min(id) from DOC_TRIP_STEPS where TRIP_ID = '$trip_id' and id > step.id), 0) id_next
                         from
                            DOC_TRIP_STEPS step,
                            DIC_DOC_DESTINATION dest
                        where
                            DEST.ID = STEP.STEP_ID and
                            STEP.TRIP_ID = '$trip_id' and 
                            STEP.ID = '$step_id'
                        order by step.ID";
            $list_steps = $db -> Select($sql_steps);
            return $list_steps;
        }
    }
?>