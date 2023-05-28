<?php
        define('COMPANY_ID', 'COMPANY_ID'); // Define COMPANY_ID constant

        $db = new My_sql_db();
        // Building the Employee object
        $empId = $_GET['employee_id'];
        $sql_company = "SELECT COMPANY_ID FROM `EMPLOYEES` WHERE ID = '$empId'";
        $list_company = $db->Select($sql_company);
        $company_id = $_SESSION[COMPANY_ID];

    //создаем обьект Employee, в параметры передаем ID
    $employee = new Employee($empId);

    //Обновление общей информации работника начало
    if(isset($_POST['empIdTrivial']))
    {
        $empIdTrivial = $_POST['empIdTrivial'];
        $LASTNAME = $_POST['LASTNAME'];
        $FIRSTNAME = $_POST['FIRSTNAME'];
        $middlename = $_POST['middlename'];
        $IIN = $_POST['IIN'];
        $BIRTHDATE = date('Y-m-d', strtotime($_POST['BIRTHDATE']));
        $NACIONAL = $_POST['NACIONAL'];
        $BIRTH_PLACE = $_POST['BIRTH_PLACE'];
        $DOCTYPE = $_POST['DOCTYPE'];
        $CONTRACT_JOB_NUM = $_POST['CONTRACT_JOB_NUM'];
        $CONTRACT_JOB_DATE = date('Y-m-d', strtotime($_POST['CONTRACT_JOB_DATE']));
        $BRANCHID = $_POST['BRANCHID'];
        $JOB_SP = $_POST['JOB_SP'];
        $JOB_POSITION = $_POST['JOB_POSITION'];
        $ID_RUKOV = $_POST['ID_RUKOV'];
        $EMAIL = $_POST['EMAIL'];
        $FAX = $_POST['FAX'];
        $WORK_PHONE = $_POST['WORK_PHONE'];
        $HOME_PHONE = $_POST['HOME_PHONE'];
        $MOB_PHONE = $_POST['MOB_PHONE'];
        $BANK_ID = $_POST['BANK_ID'];
        $ACCOUNT_TYPE = $_POST['ACCOUNT_TYPE'];
        $ACCOUNT = $_POST['ACCOUNT'];
        $OKLAD = $_POST['OKLAD'];
        $FAMILY = $_POST['FAMILY'];
        $STATE = $_POST['STATE'];
        $REG_ADDRESS_COUNTRY_ID = $_POST['REG_ADDRESS_COUNTRY_ID'];
        $REG_ADDRESS_CITY = $_POST['REG_ADDRESS_CITY'];
        $REG_ADDRESS_STREET = $_POST['REG_ADDRESS_STREET'];
        $REG_ADDRESS_BUILDING = $_POST['REG_ADDRESS_BUILDING'];
        $REG_ADDRESS_FLAT = $_POST['REG_ADDRESS_FLAT'];
        $FACT_ADDRESS_COUNTRY_ID = $_POST['FACT_ADDRESS_COUNTRY_ID'];
        $FACT_ADDRESS_CITY = $_POST['FACT_ADDRESS_CITY'];
        $FACT_ADDRESS_STREET = $_POST['FACT_ADDRESS_STREET'];
        $FACT_ADDRESS_BUILDING = $_POST['FACT_ADDRESS_BUILDING'];
        $FACT_ADDRESS_FLAT = $_POST['FACT_ADDRESS_FLAT'];
        $SEX = $_POST['SEX'];
        $DOCPLACE = $_POST['DOCPLACE'];
        $DOCNUM = $_POST['DOCNUM'];
        $LASTNAME2 = $_POST['LASTNAME2'];
        $FIRSTNAME2 = $_POST['FIRSTNAME2'];
        $PERSONAL_EMAIL = $_POST['PERSONAL_EMAIL'];
        $DATE_POST = date('Y-m-d', strtotime($_POST['DATE_POST']));
        $DATE_LAYOFF = date('Y-m-d', strtotime($_POST['DATE_LAYOFF']));
        $DOCDATE = date('Y-m-d', strtotime($_POST['DOCDATE']));

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($empIdTrivial);

        //$sql_upd_sup_arc = "Copy_rec_person(373)";
        //$sql_upd_sup_arc = "BEGIN Copy_rec_person('$empId'); end;";
        //$db->ExecProc($sql_upd_sup_arc, '');

        //функция обновления общей информации в БД сотрудника
        $sqlTrivial = $employee -> update_emp_to_DB_trivial($empIdTrivial, $LASTNAME, $FIRSTNAME, $middlename, $IIN, $BIRTHDATE, $NACIONAL, $BIRTH_PLACE, $DOCTYPE, $CONTRACT_JOB_NUM, $CONTRACT_JOB_DATE, $BRANCHID, $JOB_SP, $JOB_POSITION, $ID_RUKOV, $EMAIL, $FAX, $WORK_PHONE, $HOME_PHONE, $MOB_PHONE, $BANK_ID, $ACCOUNT_TYPE, $ACCOUNT, $OKLAD, $FAMILY, $STATE, $REG_ADDRESS_COUNTRY_ID, $REG_ADDRESS_CITY, $REG_ADDRESS_STREET, $REG_ADDRESS_BUILDING, $REG_ADDRESS_FLAT, $FACT_ADDRESS_COUNTRY_ID, $FACT_ADDRESS_CITY, $FACT_ADDRESS_STREET, $FACT_ADDRESS_BUILDING, $FACT_ADDRESS_FLAT, $SEX, $DOCPLACE, $DOCNUM, $LASTNAME2, $FIRSTNAME2, $PERSONAL_EMAIL, $DATE_LAYOFF, $DOCDATE, $DATE_POST);

        header("Location: /edit_employee?employee_id=$empIdTrivial");
        exit;
    }
    //Обновление общей информации работника конец

    //Обновление информации воинского статуса работника начало
    if(isset($_POST['MILITARY_SPECIALITY'])){
        $empId = $_POST['empIdMil'];
        $MILITARY_GROUP = $_POST['MILITARY_GROUP'];
        $MILITARY_SPECIALITY = $_POST['MILITARY_SPECIALITY'];
        $MILITARY_CATEG = $_POST['MILITARY_CATEG'];
        $MILITARY_SOST = $_POST['MILITARY_SOST'];
        $MILITARY_RANK = $_POST['MILITARY_RANK'];
        $MILITARY_VOENKOM = $_POST['MILITARY_VOENKOM'];
        $MILITARY_SPEC_UCH = $_POST['MILITARY_SPEC_UCH'];
        $MILITARY_SPEC_UCH_NUM = $_POST['MILITARY_SPEC_UCH_NUM'];
        $MILITARY_FIT = $_POST['MILITARY_FIT'];

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($empId);

        //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
        $sql = $listExp = $employee -> update_inf_MILITARY_SPECIALITY($empId, $MILITARY_GROUP, $MILITARY_SPECIALITY, $MILITARY_CATEG, $MILITARY_SOST, $MILITARY_RANK, $MILITARY_VOENKOM, $MILITARY_SPEC_UCH, $MILITARY_SPEC_UCH_NUM, $MILITARY_FIT);

        exit;
    }
    //Обновление информации воинского статуса работника конец

    //образование начало
    //образование таблица начало
    //редактирование
    if(isset($_POST['updateEduIdMod'])){
        $INSTITUTIONEdit = $_POST['INSTITUTIONEdit'];
        $YEAR_BEGINEdit = $_POST['YEAR_BEGINEdit'];
        $YEAR_ENDEdit = $_POST['YEAR_ENDEdit'];
        $SPECIALITYEdit = $_POST['SPECIALITYEdit'];
        $QUALIFICATIONEdit = $_POST['QUALIFICATIONEdit'];
        $DIPLOM_NUMEdit = $_POST['DIPLOM_NUMEdit'];
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['empIdEditEdu']);
        
        //функция update_edu_emp_to_DB() обновляет данные об образовании в базы
        $listUpdateEduId = $employee -> update_edu_emp_to_DB($INSTITUTIONEdit, $YEAR_BEGINEdit, $YEAR_ENDEdit, $SPECIALITYEdit, $QUALIFICATIONEdit, $DIPLOM_NUMEdit, $_POST['updateEduIdMod']);
        
        //функция get_emp_from_DB() возвращает массив с данными об образовании из базы
        $listEdu = $employee -> get_inf_from_DB_edu();
        
        //функция show_data_table_Edu() выводит таблицу с данными элемента массива переданного в параметре
        $employee ->show_data_table_Edu($listEdu);
        
        exit;
    }
    //редактирование

    //удаление
    if(isset($_POST['deleteEduId'])){        
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['empIdDelEdu']);
        
        //функция delete_inf_in_DB_edu() удаляет данные об образовании из базы
        $employee -> delete_inf_in_DB_edu($_POST['deleteEduId']);
        
        //функция get_emp_from_DB() возвращает массив с данными об образовании из базы
        $listEdu = $employee -> get_inf_from_DB_edu();
               
        //функция show_data_table_Edu() выводит таблицу с данными элемента массива переданного в параметре
        $employee ->show_data_table_Edu($listEdu);
        
        exit;
    }

    //добавление
    if($_POST['idPersEdu']){
        $idPersEdu = $_POST['idPersEdu'];
        $INSTITUTION = $_POST['INSTITUTION'];
        $YEAR_BEGIN = $_POST['YEAR_BEGIN'];
        $YEAR_END = $_POST['YEAR_END'];
        $SPECIALITY = $_POST['SPECIALITY'];
        $QUALIFICATION = $_POST['QUALIFICATION'];
        $DIPLOM_NUM = $_POST['DIPLOM_NUM'];

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($idPersEdu);

        //функция set_inf_to_DB_edu() добавляет данные об образовании из базу
        $employee -> set_inf_to_DB_edu($idPersEdu, $INSTITUTION, $YEAR_BEGIN, $YEAR_END, $SPECIALITY, $QUALIFICATION, $DIPLOM_NUM);

        //функция get_emp_from_DB() возвращает массив с данными об образовании из базы
        $listEdu = $employee -> get_inf_from_DB_edu();

        //функция show_data_table_Edu() выводит таблицу с данными элемента массива переданного в параметре
        $employee ->show_data_table_Edu($listEdu);                

        exit;
    }
    //добавление
    //образование таблица конец

    //образование модальное окно начало
    if(isset($_POST['editEduIdMod'])){
        $sqlEditEduId = "select * from PERSON_EDUCATION where ID = ".$_POST['editEduIdMod'];
        $listEditEduId = $db ->Select($sqlEditEduId);
?>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Название учебного заведения</label>
            <input name="INSTITUTIONEdit" type="text" placeholder="" class="form-control" id="INSTITUTIONEdit" value="<?php echo $listEditEduId[0]['INSTITUTION'];?>" required>
        </div>
        <div class="form-group">
            <label class="font-noraml">Год начала обучения</label>
            <input type="" class="form-control dateOform" name="YEAR_BEGINEdit" data-mask="9999" id="YEAR_BEGINEdit" value="<?php echo $listEditEduId[0]['YEAR_BEGIN'];?>" required/>
        </div>
        <div class="form-group">
            <label class="font-noraml">Год конца обучения</label>
            <input type="" class="form-control dateOform" name="YEAR_ENDEdit" data-mask="9999" id="YEAR_ENDEdit" value="<?php echo $listEditEduId[0]['YEAR_END'];?>" required/>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Специальность</label>
            <input name="SPECIALITYEdit" type="text" placeholder="" class="form-control" id="SPECIALITYEdit" value="<?php echo $listEditEduId[0]['SPECIALITY'];?>" required>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Квалификация</label>
            <input name="QUALIFICATIONEdit" type="text" placeholder="" class="form-control" id="QUALIFICATIONEdit" value="<?php echo $listEditEduId[0]['QUALIFICATION'];?>" required>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Номер диплома</label>
            <input name="DIPLOM_NUMEdit" type="text" placeholder="" class="form-control" id="DIPLOM_NUMEdit" value="<?php echo $listEditEduId[0]['DIPLOM_NUM'];?>" required>
        </div>
<?php
        exit;
    }
    //образование модальное окно конец
    //образование конец            

    //стаж таблица начало
    //редактирование
    if(isset($_POST['idExp'])){
        $empIdEditExp = $_POST['empIdEditExp'];
        $idExp = $_POST['idExp'];
        $expStartDateEdit = $_POST['expStartDateEdit'];
        $expEndDateEdit = $_POST['expEndDateEdit'];
        $P_NAMEEdit = $_POST['P_NAMEEdit'];
        $P_DOLZHEdit = $_POST['P_DOLZHEdit'];
        $P_ADDRESSEdit = $_POST['P_ADDRESSEdit'];
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($empIdEditExp);
        
        //функция update_emp_exp_to_DB() обновляет данные об образовании в базы
        $employee -> update_emp_exp_to_DB($expStartDateEdit, $expEndDateEdit, $P_DOLZHEdit, $P_NAMEEdit, $P_ADDRESSEdit, $idExp);
        
        //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
        $listExp = $employee -> get_inf_from_DB_experience();
            
        //выводит таблицу со стажем
        $employee -> show_data_table_Exp($listExp);
        
        exit;
    }
    //редактирование

    //удаление
    if(isset($_POST['empIdDelExp'])){
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['empIdDelExp']);
        
        //функция delete_inf_in_DB_exp() удаляет данные о стаже из базы
        $employee -> delete_inf_in_DB_exp($_POST['deleteExpId']);
        
        //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
        $listExp = $employee -> get_inf_from_DB_experience();
                
        //выводит таблицу со стажем
        $employee -> show_data_table_Exp($listExp);
        exit;
    }
    //удаление

    //добавление
    if($_POST['idPersExp']){
        $idPersExp = $_POST['idPersExp'];
        $expStartDate = $_POST['expStartDate'];
        $expEndDate = $_POST['expEndDate'];
        $P_NAME = $_POST['P_NAME'];
        $P_DOLZH = $_POST['P_DOLZH'];
        $P_ADDRESS = $_POST['P_ADDRESS'];

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($idPersExp);

        //функция set_inf_to_DB_exp() добавляет данные о стаже в базу
        $employee -> set_inf_to_DB_exp($idPersExp, $expStartDate, $expEndDate, $P_NAME, $P_DOLZH, $P_ADDRESS);

        //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
        $listExp = $employee -> get_inf_from_DB_experience();

        //выводит таблицу со стажем
        $employee -> show_data_table_Exp($listExp);
        exit;
    }
    //добавление
    //стаж таблица конец

    //стаж модальное окно начало
    if(isset($_POST['editExpIdMod'])){
        $sqlEditExpId = "select * from PERSON_STAZH where id = ".$_POST['editExpIdMod']." order by ID";
        $listEditExpId = $db -> Select($sqlEditExpId);
        ?>
        <div class="form-group">
        <label class="font-noraml">Дата начала сотрудничества</label>
        <div class="input-group date ">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" class="form-control dateOform" name="expStartDateEdit" data-mask="99.99.9999" value="<?php echo $listEditExpId[0]['DATE_BEGIN']; ?>" id="expStartDateEdit" required/>
        </div>
        </div>
        <div class="form-group">
        <label class="font-noraml">Дата конца сотрудничества</label>
        <div class="input-group date ">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" class="form-control dateOform" name="expEndDateEdit" data-mask="99.99.9999" value="<?php echo $listEditExpId[0]['DATE_END']; ?>" id="expEndDateEdit" required/>
        </div>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Название организации</label>
            <input name="P_NAMEEdit" type="text" placeholder="" class="form-control" value="<?php echo $listEditExpId[0]['P_NAME']; ?>" id="P_NAMEEdit" required>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Должность</label>
            <input name="P_DOLZHEdit" type="text" placeholder="" class="form-control" value="<?php echo $listEditExpId[0]['P_DOLZH']; ?>" id="P_DOLZHEdit" required>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Местоположение</label>
            <input name="P_ADDRESSEdit" type="text" placeholder="" class="form-control" value="<?php echo $listEditExpId[0]['P_ADDRESS']; ?>" id="P_ADDRESSEdit" required>
        </div>
        <?php
        exit;
    }
    //стаж модальное окно конец

    //члены семьи таблица начало
    //редактирование
    if(isset($_POST['idFamUpdate'])){
        $empIdEditUpdate = $_POST['empIdEditUpdate'];
        $idFamUpdate = $_POST['idFamUpdate'];
        $LASTNAMEfamedit = $_POST['LASTNAMEfamedit'];
        $FIRSTNAMEfamedit = $_POST['FIRSTNAMEfamedit'];
        $MIDDLENAMEfamedit = $_POST['MIDDLENAMEfamedit'];
        $BIRTHDATEfamMembedit = $_POST['BIRTHDATEfamMembedit'];
        $TYP_RODSTVedit = $_POST['TYP_RODSTVedit'];
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($empIdEditUpdate);
        
        //функция update_emp_exp_to_DB() обновляет данные о членах семьи в базе
        $employee -> update_emp_fam_to_DB($LASTNAMEfamedit, $FIRSTNAMEfamedit, $MIDDLENAMEfamedit, $BIRTHDATEfamMembedit, $TYP_RODSTVedit, $idFamUpdate);
        
        //функция get_inf_from_DB_fam_memb() возвращает массив с данными о членах семьи из базы
        $listFam = $employee -> get_inf_from_DB_fam_memb();
        
        //выводит таблицу с членами семьи
        $employee -> show_data_table_Fam($listFam);
        
        exit;
    }
    //редактирование

    //удаление
        if(isset($_POST['deleteFamMembId'])){
        $id = $_POST['empIdDelFamMemb'];
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($id);
                
        //функция delete_inf_in_DB_fam() удаляет члена семьи из базы
        $employee -> delete_inf_in_DB_fam($_POST['deleteFamMembId']);
        
        //функция get_inf_from_DB_fam_memb() возвращает массив с данными о членах семьи из базы
        $listFam = $employee -> get_inf_from_DB_fam_memb();
        
        //выводит таблицу с членами семьи
        $employee -> show_data_table_Fam($listFam);
        
        exit;
    }
    //удаление

    //добавление
    if(isset($_POST['idPersFam']))
    {
        $idPersFam = $_POST['idPersFam'];
        $LASTNAMEfam = $_POST['LASTNAMEfam'];
        $FIRSTNAMEfam = $_POST['FIRSTNAMEfam'];
        $MIDDLENAMEfam = $_POST['MIDDLENAMEfam'];
        $BIRTHDATEfamMemb = $_POST['BIRTHDATEfamMemb'];
        $BIRTHDATEfamMemb = date('Y-m-d', strtotime($BIRTHDATEfamMemb));
        $TYP_RODSTV = $_POST['TYP_RODSTV'];

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($idPersFam);

        //функция set_inf_to_DB_fam() добавляет данные о члене семьи в базу
        $employee -> set_inf_to_DB_fam($idPersFam, $LASTNAMEfam, $FIRSTNAMEfam, $MIDDLENAMEfam, $BIRTHDATEfamMemb, $TYP_RODSTV);

        //функция get_inf_from_DB_fam_memb() возвращает массив с данными о членах семьи из базы
        $listFam = $employee -> get_inf_from_DB_fam_memb();

        //выводит таблицу с членами семьи
        $employee -> show_data_table_Fam($listFam);
        exit;
    }
    //добавление
    //члены семьи таблица конец

    //члены семьи модальное окно начало
    if(isset($_POST['editFamIdMod'])){
        $editFamIdMod = $_POST['editFamIdMod'];
        $sqlEditFamId = "select * from FAMILY_STRUCT where ID = $editFamIdMod order by ID";
        $listEditFamId = $db -> Select($sqlEditFamId);
        
        //члены семьи
        $sqlFamPers = "select * from DIC_TYP_RODSTV order by ID";
        $listFamPers = $db -> Select($sqlFamPers);
    ?>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Фамилия</label>
            <input name="LASTNAMEfamedit" type="text" placeholder="" class="form-control" id="LASTNAMEfamedit" value="<?php echo $listEditFamId[0]['LASTNAME']; ?>" required>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Имя</label>
            <input name="FIRSTNAMEfamedit" type="text" placeholder="" class="form-control" id="FIRSTNAMEfamedit" value="<?php echo $listEditFamId[0]['FIRSTNAME']; ?>" required>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Отчество</label>
            <input name="MIDDLENAMEfamedit" type="text" placeholder="" class="form-control" id="MIDDLENAMEfamedit" value="<?php echo $listEditFamId[0]['MIDDLENAME']; ?>" required>
        </div>
        <div class="form-group">
        <label class="font-noraml">Дата рождения</label>
        <div class="input-group date ">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" class="form-control dateOform" name="BIRTHDATEfamMembedit" data-mask="99.99.9999" id="BIRTHDATEfamMembedit" value="<?php echo $listEditFamId[0]['BIRTHDATE']; ?>" required/>
        </div>
        </div>
        <div class="form-group" id="data_1">
            <label class="font-noraml">Степень родства</label>
            <select name="TYP_RODSTVedit" id="TYP_RODSTVedit" class="select2_demo_1 form-control" >
                    <?php
                        foreach($listFamPers as $d => $f){
                    ?>
                        <option <?php if(trim($f['ID']) == $listEditFamId[0]['TYP_RODSTV']){echo 'selected=""';} ?> value="<?php echo trim($f['ID']); ?>"><?php echo $f['NAME']; ?></option>
                    <?php
                        }
                    ?>
        </select>
        </div>
    <?php
        exit;
    }
    //члены семьи модальное окно конец

    //добавление
    if(isset($_POST['ID_PERSONholi'])){
        //место редактирования
/*
        foreach($_POST['USING_PERIOD'] as $kk => $vv)
        {
            $current_used_day_count = 0;
            $sql_PERSON_HOLYDAYS_PERIOD = "select PERIOD_END, PERIOD_START, DIDNT_ADD, DAY_COUNT_USED_FOR_TODAY from PERSON_HOLYDAYS_PERIOD where ID = $vv";
            $select_PERSON_HOLYDAYS_PERIOD = $db -> Select($sql_PERSON_HOLYDAYS_PERIOD);
                        
            $current_used_day_count = $select_PERSON_HOLYDAYS_PERIOD[0]['DAY_COUNT_USED_FOR_TODAY'] + $select_PERSON_HOLYDAYS_PERIOD[0]['DIDNT_ADD'];
            
            $total_used_day = $current_used_day_count + $total_used_day;
            if(strtotime($today_date) < strtotime($select_PERSON_HOLYDAYS_PERIOD[0]['PERIOD_END']))
            {
                $day_from_period_start = floor((strtotime($today_date) - strtotime($select_PERSON_HOLYDAYS_PERIOD[0]['PERIOD_START']))/ 86400);
                $avail_day_for_today = $day_from_period_start/365*30;
                $past_days = $past_days+round($avail_day_for_today);
            }else{
                $past_days = $past_days+30;
            }
        }
        $total_avail_days = $past_days - $total_used_day;
        $CNT_DAYSholi = $_POST['CNT_DAYSholi'];
        $some_num = $CNT_DAYSholi;
        if($CNT_DAYSholi <= $total_avail_days)
        {
            foreach($_POST['USING_PERIOD'] as $kk => $vv)
            {
                $sql_PERSON_HOLYDAYS_PERIOD = "select DIDNT_ADD, DAY_COUNT_USED_FOR_TODAY from PERSON_HOLYDAYS_PERIOD where ID = $vv";
                $select_PERSON_HOLYDAYS_PERIOD = $db -> Select($sql_PERSON_HOLYDAYS_PERIOD);
                
                $current_used_day_count_second = $select_PERSON_HOLYDAYS_PERIOD[0]['DAY_COUNT_USED_FOR_TODAY'] + $select_PERSON_HOLYDAYS_PERIOD[0]['DIDNT_ADD'];
                echo 'использовано за период '.$current_used_day_count_second;
                
                echo 'количество планируемых дней '.$some_num;
                $avail_for_this_period = 30 - $current_used_day_count_second;
                if($some_num <= $avail_for_this_period)
                {
                    $updating_day_count = $select_PERSON_HOLYDAYS_PERIOD[0]['DAY_COUNT_USED_FOR_TODAY']+$some_num;
                    echo 'дней меньше чем возможно за период. Количество дней для обновления '.$updating_day_count.'||';
                }else{
                    $updating_day_count = 30;
                    echo 'дней больше чем возможно за период. Количество дней для обновления '.$updating_day_count.'||';
                    $some_num = $some_num - $avail_for_this_period;
                }
                $sql_change_state = "update PERSON_HOLYDAYS_PERIOD set DAY_COUNT_USED_FOR_TODAY = '$updating_day_count' where ID = '$vv'";
                $list_change_state = $db -> Execute($sql_change_state);
                
                echo $sql_change_state;
            }
        }else{
            echo 'Вы ввели недоступное количество дней!';
            exit;
        }
*/
        $ID_PERSONholi = $_POST['ID_PERSONholi'];
        $DATE_BEGINholi = $_POST['DATE_BEGINholi'];
        $DATE_BEGINholi = date('Y-m-d', strtotime($DATE_BEGINholi));
        $DATE_ENDholi = $_POST['DATE_ENDholi'];
        $DATE_ENDholi = date('Y-m-d', strtotime($DATE_ENDholi));
        $PERIOD_BEGINholi = $_POST['PERIOD_BEGINholi'];
        $DATE_ENDholi = date('Y-m-d', strtotime($DATE_ENDholi));
        $PERIOD_ENDholi = $_POST['PERIOD_ENDholi'];
        $PERIOD_ENDholi = date('Y-m-d', strtotime($PERIOD_ENDholi));
        $ORDER_NUMholi = $_POST['ORDER_NUMholi'];
        $ORDER_DATEholi = $_POST['ORDER_DATEholi'];
        $ORDER_DATEholi = date('Y-m-d', strtotime($ORDER_DATEholi));
        $EMP_IDholi = $_POST['EMP_IDholi'];
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        $AUTHOR_ID = $_POST['AUTHOR_ID'];
        $today_date = $_POST['today_date'];
        $today_date = date('Y-m-d', strtotime($today_date));
        $HOLY_TYPE = $_POST['HOLY_TYPE'];
        $HOLY_KIND = $_POST['HOLY_KIND'];
        $CNT_DAYSholi = $_POST['CNT_DAYSholi'];
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['ID_PERSONholi']);

        //функция set_inf_to_DB_Holidays() добавляет данные об отпуске
        $sqlHoli = $employee -> set_inf_to_DB_Holidays($ID_PERSONholi, $DATE_BEGINholi, $DATE_ENDholi, $CNT_DAYSholi, $PERIOD_BEGINholi, $PERIOD_ENDholi, $ORDER_NUMholi, $ORDER_DATEholi, $EMP_IDholi, $BRANCH_IDholi, $DEPARTMENTholi, $POSITIONholi, $AUTHOR_ID, $today_date, $HOLY_TYPE, $HOLY_KIND);

        //возвращает массив с отпусками
        $listHolidays = $employee -> get_inf_from_DB_holidays();

        //выводит таблицу с отпусками
        $listUpdateHolidays = $employee -> show_data_table_Holidays($listHolidays);

        echo $sqlHoli;

        exit;
    }
    //добавление

    //больничный начало
    //больничный таблица начало
    //добавление
    if(isset($_POST['ID_PERSONhosp']))
    {
        $ID_PERSONhosp = $_POST['ID_PERSONhosp'];
        $DATE_BEGINhosp = $_POST['DATE_BEGINhosp'];
        $DATE_BEGINhosp = date('Y-m-d', strtotime($DATE_BEGINhosp));
        $DATE_ENDhosp = $_POST['DATE_ENDhosp'];
        $DATE_ENDhosp = date('Y-m-d', strtotime($DATE_ENDhosp));
        $CNT_DAYShosp = $_POST['CNT_DAYShosp'];
        $EMP_IDhosp = $_POST['EMP_IDhosp'];
        $today_date = $_POST['today_date'];
        $today_date = date('Y-m-d', strtotime($today_date));
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        $AUTHOR_ID = $_POST['AUTHOR_ID'];
        $ORDER_DATEhosp = $_POST['ORDER_DATEhosp'];
        $ORDER_DATEhosp = date('Y-m-d', strtotime($ORDER_DATEhosp));
        $ORDER_NUMhosp = $_POST['ORDER_NUMhosp'];

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['ID_PERSONhosp']);

        //функция set_inf_to_DB_Hosp() добавляет данные о больничными
        $sqlHosp = $employee -> set_inf_to_DB_Hosp($ID_PERSONhosp, $DATE_BEGINhosp, $DATE_ENDhosp, $CNT_DAYShosp, $EMP_IDhosp, $today_date, $BRANCH_IDholi, $DEPARTMENTholi, $POSITIONholi, $AUTHOR_ID, $ORDER_DATEhosp, $ORDER_NUMhosp);

        //функция get_inf_from_DB_HOSPITAL() возвращает массив с данными о больничными
        $listHOSPITAL = $employee -> get_inf_from_DB_HOSPITAL();

        //выводит таблицу с больничными
        $listUpdateHOSPITAL = $employee -> show_data_table_HOSPITAL($listHOSPITAL);
    }
    //добавление

    //удаление
    if(isset($_POST['deleteHospId'])){
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['EMP_IDhosp']);

        //функция delete_inf_in_DB_holi() удаляет данные об отпуске из базы
        $employee -> delete_inf_in_DB_hosp($_POST['deleteHospId']);

        //функция get_inf_from_DB_HOSPITAL() возвращает массив с данными о больничными
        $listHOSPITAL = $employee -> get_inf_from_DB_HOSPITAL();

        //выводит таблицу с больничными
        $listUpdateHOSPITAL = $employee -> show_data_table_HOSPITAL($listHOSPITAL);

        exit;
    }

    //редактирование
    if(isset($_POST['ID_PERSONhospEdit'])){
        $ID_PERSONhospEdit = $_POST['ID_PERSONhospEdit'];
        $DATE_BEGINhospEdit = $_POST['DATE_BEGINhospEdit'];
        $DATE_ENDhospEdit = $_POST['DATE_ENDhospEdit'];
        $CNT_DAYShospEdit = $_POST['CNT_DAYShospEdit'];
        $EMP_IDhospEdit = $_POST['EMP_IDhospEdit'];
        $IDhospEdit = $_POST['IDhospEdit'];
        $BRANCH_IDholiEdit = $_POST['BRANCH_IDholiEdit'];
        $JOB_SPholiEdit = $_POST['JOB_SPholiEdit'];
        $JOB_POSITIONholiEdit = $_POST['JOB_POSITIONholiEdit'];

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['ID_PERSONhospEdit']);

        //функция update_inf_DB_Hosp() обновляет данные об образовании в базы
        $listUpdateHospId = $employee -> update_inf_DB_Hosp($ID_PERSONhospEdit, $DATE_BEGINhospEdit, $DATE_ENDhospEdit, $CNT_DAYShospEdit, $EMP_IDhospEdit, $IDhospEdit, $today_date, $emp_author_id, $BRANCH_IDholiEdit, $JOB_SPholiEdit, $JOB_POSITIONholiEdit);

        //функция get_inf_from_DB_HOSPITAL() возвращает массив с данными о больничными
        $listHOSPITAL = $employee -> get_inf_from_DB_HOSPITAL();

        //выводит таблицу с больничными
        $listUpdateHOSPITAL = $employee -> show_data_table_HOSPITAL($listHOSPITAL);
        //print_r($listHOSPITAL);

        exit;
    }
    //редактирование

    //отпуск модальное окно начало
    if(isset($_POST['IDhospEditMod'])){
        $sqlHospId = "select * from PERSON_HOSPITAL where id = ".$_POST['IDhospEditMod'];
        $listHospId = $db -> Select($sqlHospId);
?>
                    <div hidden="" class="form-group" id="data_1">
                        <input name="IDhospEdit" type="text" placeholder="" class="form-control" id="IDhospEdit" value="<?php echo $listHospId[0]['ID']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="font-noraml">Дата вступления в силу ЛН</label>
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input disabled="" type="text" class="form-control dateOform" name="DATE_BEGINhospEdit" data-mask="99.99.9999" id="DATE_BEGINhospEdit" value="<?php echo $listHospId[0]['DATE_BEGIN']; ?>" required/>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата конца ЛН</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_ENDhospEdit" data-mask="99.99.9999" id="DATE_ENDhospEdit" value="<?php echo $listHospId[0]['DATE_END']; ?>" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Находился на лечении</label>
                        <input name="CNT_DAYShospEdit" type="text" placeholder="" class="form-control" id="CNT_DAYShospEdit" value="<?php echo $listHospId[0]['CNT_DAYS']; ?>" required>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">Создатель</label>
                        <input name="EMP_IDhospEdit" type="text" placeholder="" class="form-control" id="EMP_IDhospEdit" value="<?php echo $listHospId[0]['EMP_ID']; ?>" required>
                    </div>
<?php
        exit;
    }
