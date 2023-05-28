<?php
    if($_SESSION['insurance']['other']['mail'][0] != 'i.akhmetov@gak.kz')
    {
        //echo '<h1>Вы не можете видеть чужую страницу редактирования!</h1>';
        //exit;
    }
?>
<div class="row wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4><?php echo $empInfo[0]['LASTNAME'].' '.$empInfo[0]['FIRSTNAME'].' '.$empInfo[0]['MIDDLENAME'].' ("'.$list_company[0]['NAME'].'", '.$empInfo[0]['role_name'].')'; ?></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="tabs-container">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#tab-1"> Общие </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-2"> Образование </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-3"> Стаж </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-4"> Воинский учет </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-5"> Состав семьи </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-55"> Отпуск </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-56"> Лист нетрудоспособности </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-6"> Журнал документов </a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-7"> Командировки </a></li>
                                                <!--
                                                <li class=""><a data-toggle="tab" href="#tab-8"> Табель </a></li>
                                                -->
                                                <li class=""><a data-toggle="tab" href="#tab-9"> Техника </a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="tab-1" class="tab-pane active">
                                                    <div class="panel-body">
                                                        <form method="POST" action="edit_employee">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <input name="empIdTrivial" type="text" placeholder="" class="form-control" id="empIdTrivial" value="<?php echo $empId;?>" style="display: none;"/>
                                                                    <label class="font-noraml">Фамилия</label>
                                                                    <input name="LASTNAME" id="LASTNAME" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['LASTNAME'];?>"/>
                                                                </div>
                                                                <div hidden="" class="col-lg-3">
                                                                    <label class="font-noraml">emp_author_id</label>
                                                                    <input name="AUTHOR_ID" id="AUTHOR_ID" type="text" placeholder="" class="form-control" value="<?php echo $emp_author_id;?>"/>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">Имя</label>
                                                                    <input name="FIRSTNAME" id="FIRSTNAME" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['FIRSTNAME'];?>"/>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">Отчество</label>
                                                                    <input name="middlename" id="middlename" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['MIDDLENAME'];?>"/>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">ИИН</label>
                                                                    <input data-mask="999999999999" name="IIN" id="IIN" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['IIN'];?>">
                                                                </div>
                                                            </div>
                                                            <br />
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">Имя латинскими символами</label>
                                                                    <input name="LASTNAME2" id="LASTNAME2" type="text" class="form-control" value="<?php echo $empInfo[0]['LASTNAME2'];?>"/>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">Фамилия латинскими символами</label>
                                                                    <input name="FIRSTNAME2" id="FIRSTNAME2" type="text" class="form-control" value="<?php echo $empInfo[0]['FIRSTNAME2'];?>"/>
                                                                </div>
                                                            </div>
                                                            <br />
                                                            <h4>Штатное расписание</h4>
                                                            <div id="place_for_state_table">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <label class="font-noraml">Организация</label>
                                                                    <input name="COMPANY_ID" placeholder="" class="form-control" id="COMPANY_ID" value="<?php echo $empInfo[0]['comp_name']; ?>"/>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label class="font-noraml">Филиал</label>
                                                                    <input name="BRANCHID" placeholder="" class="form-control" id="BRANCHID" value="<?php echo $list_branch_name[0]['NAME']; ?>"/>
                                                                </div>
                                                            </div><br />
                                                            <div class="row">
                                                                <div class="col-lg-5">
                                                                    <label class="font-noraml">Департамент</label>
                                                                    <select disabled="" id="JOB_SP" name="JOB_SP" class="select2_demo_1 form-control chosen-select">
                                                                        <option></option>
                                                                        <?php
                                                                            $dolzh_id = trim($empInfo[0]['JOB_SP']);
                                                                            foreach($listDepartments as $q => $d)
                                                                            {
                                                                        ?>
                                                                            <option <?php if($d['ID'] == $dolzh_id){echo "selected";} ?> value="<?php echo $d['ID']; ?>"><?php echo $d['NAME']; ?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <label class="font-noraml">Должность</label>
                                                                    <select disabled="" id="JOB_POSITION" name="JOB_POSITION" class="select2_demo_1 form-control chosen-select">
                                                                        <option></option>
                                                                        <?php
                                                                            $pos_id = trim($empInfo[0]['JOB_POSITION']);
                                                                            foreach($listPosition as $l => $p)
                                                                            {
                                                                        ?>
                                                                            <option <?php if($p['ID'] == $pos_id){echo "selected";} ?> value="<?php echo $p['ID']; ?>"><?php echo $p['D_NAME']; ?></option>
                                                                        <?php 
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <!--
                                                                <div class="col-lg-5">
                                                                    <label class="font-noraml">Руководитель</label>
                                                                    <input disabled="" name="ID_RUKOV" placeholder="" class="form-control" id="ID_RUKOV" value="<?php echo $empInfo[0]['ID_RUKOV'];; ?>"/>
                                                                </div>
                                                                -->
                                                                <div class="col-lg-2">
                                                                    <label class="font-noraml">Оклад</label>
                                                                    <input disabled="" name="OKLAD" placeholder="" class="form-control" id="OKLAD" value="<?php $oklad = $empInfo[0]['OKLAD']; echo $empInfo[0]['OKLAD']; ?>"/>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <br/>
                                                            <button data-toggle="modal" data-target="#change_pos" type="button" class="btn btn-primary btn-xs" id="pos_change_btn">Задать новую должность</button>
                                                            <br/>
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">Надбавка</label>
                                                                    <input name="" id="" type="text" class="form-control" value="<?php echo $empInfo[0]['NADBAVKA'];?>"/>
                                                                </div>                                                                
                                                            </div>
                                                            <br />
                                                            <a data-toggle="modal" data-target="#add_bonus" class="btn btn-primary btn-xs">Добавить надбавку</a>
                                                            <br/>
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">Надбавка экологическая</label>
                                                                    <input name="" id="" type="text" class="form-control" value="<?php echo $empInfo[0]['NADBAVKA_ECO'];?>"/>
                                                                </div>
                                                            </div>
                                                            <br />
                                                            <a data-toggle="modal" data-target="#add_bonus_eco" class="btn btn-primary btn-xs">Добавить надбавку (экологическую)</a>
                                                            <br />
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <label class="font-noraml">Доплата за совмещение должностей</label>
                                                                    <input name="" id="" type="text" class="form-control" value="<?php echo $empInfo[0]['PREMIUM'];?>"/>
                                                                </div>
                                                            </div>
                                                            <br />
                                                            <a data-toggle="modal" data-target="#add_bonus_for_couple_func" class="btn btn-primary btn-xs">Добавить доплату за совмещение должностей</a>
                                                            <hr />
                                                            <a target="_blank" href="emp_history?emp_id=<?php echo $empId;?>" class="btn btn-warning btn-xs">Перейти в историю сотрудника</a>
                                                            <hr />
                                                            <h4>Контакты</h4>
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <label class="font-noraml">Телефон (дом.)</label>
                                                                    <input name="HOME_PHONE" type="tel" placeholder="" class="form-control" id="HOME_PHONE" value="<?php echo $empInfo[0]['HOME_PHONE'];?>"/>
                                                                </div>
                                                                <div class="col-lg-2"> 
                                                                    <label class="font-noraml">Телефон (раб.)</label>
                                                                    <input data-mask="99-99" name="WORK_PHONE" type="tel" class="form-control" id="WORK_PHONE" value="<?php echo $empInfo[0]['WORK_PHONE'];?>"/>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label class="font-noraml">Телефон (моб.)</label>
                                                                    <input name="MOB_PHONE" type="" placeholder="" class="form-control" id="MOB_PHONE" value="<?php echo $empInfo[0]['MOB_PHONE'];?>"/>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <label class="font-noraml">Факс</label>
                                                                    <input name="FAX" type="tel" placeholder="" class="form-control" id="FAX" value="<?php echo $empInfo[0]['FAX'];?>"/>
                                                                </div>
                                                            </div>
                                                            <br />
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label class="font-noraml">Email (корп.)</label>
                                                                        <input name="EMAIL" type="email" placeholder="" class="form-control" id="EMAIL" value="<?php echo $empInfo[0]['EMAIL'];?>"/>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label class="font-noraml">Email (корп.)</label>
                                                                        <input name="PERSONAL_EMAIL" type="email" placeholder="" class="form-control" id="PERSONAL_EMAIL" value="<?php echo $empInfo[0]['PERSONAL_EMAIL'];?>"/>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                                <h4>Проживание</h4>
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                        <label class="font-noraml">Страна</label>
                                                                            <select id="FACT_ADDRESS_COUNTRY_ID" name="FACT_ADDRESS_COUNTRY_ID" class="select2_demo_1 form-control chosen-select">
                                                                                <option></option>
                                                                                <?php
                                                                                    $countryId = trim($empInfo[0]['FACT_ADDRESS_COUNTRY_ID']);
                                                                                    foreach($listCountry as $a => $s){
                                                                                ?>
                                                                                    <option <?php if($s['ID'] == $countryId){echo "selected";} ?> value="<?php echo $s['ID']; ?>"><?php echo $s['RU_NAME']; ?></option>
                                                                                <?php 
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <label class="font-noraml">Город</label>
                                                                            <input name="FACT_ADDRESS_CITY" id="FACT_ADDRESS_CITY" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['FACT_ADDRESS_CITY'];?>">
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <label class="font-noraml">Улица</label>
                                                                            <input name="FACT_ADDRESS_STREET" id="FACT_ADDRESS_STREET" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['FACT_ADDRESS_STREET'];?>">
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <label class="font-noraml">Строение</label>
                                                                            <input name="FACT_ADDRESS_BUILDING" id="FACT_ADDRESS_BUILDING" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['FACT_ADDRESS_BUILDING'];?>">
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <label class="font-noraml">Кв.</label>
                                                                            <input name="FACT_ADDRESS_FLAT" id="FACT_ADDRESS_FLAT" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['FACT_ADDRESS_FLAT'];?>">
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                    <a onclick="same_address();" type="button" class="btn btn-primary btn-xs">Адрес проживания и прописки совпадают</a>
                                                                <hr />
                                                                <h4>Прописка</h4>
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Страна прописки</label>
                                                                        <select id="REG_ADDRESS_COUNTRY_ID" name="REG_ADDRESS_COUNTRY_ID" class="select2_demo_1 form-control" >
                                                                                <option></option>
                                                                            <?php
                                                                                $countryId = trim($empInfo[0]['REG_ADDRESS_COUNTRY_ID']);
                                                                                foreach($listCountry as $a => $s){
                                                                            ?>
                                                                                <option <?php if($s['ID'] == $countryId){echo "selected";} ?> value="<?php echo $s['ID']; ?>"><?php echo $s['RU_NAME']; ?></option>
                                                                            <?php 
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Город </label>
                                                                        <input name="REG_ADDRESS_CITY" id="REG_ADDRESS_CITY" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['REG_ADDRESS_CITY'];?>">
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Улица</label>
                                                                        <input name="REG_ADDRESS_STREET" id="REG_ADDRESS_STREET" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['REG_ADDRESS_STREET'];?>">
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label class="font-noraml">Строение</label>
                                                                        <input name="REG_ADDRESS_BUILDING" id="REG_ADDRESS_BUILDING" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['REG_ADDRESS_BUILDING'];?>">
                                                                    </div>
                                                                    <div class="col-lg-1">
                                                                        <label class="font-noraml">Кв.</label>
                                                                        <input name="REG_ADDRESS_FLAT" id="REG_ADDRESS_FLAT" type="text" placeholder="" class="form-control" value="<?php echo $empInfo[0]['REG_ADDRESS_FLAT'];?>">
                                                                    </div>
                                                                </div>
                                                             <hr />
                                                             <h4>Документ</h4>
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Тип документа</label>
                                                                        <select name="DOCTYPE" id="DOCTYPE" class="select2_demo_1 form-control" >
                                                                                                <option></option>
                                                                        <?php
                                                                            $doctype = trim($empInfo[0]['DOCTYPE']);
                                                                            foreach($listDocs as $q => $w){
                                                                        ?>
                                                                            <option <?php if($w['ID'] == $doctype) {echo "selected";} ?> value="<?php echo $w['ID']; ?>"><?php echo $w['RU_NAME']; ?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Дата Рождения *</label>
                                                                        <div class="input-group date ">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </span>
                                                                            <input type="text" class="form-control dateOform" name="BIRTHDATE" data-mask="99.99.9999" id="BIRTHDATE" value="<?php echo date('d.m.Y', strtotime($empInfo[0]['BIRTHDATE'])); ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Национальность</label>
                                                                        <select name="NACIONAL" id="NACIONAL" class="select2_demo_1 form-control chosen-select" >
                                                                                                <option></option>
                                                                        <?php
                                                                            $nation = trim($empInfo[0]['NACIONAL']);
                                                                            foreach($listNationality as $e => $r){
                                                                        ?>
                                                                                                <option <?php if($r['ID'] == $nation) {echo "selected";} ?> value="<?php echo $r['ID']; ?>"><?php echo $r['RU_NAME']; ?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Пол</label></br>
                                                                        <div class="i-checks checkbox-inline">
                                                                                <label> <input type="radio" name="SEX" value="1" <?php if($empInfo[0]['SEX']==1){echo 'checked=""';}?> /> <i></i> Мужской</label>
                                                                        </div>
                                                                        <div class="i-checks checkbox-inline">
                                                                                <label> <input type="radio" name="SEX" value="2" <?php if($empInfo[0]['SEX']==2){echo 'checked=""';}?> /> <i></i> Женский</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <br />
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Номер документа</label>
                                                                        <input name="DOCNUM" type="" placeholder="" class="form-control" id="DOCNUM" value="<?php echo $empInfo[0]['DOCNUM'];?>">
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Дата выдачи</label>
                                                                        <div class="input-group date ">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </span>
                                                                            <input type="text" class="form-control dateOform" name="DOCDATE" data-mask="99.99.9999" id="DOCDATE" value="<?php echo $empInfo[0]['DOCDATE']?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Выдан</label>
                                                                        <select id="DOCPLACE" name="DOCPLACE" class="select2_demo_1 form-control" >
                                                                                <option></option>
                                                                                <option <?php if(1 == trim($empInfo[0]['DOCPLACE'])){echo "selected";} ?> value="1">МВД РК</option>
                                                                                <option <?php if(2 == trim($empInfo[0]['DOCPLACE'])){echo "selected";} ?> value="2">МЮ РК</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Семейное положение</label>
                                                                        <select id="FAMILY" name="FAMILY" class="select2_demo_1 form-control" >
                                                                                <option></option>
                                                                            <?php
                                                                                $familyStat = trim($empInfo[0]['FAMILY']);
                                                                                foreach($listFamStat as $a => $s){
                                                                            ?>
                                                                                <option <?php if($s['ID'] == $familyStat){echo "selected";} ?> value="<?php echo $s['ID']; ?>"><?php echo $s['NAME']; ?></option>
                                                                            <?php 
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                                <h4>Трудовой договор</h4>
                                                                <div class="row">
                                                                    <div class="col-lg-2">
                                                                        <label class="font-noraml">Номер трудового договора</label>
                                                                        <input name="CONTRACT_JOB_NUM" type="text" class="form-control" id="CONTRACT_JOB_NUM" value="<?php echo $empInfo[0]['CONTRACT_JOB_NUM'];?>"/>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label class="font-noraml">Дата трудового договора</label>
                                                                        <div class="input-group date ">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </span>
                                                                            <input type="text" class="form-control dateOform" name="CONTRACT_JOB_DATE" data-mask="99.99.9999" id="CONTRACT_JOB_DATE" value="<?php echo $empInfo[0]['CONTRACT_JOB_DATE']?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label class="font-noraml">Дата начала работы</label>
                                                                        <div class="input-group date ">
                                                                            <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                            </span>
                                                                            <input type="text" class="form-control dateOform" name="DATE_POST" data-mask="99.99.9999" id="DATE_POST" value="<?php echo $empInfo[0]['DATE_POST']?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <label class="font-noraml">Дата конца работы</label>
                                                                        <input name="DATE_LAYOFF" type="text" placeholder="" class="form-control" data-mask="99.99.9999" id="DATE_LAYOFF" value="<?php echo $empInfo[0]['DATE_LAYOFF'];?>">
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <label class="font-noraml">Статус</label>
                                                                        <select id="STATE" name="STATE" class="select2_demo_1 form-control">
                                                                                <option></option>
                                                                            <?php
                                                                                $stateId = trim($empInfo[0]['STATE']);
                                                                                foreach($listState as $g => $h){
                                                                            ?>
                                                                                <option <?php if($h['ID'] == $stateId){echo "selected";} ?> value="<?php echo $h['ID']; ?>"><?php echo $h['NAME']; ?></option>
                                                                            <?php 
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            <br/>
                                                            <a data-toggle="modal" data-target="#dismiss" class="btn btn-danger btn-xs">Уволить</a><br />
                                                            <a data-toggle="modal" data-target="#maternity_leave_finish" class="btn btn-warning btn-xs">Отозвать с декретного отпуска</a>
                                                            <hr />
                                                            <h4>Банковские данные</h4>
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Банк</label>
                                                                        <select id="BANK_ID" name="BANK_ID" class="select2_demo_1 form-control">
                                                                                <option></option>
                                                                            <?php
                                                                                $bank_id = trim($empInfo[0]['BANK_ID']);
                                                                                foreach($listBanks as $b => $s){
                                                                            ?>
                                                                                <option <?php if($s['BANK_ID'] == $bank_id){echo "selected";} ?> value="<?php echo $s['BANK_ID']; ?>"><?php echo $s['NAME']; ?></option>
                                                                            <?php 
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Тип счета</label>
                                                                        <input name="ACCOUNT_TYPE" type="text" placeholder="" class="form-control" id="ACCOUNT_TYPE" value="<?php echo $empInfo[0]['ACCOUNT_TYPE'];?>">
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="font-noraml">Номер счета</label>
                                                                        <input name="ACCOUNT" type="text" placeholder="" class="form-control" id="ACCOUNT" value="<?php echo $empInfo[0]['ACCOUNT'];?>">
                                                                    </div>
                                                                </div>
                                                            <br/>
                                                            <a data-toggle="modal" data-target="#change_bank_inf" class="btn btn-primary btn-xs">Изменить банковские реквизиты</a>
                                                            <hr />
                                                            <div id="placeForDoInf">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a id="checkTrivial" class="btn btn-success btn-sm demo2">Сохранить</a>
                                                        </div>
                                                    </div>
                                                    <div id="tab-2" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Образование</h3>
                                                                <a data-toggle="modal" data-target="#addEdu" class="btn btn-primary btn-xs">Добавить образование</a>
                                                                <table class="table table-hover margin bottom" id="editEduTable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 1%" class="text-center">#</th>
                                                                        <th>Учебное заведение</th>
                                                                        <th class="text-center">Год начала</th>
                                                                        <th class="text-center">Год окончания</th>
                                                                        <th class="text-center">Специализация</th>
                                                                        <th class="text-center">Квалификация</th>
                                                                        <th class="text-center">Номер диплома</th>
                                                                        <th class="text-center">Функции</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="place_for_edu">
                                                                    <?php
                                                                        foreach($listEdu as $x => $z){
                                                                    ?>
                                                                    <tr data="<?php echo $z['ID']; ?>">
                                                                        <td class="text-center"><?php echo $z['ID']; ?></td>
                                                                        <td><?php echo $z['INSTITUTION']; ?></td>
                                                                        <td class="text-center"><?php echo $z['YEAR_BEGIN']; ?></td>
                                                                        <td class="text-center"><?php echo $z['YEAR_END']; ?></td>
                                                                        <td class="text-center"><?php echo $z['SPECIALITY']; ?></td>
                                                                        <td class="text-center small"><?php echo $z['QUALIFICATION']; ?></td>
                                                                        <td class="text-center small"><?php echo $z['DIPLOM_NUM']; ?></td>
                                                                        <td class="text-center small"><div class="btn-group">
                                                                            <a data-toggle="modal" data-target="#editEdu" onclick="getEduInfForModal(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Редактировать</a>
                                                                            <a id="deleteEduId" onclick="deleteEdu(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>
                                                                        </div></td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            <hr />
                                                        </div>
                                                    </div>
                                                    <div id="tab-3" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Стаж</h3>   
                                                                <a data-toggle="modal" data-target="#addExperience" id="formAddJob" class="btn btn-primary btn-xs">Добавить рабочее место</a>
                                                                <table class="table table-hover margin bottom">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 1%" class="text-center">#</th>
                                                                        <th class="text-center">Дата начала сотрудничества</th>
                                                                        <th class="text-center">Дата конца сотрудничества</th>
                                                                        <th class="text-center">Должность</th>
                                                                        <th class="text-center">Организация</th>
                                                                        <th class="text-center">Местонахождение</th>
                                                                        <th class="text-center">Функции</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="place_for_formJob">
                                                                    <?php
                                                                        foreach($listExp as $k => $v){
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $v['ID']; ?></td>
                                                                        <td class="text-center"><?php echo $v['DATE_BEGIN']; ?></td>
                                                                        <td class="text-center"><?php echo $v['DATE_END']; ?></td>
                                                                        <td class="text-center"><?php echo $v['P_DOLZH']; ?></td>
                                                                        <td class="text-center small"><?php echo $v['P_NAME']; ?></td>
                                                                        <td class="text-center small"><?php echo $v['P_ADDRESS']; ?></td>
                                                                        <td class="text-center small"><div class="btn-group">
                                                                            <a data-toggle="modal" data-target="#editExp" onclick="getExpInfForModal(<?php echo $v['ID']; ?>);" class="btn-white btn btn-xs">Редактировать</a>
                                                                            <a id="deleteEduId" onclick="deleteExp(<?php echo $v['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>
                                                                        </div></td>
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            <hr />
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="tab-4" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Воинский учет</h3>
                                                            <div class="col-lg-6">
                                                                                <input name="empIdMil" id="empIdMil" type="text" placeholder="" class="form-control fio" value="<?php echo $empId;?>" style="display: none;">
                                                                            <label class="font-noraml">Группа учета</label>
                                                                                <input name="MILITARY_GROUP" id="MILITARY_GROUP" type="text" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_GROUP'];?>">
                                                                            <label class="font-noraml">Категория учета</label>
                                                                                <input name="MILITARY_CATEG" id="MILITARY_CATEG" type="text" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_CATEG'];?>">
                                                                            <label class="font-noraml">Состав</label>
                                                                                <input name="MILITARY_SOST" id="MILITARY_SOST" type="text" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_SOST'];?>">
                                                                            <label class="font-noraml">Воинское звание</label>
                                                                                <input name="MILITARY_RANKinp" id="MILITARY_RANKinp" type="text" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_RANK'];?>"  style="display: none;">
                                                                                <select name="MILITARY_RANK" id="MILITARY_RANK" name="rank" class="select2_demo_1 form-control" >
                                                                                        <option value="1"></option>
                                                                                        <option value="2">Рядовой</option>
                                                                                        <option value="3">Ефрейтор</option>
                                                                                        <option value="4">Младший сержант</option>
                                                                                        <option value="5">Сержант</option>
                                                                                        <option value="6">Старший сержант</option>
                                                                                        <option value="7">Сержант третьего класса</option>
                                                                                        <option value="8">Сержант второго класса</option>
                                                                                        <option value="9">Сержант первого класса</option>
                                                                                        <option value="10">Штаб-сержант</option>
                                                                                        <option value="11">Мастер-сержант</option>
                                                                                        <option value="12">Лейтенант</option>
                                                                                        <option value="13">Старший лейтенант</option>
                                                                                        <option value="14">Капитан</option>
                                                                                        <option value="15">Майор</option>
                                                                                        <option value="16">Подполковник</option>
                                                                                        <option value="17">Полковник</option>
                                                                                        <option value="18">Генерал-майор</option>
                                                                                        <option value="19">Генерал-лейтенант</option>
                                                                                        <option value="20">Генерал-полковник</option>
                                                                                        
                                                                                        <option value="4">Генерал-армии</option>
                                                                                    </select>
                                                                                    <script>
                                                                                        $(document).ready(
                                                                                            function(){
                                                                                                var MILITARY_RANKinp = $('#MILITARY_RANKinp').val();
                                                                                                $("#MILITARY_RANK :nth-child("+MILITARY_RANKinp+")").attr("selected", "selected");
                                                                                            }
                                                                                        )
                                                                                    </script>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                            <label class="font-noraml">Военно-учетная специальность</label>
                                                                                <input name="MILITARY_SPECIALITY" id="MILITARY_SPECIALITY" type="text" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_SPECIALITY'];?>">
                                                                            <label class="font-noraml">Название районного военкомата</label>
                                                                                <input name="MILITARY_VOENKOM" id="MILITARY_VOENKOM" type="text" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_VOENKOM'];?>">
                                                                                
                                                                            <label class="font-noraml">Состоит на спец. учете</label>
                                                                                <input name="MILITARY_SPEC_UCHinp" id="MILITARY_SPEC_UCHinp" type="number" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_SPEC_UCH'];?>" style="display: none;">
                                                                                
                                                                                <select name="MILITARY_SPEC_UCH" id="MILITARY_SPEC_UCH" class="select2_demo_1 form-control" >
                                                                                    <option value="1">Да</option>
                                                                                    <option value="2">Нет </option>
                                                                                </select>
                                                                            
                                                                            <script>
                                                                                $(document).ready(
                                                                                    function(){
                                                                                        var MILITARY_SPEC_UCHinp = $('#MILITARY_SPEC_UCHinp').val();
                                                                                        $("#MILITARY_SPEC_UCH :nth-child("+MILITARY_SPEC_UCHinp+")").attr("selected", "selected");
                                                                                    }
                                                                                )
                                                                            </script>
                                                                            
                                                                            <label class="font-noraml">Номер спец. учета</label>
                                                                                <input name="MILITARY_SPEC_UCH_NUMinp" id="MILITARY_SPEC_UCH_NUMinp" type="text" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_SPEC_UCH_NUM'];?>"  style="display: none;">
                                                                            
                                                                            <select name="MILITARY_SPEC_UCH_NUM" id="MILITARY_SPEC_UCH_NUM" class="select2_demo_1 form-control" >
                                                                                <option value="1"></option>
                                                                                <option value="2">один </option>
                                                                                <option value="3">два</option>
                                                                                <option value="4">три</option>
                                                                            </select>
                                                                            
                                                                            <script>
                                                                                $(document).ready(
                                                                                    function(){
                                                                                        var MILITARY_SPEC_UCH_NUMinp = $('#MILITARY_SPEC_UCH_NUMinp').val();
                                                                                        $("#MILITARY_SPEC_UCH_NUM :nth-child("+MILITARY_SPEC_UCH_NUMinp+")").attr("selected", "selected");
                                                                                    }
                                                                                )
                                                                            </script>
                                                                            
                                                                            <label class="font-noraml">Годность к военной службе</label>
                                                                                <input name="MILITARY_FITinp" id="MILITARY_FITinp" type="number" placeholder="" class="form-control fio" value="<?php echo $empInfo[0]['MILITARY_FIT'];?>" style="display: none;">
                                                                                
                                                                            <select name="MILITARY_FIT" id="MILITARY_FIT" class="select2_demo_1 form-control">
                                                                                <option value="1"></option>
                                                                                <option value="2">Годен </option>
                                                                                <option value="3">Не годен </option>
                                                                                <option value="4">Годен к не строевой службе</option>
                                                                            </select>
                                                                            <script>
                                                                                $(document).ready(
                                                                                    function(){
                                                                                        var MILITARY_FITinp = $('#MILITARY_FITinp').val();
                                                                                        $("#MILITARY_FIT :nth-child("+MILITARY_FITinp+")").attr("selected", "selected");
                                                                                    }
                                                                                )
                                                                            </script>
                                                                        </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a id="checkMilitary" class="btn btn-success btn-sm demo2">Сохранить</a>              
                                                        </div>
                                                    </div>
                                                    <div id="tab-5" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Семья</h3>
                                                                    <a data-toggle="modal" data-target="#addFamilyMemb" id="addFamilyMember" class="btn btn-primary btn-xs">Добавить члена семьи</a>
                                                                    <a target="_blank" href="siblings?emp_id=<?php echo $empId; ?>" class="btn btn-primary btn-xs">Справка о составе семьи</a>
                                                                    <table class="table table-hover margin bottom">
                                                                        <thead>
                                                                        <tr>
                                                                            <th style="width: 1%" class="text-center">#</th>
                                                                            <th>ФИО</th>
                                                                            <th class="text-center">Дата рождения</th>
                                                                            <th class="text-center">Степень родства</th>
                                                                            <th class="text-center">Функции</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody id="placeForFamilyMember">
                                                                            <?php
                                                                            foreach($listFam as $q => $w){
                                                                            ?>
                                                                                <tr>
                                                                                    <td class="text-center"><?php echo $w['ID']; ?></td>
                                                                                    <td> <?php echo $w['FIO']; ?> </td>
                                                                                    <td class="text-center"><?php echo $w['BIRTHDATE']; ?></td>
                                                                                    <td class="text-center small"><?php echo $w['NAME']; ?></td>
                                                                                    <td class="text-center small"><div class="btn-group">
                                                                                        <a data-toggle="modal" data-target="#editExpFam" onclick="getInfFam(<?php echo $w['ID']; ?>);" class="btn-white btn btn-xs">Редактировать</a>
                                                                                        <a id="deleteEduId" onclick="deleteFamMemb(<?php echo $w['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>
                                                                                    </div></td>
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                <hr />
                                                        </div>
                                                    </div>
                                                    <div id="tab-55" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Отпуска</h3>
                                                            <!--<p>Количество отпускных дней: <strong id="holyday_cnt"></strong></p>-->
                                                                <a data-toggle="modal" data-target="#addHoliday" class="btn btn-primary btn-xs">Добавить отпуск</a>
                                                                <table class="table table-hover margin bottom" id="editEduTable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 1%" class="text-center">Тип</th>
                                                                        <th style="width: 1%" class="text-center">#</th>
                                                                        <th class="text-center">Дата начала отпуска</th>
                                                                        <th class="text-center">Дата конца отпуска</th>
                                                                        <th class="text-center">Количество дней</th>
                                                                        <th class="text-center">За период (начало)</th>
                                                                        <th class="text-center">За период (конец)</th>
                                                                        <th class="text-center">Номер приказа</th>
                                                                        <th class="text-center">Дата приказа</th>
                                                                        <th class="text-center">Тип</th>
                                                                        <th class="text-center">Функции</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="place_for_holi">
                                                                    <?php
                                                                        foreach($listHolidays as $x => $z)
                                                                        {
                                                                            $sqlReturn = "select * from RETURN_FROM_HOLY where ID_HOLY = ".$z['ID'];
                                                                            $listReturn = $db -> Select($sqlReturn);
                                                                    ?>
                                                                        <tr data="<?php echo $z['ID']; ?>">
                                                                            <td class="text-center"><strong>Отпуск</strong></td>
                                                                            <td class="text-center"><?php echo $z['ID']; ?></td>
                                                                            <td class="text-center"><?php echo $z['DATE_BEGIN']; ?></td>
                                                                            <td class="text-center"><?php echo $z['DATE_END']; ?></td>
                                                                            <td class="text-center"><?php echo $z['CNT_DAYS']; ?></td>
                                                                            <td class="text-center small"><?php echo $z['PERIOD_BEGIN']; ?></td>
                                                                            <td class="text-center small"><?php echo $z['PERIOD_END']; ?></td>
                                                                            <td class="text-center small"><?php echo $z['ORDER_NUM']; ?></td>
                                                                            <td class="text-center small"><?php echo $z['ORDER_DATE']; ?></td>
                                                                            <td class="text-center small"><?php echo $z['K_NAME']; ?></td>
                                                                            <td class="text-center small">
                                                                                <div class="btn-group">
                                                                                    <!--<a id="deleteHoliId" onclick="deleteHoli(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>-->
                                                                                    <a data-toggle="modal" data-target="#returnMod" id="return"  onclick="getHoliInfForModalReturn(<?php echo $z["ID"]; ?>);" class="btn-white btn btn-xs">Отозвать</a>
                                                                                    <!--<a data-toggle="modal" data-target="#editHoliMod" onclick="getHoliInfForModal(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Редактировать</a>-->
                                                                                    <div class="input-group-btn btn-xs">
                                                                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle btn-xs" type="button">Сгенерировать <span class="caret"></span></button>
                                                                                        <ul class="dropdown-menu">
                                                                                            <li><a href="edit_doc?temp_id=25&employee_id=<?php echo $empId; ?>&HOLIDAYS_ID=<?php echo $z['ID']; ?>">Печать трудового отпуска</a></li>
                                                                                            <li><a href="edit_doc?temp_id=26&employee_id=<?php echo $empId; ?>&HOLIDAYS_ID=<?php echo $z['ID']; ?>">Печать отпуска без сохр.ЗП</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                        <textarea hidden="" name="text_for_edit"><?php echo $z['DOC_CONTENT'];?></textarea>
                                                                                        <input hidden="" name="holi_id" value="<?php echo $z['ID'];?>"/>
                                                                                        <button class="btn-white btn btn-xs <?php if($z['DOC_CONTENT'] == ''){echo 'disabled';} ?>">Печать с базы</button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                                foreach($listReturn as $n => $m)
                                                                                {
                                                                        ?>
                                                                                    <tr data="<?php echo $m['ID']; ?>">
                                                                                        <td class="text-center"><strong>Отзыв</strong></td>
                                                                                        <td class="text-center"><?php echo $m['ID']; ?></td>
                                                                                        <td class="text-center"><?php echo $m['DATE_HOLY_START']; ?></td>
                                                                                        <td class="text-center"><?php echo $m['DATE_HOLY_END']; ?></td>
                                                                                        <td class="text-center"><?php echo $m['DAY_COUNT']; ?></td>
                                                                                        <td class="text-center"></td>
                                                                                        <td class="text-center"></td>
                                                                                        <td class="text-center"></td>
                                                                                        <td class="text-center"></td>
                                                                                        <td class="text-center"></td>
                                                                                        <td class="text-center small">
                                                                                            <div class="btn-group">
                                                                                                <!--<a id="deleteHoliId" onclick="deleteHoli(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>-->
                                                                                                <!--<a data-toggle="modal" data-target="#editHoliMod" onclick="getHoliInfForModal(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Редактировать</a>-->
                                                                                                <div class="input-group-btn btn-xs">
                                                                                                    <button data-toggle="dropdown" class="btn btn-white dropdown-toggle btn-xs" type="button">Печать <span class="caret"></span></button>
                                                                                                    <ul class="dropdown-menu">
                                                                                                        <li><a href="edit_doc?temp_id=38&employee_id=<?php echo $empId; ?>&HOLIDAYS_ID=<?php echo $z['ID']; ?>">Печать приказа</a></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                        </div>
                                                    </div>
                                                    <div id="tab-56" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Лист нетрудоспособности</h3>
                                                                <a data-toggle="modal" data-target="#addHealthMod" class="btn btn-primary btn-xs">Добавить лист нетрудоспособности</a>
                                                                <table class="table table-hover margin bottom" id="editEduTable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 1%" class="text-center">#</th>
                                                                        <th class="text-center">Дата вступления в силу ЛН</th>
                                                                        <th class="text-center">Дата конца ЛН</th>
                                                                        <th class="text-center">Находился на лечении (дн.)</th>
                                                                        <th class="text-center">Функции</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="place_for_hosp">
                                                                    <?php
                                                                        foreach($listHOSPITAL as $x => $z)
                                                                        {
                                                                    ?>
                                                                    <tr data="<?php echo $z['ID']; ?>">
                                                                        <td class="text-center"><?php echo $z['ID']; ?></td>
                                                                        <td class="text-center"><?php echo $z['DATE_BEGIN']; ?></td>
                                                                        <td class="text-center"><?php echo $z['DATE_END']; ?></td>
                                                                        <td class="text-center"><?php echo $z['CNT_DAYS']; ?> дн.</td>
                                                                        <td class="text-center small"><div class="btn-group">
                                                                            <a data-toggle="modal" data-target="#editHealthMod" onclick="getHospInfForModal(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Редактировать</a>
                                                                            <a id="deleteHoliId" onclick="deleteHosp(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>
                                                                        </div></td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            <hr />
                                                        </div>
                                                    </div>
                                                    </form>
                                                    <div id="tab-6" class="tab-pane">
                                                        <form enctype="multipart/form-data" method="post">
                                                        <div class="panel-body">
                                                                                                                                        
                                                            <table class="table table-striped table-bordered table-hover" id="editable" >
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Текст заголовка</th> 
                                                                <th>Дата последнего обновления</th> 
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Трудовой договор</td>
                                                                <td></td>
                                                                <td><input name="IINforFolder" id="IINforFolder" type="text" placeholder="" class="form-control fio" id="fio" value="<?php echo $empInfo[0]['IIN'];?>" style="display: none;">
                                                                    <div class="btn-group">
                                                                        <a href="job_contract?employee_id=<?php echo $empId; ?>&bossname=Директоров Д. Д.&bossname_kaz=Директоров Д. Д." target="_blank" type="submit" onclick="addDocs" id="addDocs" class="btn btn-sm btn-danger" data="<?php echo $v['ID'] ?>"><i class="fa fa-file-pdf-o"></i></a> 
                                                                    </div>
                                                                </td>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Приложение к трудовому договору</td>
                                                                <td></td>
                                                                <td><input name="IINforFolder" id="IINforFolder" type="text" placeholder="" class="form-control fio" id="fio" value="<?php echo $empInfo[0]['IIN'];?>" style="display: none;">
                                                                    <div class="btn-group">
                                                                        <a href="append_contr?employee_id=<?php echo $empId; ?>&bossname=Директоров Д. Д.&bossname_kaz=Директоров Д. Д." target="_blank" type="submit" onclick="addDocs" id="addDocs" class="btn btn-sm btn-danger" data="<?php echo $v['ID'] ?>"><i class="fa fa-file-pdf-o"></i></a> 
                                                                    </div>
                                                                </td>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td>5</td>
                                                                <td>Справка с места работы</td>
                                                                <td></td>
                                                                <td><div class="btn-group">
                                                                        <a href="edit_doc?temp_id=23&employee_id=<?php echo $empId; ?>" target="_blank" type="submit" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i></a>  
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td>Печать трудового отпуска</td>
                                                                <td></td>
                                                                <td><div class="btn-group">
                                                                        <a href="edit_doc?temp_id=23&employee_id=<?php echo $empId; ?>&HOLIDAYS_ID=<?php echo $z['ID']; ?>" target="_blank" type="submit" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                              foreach($sqlReport_html_other_dan as $k => $v){  
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $v['ID'] ?></td>
                                                                    <td><?php echo $v['TITLE_TEXT']?></td>
                                                                    <td><?php echo $v['DATE_ADD']?></td>
                                                                    <td>
                                                                        <a href="edit_doc?temp_id=<?php echo $v['ID'] ?>&employee_id=<?php echo $empId; ?>&file_name=<?php echo $v['TITLE_TEXT'].' '.$empInfo[0]['LASTNAME'].' '.$empInfo[0]['FIRSTNAME']; ?>" class="btn btn-sm btn-danger" data="<?php echo $v['ID'] ?>"><i class="fa fa-file-pdf-o"></i></a>                          
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                }
                                                            ?>
                                                            </tbody>
                                                            </table>
                                                        </div>
                                                        <div hidden="">
                                                            <input name="test" value=""/>
                                                            <button type="submit">Send docs</button>
                                                        </div>
                                                        </form>
    
                                                    </div>
                                                    <div id="tab-7" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Командировки</h3>
                                                                <a data-toggle="modal" data-target="#add_trip" class="btn btn-primary btn-xs">Добавить командировку</a>
                                                                <table class="table table-hover margin bottom" id="editEduTable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center">Дата начала командировки</th>
                                                                        <th class="text-center">Дата конца командировки</th>
                                                                        <th class="text-center">Количество дней</th>
                                                                        <th class="text-center">Номер приказа</th>
                                                                        <th class="text-center">Дата приказа</th>
                                                                        <th class="text-center">Цель</th>
                                                                        <th class="text-center">Маршрут</th>
                                                                        <th class="text-center">Функции</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="place_for_trip">
                                                                    <?php
                                                                        foreach($list_trip as $n => $m){
                                                                            $trip_id = $m['ID'];
                                                                    ?>
                                                                        <tr data="<?php echo $m['ID']; ?>">
                                                                            <td class="text-center"><?php echo $m['DATE_BEGIN']; ?></td>
                                                                            <td class="text-center"><?php echo $m['DATE_END']; ?></td>
                                                                            <td class="text-center"><?php echo $m['CNT_DAYS']; ?></td>
                                                                            <td class="text-center small"><?php echo $m['ORDER_NUM']; ?></td>
                                                                            <td class="text-center small"><?php echo $m['ORDER_DATE']; ?></td>
                                                                            <td class="text-center small"><?php echo $m['AIM']; ?></td>
                                                                            <td class="text-center small">
                                                                                <?php
                                                                                    $sql_trip = "select FROM_TO.*, TRANS.NAME TR_NAME from TRIP_FROM_TO FROM_TO, DIC_TRANSPORT_FOR_TRIP TRANS where TRANS.ID = FROM_TO.TRANSPORT AND FROM_TO.TRIP_ID = $trip_id order by FROM_TO.id";
                                                                                    $list_trip = $db -> Select($sql_trip);
                                                                                    foreach($list_trip as $y => $t){
                                                                                ?>
                                                                                    <p><?php echo $t['FROM_PLACE'].'-'.$t['TO_PLACE'].'('.$t['TR_NAME'].')' ?> <i onclick="delete_detail(<?php echo $t['ID']; ?>);" title="Удалить маршрут" style="cursor: pointer;" class="fa fa-times btn-danger"></i></p>
                                                                                <?php
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td class="text-center small">
                                                                                <div class="btn-group"><a data-toggle="modal" data-target="#trip_details" onclick="$('#TRIP_DETAIL_ID').val('<?php echo $m['ID']; ?>');" class="btn-white btn btn-xs">Добавить транспорт</a>
                                                                                    <div class="input-group-btn btn-xs">
                                                                                        <a href="emp_trip?trip_id=<?php echo $m['ID']; ?>" class="btn btn-white btn-xs" type="button">Печать приказа</a>
                                                                                        <a href="trip_doc?trip_id=<?php echo $m['ID']; ?>&employee_id=<?php echo $empId; ?>" class="btn btn-white btn-xs" type="button">Печать удостоверения</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            <hr />
                                                        </div>
                                                    </div>
                                                    <div id="tab-8" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Табель</h3>
                                                                <div class="ibox-tools">
                                                                    <form method="POST">
                                                                        <div class="row">
                                                                            <div class="col-md-5">
                                                                                <div class="input-group date ">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                    </span>
                                                                                    <input value="<?php echo $timesheet_date_start; ?>" type="text" class="form-control dateOform" name="timesheet_date_start" data-mask="99.99.9999" id="timesheet_date_start" required/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-5"> 
                                                                                <div class="input-group date ">
                                                                                    <span class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                    </span>
                                                                                    <input value="<?php echo $timesheet_date_end; ?>" type="text" class="form-control dateOform" name="timesheet_date_end" data-mask="99.99.9999" id="timesheet_date_end" required/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <button type="submit" class="btn btn-primary">Показать</button>
                                                                            </div>
                                                                        </div>
                                                                        <br />
                                                                    </form>
                                                                </div>
                                                                <div class="ibox-content">
                                                                    <div class="table-responsive" id="table_with_data">
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ФИО</th>
                                                                                    <th>Должность</th>
                                                                                    <?php
                                                                                    foreach($list_guy as $b => $d){
                                                                                        echo '<th>'.$d['WEEK_DAY'].'</th>';
                                                                                    }
                                                                                    ?>
                                                                                    <th>Кол-во дней</th>
                                                                                    <th>Кол-во часов</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                                foreach($list_guys as $k => $v)
                                                                                {
                                                                                    $sql_timesheet_test = "select * from TABLE_OTHER where EMP_ID = ".$v['ID']." and DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' order by DAY_DATE";
                                                                                    //echo $sql_timesheet_test;
                                                                                    $list_timesheet_test = $db -> Select($sql_timesheet_test);
                                                                                    
                                                                                    $sql_timesheet_job_day = "select * from TABLE_OTHER where DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' and EMP_ID = ".$v['ID']." and VALUE = '8'";
                                                                                    $list_timesheet_job_day = $db -> Select($sql_timesheet_job_day);
                                                                                    $hours = 0;
                                                                                    $days = 0;
                                                                                    $name = $v['FIRSTNAME'];
                                                                                    $name_first_simb = mb_substr($name,0,1,"UTF-8");
                                                                                    $middlename = $v['MIDDLENAME'];
                                                                                    $middlename_first_simb = mb_substr($middlename,0,1,"UTF-8");
                                                                                    
                                                                                    echo '<tr class="gradeX">';
                                                                                    echo '<td style="border: 1px solid #8E8DA2">'.$v['LASTNAME'].'. '.$name_first_simb.'. '.$middlename_first_simb.'</td>';
                                                                                    echo '<td style="border: 1px solid #8E8DA2">'.$v['D_NAME'].'</td>';
                                                                                    foreach($list_timesheet_test as $x => $z)
                                                                                    {
                                                                                            if
                                                                                            ($z['VALUE'] == 'А'){$color = " style='cursor: pointer; border: 1px solid #8E8DA2; background-color:#dff0d8'";}else if
                                                                                            ($z['VALUE'] == 'О'){$color = " style='cursor: pointer; border: 1px solid #8E8DA2; background-color:#fcf8e3'";}else if
                                                                                            ($z['VALUE'] == 'Б'){$color = " style='cursor: pointer; border: 1px solid #8E8DA2; background-color:#d9edf7'";}else if
                                                                                            ($z['VALUE'] == 'П'){$color = " style='cursor: pointer; border: 1px solid #8E8DA2; background-color:#bce8f1'";}else if
                                                                                            ($z['VALUE'] == 'К'){$hours = $hours+8; $days = $days+1; $color = " style='cursor: pointer; border: 1px solid #8E8DA2; background-color:#d1dade'";}else if
                                                                                            ($z['VALUE'] == ' '){$color = " style='cursor: pointer; border: 1px solid #8E8DA2; background-color:#2f4050'";}else if
                                                                                            ($z['VALUE'] == '4'){$hours = $hours+4; $days = $days+1; $color = " style='cursor: pointer; border: 1px solid #8E8DA2'";}else if
                                                                                            ($z['VALUE'] == '5'){$hours = $hours+5; $days = $days+1; $color = " style='cursor: pointer; border: 1px solid #8E8DA2'";}else if
                                                                                            ($z['VALUE'] == '12'){$hours = $hours+12; $days = $days+1; $color = " style='cursor: pointer; border: 1px solid #8E8DA2'";}else if
                                                                                            ($z['VALUE'] == 'В'){$color = " style='cursor: pointer; border: 1px solid #8E8DA2; background-color:#f8ac59'";}else
                                                                                            {$hours = $hours+8; $days = $days+1;$color = " style='cursor: pointer; border: 1px solid #8E8DA2'";}
                                                                                            echo '<td class="td_table" data-toggle="modal" data-target="#edit_table" onclick="set_id('.$z['ID'].');"'.$color.'>'.$z['VALUE'].'</td>';
                                                                                    }
                                                                                    echo '<td style="border: 1px solid #8E8DA2">'.$days.'</td>';
                                                                                    echo '<td style="border: 1px solid #8E8DA2">'.$hours.'</td>';
                                                                                    //echo '<pre>';
                                                                                    //print_r($list_timesheet_test);
                                                                                    //echo '<pre>';
                                                                                    echo '</tr>';
                                                                                }
                                                                            ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <form target="_blank" id="table_form" method="post" action="print_timesheet">
                                                                                <input name="dep_id" value="<?php echo $dep_id; ?>" style="display: none;"/>
                                                                                <div hidden="" id="head_of_doc">
                                                                                <div style="text-align: right;">
                                                                                Утверждаю<br />
                                                                                <?php echo $curatots_pos; ?><br />
                                                                                АО "КСЖ "ГАК"<br /><br /><br />
                                                                                Г. Т. Амерходжаев_______________<br /><br />
                                                                                <div style="text-align: center;"><strong><h3>ТАБЕЛЬ УЧЕТА РАБОЧЕГО ВРЕМЕНИ С <?php echo $timesheet_date_start; ?> ПО <?php echo $timesheet_date_end; ?></h3></strong></div>
                                                                                <div style="text-align: center;"><strong><h3><?php echo $dep_name; ?></h3></strong></div>
                                                                                <hr/>
                                                                                </div>
                                                                                </div>
                                                                                <div hidden="" id="foot_of_doc">
                                                                                <hr/><br /><br /><br /><br />
                                                                Специалист по управлению персоналом
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                К. К. Кадровикова
                                                                        </div>
                                                                        
                                                                        <textarea hidden="" name="content" id="area_for_print">
                                                                            
                                                                        </textarea>
                                                                        <div class="ibox-content">
                                                                            <div class="table-responsive">
                                                                                <a id="submit_and_print" class="btn btn-primary pull-right"><i class="fa fa-check-square-o"></i> Утвердить и отправить на печать</a>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            <hr />
                                                        </div>
                                                    </div>
                                                    <div id="tab-9" class="tab-pane">
                                                        <div class="panel-body">
                                                            <h3>Техника</h3>
                                                                <a data-toggle="modal" data-target="#add_tech" class="btn btn-primary btn-xs">Добавить технику</a>
                                                                <table class="table table-hover margin bottom" id="editEduTable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center">Наименование</th>
                                                                        <th class="text-center">Инвенатрный номер</th>
                                                                        <th class="text-center">Тип</th>
                                                                        <th class="text-center">Цена</th>
                                                                        <th class="text-center">Функции</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="place_for_hosp">
                                                                    <?php
                                                                        foreach($list_usr_techs as $x => $z){
                                                                    ?>
                                                                    <tr data="<?php echo $z['ID']; ?>">
                                                                        <td class="text-center"><?php echo $z['NAME']; ?></td>
                                                                        <td class="text-center"><?php echo $z['INVENT_NUM']; ?></td>
                                                                        <td class="text-center"><?php echo $z['TYPE_NAME']; ?></td>
                                                                        <td class="text-center"><?php echo $z['PRICE']; ?> тенге</td>
                                                                        <td class="text-center small"><div class="btn-group">
                                                                            <a data-toggle="modal" data-target="#delete_tech" onclick="$('#DEL_TECH_ID').val(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>
                                                                        </div></td>
                                                                        
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    </tbody>
                                                                </table>
                                                            <hr />
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>

<!-- Редактировать доки --> 
<div class="modal inmodal fade" id="maternity_leave_finish" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Отозвать с декретного отпуска</h4>
            </div>
            <div class="modal-body">
            <form method="post">
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">BRANCH_ID</label>
                    <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_SP</label>
                    <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_POSITION</label>
                    <input name="JOB_POSITIONholi" type="text" class="form-control" id="JOB_POSITIONholi" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">emp_author_id</label>
                    <input name="AUTHOR_ID" type="number" placeholder="" class="form-control pos_btn" id="AUTHOR_ID" value="<?php echo $emp_author_id;?>"/>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата первого рабочего дня</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_maternity" data-mask="99.99.9999" id="DATE_maternity" required=""/>
                    </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата (приказа)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="maternity_ORDER_DATE" data-mask="99.99.9999" id="maternity_ORDER_DATE" required/>
                    </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Номер приказа</label>
                    <input name="ORDER_NUMmaternity" type="text" placeholder="" class="form-control" id="ORDER_NUMmaternity" value="" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#submit_and_print').click(function() 
    {
        var head_of_doc = $('#head_of_doc').html();
        var foot_of_doc = $('#foot_of_doc').html();
        
        var table_with_data = $('#table_with_data').html();
        $('#area_for_print').html(head_of_doc+table_with_data+foot_of_doc);
        $('#table_form').submit();
    })
</script>

<!-- образование -->
<!-- MODAL WINDOWS -->
<div class="modal inmodal fade" id="addEdu" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление образования</h4>
                <small class="font-bold">Введите данные</small>
            </div>
            <form method="post">
            <div class="modal-body">
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID person</label>
                        <input name="idPersEdu" type="text" placeholder="" class="form-control" id="idPersEdu" value="<?php echo $empId; ?>" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Название учебного заведения</label>
                        <input name="INSTITUTION" type="text" placeholder="" class="form-control" id="INSTITUTION" required>
                    </div>
                    <div class="form-group">
                        <label class="font-noraml">Год начала обучения</label>
                        <input type="" class="form-control dateOform" name="YEAR_BEGIN" data-mask="9999" id="YEAR_BEGIN" required/>
                    </div>
                    <div class="form-group">
                        <label class="font-noraml">Год конца обучения</label>
                        <input type="" class="form-control dateOform" name="YEAR_END" data-mask="9999" id="YEAR_END" required/>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Специальность</label>
                        <input name="SPECIALITY" type="text" placeholder="" class="form-control" id="SPECIALITY" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Квалификация</label>
                        <input name="QUALIFICATION" type="text" placeholder="" class="form-control" id="QUALIFICATION" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер диплома</label>
                        <input name="DIPLOM_NUM" type="text" placeholder="" class="form-control" id="DIPLOM_NUM" required>
                    </div>
            </div>
            <div class="modal-footer">
                <a id="saveEdu" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="editEdu" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Редактирование образования</h4>
                <small class="font-bold">Введите данные</small>
            </div>
            <form method="post">
            <div class="modal-body" id="placeForEduEdit">
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID person</label>
                        <input name="idPersEduEdit" type="text" placeholder="" class="form-control" id="idPersEduEdit" value="<?php echo $empId; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID вуза</label>
                        <input name="editEduIdMod" type="text" placeholder="" class="form-control" id="editEduIdMod" required>
                    </div>
                    <div id="placeForEditEduIdMod">
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Редактирование учебного заведения</label>
                        <input name="INSTITUTIONEdit" type="text" placeholder="" class="form-control" id="INSTITUTIONEdit" required>
                    </div>
                    <div class="form-group">
                        <label class="font-noraml">Год начала обучения</label>
                        <input type="number" class="form-control dateOform" name="YEAR_BEGINEdit" data-mask="9999" id="YEAR_BEGINEdit" required/>
                    </div>
                    <div class="form-group">
                        <label class="font-noraml">Год конца обучения</label>
                        <input type="number" class="form-control dateOform" name="YEAR_ENDEdit" data-mask="9999" id="YEAR_ENDEdit" required/>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Специальность</label>
                        <input name="SPECIALITYEdit" type="text" placeholder="" class="form-control" id="SPECIALITYEdit" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Квалификация</label>
                        <input name="QUALIFICATIONEdit" type="text" placeholder="" class="form-control" id="QUALIFICATIONEdit" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер диплома</label>
                        <input name="DIPLOM_NUMEdit" type="text" placeholder="" class="form-control" id="DIPLOM_NUMEdit" required>
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a onclick="updateEdu();" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>
<!-- образование -->

<!-- стаж --> 
<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="addExperience" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление рабочего места</h4>
                <small class="font-bold">Введите организации для графы "стаж"</small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID person</label>
                        <input name="idPersExp" type="text" placeholder="" class="form-control" id="idPersExp" value="<?php echo $empId; ?>" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата начала сотрудничества</label>
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="expStartDate" data-mask="99.99.9999" id="expStartDate" required/>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата конца сотрудничества</label>
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="expEndDate" data-mask="99.99.9999" id="expEndDate" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Название организации</label>
                        <input name="P_NAME" type="text" placeholder="" class="form-control" id="P_NAME" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Должность</label>
                        <input name="P_DOLZH" type="text" placeholder="" class="form-control" id="P_DOLZH" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Местоположение</label>
                        <input name="P_ADDRESS" type="text" placeholder="" class="form-control" id="P_ADDRESS" required>
                    </div>
            </div>
            <div class="modal-footer">
                <a id="addExperiance" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="editExp" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Редактирование рабочего места</h4>
                <small class="font-bold">Введите организации для графы "стаж"</small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID person</label>
                        <input name="idPersExpEdit" type="text" placeholder="" class="form-control" id="idPersExpEdit" value="<?php echo $empId; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID места работы</label>
                        <input name="editExpIdMod" type="text" placeholder="" class="form-control" id="editExpIdMod" required>
                    </div>
                    <div id="placeForEditExpIdMod">
                    <div class="form-group">
                    <label class="font-noraml">Дата начала сотрудничества</label>
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="expStartDateEdit" data-mask="99.99.9999" id="expStartDateEdit" required/>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата конца сотрудничества</label>
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="expEndDateEdit" data-mask="99.99.9999" id="expEndDateEdit" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Название организации</label>
                        <input name="P_NAMEEdit" type="text" placeholder="" class="form-control" id="P_NAMEEdit" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Должность</label>
                        <input name="P_DOLZHEdit" type="text" placeholder="" class="form-control" id="P_DOLZHEdit" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Местоположение</label>
                        <input name="P_ADDRESSEdit" type="text" placeholder="" class="form-control" id="P_ADDRESSEdit" required>
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a id="updateExperiance" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>
<!-- стаж --> 

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="addFamilyMemb" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление члена семьи</h4>
                <small class="font-bold"></small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div class="form-group" id="data_1">
                        <input name="idPersFam" type="text" placeholder="" class="form-control" id="idPersFam" value="<?php echo $empId; ?>" style="display: none;">
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Фамилия</label>
                        <input name="LASTNAMEfam" type="text" placeholder="" class="form-control" id="LASTNAMEfam" value="" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Имя</label>
                        <input name="FIRSTNAMEfam" type="text" placeholder="" class="form-control" id="FIRSTNAMEfam" value="" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Отчество</label>
                        <input name="MIDDLENAMEfam" type="text" placeholder="" class="form-control" id="MIDDLENAMEfam" value="" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата рождения</label>
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="BIRTHDATEfamMemb" data-mask="99.99.9999" id="BIRTHDATEfamMemb" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Степень родства</label>
                        <select name="TYP_RODSTV" id="TYP_RODSTV" class="select2_demo_1 form-control" >
                                <option></option>
                                <?php
                                    foreach($listFamPers as $d => $f){
                                ?>
                                    <option value="<?php echo trim($f['ID']); ?>"><?php echo $f['NAME']; ?></option>
                                <?php
                                    }
                                ?>
                    </select>
                    </div>
                    
            </div>
            <div class="modal-footer">
                <a id="addFamilyMemberDB" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="editExpFam" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление члена семьи</h4>
                <small class="font-bold"></small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <input name="idPersFamedit" type="text" placeholder="" class="form-control" id="idPersFamedit" value="<?php echo $empId; ?>">
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID члена семьи</label>
                        <input name="editFamIdMod" type="text" placeholder="" class="form-control" id="editFamIdMod" required>
                    </div>
                    <div id="placeForFamMembAjax">
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Фамилия</label>
                        <input name="LASTNAMEfamedit" type="text" placeholder="" class="form-control" id="LASTNAMEfamedit" value="" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Имя</label>
                        <input name="FIRSTNAMEfamedit" type="text" placeholder="" class="form-control" id="FIRSTNAMEfamedit" value="" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Отчество</label>
                        <input name="MIDDLENAMEfamedit" type="text" placeholder="" class="form-control" id="MIDDLENAMEfamedit" value="" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата рождения</label>
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="BIRTHDATEfamMembedit" data-mask="99.99.9999" id="BIRTHDATEfamMembedit" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Степень родства</label>
                        <select name="TYP_RODSTVedit" id="TYP_RODSTVedit" class="select2_demo_1 form-control" >
                                <option></option>
                                <?php
                                    foreach($listFamPers as $d => $f){
                                ?>
                                    <option value="<?php echo trim($f['ID']); ?>"><?php echo $f['NAME']; ?></option>
                                <?php
                                    }
                                ?>
                    </select>
                    </div>
                    </div>
                    
            </div>
            <div class="modal-footer">
                <a id="updateFamilyMemberDB" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="addHoliday" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление отпуска</h4>
                <small class="font-bold">отпуск</small>
            </div>
            <div class="modal-body">
            <form method="post">
                <div hidden="" class="form-group" id="data_1">
                    <input name="ID_PERSONholi" type="text" placeholder="" class="form-control" id="ID_PERSONholi" value="<?php echo $empId; ?>">
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Тип отпуска</label>
                    <select name="HOLY_KIND" id="HOLY_KIND" class="select2_demo_1 form-control">
                            <option></option>
                            <?php
                                foreach($listVID_HOLIDAYS as $d => $f)
                                {
                            ?>
                                <option id="<?php echo trim($f['SIMB']); ?>" value="<?php echo trim($f['ID']); ?>"><?php echo $f['NAME']; ?></option>
                            <?php
                                }
                            ?>
                    </select>
                </div>
                <div class="form-group" id="small_period_table" hidden="">
                    <table class="table table-hover margin bottom" id="editEduTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">Период (начало)</th>
                            <th class="text-center">Период (конец)</th>
                            <th class="text-center">Итого доступно на период</th>
                        </tr>
                        </thead>
                        <tbody id="place_for_holi3">
                            <?php
                                    foreach($list_holy_period as $n => $m)
                                    {
                                        $avail_day_for_today = 30;
                                        $used = $m['DAY_COUNT_USED_FOR_TODAY'];
                                        $didnt_add = $m['DIDNT_ADD'];
                                        if(strtotime($today_date) < strtotime($m['PERIOD_END']))
                                        {
                                            $day_from_period_start = floor((strtotime($today_date) - strtotime($m['PERIOD_START']))/ 86400);
                                            $avail_day_for_today = $day_from_period_start/365*30;
                                        }
                                        $avail_day = round($avail_day_for_today - $used - $didnt_add);
                                        $total_avial_days_count = $avail_day + $total_avial_days_count;
                            ?>
                            <tr>
                                <td>
                                    <input onclick="add_input(<?php echo $m['ID']; ?>);" type="checkbox" id="period_check<?php echo $m['ID']; ?>"/>
                                </td>
                                <td hidden=""><input class="ui-pg-input" name="PERSON_HOLYDAYS_PERIOD_ID" value="<?php echo $m['ID']; ?>"/></td>
                                <td class="text-center"><?php echo $m['PERIOD_START']; ?></td>
                                <td class="text-center"><?php echo $m['PERIOD_END']; ?></td>
                                <td class="text-center"><?php echo $avail_day; ?></td>
                            </tr>
                            <?php
                                    }
                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    function add_input(id)
                    {
                        if($('#period_check'+id).is(':checked'))
                        {
                          $('#PERIOD_ID_PLACE').append('<input  style="display: none;" name="USING_PERIOD[]" class="form-control" id="PERIOD_ID'+id+'" value="'+id+'"/>');
                        }else
                        {
                          $('#PERIOD_ID'+id).remove();
                        }
                    }

                    $("#HOLY_KIND").change(function()
                    {
                          var id = $(this).children(":selected").attr("id");
                          $('#HOLY_TYPE').val(id);
                          var sel_num = $(this).children(":selected").val();
                          if(sel_num == 1 || sel_num == 2)
                          {
                            show_period();
                          }else{
                            hide_period();
                          }
                    });

                    function show_period()
                    {
                        $('#small_period_table').show();
                        var AVAIL_DAY_PER = $('#AVAIL_DAY_PER').val();
                        $('#CNT_DAYSholi').val(AVAIL_DAY_PER);
                        alert('Сотруднику доступно '+AVAIL_DAY_PER+' трудовых отпускных дней');
                    }

                    function hide_period()
                    {
                        $('#small_period_table').hide();
                        $('#CNT_DAYSholi').val('');
                    }
                </script>
                <div class="form-group" id="PERIOD_ID_PLACE">
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">AVAIL_DAY_PER</label>
                    <input name="AVAIL_DAY_PER" class="form-control" id="AVAIL_DAY_PER" value="<?php echo round($total_avial_days_count); ?>"/>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">Буква в табель</label>
                    <input name="HOLY_TYPE" type="text" placeholder="" class="form-control" id="HOLY_TYPE" value="" required>
                </div>
                <div class="form-group">
                <label class="font-noraml">Дата начала отпуска</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control dateOform" name="DATE_BEGINholi" data-mask="99.99.9999" id="DATE_BEGINholi" required/>
                </div>
                </div>
                <div class="form-group">
                <label class="font-noraml">Дата конца отпуска</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control dateOform" name="DATE_ENDholi" data-mask="99.99.9999" id="DATE_ENDholi" required/>
                </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Количество дней</label>
                    <input name="CNT_DAYSholi" class="form-control" id="CNT_DAYSholi" required=""/>
                </div>
                <div class="form-group">
                <label class="font-noraml">За период(начало)</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control dateOform" name="PERIOD_BEGINholi" data-mask="99.99.9999" id="PERIOD_BEGINholi" required/>
                </div>
                </div>
                <div class="form-group">
                <label class="font-noraml">За период (конец)</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control dateOform" name="PERIOD_ENDholi" data-mask="99.99.9999" id="PERIOD_ENDholi" required/>
                </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Номер приказа</label>
                    <input name="ORDER_NUMholi" type="text" placeholder="" class="form-control" id="ORDER_NUMholi" value="" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">BRANCH_ID</label>
                    <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required=""/>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_SP</label>
                    <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required=""/>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_POSITION</label>
                    <input name="JOB_POSITIONholi" type="text" class="form-control" id="JOB_POSITIONholi" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                </div>
                <div class="form-group">
                <label class="font-noraml">Дата приказа</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control dateOform" name="ORDER_DATEholi" data-mask="99.99.9999" id="ORDER_DATEholi" required=""/>
                </div>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">Автор</label>
                    <input name="EMP_IDholi" type="text" placeholder="" class="form-control" id="EMP_IDholi" value="<?php echo $active_user_dan['emp']; ?>" required=""/>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="addHolidayFunc();" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="add_trip" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление командировки</h4>
                <small class="font-bold">командировка</small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <input name="ID_PERSONtrip" type="text" placeholder="" class="form-control" id="ID_PERSONtrip" value="<?php echo $empId; ?>">
                    </div>
                    <div class="form-group">
                        <label class="font-noraml">Дата начала командировки</label>
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="form-control dateOform" name="DATE_BEGINtrip" data-mask="99.99.9999" id="DATE_BEGINtrip" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-noraml">Дата конца командировки</label>
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="form-control dateOform" name="DATE_ENDtrip" data-mask="99.99.9999" id="DATE_ENDtrip" required/>
                        </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Цель поездки</label>
                        <textarea class="form-control" name="AIM" id="AIM"></textarea>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Цель поездки (каз)</label>
                        <textarea class="form-control" name="AIM_KAZ" id="AIM_KAZ"></textarea>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Пункт назначения</label>
                        <textarea class="form-control" name="FINAL_DESTINATION" id="FINAL_DESTINATION"></textarea>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Пункт назначения (каз)</label>
                        <textarea class="form-control" name="FINAL_DESTINATION_KAZ" id="FINAL_DESTINATION_KAZ"></textarea>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Количество дней</label>
                        <input name="CNT_DAYStrip" type="text" placeholder="" class="form-control" id="CNT_DAYStrip" value="" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер приказа</label>
                        <input name="ORDER_NUMtrip" type="text" placeholder="" class="form-control" id="ORDER_NUMtrip" value="" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">BRANCH_ID</label>
                        <input name="BRANCH_IDtrip" type="text" class="form-control" id="BRANCH_IDtrip" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">JOB_SP</label>
                        <input name="JOB_SPtrip" type="text" class="form-control" id="JOB_SPtrip" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">JOB_POSITION</label>
                        <input name="JOB_POSITIONtrip" type="text" class="form-control" id="JOB_POSITIONtrip" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата приказа</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="ORDER_DATEtrip" data-mask="99.99.9999" id="ORDER_DATEtrip" required/>
                    </div>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">Автор</label>
                        <input name="EMP_IDtrip" type="text" placeholder="" class="form-control" id="EMP_IDtrip" value="<?php echo $active_user_dan['emp']; ?>" required>
                    </div>
                    
                    
            </div>
            <div class="modal-footer">
                <a onclick="addTripFunc();" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addHolidayFunc(){
            //$('#place_for_holi').html('Ошибка');
            var HOLY_TYPE = $('#HOLY_TYPE').val();
            var ID_PERSONholi = $('#ID_PERSONholi').val();
            var DATE_BEGINholi = $('#DATE_BEGINholi').val();
            var DATE_ENDholi = $('#DATE_ENDholi').val();
            var CNT_DAYSholi = $('#CNT_DAYSholi').val();
            var PERIOD_BEGINholi = $('#PERIOD_BEGINholi').val();
            var PERIOD_ENDholi = $('#PERIOD_ENDholi').val();
            var ORDER_NUMholi = $('#ORDER_NUMholi').val();
            var ORDER_DATEholi = $('#ORDER_DATEholi').val();
            var EMP_IDholi = $('#EMP_IDholi').val();
            var BRANCH_IDholi = $('#BRANCH_IDholi').val();
            var JOB_SPholi = $('#JOB_SPholi').val();
            var JOB_POSITIONholi = $('#JOB_POSITIONholi').val();
            var AUTHOR_ID = $('#AUTHOR_ID').val();
            var today_date = $('#today_date').val();
            var HOLY_KIND = $('#HOLY_KIND').val();
            var users = $('input[name="USING_PERIOD[]"]').map(function(){ return this.value; }).get();

            console.log('ID_PERSONholi-'+ID_PERSONholi+' DATE_BEGINholi-'+DATE_BEGINholi+' DATE_ENDholi-'+DATE_ENDholi+' CNT_DAYSholi-'+CNT_DAYSholi+' PERIOD_BEGINholi-'+PERIOD_BEGINholi+' PERIOD_ENDholi-'+PERIOD_ENDholi+'BRANCH_IDholi-'+BRANCH_IDholi+' JOB_SPholi-'+JOB_SPholi+' JOB_POSITIONholi-'+JOB_POSITIONholi+' today_date-'+today_date+' AUTHOR_ID-'+AUTHOR_ID+' HOLY_KIND-'+HOLY_KIND+' HOLY_TYPE-'+HOLY_TYPE+ORDER_NUMholi+'/'+ORDER_DATEholi+'/'+EMP_IDholi);

            if(ID_PERSONholi != '' && DATE_BEGINholi != '' && DATE_ENDholi != '' && CNT_DAYSholi != '' && PERIOD_BEGINholi != '' && PERIOD_ENDholi != '' && ORDER_NUMholi != '' && ORDER_DATEholi != '' && BRANCH_IDholi != '' && JOB_SPholi != '' && JOB_POSITIONholi != '' && HOLY_KIND != '')
            {
                $.post('edit_employee', {"ID_PERSONholi": ID_PERSONholi,
                                         "DATE_BEGINholi": DATE_BEGINholi,
                                         "DATE_ENDholi": DATE_ENDholi,
                                         "CNT_DAYSholi": CNT_DAYSholi,
                                         "PERIOD_BEGINholi": PERIOD_BEGINholi,
                                         "PERIOD_ENDholi": PERIOD_ENDholi,
                                         "ORDER_NUMholi": ORDER_NUMholi,
                                         "ORDER_DATEholi": ORDER_DATEholi,
                                         "EMP_IDholi": EMP_IDholi,
                                         "BRANCH_IDholi": BRANCH_IDholi,
                                         "JOB_SPholi": JOB_SPholi,
                                         "JOB_POSITIONholi": JOB_POSITIONholi,
                                         "AUTHOR_ID": AUTHOR_ID,
                                         "today_date": today_date,
                                         "HOLY_TYPE": HOLY_TYPE,
                                         "HOLY_KIND": HOLY_KIND,
                                         'USING_PERIOD[]': users
                                        }, function(d){
                                            //alert(d);
                                            $('#place_for_holi').html(d);
                                        })
            }else{
                alert('Не заполнены все поля');
            }
    }
</script>
<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="returnMod" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Отозвать сотрудника</h4>
                <small class="font-bold"></small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <input name="ID_PERSONholiReturn" type="text" placeholder="" class="form-control" id="ID_PERSONholiReturn" value="<?php echo $empId; ?>">
                    </div>
                    <div id="placeForReturnHoliIdMod">
                    <div class="form-group">
                    <label class="font-noraml">Отозвать с </label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_BEGINholiReturn" data-mask="99.99.9999" id="DATE_BEGINholiReturn" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Дата конца отпуска</label>
                        <input name="DATE_ENDholiReturn" type="text" placeholder="" class="form-control" id="DATE_ENDholiReturn" value="" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Количество дней</label>
                        <input name="CNT_DAYSholiReturn" type="text" placeholder="" onclick="culc_day_return();" class="form-control" id="CNT_DAYSholiReturn" value="" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер приказа</label>
                        <input name="ORDER_NUMholiReturn" type="text" placeholder="" class="form-control" id="ORDER_NUMholiReturn" value="" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата приказа</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="ORDER_DATEholiReturn" data-mask="99.99.9999" id="ORDER_DATEholiReturn" required/>
                    </div>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">Автор</label>
                        <input name="EMP_IDholiReturn" type="text" placeholder="" class="form-control" id="EMP_IDholiReturn" value="<?php echo $active_user_dan['emp']; ?>" required>
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a id="" onclick="returnHoly();" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="trip_details" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Детали командировки</h4>
            </div>
            <div class="modal-body">
                <div id="placeForEditTrip">
                    <div hidden="" class="form-group" id="data_1">
                        <input name="TRIP_DETAIL_ID" class="form-control" id="TRIP_DETAIL_ID" value="<?php echo $empId; ?>">
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Пункт отправки</label>
                        <input name="FROM_PLACE" class="form-control" id="FROM_PLACE"/>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Пункт назначения</label>
                        <input name="TO_PLACE" class="form-control" id="TO_PLACE"/>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Вид транспорта</label>
                        <select name="TRANSPORT" id="TRANSPORT" class="select2_demo_1 form-control">
                            <option value="0"></option>
                        <?php
                            foreach($list_transport as $h => $j){
                        ?>
                            <option  value="<?php echo trim($j['ID']); ?>"><?php echo $j['NAME']; ?></option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>
                </div>                                                   
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" data-dismiss="modal" onclick="add_trip_detail();">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="editHoliMod" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление отпуска</h4>
                <small class="font-bold">отпуск</small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <input name="ID_PERSONholiEdit" type="text" placeholder="" class="form-control" id="ID_PERSONholiEdit" value="<?php echo $empId; ?>">
                    </div>
                    <div id="placeForEditHoliIdMod">
                    <div class="form-group">
                    <label class="font-noraml">Дата начала отпуска</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_BEGINholiEdit" data-mask="99.99.9999" id="DATE_BEGINholiEdit" required/>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата конца отпуска</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_ENDholiEdit" data-mask="99.99.9999" id="DATE_ENDholiEdit" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Количество дней</label>
                        <input name="CNT_DAYSholiEdit" type="text" placeholder="" class="form-control" id="CNT_DAYSholiEdit" value="" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">За период(начало)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="PERIOD_BEGINholiEdit" data-mask="99.99.9999" id="PERIOD_BEGINholiEdit" required/>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">За период (конец)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="PERIOD_ENDholiEdit" data-mask="99.99.9999" id="PERIOD_ENDholiEdit" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер приказа</label>
                        <input name="ORDER_NUMholiEdit" type="text" placeholder="" class="form-control" id="ORDER_NUMholiEdit" value="" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата приказа</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="ORDER_DATEholiEdit" data-mask="99.99.9999" id="ORDER_DATEholiEdit" required/>
                    </div>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">Автор</label>
                        <input name="EMP_IDholiEdit" type="text" placeholder="" class="form-control" id="EMP_IDholiEdit" value="<?php echo $active_user_dan['emp']; ?>" required>
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a id="editHoli" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="editHealthMod" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Редактирование больничного</h4>
                <small class="font-bold">больничный</small>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <input name="EMP_IDhosp" type="text" placeholder="" class="form-control" id="EMP_IDhosp" value="<?php echo $empId; ?>">
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <input name="today_date" type="text" placeholder="" class="form-control" id="today_date" value="<?php echo $today_date; ?>">
                    </div>
                    <div id="placeForEditHospdMod">
                    <label class="font-noraml">ID</label>
                    <div class="form-group" id="data_1">
                        <input name="IDhospEdit" type="text" placeholder="" class="form-control" id="IDhospEdit" value="<?php echo $empId; ?>">
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата вступления в силу ЛН</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_BEGINhospEdit" data-mask="99.99.9999" id="DATE_BEGINhospEdit" required/>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата конца ЛН</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_ENDhospEdit" data-mask="99.99.9999" id="DATE_ENDhospEdit" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Находился на лечении</label>
                        <input name="CNT_DAYShospEdit" type="text" placeholder="" class="form-control" id="CNT_DAYShospEdit" value="" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">Создатель</label>
                        <input name="EMP_IDhospEdit" type="text" placeholder="" class="form-control" id="EMP_IDhospEdit" value="<?php echo $active_user_dan['emp']; ?>" required>
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a id="editHosp" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="addHealthMod" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавление листа нетрудоспособности</h4>
                <small class="font-bold">отпуск</small>
            </div>
            <div class="modal-body">
            <form method="post">
                <div hidden="" class="form-group">
                    <input name="ID_PERSONhosp" type="text" placeholder="" class="form-control" id="ID_PERSONhosp" value="<?php echo $empId; ?>"/>
                </div>
                <div class="form-group">
                <label class="font-noraml">Дата вступления в силу ЛН</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control dateOform" name="DATE_BEGINhosp" data-mask="99.99.9999" id="DATE_BEGINhosp" required=""/>
                </div>
                </div>
                <div class="form-group">
                <label class="font-noraml">Дата конца ЛН</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control dateOform" name="DATE_ENDhosp" data-mask="99.99.9999" id="DATE_ENDhosp" required=""/>
                </div>
                </div>
                <div class="form-group">
                    <label class="font-noraml">Находился на лечении</label>
                    <input name="CNT_DAYShosp" type="text" placeholder="" class="form-control" id="CNT_DAYShosp" value="" required=""/>
                </div>
                <div class="form-group">
                    <label class="font-noraml">Номер приказа</label>
                    <input name="ORDER_NUMhosp" type="text" placeholder="" class="form-control" id="ORDER_NUMhosp" value="" required=""/>
                </div>
                <div  class="form-group">
                    <label class="font-noraml">Дата приказа</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="ORDER_DATEhosp" data-mask="99.99.9999" id="ORDER_DATEhosp" required=""/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="addHosp" type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить</a>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="change_pos" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Перемещение</h4>
                <small class="font-bold">Сменить филиал, подразделение, должность</small>
            </div>
            <div class="modal-body">
            <form method="post">
                <input name="empIdTrivial_view" type="text" placeholder="" class="form-control" id="empIdTrivial_view" value="<?php echo $empId;?>" style="display: none;"/>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Компания</label>
                    <input disabled="" name="COMPANY_NAME_view" class="form-control" id="COMPANY_NAME_view" value="<?php echo $empInfo[0]['comp_name']; ?>"/>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Подразделение</label>
                    <select name="JOB_SP_view" id="JOB_SP_view" class="select2_demo_1 form-control" onchange="get_positions();">
                        <option></option>
                        <?php
                            $dolzh_id = trim($empInfo[0]['JOB_SP']);
                            foreach($listDepartments as $q => $d)
                            {
                        ?>
                            <option <?php if($d['ID'] == $dolzh_id){echo "selected";} ?> value="<?php echo $d['ID']; ?>"><?php echo $d['NAME']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Должность</label>
                    <div id="place_for_job_pos">
                        <select style="display: none;" onchange="" name="JOB_POSITION_view" id="JOB_POSITION_view" class="select2_demo_1 form-control">
                        <?php
                            $pos_id = trim($empInfo[0]['JOB_POSITION']);
                            foreach($listPosition as $l => $p)
                            {
                        ?>
                            <option <?php if($p['ID'] == $pos_id){echo "selected";} ?> value="<?php echo $p['ID']; ?>"><?php echo $p['D_NAME']; ?></option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Оклад (тенге)</label>
                    <input name="OKLAD_view" class="form-control" id="OKLAD_view" value="<?php echo $oklad; ?>"/>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата (приказа)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="ORDER_TO_TRANSFER_DATE_view" data-mask="99.99.9999" id="ORDER_TO_TRANSFER_DATE_view" required/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="delete_tech" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Удалить технику</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">tech ID</label>
                        <input name="DEL_TECH_ID" class="form-control pos_btn" id="DEL_TECH_ID"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Удалить</button>
                    <a type="button" class="btn btn-white" data-dismiss="modal">Отмена</a>                  
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="add_tech" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавить технику</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Техника</label>
                        <select id="TECH_ID" name="TECH_ID" class="select2_demo_1 form-control chosen-select">
                            <option></option>
                            <?php
                                foreach($list_techs as $s => $t){
                            ?>
                                <option  value="<?php echo trim($t['ID']); ?>"><?php echo $t['INVENT_NUM'].' - '.$t['NAME']; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Тип</label>
                        <select id="TECH_TYPE" name="TECH_TYPE" class="select2_demo_1 form-control chosen-select">
                            <option></option>
                            <?php
                                foreach($list_techs_type as $b => $n){
                            ?>
                                <option  value="<?php echo trim($n['ID']); ?>"><?php echo $n['NAME']; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="" type="submit" class="btn btn-primary">Сохранить</button>
                    <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="add_bonus" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавить надбавку</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">BRANCH_ID</label>
                    <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_SP</label>
                    <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_POSITION</label>
                    <input name="JOB_POSITIONholi" type="text" class="form-control" id="JOB_POSITIONholi" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">emp_author_id</label>
                    <input name="AUTHOR_ID" type="number" placeholder="" class="form-control pos_btn" id="AUTHOR_ID" value="<?php echo $emp_author_id;?>"/>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Сумма (тенге)</label>
                    <input name="NABDAVKA" type="number" placeholder="" class="form-control pos_btn" id="NABDAVKA" value="">
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата начала выплаты набдавки</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="NABDAVKA_DATE" data-mask="99.99.9999" id="NABDAVKA_DATE" required/>
                    </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Номер приказа</label>
                    <input name="NABDAVKA_ORDER_NUM" placeholder="" class="form-control pos_btn" id="NABDAVKA_ORDER_NUM" value="">
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата (приказа)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="NABDAVKA_ORDER_DATE" data-mask="99.99.9999" id="NABDAVKA_ORDER_DATE" required/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="" type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="add_bonus_eco" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавить экологическую надбавку</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">BRANCH_ID</label>
                    <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_SP</label>
                    <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_POSITION</label>
                    <input name="JOB_POSITIONholi" type="text" class="form-control" id="JOB_POSITIONholi" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">emp_author_id</label>
                    <input name="AUTHOR_ID" type="number" placeholder="" class="form-control pos_btn" id="AUTHOR_ID" value="<?php echo $emp_author_id;?>"/>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Сумма (тенге)</label>
                    <input name="NABDAVKA_ECO" type="number" placeholder="" class="form-control pos_btn" id="NABDAVKA_ECO" value="">
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата начала выплаты экологической набдавки</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="NABDAVKA_ECO_DATE" data-mask="99.99.9999" id="NABDAVKA_ECO_DATE" required/>
                    </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Номер приказа</label>
                    <input name="NABDAVKA_ECO_ORDER_NUM" placeholder="" class="form-control pos_btn" id="NABDAVKA_ECO_ORDER_NUM" value="">
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата (приказа)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="NABDAVKA_ORDER_ECO_DATE" data-mask="99.99.9999" id="NABDAVKA_ORDER_ECO_DATE" required/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="" type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
            </div>
            </form>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="add_bonus_for_couple_func" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Добавить доплату за совмещение должностных обязанностей</h4>
            </div>
            <form method="post">
            <div class="modal-body">
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">BRANCH_ID</label>
                    <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_SP</label>
                    <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">JOB_POSITION</label>
                    <input name="JOB_POSITIONholi" type="text" class="form-control" id="JOB_POSITIONholi" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                </div>
                <div hidden="" class="form-group" id="data_1">
                    <label class="font-noraml">emp_author_id</label>
                    <input name="AUTHOR_ID" type="number" placeholder="" class="form-control pos_btn" id="AUTHOR_ID" value="<?php echo $emp_author_id;?>"/>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Сумма (тенге)</label>
                    <input name="SURCHARGE" type="number" placeholder="" class="form-control pos_btn" id="SURCHARGE" value="">
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата начала выплаты доплаты</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="SURCHARGE_DATE" data-mask="99.99.9999" id="SURCHARGE_DATE" required/>
                    </div>
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Номер приказа</label>
                    <input name="SURCHARGE_ORDER_NUM" placeholder="" class="form-control pos_btn" id="SURCHARGEO_ORDER_NUM" value="">
                </div>
                <div class="form-group" id="data_1">
                    <label class="font-noraml">Дата (приказа)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="SURCHARGE_ORDER_DATE" data-mask="99.99.9999" id="SURCHARGE_ORDER_DATE" required/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="" type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
            </div>
            </form>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="dismiss" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Уволить сотрудника</h4>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">BRANCH_ID</label>
                        <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">JOB_SP</label>
                        <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">JOB_POSITION</label>
                        <input name="JOB_POSITIONholi" type="text" class="form-control" id="JOB_POSITIONholi" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Дата конца сотрудничества</label>
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="form-control dateOform" name="DATE_dismiss" data-mask="99.99.9999" id="DATE_dismiss" required/>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>                  
            </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL WINDOWS -->            
<div class="modal inmodal fade" id="change_bank_inf" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Изменить банковские реквизиты</h4>
            </div>
            <div class="modal-body">
            <form method="post">
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">BRANCH_ID</label>
                        <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">JOB_SP</label>
                        <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">JOB_POSITION</label>
                        <input name="JOB_POSITIONholi" type="text" class="form-control" id="JOB_POSITIONholi" value="<?php echo $empInfo[0]['JOB_POSITION']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">BRANCH_ID</label>
                        <input name="BRANCH_IDholi" type="text" class="form-control" id="BRANCH_IDholi" value="<?php echo $empInfo[0]['BRANCHID']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">JOB_SP</label>
                        <input name="JOB_SPholi" type="text" class="form-control" id="JOB_SPholi" value="<?php echo $empInfo[0]['JOB_SP']; ?>" required>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Банк</label>
                        <select id="BANK_ID_change" name="BANK_ID_change" class="select2_demo_1 form-control">
                                <option></option>
                            <?php
                                $bank_id = trim($empInfo[0]['BANK_ID']);
                                foreach($listBanks as $b => $s){
                            ?>
                                <option <?php if($s['BANK_ID'] == $bank_id){echo "selected";} ?> value="<?php echo $s['BANK_ID']; ?>"><?php echo $s['NAME']; ?></option>
                            <?php 
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Банк</label>
                        <input name="ACCOUNT_TYPE" type="text" placeholder="" class="form-control" id="ACCOUNT_TYPE" value="<?php echo $empInfo[0]['ACCOUNT_TYPE'];?>">
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Банк</label>
                        <input name="ACCOUNT" type="text" placeholder="" class="form-control" id="ACCOUNT" value="<?php echo $empInfo[0]['ACCOUNT'];?>">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a type="button" class="btn btn-white" data-dismiss="modal">Закрыть</a>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#checkMilitary').click
    (
        function()
        {
            addMilitaryFunc();
            addTrivialInfoFunc();
        }
    )

    $('#saveEdu').click
    (
        function()
        {
            addEducationFunc();
        }
    )

    $('#addExperiance').click
    (
        function()
        {
            addExpirienceFunc();
        }
    )

    $('#addFamilyMemberDB').click
    (
        function()
        {
            addFamilyFunc();
        }
    )

    $('#checkTrivial').click
    (
        function()
        {
            addTrivialInfoFunc();
            addMilitaryFunc();
        }
    )

    $('#returnHoli').click
    (
        function()
        {
            returnHoly();
        }
    )

    function returnHoly(){
        var idholiReturn = $('#idholiReturn').val();
        var empIdEditHoli = $('#empIdTrivial').val();
        var DATE_BEGINholiReturn = $('#DATE_BEGINholiReturn').val();
        var DATE_ENDholiReturn = $('#DATE_ENDholiReturn').val();
        var CNT_DAYSholiReturn = $('#CNT_DAYSholiReturn').val();
        var BRANCH_IDholi = $('#BRANCH_IDholi').val();
        var JOB_SPholi = $('#JOB_SPholi').val();
        var JOB_POSITIONholi = $('#JOB_POSITIONholi').val();
        var ORDER_NUMholiReturn = $('#ORDER_NUMholiReturn').val();
        var ORDER_DATEholiReturn = $('#ORDER_DATEholiReturn').val();
        var AUTHOR_ID = $('#AUTHOR_ID').val();

        console.log(idholiReturn+'/'+DATE_BEGINholiReturn+'/'+DATE_ENDholiReturn+'/'+CNT_DAYSholiReturn+'/'+BRANCH_IDholi+'/'+JOB_SPholi+'/'+JOB_POSITIONholi+'/'+ORDER_DATEholiReturn);

        if(idholiReturn != '' && DATE_BEGINholiReturn != '' && DATE_ENDholiReturn != '' && CNT_DAYSholiReturn != '' && BRANCH_IDholi != '' && JOB_SPholi != '' && JOB_POSITIONholi != '' && ORDER_DATEholiReturn != ''){
            console.log('ушло в базу');
            $.post('edit_employee', {"idholiReturn": idholiReturn,
                                     "DATE_BEGINholiReturn": DATE_BEGINholiReturn,
                                     "DATE_ENDholiReturn": DATE_ENDholiReturn,
                                     "CNT_DAYSholiReturn": CNT_DAYSholiReturn,
                                     "BRANCH_IDholi": BRANCH_IDholi,
                                     "JOB_SPholi": JOB_SPholi,
                                     "JOB_POSITIONholi": JOB_POSITIONholi,
                                     "empIdEditHoli": empIdEditHoli,
                                     "ORDER_NUMholiReturn": ORDER_NUMholiReturn,
                                     "ORDER_DATEholiReturn": ORDER_DATEholiReturn,
                                     "AUTHOR_ID": AUTHOR_ID
                                     }, function(d){
                                        $('#place_for_holi').html(d);
                });
        }else{
            alert('Не все поля заполнены');
        }
    }

    $('#editHoli').click
    (
        function()
        {
            updateHoli();
        }
    )

    $('#addHosp').click
    (
        function()
        {
            var EMP_IDhosp = $('#EMP_IDhosp').val();
            alert("EMP_IDhosp "+EMP_IDhosp);
            addHospFunc();
        }
    )

    $('#editHosp').click(
        function(){
            updateHosp();
        }
    )

    $('#addHolidayDB').click(
        function(){
            //addHolidayFunc();
        }
    );

    function culc_day_return(){
        var date1 = $('#DATE_BEGINholiReturn').val();
        var date2 = $('#DATE_ENDholiReturn').val();
        var day = count_diff(date1, date2);
        var daycount = day + 1;
        $('#CNT_DAYSholiReturn').val(daycount);
    }

    function culc_holyday_return(){
        var date1 = $('#today_date').val();
        var date2 = $('#DATE_POST').val();
        var day = count_diff(date1, date2);
        var daycount = day;
        $('#holyday_cnt').html(daycount);
    }        

    $('#CNT_DAYSholi').click(
        function(){
            var date1 = $('#DATE_BEGINholi').val();
            var date2 = $('#DATE_ENDholi').val();
            var day = count_diff(date1, date2);
            var daycount = day + 1;
            $('#CNT_DAYSholi').val(daycount);
        }
    )

    function count_diff(d1, d2){
        var date_1 = new Date(parseInt(d1.substr(6, 4), 10), parseInt(d1.substr(3, 2), 10), parseInt(d1.substr(0, 2), 10));
        var date_2 = new Date(parseInt(d2.substr(6, 4), 10), parseInt(d2.substr(3, 2), 10), parseInt(d2.substr(0, 2), 10));
        return Math.abs(((date_1-date_2)/86400000));;
    }

    $('#CNT_DAYShosp').click(
        function(){
            var date1 = $('#DATE_BEGINhosp').val();
            var date2 = $('#DATE_ENDhosp').val();
            var day = count_diff(date1, date2);
            var daycount = day + 1;
            
            $('#CNT_DAYShosp').val(daycount);
        }
    )

    function count_diff(d1, d2){
        var date_1 = new Date(parseInt(d1.substr(6, 4), 10), parseInt(d1.substr(3, 2), 10), parseInt(d1.substr(0, 2), 10));
        var date_2 = new Date(parseInt(d2.substr(6, 4), 10), parseInt(d2.substr(3, 2), 10), parseInt(d2.substr(0, 2), 10));
        return Math.abs(((date_1-date_2)/86400000));;
    }
</script>

<script>
    function get_table(){
        var emp_id = $('#empIdTrivial').val();
        var year_for_table = $('#YEAR_FOR_TABLE').val();
        var month_for_table = $('#MONTH_FOR_TABLE').val();
        console.log(year_for_table+'/////'+month_for_table);
        $.post('edit_employee', {"GET_TABLE": "GET_TABLE",
                                 "year_for_table": year_for_table,
                                 "month_for_table": month_for_table,
                                 "emp_id": emp_id
                                }, function(d){
            $('#place_for_table').html(d);
        })
    }
</script>

<script>    
    $('#BRANCHID_view').change(
        function(){
            var BRANCHID = $('#BRANCHID_view').val();
            correct_selects_sp(BRANCHID);
        }
    )
    
    function correct_selects_sp(BRANCHID){
        $('#OKLAD_view').val('');
        
        if(BRANCHID == '0')
        {
            $('#JOB_SP_view').html('<option value="0" selected="selected">ДИТ</option>');
            $.post('edit_employee', {"BRANCHID_FOR_JOB_POSITION": BRANCHID
                                }, function(d){
                                    $('#JOB_POSITION_view').html(d);
                                })
            $('#JOB_POSITION_view').html('<option value="0" selected="selected"></option>');
            $('#ID_RUKOV').val('');
            $('#ID_RUKOV_VIEW').val('');
        }
            else if(BRANCHID == '0000')
        {
            $('.secondary_option').show();
            $.post('edit_employee', {"BRANCHID_FOR_SP": "BRANCHID_FOR_SP"
                                }, function(d){
                                    $('#JOB_SP_view').html(d);
                                    $('#JOB_POSITION_view').html('<option value="0" selected="selected"></option>');
                                })
            $.post('edit_employee', {"GET_CHIEF_NAME": "GET_CHIEF_NAME",
                                     "BRANCHID_CHIEF_NAME": BRANCHID
                                    }, function(d){
                                        $('#ID_RUKOV_VIEW').val(d.trim());
                                    })
            $('#ID_RUKOV_MOD').val('ФИО Руководителя');
            /*
            $.post('edit_employee', {"GET_CHIEF_NAME_ID": "GET_CHIEF_NAME_ID",
                                     "BRANCHID_CHIEF_NAME": BRANCHID
                                    }, function(d){
                                        $('#ID_RUKOV_MOD').val('ФИО Руководителя');
                                    })
            */
        }
        else
        {
            $('#JOB_SP_view').html('<option value="0" selected="selected">ДИТ</option>');
            $.post('edit_employee', {"BRANCHID_FOR_JOB_POSITION": BRANCHID
                                }, function(d){
                                    $('#JOB_POSITION_view').html(d);
                                })
            $.post('edit_employee', {"GET_CHIEF_NAME": "GET_CHIEF_NAME",
                                     "BRANCHID_CHIEF_NAME": BRANCHID
                                    }, function(d){
                                        $('#ID_RUKOV_view').val(d.trim());
                                    })
            $('#ID_RUKOV_MOD').val('ФИО Руководителя');
            /*
            $.post('edit_employee', {"GET_CHIEF_NAME_ID": "GET_CHIEF_NAME_ID",
                                     "BRANCHID_CHIEF_NAME": BRANCHID
                                    }, function(d){
                                        $('#ID_RUKOV_MOD').val('ФИО Руководителя');
                                    })
            */
            $('.secondary_option').hide();
        }
    }

    function get_positions()
    {
        var DEP_ID = $('#JOB_SP_view').val();
        $.post
        ('edit_employee',
                {"BRANCHID_FOR_POSITIONS": DEP_ID
                },
                    function(d)
                {
                    $('#place_for_job_pos').html(d);
                }
        )
    }

    $('#save_pos').click(
    function(){
        var BRANCHID = $('#BRANCHID_view').val();
        var JOB_SP = $('#JOB_SP_view').val();
        var JOB_POSITION = $('#JOB_POSITION_view').val();
        var OKLAD = $('#OKLAD_view').val();
        var ID_RUKOV = $('#ID_RUKOV_VIEW').val();
        var emp_id = $('#empIdTrivial').val();
        var ORDER_TO_TRANSFER_DATE = $('#ORDER_TO_TRANSFER_DATE').val();
        if(OKLAD == '')
            {
                alert('Вы не ввели оклад!');
            }
            else if(JOB_POSITION == 0){
                alert('Вы не выбрали должность!');
            }
            else if(ORDER_TO_TRANSFER_DATE == ''){
                alert('Вы не выбрали дату события!');
            }
            else
            {
                $('#change_pos').modal('hide');
                $('#BRANCHID').val(BRANCHID);
                $('#JOB_SP').val(JOB_SP);
                $('#JOB_POSITION').val(JOB_POSITION);
                $('#ID_RUKOV').val(ID_RUKOV);
                $('#OKLAD').val(OKLAD);
                build_position(BRANCHID, JOB_SP, JOB_POSITION, OKLAD, ID_RUKOV, emp_id, ORDER_TO_TRANSFER_DATE);
                //update_job_pos_inf(emp_id);
            }
    })

    function build_position(BRANCHID, JOB_SP, JOB_POSITION, OKLAD, ID_RUKOV, emp_id, ORDER_TO_TRANSFER_DATE)
    {
          $.post('edit_employee',
                {"GET_TABLE_WITH_DATA": "GET_TABLE_WITH_DATA",
                 "BRANCHID": BRANCHID,
                 "JOB_SP": JOB_SP,
                 "JOB_POSITION": JOB_POSITION,
                 "ID_RUKOV": ID_RUKOV,
                 "OKLAD": OKLAD,
                 "emp_id": emp_id,
                 "ORDER_TO_TRANSFER_DATE": ORDER_TO_TRANSFER_DATE
                },
                    function(d)
                {
                    $('#place_for_state_table').html(d);
                })
    }

    function same_address(){
        var FACT_ADDRESS_COUNTRY_ID = $('#FACT_ADDRESS_COUNTRY_ID').val();
        var FACT_ADDRESS_CITY = $('#FACT_ADDRESS_CITY').val();
        var FACT_ADDRESS_STREET = $('#FACT_ADDRESS_STREET').val();
        var FACT_ADDRESS_BUILDING = $('#FACT_ADDRESS_BUILDING').val();
        var FACT_ADDRESS_FLAT = $('#FACT_ADDRESS_FLAT').val();
        
        //var REG_ADDRESS_COUNTRY_ID = $('#REG_ADDRESS_COUNTRY_ID').val();
        $("#REG_ADDRESS_COUNTRY_ID [value='"+FACT_ADDRESS_COUNTRY_ID+"']").attr("selected", "selected");
        $('#REG_ADDRESS_CITY').val(FACT_ADDRESS_CITY);
        $('#REG_ADDRESS_STREET').val(FACT_ADDRESS_STREET);
        $('#REG_ADDRESS_BUILDING').val(FACT_ADDRESS_BUILDING);
        $('#REG_ADDRESS_FLAT').val(FACT_ADDRESS_FLAT);
    }
    
    $(document).ready(
        function(){
            culc_holyday_return();
                    
        }
    )        
</script>










