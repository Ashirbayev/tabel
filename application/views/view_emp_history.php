<div class="ibox-content">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Дата события</th>
            <th>Филиал</th>
            <th>Департамент</th>
            <th>Должность до изменений</th>
            <th>Должность</th>
            <th>Оклад</th>
            <th>EMP</th>
            <th>Тип</th>
            <th>Функция</th>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach($list_history as $k => $v)
                {
                    $last_pos = $list_history[$k-1]['ID'];
            ?>
            <tr>
                <td><?php echo $v['ID']; ?></td>
                <td><?php echo $v['EVENT_DATE']; ?></td>
                <td><?php echo $v['BRANCHNAME']; ?></td>
                <td><?php echo $v['DEP_NAME']; ?></td>
                <td><?php echo $v['POSITION_FROM']; ?></td>
                <td><?php echo $v['DOLZH']; ?></td>
                <td><?php echo $v['SALARY']; ?></td>
                <td><?php echo $v['ID_PERSON']; ?></td>
                <td><?php echo $v['ACT_NAME']; ?></td>
                <td>
                    <a target="_blank" href="emp_transfer?transf_id=<?php echo $v['ID']; ?>&last_transf_id=<?php echo $last_pos; ?>" class="btn btn-primary btn-xs">Приказ о переводе</a>
                    <a target="_blank" href="change_salary?transf_id=<?php echo $v['ID']; ?>&last_transf_id=<?php echo $last_pos; ?>" class="btn btn-primary btn-xs">Приказ о повышении оклада</a>
                    <a target="_blank" href="transfer_append?employee_id=<?php echo $empId; ?>&transf_id=<?php echo $v['ID']; ?>&last_transf_id=<?php echo $last_pos; ?>" class="btn btn-primary btn-xs">Дополнительное соглашение</a></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <a target="_blank" href="t2_print?employee_id=<?php echo $empId; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Печать карты Т2</a>
</div>