/*
    $emp_mail = $_SESSION['insurance']['other']['mail'][0];
    $emp_fio = $_SESSION['insurance']['fio'];

    $select_author_id = "select ID from sup_person where EMAIL = '$emp_mail'";
    $list_author_id = $db -> Select($select_author_id);
    $emp_author_id = $list_author_id[0]['ID'];
    
    //отзыв с декретного отпуска
    if(isset($_POST['DATE_maternity']))
    {
        $seqArray = $db -> Select("select SEQ_RETURN_FROM_HOLY.nextval from dual");
        $sequance = $seqArray[0]['NEXTVAL'];
        
        $maternity_date = $_POST['DATE_maternity'];
        $maternity_ORDER_DATE = $_POST['maternity_ORDER_DATE'];
        $order_num = $_POST['ORDER_NUMmaternity'];
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        $AUTHOR_ID = $_POST['AUTHOR_ID'];
        $sql_change_state = "update SUP_PERSON set STATE = '2' where id = '$empId'";
        $list_change_state = $db -> Execute($sql_change_state);

        //добавляем в таблицу отзывов
        $sqlHoli = "insert into RETURN_FROM_HOLY (ID, ID_HOLY, DATE_HOLY_START, DATE_HOLY_END, DAY_COUNT, ORDER_NUM, ORDER_DATE, PERSON_ID) 
                        values ($sequance,
                                '', 
                                '$maternity_date',
                                '',
                                '',
                                '$order_num',
                                '$maternity_ORDER_DATE',
                                '$empId'
                                )";
            
        $listHoli = $db -> Execute($sqlHoli);

        //удаляем табель со значением декретного отпуска
        $sql = "DELETE TABLE_OTHER WHERE EMP_ID = '$empId' AND DAY_DATE BETWEEN '$maternity_date' AND '31.12.2050'";
        $list_sql = $db->Execute($sql);

        //вносим в историю
        $sql_update_history = "insert into T2_CARD 
        (ID, EVENT_DATE, ID_PERSON, BRANCH_ID, DEPARTMENT, POSITION, ACT_ID, ORDER_DATE, ORDER_NUM, EMP_ID, ID_MISS, OTPR) values 
        (SEQ_T2_CARD.nextval, '$today_date', '$empId', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '8', '$maternity_ORDER_DATE', '$order_num', '$AUTHOR_ID', '$sequance', 0)";
        $update_history = $db -> Execute($sql_update_history);

        //создаем табель для нового сотрудника
        $CREATE_TABLE_FOR_ONE_PERS_ID = $empId;
        $work_start_day = $maternity_date;

        $post_day_list = explode('.', $work_start_day);
        $post_day = $post_day_list[0];

        $post_withuot_day = '.'.$post_day_list[1].'.'.$post_day_list[2];
        create_other_table("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, $post_day);

        for($i = $post_day_list[1]+1; $i <= 12; $i++)
        {
            if($i<10)
            {
                $post_withuot_day = '.0'.$i.'.'.$post_day_list[2];
                create_other_table_for_this_year("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, '01');
            }
                else
            {
                $post_withuot_day = '.'.$i.'.'.$post_day_list[2];
                create_other_table_for_this_year("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, '01');
            }
        }
    }

    if(isset($_POST['DEL_TECH_ID']))
    {
        $del_tech_id = $_POST['DEL_TECH_ID'];
        $sql_del_tech = "update TECHNICS set EMP_ID = '' where id = '$del_tech_id'";
        $list_del_tech = $db -> Execute($sql_del_tech);
    }
    
    if(isset($_POST['TECH_ID']))
    {
        $tech_id = $_POST['TECH_ID'];
        $tech_type = $_POST['TECH_TYPE'];
        $sql = "update TECHNICS set EMP_ID = '$empId', ID_TYPE = '$tech_type' where id = '$tech_id'";
        $list = $db -> Execute($sql);
    }
    
    //доплата за совмещение должностей
    if(isset($_POST['SURCHARGE']))
    {
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        $SURCHARGE = $_POST['SURCHARGE'];
        $SURCHARGE_DATE = $_POST['SURCHARGE_DATE'];
        $SURCHARGE_ORDER_DATE = $_POST['SURCHARGE_ORDER_DATE'];
        $SURCHARGE_ORDER_NUM = $_POST['SURCHARGE_ORDER_NUM'];
        $AUTHOR_ID = $_POST['AUTHOR_ID'];
        $sql = "update sup_person set PREMIUM = '$SURCHARGE', PREMIUM_PERIOD = '$SURCHARGE_DATE' where id = '$empId'";
        $list = $db -> Execute($sql);
        $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ID_PERSON, BRANCH_ID, DEPARTMENT, POSITION, ACT_ID, ORDER_DATE, ORDER_NUM, EMP_ID, OTPR) values (SEQ_T2_CARD.nextval, '$today_date', '$empId', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '11', '$SURCHARGE_ORDER_DATE', '$SURCHARGE_ORDER_NUM', '$AUTHOR_ID', 0)";
        $update_history = $db -> Execute($sql_update_history);
    }
    
    //надбавка
    if(isset($_POST['NABDAVKA']))
    {
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        $NABDAVKA = $_POST['NABDAVKA'];
        $NABDAVKA_DATE = $_POST['NABDAVKA_DATE'];
        $NABDAVKA_ORDER_DATE = $_POST['NABDAVKA_ORDER_DATE'];
        $ORDER_NUM = $_POST['NABDAVKA_ORDER_NUM'];
        $AUTHOR_ID = $_POST['AUTHOR_ID'];
        $sql = "update sup_person set NADBAVKA = '$NABDAVKA', NADBAVKA_DATE = '$NABDAVKA_DATE' where id = '$empId'";
        $list = $db -> Execute($sql);
        $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ID_PERSON, BRANCH_ID, DEPARTMENT, POSITION, ACT_ID, ORDER_DATE, ORDER_NUM, EMP_ID) values (SEQ_T2_CARD.nextval, '$today_date', '$empId', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '9', '$NABDAVKA_ORDER_DATE', '$ORDER_NUM', '$AUTHOR_ID')";
        $update_history = $db -> Execute($sql_update_history);
    }
    
    //экологическая надбавка
    if(isset($_POST['NABDAVKA_ECO']))
    {
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        $NABDAVKA_ECO = $_POST['NABDAVKA_ECO'];
        $NABDAVKA_ECO_DATE = $_POST['NABDAVKA_ECO_DATE'];
        $NABDAVKA_ORDER_DATE = $_POST['NABDAVKA_ORDER_ECO_DATE'];
        $ORDER_NUM = $_POST['NABDAVKA_ECO_ORDER_NUM'];
        $AUTHOR_ID = $_POST['AUTHOR_ID'];
        $sql = "update sup_person set NADBAVKA_ECO = '$NABDAVKA_ECO', NADBAVKA_ECO_DATE = '$NABDAVKA_ECO_DATE' where id = $empId";
        $list = $db -> Execute($sql);
        $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ID_PERSON, BRANCH_ID, DEPARTMENT, POSITION, ACT_ID, ORDER_DATE, ORDER_NUM, EMP_ID) values (SEQ_T2_CARD.nextval, '$today_date', '$empId', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '10', '$NABDAVKA_ORDER_DATE', '$ORDER_NUM', '$AUTHOR_ID')";
        $update_history = $db -> Execute($sql_update_history);
    }

    if(isset($_POST['DATE_dismiss'])){
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        
        $sql_upd_sup_arc = "BEGIN Copy_rec_person(
                                '$empId');
                            end;";
        $db->ExecProc($sql_upd_sup_arc, '');
                
        $DATE_dismiss = $_POST['DATE_dismiss'];
        $sql_update_dismiss = "update sup_person set DATE_LAYOFF = '$DATE_dismiss' where id = $empId";
        $list_update_dismiss = $db -> Execute($sql_update_dismiss);
        
        //$sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ID_PERSON, BRANCH_ID, DEPARTMENT, POSITION, ACT_ID) values (SEQ_T2_CARD.nextval, '$DATE_dismiss', '$empId', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '5')";
        //$update_history = $db -> Execute($sql_update_history);
        
        $sql_update_table_dismiss = "update TABLE_OTHER set VALUE = ' ' where EMP_ID = $empId and DAY_DATE between '$DATE_dismiss' and '31.12.2050'";
        $list_update_table_dismiss = $db -> Execute($sql_update_table_dismiss);
        
        $sql_fire_pers = "insert into SET_DELETED_PERSONS (ID, EMP_ID, DELETE_DATE, STATE, JOB_POSITION, JOB_SP, BRANCHID) values (SEQ_SET_DELETED_PERSONS.NEXTVAL, $empId, '$DATE_dismiss', 0, '$POSITIONholi', '$DEPARTMENTholi', '$BRANCH_IDholi')";
        $update_fire_pers = $db -> Execute($sql_fire_pers);
        
        $sql = "select
                s.id, s.lastname||' '||s.firstname||' '||s.middlename fio,
                s.EMAIL,
                s.WORK_PHONE,
                s.MOB_PHONE,
                S.STATE state,
                d.d_name,
                DEP.NAME dep,
                state.name
            from
                sup_person s, 
                dic_dolzh d,
                DIC_PERSON_STATE state,
                dic_department dep
            where
                s.ID = $empId
                and
                D.ID(+) = S.JOB_POSITIOn
                and
                state.id(+) = s.state
                and
                dep.id(+) = s.job_sp
            order by s.id";
    
        $listEmployee = $db -> Select($sql);
        foreach($listEmployee as $k=> $v){}
        $lastname = $v['FIO'];
        $firstname = $v['FIRSTNAME'];
        $middlename = $v['MIDDLENAME'];
        $PERSONAL_EMAIL = $v['EMAIL'];
        
        mail('i.akhmetov@gak.kz', 'Уведомление об увольнении сотрудника', "ФИО: $lastname $firstname $middlename \r\nПочта: $PERSONAL_EMAIL \r\nДата увольнения: $DATE_dismiss", 'From: hr@gak.kz');
        mail('a.omarov@gak.kz', 'Уведомление об увольнении сотрудника', "ФИО: $lastname $firstname $middlename \r\nПочта: $PERSONAL_EMAIL \r\nДата увольнения: $DATE_dismiss", 'From: hr@gak.kz');
        mail('n.omirbekov@gak.kz', 'Уведомление об увольнении сотрудника', "ФИО: $lastname $firstname $middlename \r\nПочта: $PERSONAL_EMAIL\r\nДата увольнения: $DATE_dismiss", 'From: hr@gak.kz');
        mail('a.saleev@gak.kz', 'Уведомление об увольнении сотрудника', "ФИО: $lastname $firstname $middlename \r\nПочта: $PERSONAL_EMAIL\r\nДата увольнения: $DATE_dismiss", 'From: hr@gak.kz');
    }
*/
    //дата сегодня
    $today_date = date('Y-m-d');

    if(isset($_POST['ORDER_TO_TRANSFER_DATE_view']))
    {
        $JOB_SP = $_POST['JOB_SP_view'];
        $JOB_POSITION = $_POST['JOB_POSITION_view'];
        $ID_RUKOV = $_POST['ID_RUKOV'];
        $OKLAD = $_POST['OKLAD_view'];
        $emp_id_view = $_POST['empIdTrivial_view'];
        $ORDER_TO_TRANSFER_DATE = date('Y-m-d', strtotime($_POST['ORDER_TO_TRANSFER_DATE_view']));
        //Сюда вставить SQL код с для получения айди руководителя

        $sql_update_job_posit = "update EMPLOYEES set JOB_SP = '$JOB_SP', JOB_POSITION = '$JOB_POSITION', OKLAD = '$OKLAD' where id = $emp_id_view";
        $update_job_posi_list = $db -> Execute($sql_update_job_posit);
        $sql_update_history =
        "insert into T2_CARD (ID, EVENT_DATE, DEPARTMENT, POSITION, SALARY, ID_PERSON, ACT_ID, EMP_ID, COMPANY, BRANCH_ID, ORDER_DATE, EVENT_START_DATE) values
        (NULL, '$today_date', '$JOB_SP', '$JOB_POSITION', '$OKLAD', '$emp_id_view', '3', '$emp_id_view', '10', '2', '$ORDER_TO_TRANSFER_DATE', '$ORDER_TO_TRANSFER_DATE')";
        $update_history = $db -> Execute($sql_update_history);
    }
