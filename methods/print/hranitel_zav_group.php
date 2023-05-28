<?php
	header('Content-Type: text/html; charset=utf-8');    
?>
<link href="styles/css/bootstrap.min.css"/>

<div id="print_zav_text">
<img src="styles/img/logo gak.png" width="250px"/>
<p style="text-align: center;" align="left"><strong>ЗАЯВЛЕНИЕ НА ГРУППОВОЕ СТРАХОВАНИЕ ЖИЗНИ № <?php echo $dan['zv_num']; ?></strong></p>
<p><strong>1. Сведения о Страхователе (юр. лицо):</strong></p>
<table border="1" width="100%" cellspacing="0" cellpadding="0">
<tbody>
    <tr>
        <td valign="top" width="323"><p>Полное наименование:</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['NAME']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>БИН</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['BIN']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Кбе</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['KBE']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Код сектора экономики</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['SEC_ECONOM']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Признак резидентства:</p></td>
        <td valign="top" width="369"><p><?php if($dan['strahovatel']['RESIDENT'] == '1'){ echo 'Резидент';}else echo 'Не Резидент';; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Юридический адрес:</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['ADDRESS']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Фактический адрес:</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['ADDRESS']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Телефон, электронный адрес:</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['PHONE']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323">
            <p>Банковские реквизиты:</p>
            <p>Наименование банка</p>
            <p>БИК банка</p>
            <p>ИИК (20 знаков)</p>
        </td>
        <td valign="top" width="369">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p><?php echo $dan['bank_iik']; ?></p>
        </td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>ОКЭД/Виды экономической деятельности:</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['OKED_NAME']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Численность работников:</p></td>
        <td valign="top" width="369"><p><?php echo count($dan['print_zayavlenie']); ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323"><p>Должность и Ф.И.О. руководителя организации:</p></td>
        <td valign="top" width="369"><p><?php echo $dan['strahovatel']['CHIEF_DOLZH'].' '.$dan['CHIEF']; ?></p></td>
    </tr>
    <tr>
        <td valign="top" width="323">
            <p>Является ли первый руководитель или член (-ы) исполнительного органа иностранным публичным должностным лицом (политическим деятелем или государственным служащим иностранного государства)?</p>
        </td>
        <td valign="top" width="369">
            <p>Нет</p>
        </td>
    </tr>
</tbody>
</table>

<p><strong>2. Условия страхования:</strong></p>
<table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top" width="323"><p>Срок (в годах)</p></td>
            <td valign="top" width="369"><?php echo $dan['max_strah_god']; ?></td>
        </tr>
        <tr>
            <td valign="top" width="323"><p>Страховая премия</p></td>
            <td valign="top" width="369"><p><?php echo $dan['PAY_SUM_P_ALL'].' '.$dan['PAY_SUM_P_TEXT']; ?></p></td>
        </tr>
        <tr>
            <td valign="top" width="323"><p>Страховой взнос (цифрами и прописью)</p></td>
            <td valign="top" width="369"><p><?php echo $dan['PAY_SUM_V_ALL'].' '.$dan['PAY_SUM_V_TEXT']; ?></p></td>
        </tr>
        <tr>
            <td valign="top" width="323"><p>Периодичность оплаты страхового взноса</p></td>
            <td valign="top" width="369">            
                <p><?php echo $dan['print_zayavlenie'][0]->periodich; ?></p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="323"><p>Период действия страховой защиты</p></td>
            <td valign="top" width="369"><p>с <?php echo $dan['date_begin']; ?> г. по <?php echo $dan['date_end']; ?> г.</p></td>
        </tr>
    </tbody>
</table>
<p><strong>3. Общая страховая премия (цифрами и прописью): </strong> <?php echo $dan['PAY_SUM_P_ALL'].' '.$dan['PAY_SUM_P_TEXT']; ?>.</p>
<p><strong>4. Общая страховая сумма по договору</strong> <strong>(цифрами и прописью): </strong> <?php echo $dan['PAY_SUM_V_ALL'].' '.$dan['PAY_SUM_V_TEXT']; ?>.</p>
<p><strong>5. Сведения о Застрахованных: </strong>согласно Приложению 1 к настоящему Заявлению.</p>
<p><strong>6. Основные и дополнительные покрытия:</strong></p>
<p><strong>&nbsp;&nbsp;&nbsp; Основные покрытия: </strong></p>
<p>Смерть застрахованного по любой причине</p>

<p><strong>&nbsp;&nbsp;&nbsp; Дополнительные покрытия:</strong> <input type="checkbox" <?php if(count($dan['print_zayavlenie'][0]->dop_pokr) > 0){echo 'checked';} ?>> Да <input type="checkbox" <?php if(count($dan['print_zayavlenie'][0]->dop_pokr) == 0){echo 'checked';} ?>>Нет</p>
<?php 
foreach($dan['dop_pokr'] as $k=>$v){
    echo '<p>'.$v.'</p>';
}
?>
<hr />
<p>Даю согласие на заключение договора страхования жизни.</p>
<p>Подтверждаю, что ознакомлен (-а) с условиями страхования и получил (-а) копию правил страхования.</p>
<p><strong>Принимаю ответственность за предоставление недостоверных данных, отраженных в Заявлении и Анкете. </strong></p>
<p><strong>Обязуюсь предоставить все необходимые документы, запрашиваемые </strong><strong>АО &laquo;КСЖ &laquo;Государственная аннуитетная компания&raquo; в целях соблюдения требования законодательства Республики Казахстан по противодействию легализации (отмыванию) доходов, полученных преступным путем и финансированию терроризма.</strong></p>
<p><strong>Подписав Заявление, подтверждаю, что осуществляемая операция не связана с легализацией (отмыванием) доходов, полученных преступным путем и финансированием террористической деятельности.</strong></p>

