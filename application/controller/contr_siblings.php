<?php
    $db = new My_sql_db();

    //построение обьекта Employee
    $empId = $_GET['emp_id'];
    
    //создаем обьект Employee, в параметры передаем ID
    $employee = new Employee($empId);
    
    //функция get_emp_from_DB() возвращает массив с данными о работнике из базы
    $empInfo = $employee -> get_emp_from_DB_trivial();

    $name = $empInfo[0]['LASTNAME'];
    $lastname = $empInfo[0]['FIRSTNAME'];
    $middlename = $empInfo[0]['MIDDLENAME'];
    $birthdate = $empInfo[0]['BIRTHDATE'];
    $DOCNUM = $empInfo[0]['DOCNUM'];
    $DOCDATE = $empInfo[0]['DOCDATE'];
    $country = $empInfo[0]['RU_NAME'];
    $cityname = $empInfo[0]['FACT_ADDRESS_CITY'];
    $fact_street = $empInfo[0]['FACT_ADDRESS_STREET'];
    $fact_address_building = $empInfo[0]['FACT_ADDRESS_BUILDING'];
    //position ID
    $pos_id = $empInfo[0]['JOB_POSITION'];
    $dep_id = $empInfo[0]['JOB_SP'];
    $filial_id = $empInfo[0]['FILIAL'];
    $branch_id = $empInfo[0]['BRANCHID'];

    //функция get_inf_from_DB_fam_memb() возвращает массив с данными о членах семьи из базы
    $listFam = $employee -> get_inf_from_DB_fam_memb();

    $html = '';?>

<div class="mail-box-header">
    <h2>
        Редактирование документа
    </h2>
</div>
<div class="col-lg-12 animated fadeInRight" style="background-color: white;">
    <form id="form_send_html" method="POST" action="just_print" target="_blank">
    <textarea name="content" style="width: 100%;">
    <div align="left" style="margin-right: 10px;
               float: left;
               font-family: TimesNewRoman;
               font-size: 16px;
               font-style: normal;
               font-variant: normal;
               font-weight: 400;
               width: 100%;
               text-align: left">
       <img style="width: 25%" src="http://89.219.20.234:1198/styles/img/logo_for_doc.jpg"/>
    </div>
    <br /><br />

    <div align="center">
            <div style="
               float: left;
               font-family: TimesNewRoman;
               font-size: 10px;
               font-style: normal;
               font-variant: normal;
               font-weight: 400;
               width: 30%;
               margin-right: 10px;">
       «ҚазИмпекс»
       Республикалық орталығы» АҚ<br />
       010000 Қазақстан Республикасы,<br />
       Нұр-Сүлтан қаласы, Сембинова к-сі, 34<br />
       Тел. +7/7172/43 31 01
    </div>
    <div style="width: 5%;"></div>
    <div style="margin-left: 10px;
               padding-left: 10px;
               float: left;
               font-family: TimesNewRoman;
               font-size: 10px;
               font-style: normal;
               font-variant: normal;
               font-weight: 400;
               width: 30%;
               border-left: 0.5px solid;">
       АО Республиканский центр «КазИмпекс»<br />
       010000 Республика Казахстан,<br />
       г. Нұр-Сүлтан, Сембинова, 34<br />
       Тел. +7/7172/43 31 01
    </div>
    <div style="width: 5%;"></div>
    <div style="
               margin-left: 10px;
               padding-left: 10px;
               float: left;
               font-family: TimesNewRoman;
               font-size: 10px;
               font-style: normal;
               font-variant: normal;
               font-weight: 400;
               width: 30%;
               border-left: 0.5px solid;">
       JSC «KazImpex»<br />
       010000, Republic of Kazakhstan,<br />
       Nur-Sultan city, Sembinov str,<br />
       Phone +7/7172/43 31 01
    </div>
    <br/>
    <div width="100%" style="
                   float: left;
                   font-family: TimesNewRoman;
                   font-size: 16px;
                   font-style: normal;
                   font-variant: normal;
                   font-weight: 400;">
          <br /><br /><br /><br />
          <div style="float: left;
                   font-family: TimesNewRoman;
                   font-size: 16px;
                   font-style: normal;
                   font-variant: normal;
                   font-weight: 400;
                   text-indent: 30px; text-align: center;">
             <strong><i>Справка</i></strong>
          </div><br /><br />
          <div style="float: left;
                   font-family: TimesNewRoman;
                   font-size: 16px;
                   font-style: normal;
                   font-variant: normal;
                   font-weight: 400;
                   text-indent: 30px;
                   text-align: center;">
             О составе семьи
          </div><br />
          <div style="text-indent: 30px;
                   float: left;
                   font-family: TimesNewRoman;
                   font-size: 16px;
                   font-style: normal;
                   font-variant: normal;
                   font-weight: 400;
                   text-indent: 30px;
                   text-align: center;">
             Дана гр-ну(ке) <strong><?php echo $name.' '.$lastname.' '.$middlename; ?></strong> (<?php echo $birthdate; ?> г.р.,) о том, что действительно семья состоит из следующих членов:
          </div>
    </div><br /><br />
        <table style="width: 100%;
                   text-indent: 30px;
                   float: left;
                   font-family: TimesNewRoman;
                   font-size: 16px;
                   font-style: normal;
                   font-variant: normal;
                   font-weight: 400;
                   text-indent: 30px;
                   text-align: center;">
            <thead border="1">
            <tr>
                <th style="border: 1px solid black;">ФИО</th>
                <th style="border: 1px solid black;" class="text-center">Дата рождения</th>
                <th style="border: 1px solid black;" class="text-center">Степень родства</th>
            </tr>
            </thead>
            <tbody border="1">
            <?php
            foreach($listFam as $q => $w)
            {
            ?>
                <tr>
                    <td style="border: 1px solid black;"> <?php echo $w['FIO']; ?> </td>
                    <td style="border: 1px solid black;" class="text-center"><?php echo $w['BIRTHDATE']; ?></td>
                    <td style="border: 1px solid black;" class="text-center small"><?php echo $w['NAME']; ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    <br /><br /><br />
    </textarea>

    <div class="mail-body text-right tooltip-demo">
        <button onclick="" type="submit" target="_blank" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="print"><i class="fa fa-reply"></i> Конвертировать в PDF</button>
    </div>
    </div>
    </form>
</div>
<script type="text/javascript" src="styles/js/others/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

<?php
    exit;
?>