/*
    if(isset($_POST['BRANCHID_FOR_JOB_POSITION'])){
        $BRANCHID_FOR_JOB_POSITION = $_POST['BRANCHID_FOR_JOB_POSITION'];
        //должности
        $sqlBRANCHID_FOR_JOB_POSITION = "select * from DIC_Dolzh where BRANCH_ID = '$BRANCHID_FOR_JOB_POSITION'";
        $listBRANCHID_FOR_JOB_POSITION = $db -> Select($sqlBRANCHID_FOR_JOB_POSITION);
        //echo $sqlPosition;
        //print_r($listPosition);
        ?>
        <select name="JOB_POSITION_view" id="JOB_POSITION_view" class="select2_demo_1 form-control pos_btn">
        <option value="0"></option>
            <?php
                $positionId = trim($empInfo[0]['JOB_POSITION']);
                foreach($listBRANCHID_FOR_JOB_POSITION as $o => $p){
            ?>
                <option class="secondary_option secondary_option2" <?php if(trim($p['ID']) == "$positionId") {echo "selected";} ?> value="<?php echo trim($p['ID']); ?>"><?php echo $p['D_NAME']; ?></option>
            <?php
                }
            ?>
        </select>
        <?php
        exit;
    }
    
    if(isset($_POST['GET_CHIEF_NAME'])){
        $BRANCHID_CHIEF_NAME = $_POST['BRANCHID_CHIEF_NAME'];
        $sqlGET_CHIEF_NAME = "select SHORT_BOSS_N from DIC_BRANCH where RFBN_ID = $BRANCHID_CHIEF_NAME";
        $listGET_CHIEF_NAME = $db -> Select($sqlGET_CHIEF_NAME);
        echo '192';
        exit;
    }
    
    if(isset($_POST['GET_CHIEF_NAME_ID'])){
        $BRANCHID_CHIEF_NAME = $_POST['BRANCHID_CHIEF_NAME'];
        $sqlGET_CHIEF_NAME = "select SHORT_BOSS_N from DIC_BRANCH where RFBN_ID = $BRANCHID_CHIEF_NAME";
        $listGET_CHIEF_NAME = $db -> Select($sqlGET_CHIEF_NAME);
        echo trim($listGET_CHIEF_NAME[0]['SHORT_BOSS_N']);
        exit;
    }
*/
    if(isset($_POST['BRANCHID_FOR_SP'])){
        $BRANCHID = $_POST['BRANCHID_FOR_SP'];
        //департаменты
        $sqlDepartments = "select * from DIC_DEPARTMENT where COMPANY_ID = '$BRANCHID' order by ID";
        $listDepartments = $db -> Select($sqlDepartments);
        echo '<option value="0"></option>';
        echo '<option value="0">22</option>';
        foreach($listDepartments as $z => $x)
        {
            echo '<option value="'.trim($x['ID']).'">'.$x['NAME'].'</option>';
        }
        exit;
    }

    if(isset($_POST['BRANCHID_FOR_POSITIONS']))
    {
        $dep_id = $_POST['BRANCHID_FOR_POSITIONS'];
        //должности
        $sqlPosition .= "select * from DIC_DOLZH where ID_DEPARTMENT = '$dep_id' ORDER BY D_NAME";
        $listPosition = $db -> Select($sqlPosition);
        ?>
        <select name="JOB_POSITION_view" id="JOB_POSITION_view" class="select2_demo_1 form-control">
        <option value="0"></option>
            <?php
                $positionId = trim($empInfo[0]['JOB_POSITION']);
                foreach($listPosition as $o => $p){
            ?>
                <option class="secondary_option secondary_option2" <?php if(trim($p['ID']) == "$positionId") {echo "selected";} ?> value="<?php echo trim($p['ID']); ?>"><?php echo $p['D_NAME']; ?></option>
            <?php
                }
            ?>
        </select>
        <?php
        exit;
    }

    //отзыв
    //добавление
    if(isset($_POST['DATE_BEGINholiReturn'])){
        //$seqArray = $db -> Select("select SEQ_RETURN_FROM_HOLY.nextval from dual");
        //$sequance = $seqArray[0]['NEXTVAL'];

        $idholiReturn = $_POST['idholiReturn'];
        $DATE_BEGINholiReturn = $_POST['DATE_BEGINholiReturn'];
        $DATE_ENDholiReturn = $_POST['DATE_ENDholiReturn'];
        $CNT_DAYSholiReturn = $_POST['CNT_DAYSholiReturn'];
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $JOB_SPholi= $_POST['JOB_SPholi'];
        $JOB_POSITIONholi = $_POST['JOB_POSITIONholi'];
        $empIdEditHoli = $_POST['empIdEditHoli'];
        $ORDER_NUMholiReturn = $_POST['ORDER_NUMholiReturn'];
        $ORDER_DATEholiReturn = $_POST['ORDER_DATEholiReturn'];
        $AUTHOR_ID = $_POST['AUTHOR_ID'];

        $employee = new Employee($empIdEditHoli);

        $sqlHoli = "insert into RETURN_FROM_HOLY (ID, ID_HOLY, DATE_HOLY_START, DATE_HOLY_END, DAY_COUNT, ORDER_NUM, ORDER_DATE, PERSON_ID) 
                        values (NULL,
                                '$idholiReturn', 
                                '$DATE_BEGINholiReturn',
                                '$DATE_ENDholiReturn',
                                '$CNT_DAYSholiReturn',
                                '$ORDER_NUMholiReturn',
                                '$ORDER_DATEholiReturn',
                                '$empIdEditHoli'
                                )";
        $listHoli = $db -> Execute($sqlHoli);
    
        //запись в таблицу T2 card
        $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ACT_ID, ID_MISS, BRANCH_ID, DEPARTMENT, POSITION, ID_PERSON, EMP_ID, ORDER_NUM, ORDER_DATE) values 
                                  (NULL, '$today_date','8', '$sequance', '$BRANCH_IDholi', '$JOB_SPholi', '$JOB_POSITIONholi', '$empIdEditHoli', '$AUTHOR_ID', '$ORDER_NUMholiReturn', '$ORDER_DATEholiReturn')";
        $update_history = $db -> Execute($sql_update_history);

        //отпуск в табель
        $sqlHoliToTable = "update TABLE_OTHER set VALUE = '8' where DAY_DATE between '$DATE_BEGINholiReturn' and '$DATE_ENDholiReturn' and EMP_ID = '$empIdEditHoli'";
        $listHoliToTable = $db -> Execute($sqlHoliToTable);

        //возвращает массив с отпусками
        $listHolidays = $employee -> get_inf_from_DB_holidays();

        //выводит таблицу с отпусками
        $listUpdateHolidays = $employee -> show_data_table_Holidays($listHolidays);

        $listUpdateHolidays = set_all_holi($empIdEditHoli, $DATE_BEGINholiReturn, $DATE_ENDholiReturn);

        echo $listUpdateHolidays;

        exit;
    }

    //модальное окно
    if(isset($_POST['editHoliIdModReturn'])){
        $sqlHoliEduId = "select * from PERSON_HOLIDAYS where id = ".$_POST['editHoliIdModReturn'];
        $listHoliEduId = $db -> Select($sqlHoliEduId);
?>
            <div hidden="" class="form-group" id="data_1">
                <label class="font-noraml">ID</label>
                <input name="idholiReturn" type="text" placeholder="" class="form-control" id="idholiReturn" value="<?php echo $listHoliEduId[0]['ID']; ?>" required>
            </div>
            <div class="form-group" id="data_1">
                <label class="font-noraml">Дата начала отзыва</label>
                <input name="DATE_BEGINholiReturn" type="text" placeholder="" class="form-control" data-mask="99.99.9999" id="DATE_BEGINholiReturn" value="<?php echo $listHoliEduId[0]['DATE_BEGIN']; ?>" required>
            </div>
            <div class="form-group" id="data_1">
                <label class="font-noraml">Дата конца отзыва</label>
                <input name="DATE_ENDholiReturn" type="text" placeholder="" class="form-control" data-mask="99.99.9999" id="DATE_ENDholiReturn" value="<?php echo $listHoliEduId[0]['DATE_END']; ?>" required>
            </div>
            <div class="form-group" id="data_1">
                <label class="font-noraml">Количество дней</label>
                <input name="CNT_DAYSholiReturn" onclick="culc_day_return();" type="text" placeholder="" class="form-control" id="CNT_DAYSholiReturn" value="" required>
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
<?php
        exit;
    }