<table border="1" width="100%" cellspacing="0" cellpadding="0">
<tbody>
    <tr>
        <td valign="top" width="151">
            <p><strong>&nbsp;</strong></p>
            <p><strong>Подпись страхователя</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>Менеджер/агент</strong></p>
        </td>
        <td valign="top" width="552">
            <p>&nbsp;</p>
            <p>Подпись/&nbsp; _____________/____________________________________________/</p>
            <p>М.П.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (ФИО)</p>
            <p>Исполнитель подтверждает, что в&nbsp; результате мониторинга&nbsp; на момент установления деловых отношений Клиент/бенефициар:</p>
            <p>- <u>не относится</u> к перечню организаций/лиц, связанных с финансированием терроризма и экстремизма □;&nbsp;</p>
            <p>- <u>относится</u> к перечню&nbsp; организаций/лиц, связанных с финансированием терроризма и экстремизма □;&nbsp;&nbsp;</p>
            <p>Подпись /&nbsp; _____________/__________________________________________/</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ФИО менеджера/агента)</p>
            <p>Уровень риска ____________________________________________</p>
            <p>Дата обновления сведений о клиенте _________________________________</p>
            <p>Дата заполнения &laquo;____&raquo;________________&nbsp; 201__года</p>
            <p>&nbsp;</p>
        </td>
    </tr>
</tbody>
</table>
<div style="page-break-before: always;"></div>
<p>&nbsp;</p>
<p align="right"><strong>Приложение № 1 к заявлению на страхование</strong></p>
<p align="right"><strong>№ <?php echo $dan['zv_num']; ?> от <?php echo $dan['zv_date']; ?> г.</strong></p>

<table style="width: 100%;" border="1" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top" width="40"><p align="center"><strong>№</strong></p></td>
            <td valign="top" width="151"><p align="center"><strong>Фамилия, имя, отчество</strong></p></td>
            <td valign="top" width="109"><p align="center"><strong>Дата рождения</strong></p></td>
            <td valign="top" width="106"><p align="center"><strong>Профессия / Должность</strong></p></td>
            <td valign="top" width="112"><p align="center"><strong>Состояние здоровья</strong></p></td>
            <td valign="top" width="86"><p align="center"><strong>Годовой доход</strong></p></td>
            <td valign="top" width="101"><p align="center"><strong>Страховая сумма</strong></p></td>
        </tr>
        <?php 
            $i = 1;
            foreach($dan['clients'] as $k=>$v){
        ?>
        <tr>
            <td valign="top" width="40">  <p align="center"><?php echo $i; ?></p></td>
            <td valign="top" width="151"> <p><?php echo $v['LASTNAME'].' '.$v['FIRSTNAME'].' '.$v['MIDDLENAME']; ?></p></td>
            <td valign="top" width="109"> <p><?php echo $v['BIRTHDATE']; ?></p></td>
            <td valign="top" width="106"> <p><?php echo $v['']; ?></p></td>
            <td valign="top" width="112"> <p><?php echo $v['']; ?></p></td>
            <td valign="top" width="86">  <p><?php echo $dan['print_zayavlenie'][$k]->year_dohod; ?></p></td>
            <td valign="top" width="101"> <p><?php echo $dan['print_zayavlenie'][$k]->str_sum; ?></p></td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

<p>&nbsp;</p>
<p><strong>Настоящим подтверждаю, </strong><strong>что все сведения, указанные в анкете являются достоверными и полными, и будут являться неотъемлемой частью договора, и если какое-либо сведение будет заведомо ложным АО &laquo;КСЖ &laquo;Государственная аннуитетная компания&raquo; имеет право отказать в осуществлении страховой выплаты.</strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Подпись Страхователя&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /____________ /_______________________________________/</p>
<p>М.П.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (ФИО)</p>
<p><strong>&nbsp;</strong></p>
<p>Дата: &laquo;___&raquo;___________________20___ г.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>&nbsp;</p>
<p>Подпись менеджера/агента /____________ /____________________________________________/</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (ФИО)</p>
</div>

<span class="btn btn-warning print"><i class="fa fa-print"></i> Печать</span>
<script>
function PrintElem(elem)
{
    Popup($(elem).html());
}

function Popup(data)
{
    var mywindow = window.open('', 'my div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>my div</title>');
    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10

    mywindow.print();
    mywindow.close();

    return true;
}

$('.print').click(function(){
    PrintElem('#print_zav_text');
})
</script>