/*
    //отпуск начало
    //отпуск таблица начало
    //редактирование
    if(isset($_POST['ID_PERSONholiEdit'])){
        $ID_PERSONholiEdit = $_POST['ID_PERSONholiEdit'];
        $DATE_BEGINholiEdit = $_POST['DATE_BEGINholiEdit'];
        $DATE_ENDholiEdit = $_POST['DATE_ENDholiEdit'];
        $CNT_DAYSholiEdit = $_POST['CNT_DAYSholiEdit'];
        $PERIOD_BEGINholiEdit = $_POST['PERIOD_BEGINholiEdit'];
        $PERIOD_ENDholiEdit = $_POST['PERIOD_ENDholiEdit'];
        $ORDER_NUMholiEdit = $_POST['ORDER_NUMholiEdit'];
        $ORDER_DATEholiEdit = $_POST['ORDER_DATEholiEdit'];
        $EMP_IDholiEdit = $_POST['EMP_IDholiEdit'];
        $IDholiEdit = $_POST['IDholiEdit'];
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['ID_PERSONholiEdit']);

        //функция update_inf_DB_Holidays() обновляет данные об образовании в базы
        $listUpdateHoliId = $employee -> update_inf_DB_Holidays($ID_PERSONholiEdit, $DATE_BEGINholiEdit, $DATE_ENDholiEdit, $CNT_DAYSholiEdit, $PERIOD_BEGINholiEdit, $PERIOD_ENDholiEdit, $ORDER_NUMholiEdit, $EMP_IDholiEdit, $IDholiEdit, $BRANCH_IDholi, $DEPARTMENTholi, $POSITIONholi);

        //возвращает массив с отпусками
        $listHolidays = $employee -> get_inf_from_DB_holidays();

        //выводит таблицу с отпусками
        $listUpdateHolidays = $employee -> show_data_table_Holidays($listHolidays);

        echo $listUpdateHoliId;

        exit;
    }
    //редактирование

    //удаление
    if(isset($_POST['IDholiDelete'])){
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($_POST['empIDholiDelete']);
        
        //функция delete_inf_in_DB_holi() удаляет данные об отпуске из базы
        $employee -> delete_inf_in_DB_holi($_POST['IDholiDelete']);
        
        //возвращает массив с отпусками
        $listHolidays = $employee -> get_inf_from_DB_holidays();
        
        //выводит таблицу с отпусками
        $listUpdateHolidays = $employee -> show_data_table_Holidays($listHolidays);
        
        exit;
    }
    //отпуск таблица конец
    
    //отпуск модальное окно начало
    if(isset($_POST['editHoliIdMod'])){
        $sqlHoliEduId = "select * from PERSON_HOLIDAYS where id = ".$_POST['editHoliIdMod'];
        $listHoliEduId = $db -> Select($sqlHoliEduId);
?>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">ID отпуска</label>
                        <input name="IDholiEdit" type="text" placeholder="" class="form-control" id="IDholiEdit" value="<?php echo $listHoliEduId[0]['ID']; ?>" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата начала отпуска</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_BEGINholiEdit" data-mask="99.99.9999" id="DATE_BEGINholiEdit" value="<?php echo $listHoliEduId[0]['DATE_BEGIN']; ?>" required/>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата конца отпуска</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="DATE_ENDholiEdit" data-mask="99.99.9999" id="DATE_ENDholiEdit" value="<?php echo $listHoliEduId[0]['DATE_END']; ?>" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Количество дней</label>
                        <input name="CNT_DAYSholiEdit" type="text" placeholder="" class="form-control" id="CNT_DAYSholiEdit" value="<?php echo $listHoliEduId[0]['CNT_DAYS']; ?>" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">За период(начало)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="PERIOD_BEGINholiEdit" data-mask="99.99.9999" id="PERIOD_BEGINholiEdit" value="<?php echo $listHoliEduId[0]['PERIOD_BEGIN']; ?>" required/>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">За период (конец)</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="PERIOD_ENDholiEdit" data-mask="99.99.9999" id="PERIOD_ENDholiEdit" value="<?php echo $listHoliEduId[0]['PERIOD_END']; ?>" required/>
                    </div>
                    </div>
                    <div class="form-group" id="data_1">
                        <label class="font-noraml">Номер приказа</label>
                        <input name="ORDER_NUMholiEdit" type="text" placeholder="" class="form-control" id="ORDER_NUMholiEdit" value="<?php echo $listHoliEduId[0]['ORDER_NUM']; ?>" required>
                    </div>
                    <div class="form-group">
                    <label class="font-noraml">Дата приказа</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control dateOform" name="ORDER_DATEholiEdit" data-mask="99.99.9999" id="ORDER_DATEholiEdit" value="<?php echo $listHoliEduId[0]['ORDER_DATE']; ?>" required/>
                    </div>
                    </div>
                    <div hidden="" class="form-group" id="data_1">
                        <label class="font-noraml">Автор</label>
                        <input name="EMP_IDholiEdit" type="text" placeholder="" class="form-control" id="EMP_IDholiEdit" value="<?php echo $active_user_dan['emp']; ?>" required>
                    </div>
<?php
        exit;
    }
    //отпуск модальное окно конец
    //отпуск конец
*/

    //командировки
    if(isset($_POST['delete_det_id']))
    {
        $empId = $_POST['empId'];
        $delete_det_id = $_POST['delete_det_id'];

        $sql_trip_det_delete = "delete from TRIP_FROM_TO where ID = $delete_det_id";

        $list_trip_det_delete = $db -> Execute($sql_trip_det_delete);

        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($empId);

        //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
        $list_trip = $employee -> get_inf_from_DB_TRIP();

        //выводит таблицу со стажем
        $employee -> show_data_table_Trip($list_trip);

        exit;
    }

    if(isset($_POST['TRIP_DETAIL_ID']))
    {
        $empId = $_POST['empId'];
        $TRIP_DETAIL_ID = $_POST['TRIP_DETAIL_ID'];
        $FROM_PLACE = $_POST['FROM_PLACE'];
        $TO_PLACE = $_POST['TO_PLACE'];
        $TRANSPORT = $_POST['TRANSPORT'];
        
        $sql_trip = "insert into TRIP_FROM_TO (ID, TRIP_ID, FROM_PLACE, TO_PLACE, TRANSPORT) values 
                             ('', '$TRIP_DETAIL_ID', '$FROM_PLACE', '$TO_PLACE', '$TRANSPORT')";  
            
        $list_trip = $db -> Select($sql_trip);
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($empId);
        
        //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
        $list_trip = $employee -> get_inf_from_DB_TRIP();
        
        //выводит таблицу со стажем
        $employee -> show_data_table_Trip($list_trip);

        exit;
    }
    
    if(isset($_POST['DATE_BEGINtrip'])){
        $ID_PERSONtrip = $_POST['ID_PERSONtrip'];
        $DATE_BEGINtrip = $_POST['DATE_BEGINtrip'];
        $DATE_ENDtrip = $_POST['DATE_ENDtrip'];
        $CNT_DAYStrip = $_POST['CNT_DAYStrip'];
        $PERIOD_BEGINtrip = $_POST['PERIOD_BEGINtrip'];
        $PERIOD_ENDtrip = $_POST['PERIOD_ENDtrip'];
        $ORDER_NUMtrip = $_POST['ORDER_NUMtrip'];
        $BRANCH_IDtrip = $_POST['BRANCH_IDtrip'];
        $JOB_POSITIONtrip = $_POST['JOB_POSITIONtrip'];
        $ORDER_DATEtrip = $_POST['ORDER_DATEtrip'];
        $EMP_IDtrip = $_POST['EMP_IDtrip'];
        $AIM = $_POST['AIM'];
        $AIM_KAZ = $_POST['AIM_KAZ'];
        $FINAL_DESTINATION = $_POST['FINAL_DESTINATION'];
        $FINAL_DESTINATION_KAZ = $_POST['FINAL_DESTINATION_KAZ'];        
        
        //создаем обьект Employee, в параметры передаем ID
        $employee = new Employee($ID_PERSONtrip);
        
        //функция set_inf_to_DB_exp() добавляет данные о командировками в базу
        $employee -> set_inf_to_DB_trip($ID_PERSONtrip, $DATE_BEGINtrip, $DATE_ENDtrip, $CNT_DAYStrip, $PERIOD_BEGINtrip, $PERIOD_ENDtrip, $ORDER_NUMtrip, $BRANCH_IDtrip, $JOB_POSITIONtrip, $ORDER_DATEtrip, $EMP_IDtrip, $AIM_KAZ, $FINAL_DESTINATION, $FINAL_DESTINATION_KAZ);
        
        //функция get_inf_from_DB_TRIP() возвращает массив с данными с командировками из базы
        $list_trip = $employee -> get_inf_from_DB_TRIP();
        
        //echo '<pre>';
        //print_r($list_trip);
        //echo '<pre>';       
        //выводит таблицу со командировками
        $employee -> show_data_table_Trip($list_trip);
        
        exit;
    }

    if(isset($_POST['BANK_ID_change']))
    {
        $BRANCH_IDholi = $_POST['BRANCH_IDholi'];
        $DEPARTMENTholi = $_POST['JOB_SPholi'];
        $POSITIONholi = $_POST['JOB_POSITIONholi'];
        $BANK_ID_change = $_POST['BANK_ID_change'];
        $ACCOUNT_TYPE = $_POST['ACCOUNT_TYPE'];
        $ACCOUNT = $_POST['ACCOUNT'];
        
        $sql_update_dismiss = "update EMPLOYEES set BANK_ID = '$BANK_ID_change', ACCOUNT_TYPE = '$ACCOUNT_TYPE', ACCOUNT = '$ACCOUNT' where id = $empId";
        $list_update_dismiss = $db -> Execute($sql_update_dismiss);
        
        //$sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ID_PERSON, BRANCH_ID, DEPARTMENT, POSITION, ACT_ID) values (SEQ_T2_CARD.nextval, '$today_date', '$empId', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '4')";
        //$update_history = $db -> Execute($sql_update_history);
    }
/*
    //загрузка документа
    $ftp = new FTP(FTP_SERVER, FTP_USER, FTP_PASS);
    
    if(isset($_POST['test'])){
        if(!$ftp->create_path('Persons/test')){
            //$msg .= ALERTS::WarningMin("Ошибка создания папки!");
            //документы
            //$sqlUpdateEduId = "update PERSON_EDUCATION set INSTITUTION = '$INSTITUTIONEdit', YEAR_BEGIN = '$YEAR_BEGINEdit', YEAR_END = '$YEAR_ENDEdit', SPECIALITY = '$SPECIALITYEdit', QUALIFICATION = '$QUALIFICATIONEdit', DIPLOM_NUM = '$DIPLOM_NUMEdit' where id = ".$_POST['updateEduIdMod'];
            //$listUpdateEduId = $db -> Select($sqlUpdateEduId);
            
            echo "Ошибка создания папки!";
        }

        //if(!$ftp->uploadfile('Persons/'.$_POST['IINforFolder'].'/', 'job_contract', $_FILES['job_contract']['tmp_name'])){
        if(!$ftp->uploadfile('Persons/test/', 'job_contract', $_FILES['job_contract']['tmp_name'])){
            //$msg .= ALERTS::WarningMin("Ошибка создания файла!");
            echo "Ошибка создания файла!";
        }

        //if(!$ftp->uploadfile('Persons/'.$_POST['IINforFolder'].'/', 'material_liability', $_FILES['material_liability']['tmp_name'])){
        if(!$ftp->uploadfile('Persons/test/', 'app_for_job', $_FILES['app_for_job']['tmp_name'])){
            //$msg .= ALERTS::WarningMin("Ошибка создания файла!");
            echo "Ошибка создания файла!";
        }
    }

    if(isset($_POST['PERSON_HOLYDAYS_PERIOD_ID']))
    {
        $DAY_COUNT_USED_FOR_TODAY = $_POST['DAY_COUNT_USED_FOR_TODAY'];
        $PERSON_HOLYDAYS_PERIOD_ID = $_POST['PERSON_HOLYDAYS_PERIOD_ID'];
        $DIDNT_ADD = $_POST['DIDNT_ADD'];
        $sql_update_PERSON_HOLYDAYS_PERIOD = "update PERSON_HOLYDAYS_PERIOD set DAY_COUNT_USED_FOR_TODAY = '$DAY_COUNT_USED_FOR_TODAY', DIDNT_ADD = '$DIDNT_ADD' where ID = $PERSON_HOLYDAYS_PERIOD_ID";
        $update_job_posi_PERSON_HOLYDAYS_PERIOD = $db -> Execute($sql_update_PERSON_HOLYDAYS_PERIOD);
    }
    */

    array_push($js_loader,
        'styles/js/inspinia.js',  
        'styles/js/plugins/pace/pace.min.js', 
        'styles/js/plugins/slimscroll/jquery.slimscroll.min.js',     
        'styles/js/plugins/chosen/chosen.jquery.js',
        'styles/js/plugins/jsKnob/jquery.knob.js',
        'styles/js/plugins/jasny/jasny-bootstrap.min.js',
        'styles/js/plugins/dataTables/jquery.dataTables.js',
        'styles/js/plugins/dataTables/dataTables.bootstrap.js',
        'styles/js/plugins/dataTables/dataTables.responsive.js',
        'styles/js/plugins/dataTables/dataTables.tableTools.min.js',
        'styles/js/plugins/datapicker/bootstrap-datepicker.js',
        'styles/js/plugins/nouslider/jquery.nouislider.min.js',
        'styles/js/plugins/switchery/switchery.js',
        'styles/js/plugins/ionRangeSlider/ion.rangeSlider.min.js',
        'styles/js/plugins/iCheck/icheck.min.js',
        'styles/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
        'styles/js/plugins/clockpicker/clockpicker.js',
        'styles/js/plugins/cropper/cropper.min.js',
        'styles/js/plugins/fullcalendar/moment.min.js',
        'styles/js/plugins/daterangepicker/daterangepicker.js',
        'styles/js/plugins/Ilyas/edit_employees_js.js',
        'styles/js/plugins/Ilyas/addClients.js',
        'styles/js/demo/contracts_osns.js',
        'styles/js/plugins/sweetalert/sweetalert.min.js',
        'styles/js/plugins/footable/footable.all.min.js'
    );   

    array_push($css_loader, 
        'styles/css/plugins/dataTables/dataTables.bootstrap.css',
        'styles/css/plugins/dataTables/dataTables.responsive.css',
        'styles/css/plugins/dataTables/dataTables.tableTools.min.css',
        'styles/css/plugins/iCheck/custom.css',
        'styles/css/plugins/chosen/chosen.css',
        'styles/css/plugins/colorpicker/bootstrap-colorpicker.min.css',
        'styles/css/plugins/cropper/cropper.min.css',
        'styles/css/plugins/switchery/switchery.css',
        'styles/css/plugins/jasny/jasny-bootstrap.min.css',
        'styles/css/plugins/nouslider/jquery.nouislider.css',
        'styles/css/plugins/datapicker/datepicker3.css',
        'styles/css/plugins/ionRangeSlider/ion.rangeSlider.css',
        'styles/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css',
        'styles/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
        'styles/css/plugins/clockpicker/clockpicker.css',
        'styles/css/plugins/daterangepicker/daterangepicker-bs3.css',
        'styles/css/plugins/select2/select2.min.css',
        'styles/css/plugins/footable/footable.core.css'
    );

    $othersJs .= "<script>

                        $(document).ready(function () {
                    
                            $('.demo1').click(function(){
                                swal({
                                    title: 'Welcome in Alerts',
                                    text: 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
                                });
                            });
                    
                            $('.demo2').click(function(){
                                swal({
                                    title: 'Сохранено!',
                                    text: 'Информация ушла в базу данных!',
                                    type: 'success'
                                });
                            });
                    
                            $('.demo3').click(function () {
                                swal({
                                    title: 'Are you sure?',
                                    text: 'You will not be able to recover this imaginary file!',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#DD6B55',
                                    confirmButtonText: 'Yes, delete it!',
                                    closeOnConfirm: false
                                }, function () {
                                    swal('Deleted!', 'Your imaginary file has been deleted.', 'success');
                                });
                            });
                    
                            $('.demo4').click(function () {
                                swal({
                                            title: 'Are you sure?',
                                            text: 'Your will not be able to recover this imaginary file!',
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#DD6B55',
                                            confirmButtonText: 'Yes, delete it!',
                                            cancelButtonText: 'No, cancel plx!',
                                            closeOnConfirm: false,
                                            closeOnCancel: false },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                swal('Deleted!', 'Your imaginary file has been deleted.', 'success');
                                            } else {
                                                swal('Cancelled', 'Your imaginary file is safe :)', 'error');
                                            }
                                        });
                            });
                    
                    
                        });
                    
                    </script>
                    <script>
                        $(document).ready(function() {
                
                            $('.footable').footable();
                            $('.footable2').footable();
                        });
                    </script>";

/*
    //$sqlJOB_CONTR_NUM = 'select JOB_CONTR_NUM from JOB_CONTR_NUM where id = 1';
    //$listJOB_CONTR_NUM = $db -> Select($sqlJOB_CONTR_NUM);            
*/

    //echo '<pre>';
    //print_r($empInfo);
    //echo '<pre';

    //создаем обьект Employee, в параметры передаем ID
    $employee = new Employee($empId);

    //функция get_emp_from_DB() возвращает массив с данными о работнике из базы
    $empInfo = $employee -> get_emp_from_DB_trivial();
    $empInfo[0]['DOCDATE'] = date('d.m.Y', strtotime($empInfo[0]['DOCDATE']));
    $empInfo[0]['CONTRACT_JOB_DATE'] = date('d.m.Y', strtotime($empInfo[0]['CONTRACT_JOB_DATE']));
    $empInfo[0]['DATE_POST'] = date('d.m.Y', strtotime($empInfo[0]['DATE_POST']));
    $empInfo[0]['DATE_LAYOFF'] = date('d.m.Y', strtotime($empInfo[0]['DATE_LAYOFF']));
    $empInfo[0]['DATE_BEGIN'] = date('d.m.Y', strtotime($empInfo[0]['DATE_BEGIN']));
    $empInfo[0]['DATE_END'] = date('d.m.Y', strtotime($empInfo[0]['DATE_END']));

    //дата сегодня
    $today_date = date('Y-m-d');

    //функция get_emp_from_DB() возвращает массив с данными об образовании из базы
    $listEdu = $employee -> get_inf_from_DB_edu();

    //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
    $listExp = $employee -> get_inf_from_DB_experience();

    //типа родства
    $sqlFamPers = "select * from DIC_TYP_RODSTV order by id";
    $listFamPers = $db -> Select($sqlFamPers);

    //функция get_inf_from_DB_fam_memb() возвращает массив с данными о членах семьи из базы
    $listFam = $employee -> get_inf_from_DB_fam_memb();

    //национальность
    $sqlNationality = "select * from DIC_NATIONALITY";
    $listNationality = $db -> Select($sqlNationality);

    //статусы сотрудников
    $sqlState = "select * from DIC_PERSON_STATE order by id";
    $listState = $db -> Select($sqlState);

    //семейное положение
    $sqlFamStat = "select * from DIC_FAMILY order by id";
    $listFamStat = $db -> Select($sqlFamStat);

    //компании
    $sql_company = "SELECT * FROM `DIC_COMPANY` where ID = 10";
    $list_company = $db->Select($sql_company);

    //должности
    $sql_dolzh = "select D_NAME from DIC_DOLZH where ID = ".$empInfo[0]['JOB_POSITION'];
    $list_dolzh = $db->Select($sql_dolzh);

    //табель типы отпусков
    $sqlVID_HOLIDAYS = "select * from DIC_VID_HOLIDAYS order by id";
    $listVID_HOLIDAYS = $db -> Select($sqlVID_HOLIDAYS);

    //функция get_inf_from_DB_holidays() возвращает массив с данными об отпусками
    $listHolidays = $employee -> get_inf_from_DB_holidays();
    
    //функция get_inf_from_DB_HOSPITAL() возвращает массив с данными об больничными
    $listHOSPITAL = $employee -> get_inf_from_DB_HOSPITAL();

    //возвращает массив с командировками
    $list_trip = $employee -> get_inf_from_DB_TRIP();

    //постоянные запросы
    $sqlBanks = "select * from DIC_BANKS";
    $listBanks = $db -> Select($sqlBanks);

    //тип документа
    $sqlDocs = "select * from DIC_DOCUMENT_TYPE order by id";
    $listDocs = $db -> Select($sqlDocs);

    //страны
    $sqlCountry = "select * from DIC_COUNTRY order by ID";
    $listCountry = $db -> Select($sqlCountry);

    //виды транспорта
    $sql_transport = "select * from DIC_TRANSPORT_FOR_TRIP order by ID";
    $list_transport = $db -> Select($sql_transport);

    //филиалы
    $sqlBranch = "select * from DIC_BRANCH where COMPANY_ID = '$company_id' order by NAME";
    $listBranch = $db -> Select($sqlBranch);

    //департаменты
    $sqlDepartments = "select * from DIC_DEPARTMENT order by NAME";
    $listDepartments = $db -> Select($sqlDepartments);

    //должности
    $sqlPosition = "select * from DIC_DOLZH order by ID";
    $listPosition = $db -> Select($sqlPosition);

    //роли
    $sqlRole = "select * from DIC_ROLE order by id";
    $listRole = $db -> Select($sqlRole);

    //вся техника
    $sql_techs = "select * from TECHNICS where EMP_ID IS NULL order by id";
    $list_techs = $db -> Select($sql_techs);

    //типы техники
    $sql_techs_type = "select * from DIC_TECH_TYPE order by id";
    $list_techs_type = $db -> Select($sql_techs_type);

    //вся техника сотрудника
    $sql_usr_techs = "select tech.*, tech_type.NAME type_name from TECHNICS tech, DIC_TECH_TYPE tech_type where tech.EMP_ID = '$empId' and tech_type.ID = tech.ID_TYPE order by tech.id";
    $list_usr_techs = $db -> Select($sql_usr_techs);

    $sql_branch_name = "select NAME from DIC_BRANCH where RFBN_ID = ".$empInfo[0]['BRANCHID'];
    $list_branch_name = $db->Select($sql_branch_name);

    $sql_dep_name = "select NAME from DIC_DEPARTMENT where ID = ".$empInfo[0]['JOB_SP'];
    $list_dep_name = $db->Select($sql_dep_name);
    $dep_name = $list_dep_name[0]['NAME'];

    $sqlReport_html_other = "select * from REPORTS_HTML order by id";
    $sqlReport_html_other_dan = $db -> Select($sqlReport_html_other);

    $sql_holy_period = "select * from PERSON_HOLYDAYS_PERIOD where PERSON_ID = $empId and PERIOD_START < '$today_date'";
    $list_holy_period = $db -> Select($sql_holy_period);
/*
    $timesheet_date_start = $_POST['timesheet_date_start'];
    $timesheet_date_end = $_POST['timesheet_date_end'];
    $sql_guys = "select dolzh.D_NAME, trivial.JOB_POSITION, trivial.FIRSTNAME, trivial.MIDDLENAME, trivial.LASTNAME, trivial.ID from sup_person trivial, DIC_DOLZH dolzh where trivial.ID = $empId and dolzh.ID = TRIVIAL.JOB_SP order by JOB_POSITION";
    $list_guys = $db -> Select($sql_guys);
    $sql_guy = "select WEEK_DAY from TABLE_OTHER where DAY_DATE between '$timesheet_date_start' and '$timesheet_date_end' and emp_id = 373 order by DAY_DATE";
    $list_guy = $db -> Select($sql_guy);
    
    //выводит список дней за след. месяц с выходными
    function weekend3($date_my) {//дата типа: date(".m.Y") или ".02.2010"
            for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++) 
            {
                    $weekend = date("w",strtotime($i.$date_my));
                    if($weekend==0 || $weekend==6)
                        {   
                            echo '<th>'.$i.'</th>';
                        }   
                        else
                        {   
                            echo '<th>'.$i.'</th>';
                        }
            }
        }
?>

<?php
    //добавляет выходные
    function set_all_holi($emp_id, $date_event_start, $date_event_end)
    {
        $db = new DB();
        $sql_all_holi_between_two_date = "select DATE_HOL from HOLIDAYS where DATE_HOL between '$date_event_start' and '$date_event_end'";
        $list_all_holi_between_two_date = $db -> Select($sql_all_holi_between_two_date);
        
        foreach($list_all_holi_between_two_date as $k => $v)
        {
            $DATE_HOL = $v['DATE_HOL'];
            $sql_change_day_state = "update TABLE_OTHER set VALUE = 'В' where EMP_ID = '$emp_id' and DAY_DATE = '$DATE_HOL'";
            $list_change_day_state = $db -> Execute($sql_change_day_state);
        }
    }

    //выводит список дней за след. месяц с выходными
    function weekend2 ($date_my, $listsql_sheet_mod_par) {//дата типа: date(".m.Y") или ".02.2010"
            for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++) {
                    $weekend = date("w",strtotime($i.$date_my));
                    $state = $listsql_sheet_mod_par[0]["DAY$i"];
                    if($weekend==0 || $weekend==6) { ?>
                    <li class="list-group-item">
                        <span class="pull-right">
                            <select onchange="calc_day();" name="DAY<?php echo $i; ?>" id="<?php echo $i; ?>" class="select2_demo_1 state_sel">
                                <option <?php if($state == 16){echo 'selected';} ?>>16</option>
                                <option <?php if($state == 8){echo 'selected';} ?>>8</option>
                                <option <?php if($state == 4){echo 'selected';} ?>>4</option>
                                <option <?php if($state == 'А'){echo 'selected';} ?>>А</option>
                                <option <?php if($state == 'В'){echo 'selected';} ?>>В</option>
                                <option <?php if($state == 'О'){echo 'selected';} ?>>О</option>
                            </select>
                        </span>
                    </li>
                        <i class="fa fa-soccer-ball-o"> </i> <?php echo $i.$date_my.' - выходной';} else {?>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    <select onchange="calc_day();" name="DAY<?php echo $i; ?>" id="<?php echo $i; ?>" class="select2_demo_1 state_sel">
                                        <option <?php if($state == 16){echo 'selected';} ?>>16</option>
                                        <option <?php if($state == 8){echo 'selected';} ?>>8</option>
                                        <option <?php if($state == 4){echo 'selected';} ?>>4</option>
                                        <option <?php if($state == 'А'){echo 'selected';} ?>>А</option>
                                        <option <?php if($state == 'В'){echo 'selected';} ?>>В</option>
                                        <option <?php if($state == 'О'){echo 'selected';} ?>>О</option>
                                    </select>
                                </span>
                            </li>
                        <?php echo $i.$date_my.' - будни';}
                        echo '<br>';
            }
    }
*/
    
/*
    for($i = $post_day_list[1]+1; $i <= 12; $i++)
    {
        if($i<10)
        {
            $post_withuot_day = '.0'.$i.'.'.$post_day_list[2];
            create_other_table_for_this_year("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, '01');
        }
            else
        {
            $post_withuot_day = '.'.$i.'.'.$post_day_list[2];
            create_other_table_for_this_year("$post_withuot_day", $CREATE_TABLE_FOR_ONE_PERS_ID, '01');
        }
    }
*/
    //functions
    function create_other_table($date_my, $emp_id)
    {
        echo $date_my.$emp_id;
        $db = new My_sql_db();
        //$sql_pers = "select id, state from EMPLOYEES where state = 2 or state = 3 or state = 4 or state = 5 or state = 6 or state = 9 order by state";
        //$list_pers = Select($sql_pers);
        for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++) 
        {
            //$db = new DB();
            $weekend = date("w",strtotime($date_my.$i));
            echo '$weekend '.$weekend;
            if($weekend==0 || $weekend==6)
            {
                echo 'weekend';
                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ('', '$i', 'В', '$emp_id', '$date_my$i', 1)";
                $db -> Execute($sql);
                echo "$date_my$i".'B<br>';
            } 
                else
            {
                echo 'budni';
                $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES ('', '$i', '8', '$emp_id', '$date_my$i', 1)";
                $db->Execute($sql);
                echo "$date_my$i".'8<br>';
            }
        }
    }
/*
    function create_other_table_for_this_year($date_my, $emp_id, $start_date)
    {
        echo 'create_other_table_for_this_year';
        for($i = 1; $i <= date("t",strtotime('01'.$date_my)); $i++)
            {
                if($start_date < 10){
                    $start_date = str_replace('0', '', $start_date);
                }
                $db = new DB();
                $weekend = date("w",strtotime($i.$date_my));
                
                if($weekend==0 || $weekend==6)
                    {
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES (SEQ_TABLE_OTHER.NEXTVAL, '$i', 'В', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
                else 
                    {
                        $sql = "INSERT INTO TABLE_OTHER (ID, WEEK_DAY, VALUE, EMP_ID, DAY_DATE, STATE) VALUES (SEQ_TABLE_OTHER.NEXTVAL, '$i', '8', '$emp_id', '$i$date_my', 1)";
                        $list_sql = $db->Execute($sql);
                    }
            }
    }
*/
?>

