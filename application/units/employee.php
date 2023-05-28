<?php
	class Employee
    {
        private $id;
        private $LASTNAME;
        private $FIRSTNAME;
        private $MIDDLENAME;
        private $BIRTHDATE;
        private $BIRTH_PLACE;
        private $SEX;
        private $IIN;
        private $NACIONAL;
        private $FAMILY;
        private $CONTRACT_JOB_NUM;
        private $CONTRACT_JOB_DATE;
        private $STAZH_ALL;
        private $STAZH_CONTIN;
        private $DOCTYPE;
        private $DOCSER;
        private $DOCNUM;
        private $DOCDATE;
        private $DOCPLACE;
        private $REG_ADDRESS;

        function __construct($id, $LASTNAME, $FIRSTNAME, $MIDDLENAME, $BIRTHDATE, $BIRTH_PLACE, $SEX, $IIN, $NACIONAL, $FAMILY, $CONTRACT_JOB_NUM, $CONTRACT_JOB_DATE, $STAZH_ALL, $STAZH_CONTIN, $DOCTYPE, $DOCSER, $DOCNUM, $DOCDATE, $DOCPLACE, $REG_ADDRESS)
        {
            $this->id = $id;
        }

        //функция get_emp_from_DB() возвращает массив с данными о работнике из базы
        function get_emp_from_DB_trivial()
        {
            $db = new My_sql_db();
            
            $id = $this->id;
            $LASTNAME = $this->LASTNAME;
            $FIRSTNAME = $this->FIRSTNAME;
            $MIDDLENAME = $this->MIDDLENAME;
            $BIRTHDATE = $this->BIRTHDATE;
            $BIRTH_PLACE = $this->BIRTH_PLACE;
            $SEX = $this->SEX;
            $IIN = $this->IIN;
            $NACIONAL = $this->NACIONAL;
            $FAMILY = $this->FAMILY;
            $CONTRACT_JOB_NUM = $this->CONTRACT_JOB_NUM;
            $CONTRACT_JOB_DATE = $this->CONTRACT_JOB_DATE;
            $STAZH_ALL = $this->STAZH_ALL;
            $STAZH_CONTIN = $this->STAZH_CONTIN;
            $DOCTYPE = $this->DOCTYPE;
            $DOCSER = $this->DOCSER;
            $DOCNUM = $this->DOCNUM;
            $DOCDATE = $this->DOCDATE;
            $DOCPLACE = $this->DOCPLACE;
            $REG_ADDRESS = $this->REG_ADDRESS;

            $sqlEmpInfo = "select triv.DATE_POST, 
                             triv.DATE_LAYOFF, 
                             triv.REASON_LAYOFF, 
                             triv.TAB_NUM, 
                             triv.LASTNAME, 
                             triv.FIRSTNAME,
                             triv.MIDDLENAME, 
                             triv.BIRTHDATE, 
                             triv.BIRTH_PLACE,
                             triv.SEX, 
                             triv.IIN, 
                             triv.NACIONAL, 
                             triv.FAMILY, 
                             triv.CONTRACT_JOB_NUM, 
                             triv.CONTRACT_JOB_DATE, 
                             triv.STAZH_ALL, 
                             triv.STAZH_CONTIN, 
                             triv.DOCTYPE, 
                             triv.DOCSER, 
                             triv.DOCNUM, 
                             triv.DOCDATE, 
                             triv.DOCPLACE, 
                             triv.REG_ADDRESS_COUNTRY_ID,
                             triv.REG_ADDRESS_DISTRICTS_ID,
                             triv.REG_ADDRESS_REGION_ID,
                             triv.REG_ADDRESS_CITY,
                             triv.REG_ADDRESS_STREET,
                             triv.REG_ADDRESS_BUILDING,
                             triv.REG_ADDRESS_CORPUS,
                             triv.REG_ADDRESS_FLAT,
                             triv.FACT_ADDRESS_COUNTRY_ID,
                             triv.FACT_ADDRESS_DISTRICTS_ID,
                             triv.FACT_ADDRESS_REGION_ID,
                             triv.FACT_ADDRESS_CITY,
                             triv.FACT_ADDRESS_STREET,
                             triv.FACT_ADDRESS_BUILDING,
                             triv.FACT_ADDRESS_CORPUS,
                             triv.FACT_ADDRESS_FLAT,
                             triv.JOB_SP,
                             triv.JOB_POSITION,
                             triv.BRANCHID,
                             triv.WORK_PHONE,
                             triv.HOME_PHONE,
                             triv.MOB_PHONE,
                             triv.FAX,
                             triv.EMAIL,
                             triv.MILITARY_GROUP,
                             triv.MILITARY_CATEG,
                             triv.MILITARY_SOST,
                             triv.MILITARY_RANK,
                             triv.MILITARY_SPECIALITY,
                             triv.MILITARY_VOENKOM,
                             triv.MILITARY_SPEC_UCH,
                             triv.MILITARY_SPEC_UCH_NUM,
                             triv.MILITARY_FIT,
                             triv.ID_RUKOV,
                             triv.BANK_ID,
                             triv.ACCOUNT_TYPE,
                             triv.ACCOUNT,
                             triv.OKLAD,
                             triv.ZV_DATE,
                             triv.GOS_NAGR,
                             triv.INVENTION,
                             triv.STATE,
                             triv.SEX,
                             triv.EMP_ID,
                             triv.PERSONAL_EMAIL,
                             triv.NADBAVKA,
                             triv.NADBAVKA_ECO,
                             triv.COMPANY_ID,
                             company.NAME comp_name
                             from
                             EMPLOYEES triv,
                             DIC_COMPANY company
                             where 
                             company.ID = triv.COMPANY_ID and
                             triv.id = $id";
            $empInfo = $db -> Select($sqlEmpInfo);
            return $empInfo;
        }

        //функция get_inf_from_DB_edu() возвращает массив с данными об образовании из базы
        function get_inf_from_DB_edu()
        {
            $db = new My_sql_db();
            $id = $this->id;
            //образование
            $sqlEdu = "select * from PERSON_EDUCATION where ID_PERSON = $id order by id";
            $listEdu = $db -> Select($sqlEdu);
            
            return $listEdu;
        }

        //функция update_edu_emp_to_DB() обновляет данные об образовании в базы
        function update_edu_emp_to_DB($INSTITUTIONEdit, $YEAR_BEGINEdit, $YEAR_ENDEdit, $SPECIALITYEdit, $QUALIFICATIONEdit, $DIPLOM_NUMEdit, $idEduUpdate){
            $db = new My_sql_db();
            $id = $this->id;
            //образование
            $sqlUpdateEduId = "update PERSON_EDUCATION set INSTITUTION = '$INSTITUTIONEdit', YEAR_BEGIN = '$YEAR_BEGINEdit', YEAR_END = '$YEAR_ENDEdit', SPECIALITY = '$SPECIALITYEdit', QUALIFICATION = '$QUALIFICATIONEdit', DIPLOM_NUM = '$DIPLOM_NUMEdit' where id = ".$_POST['updateEduIdMod'];
            $listUpdateEduId = $db -> Select($sqlUpdateEduId);

            return $listEdu;
        }

        //функция set_inf_to_DB_edu() добавляет данные об образовании в базу
        function set_inf_to_DB_edu($idPersEdu, $INSTITUTION, $YEAR_BEGIN, $YEAR_END, $SPECIALITY, $QUALIFICATION, $DIPLOM_NUM){
            
            $db = new My_sql_db();
            $id = $this->id;
            $sqlEdu = "insert into PERSON_EDUCATION (ID, ID_PERSON, INSTITUTION, YEAR_BEGIN, YEAR_END, SPECIALITY, QUALIFICATION, DIPLOM_NUM) 
                                             values ('', 
                                                     '$idPersEdu', 
                                                     '$INSTITUTION',
                                                     '$YEAR_BEGIN',
                                                     '$YEAR_END',
                                                     '$SPECIALITY',
                                                     '$QUALIFICATION',
                                                     '$DIPLOM_NUM'
                                                     )";
            $listEdu = $db -> Execute($sqlEdu);
        }
        
        //функция delete_inf_in_DB_edu() удаляет данные об образовании из базы
        function delete_inf_in_DB_edu($id){
            $db = new My_sql_db();
                    
            $sqldeleteEduId = "delete from PERSON_EDUCATION where id = $id";
            $listdeleteEduId = $db -> Execute($sqldeleteEduId);
        }
        
        //выводит таблицу с образованием
        function show_data_table_Edu($listEdu){
            foreach($listEdu as $x => $z){
                echo '<tr data="'.$z['ID'].'">
                        <td class="text-center">'.$z['ID'].'</td>
                        <td>'.$z['INSTITUTION'].'</td>
                        <td class="text-center">'.$z['YEAR_BEGIN'].'</td>
                        <td class="text-center">'.$z['YEAR_END'].'</td>
                        <td class="text-center">'.$z['SPECIALITY'].'</td>
                        <td class="text-center small">'.$z['QUALIFICATION'].'</td>
                        <td class="text-center small">'.$z['DIPLOM_NUM'].'</td>
                        <td class="text-center small"><div class="btn-group">
                            <a data-toggle="modal" data-target="#editEdu" onclick="getEduInfForModal('.$z['ID'].');" class="btn-white btn btn-xs">Редактировать</a>
                            <a id="deleteEduId" onclick="deleteEdu('.$z['ID'].');" class="btn-white btn btn-xs">Удалить</a>
                        </div></td>
                        </tr>';
                }
        }
        
        //добавляет командировки        
        function set_inf_to_DB_trip(){
            $db = new My_sql_db();
            $id = $this->id;
            $ID_PERSONtrip = $_POST['ID_PERSONtrip'];
            $DATE_BEGINtrip = $_POST['DATE_BEGINtrip'];
            $DATE_ENDtrip = $_POST['DATE_ENDtrip'];
            $CNT_DAYStrip = $_POST['CNT_DAYStrip'];
            $ORDER_NUMtrip = $_POST['ORDER_NUMtrip'];
            $BRANCH_IDtrip = $_POST['BRANCH_IDtrip'];
            $JOB_POSITIONtrip = $_POST['JOB_POSITIONtrip'];
            $ORDER_DATEtrip = $_POST['ORDER_DATEtrip'];
            $EMP_IDtrip = $_POST['EMP_IDtrip'];
            $AIM = $_POST['AIM'];
            $AIM_KAZ = $_POST['AIM_KAZ'];
            $FINAL_DESTINATION = $_POST['FINAL_DESTINATION'];
            $FINAL_DESTINATION_KAZ = $_POST['FINAL_DESTINATION_KAZ'];
            //командировки
            $sql_trip = "insert into PERSON_TRIP (ID, PERSON_ID, DATE_BEGIN, DATE_END, CNT_DAYS, ORDER_NUM, ORDER_DATE, EMP_ID, AIM, AIM_KAZ, FINAL_DESTINATION, FINAL_DESTINATION_KAZ) values 
                             ('', '$ID_PERSONtrip', '$DATE_BEGINtrip', '$DATE_ENDtrip', '$CNT_DAYStrip', '$ORDER_NUMtrip', '$ORDER_DATEtrip', '$EMP_IDtrip', '$AIM', '$AIM_KAZ', '$FINAL_DESTINATION', '$FINAL_DESTINATION_KAZ')";  

            $list_trip = $db -> Select($sql_trip);
            //echo $AIM;
        }
                        
        //возвращает массив с командировками
        function get_inf_from_DB_TRIP(){
            $db = new My_sql_db();
            $id = $this->id;
            //командировки
            $sqlExp = "select * from PERSON_TRIP where PERSON_ID = $id order by id";
            $listExp = $db -> Select($sqlExp);
            return $listExp;
        }             
        
        function show_data_table_Trip($list_trip){
            $db = new My_sql_db();
            foreach($list_trip as $k => $v){
                //echo '<pre>';
                //print_r($list_trip);
                //echo '<pre>';
                
                $trip_id = $v['ID'];
                ?>
                <tr data="<?php echo $v['ID']; ?>">
                    <td class="text-center"><?php echo $v['DATE_BEGIN']; ?></td>
                    <td class="text-center"><?php echo $v['DATE_END']; ?></td>
                    <td class="text-center"><?php echo $v['CNT_DAYS']; ?></td>
                    <td class="text-center small"><?php echo $v['ORDER_NUM']; ?></td>
                    <td class="text-center small"><?php echo $v['ORDER_DATE']; ?></td>
                    <td class="text-center small"><?php echo $v['AIM']; ?></td>
                    <td class="text-center small">
                        <?php
                            $sql_trip_det = "select FROM_TO.*, TRANS.NAME TR_NAME from TRIP_FROM_TO FROM_TO, DIC_TRANSPORT_FOR_TRIP TRANS where TRANS.ID = FROM_TO.TRANSPORT AND FROM_TO.TRIP_ID = $trip_id order by FROM_TO.id";
                            $list_trip_det = $db -> Select($sql_trip_det);
                            foreach($list_trip_det as $y => $t){
                        ?>
                            <p><?php echo $t['FROM_PLACE'].'-'.$t['TO_PLACE'].'('.$t['TR_NAME'].')' ?> <i onclick="delete_detail(<?php echo $t['ID']; ?>);" title="Удалить маршрут" style="cursor: pointer;" class="fa fa-times btn-danger"></i></p>
                        <?php
                            }
                        ?>
                        
                    </td>
                    <td class="text-center small">
                        <div class="btn-group"><a data-toggle="modal" data-target="#trip_details" onclick="$('#TRIP_DETAIL_ID').val('<?php echo $v['ID']; ?>');" class="btn-white btn btn-xs">Добавить транспорт</a>
                            <div class="input-group-btn btn-xs">
                                <a href="emp_trip?trip_id=<?php echo $v['ID']; ?>" class="btn btn-white btn-xs" type="button">Печать приказа</a>
                                <a href="emp_trip?trip_id=<?php echo $v['ID']; ?>" class="btn btn-white btn-xs" type="button">Печать удостоверения</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                    
                }
                    
        }
        
        //функция get_inf_from_DB_experience() возвращает массив с данными о стаже из базы
        function get_inf_from_DB_experience(){
            $db = new My_sql_db();
            $id = $this->id;
            //стаж
            $sqlExp = "select * from PERSON_STAZH where ID_PERSON = $id order by id";
            $listExp = $db -> Select($sqlExp);
            return $listExp;    
        }
        
        //функция update_emp_exp_to_DB() обновляет данные о стаже в базе
        function update_emp_exp_to_DB($expStartDateEdit, $expEndDateEdit, $P_DOLZHEdit, $P_NAMEEdit, $P_ADDRESSEdit, $idExp){
            $db = new My_sql_db();
            $id = $this->id;
            //образование
            $sqlUpdateExpId = "update PERSON_STAZH set DATE_BEGIN = '$expStartDateEdit', DATE_END = '$expEndDateEdit', P_DOLZH = '$P_DOLZHEdit', P_NAME = '$P_NAMEEdit', P_ADDRESS = '$P_ADDRESSEdit' where id = $idExp";
            $listUpdateExpId = $db -> Select($sqlUpdateExpId);
            
            return $sqlUpdateExpId;
        }
        
        //функция set_inf_to_DB_exp() добавляет данные о стаже в базу
        function set_inf_to_DB_exp($idPersExp, $expStartDate, $expEndDate, $P_NAME, $P_DOLZH, $P_ADDRESS){
            $db = new My_sql_db();
            $id = $this->id;
            //стаж
            $expStartDate = date('Y-m-d', strtotime($expStartDate));
            $expEndDate = date('Y-m-d', strtotime($expEndDate));
            $sqlExp = "insert into PERSON_STAZH (ID, ID_PERSON, DATE_BEGIN, DATE_END, P_NAME, P_DOLZH, P_ADDRESS) 
                                         values ('', 
                                                 '$idPersExp',
                                                 '$expStartDate',
                                                 '$expEndDate',
                                                 '$P_NAME',
                                                 '$P_DOLZH',
                                                 '$P_ADDRESS'
                                                 )";
            $listExp = $db -> Execute($sqlExp);
        }

        //функция delete_inf_in_DB_exp() удаляет данные об образовании из базы
        function delete_inf_in_DB_exp($id){
            $db = new My_sql_db();
            
            $sqldeleteExpId = "delete from PERSON_STAZH where ID = $id";
            $listdeleteExpId = $db -> Execute($sqldeleteExpId);
        }

        //функция get_inf_from_DB_fam_memb() возвращает массив с данными о членах семьи из базы
        function get_inf_from_DB_fam_memb(){
            $db = new My_sql_db();
            $id = $this->id;
            //члены семьи
            $sqlFam = "select s.ID ID, s.ID_PERSON, CONCAT(s.LASTNAME, ' ', s.FIRSTNAME, ' ', s.MIDDLENAME) as FIO, BIRTHDATE, d.NAME from FAMILY_STRUCT s, DIC_TYP_RODSTV d where s.ID_PERSON = $id and d.ID = s.TYP_RODSTV order by s.ID";
            $listFam = $db -> Select($sqlFam);
            return $listFam;
        }

        //выводит таблицу со стажем
        function show_data_table_Exp($listExp){
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
        }
        
        //функция delete_inf_in_DB_fam() удаляет члена семьи из базы
        function delete_inf_in_DB_fam($id){
            $db = new My_sql_db();
            $sqldeleteFamMembId = "delete from FAMILY_STRUCT where id = $id";
            $listdeleteFamMembId = $db -> Execute($sqldeleteFamMembId);
        }
        
        //функция update_emp_exp_to_DB() обновляет данные об образовании в базы
        function update_emp_fam_to_DB($LASTNAMEfamedit, $FIRSTNAMEfamedit, $MIDDLENAMEfamedit, $BIRTHDATEfamMembedit, $TYP_RODSTVedit, $idFamUpdate){
            $db = new My_sql_db();
            $id = $this->id;
            $sqlUpdateFamId = "update FAMILY_STRUCT set LASTNAME = '$LASTNAMEfamedit', FIRSTNAME = '$FIRSTNAMEfamedit', MIDDLENAME = '$MIDDLENAMEfamedit', BIRTHDATE = '$BIRTHDATEfamMembedit', TYP_RODSTV = $TYP_RODSTVedit where id = $idFamUpdate";
            $listUpdateFamId = $db -> Select($sqlUpdateFamId);
        }

        //функция обновления информации в БД о воинском статусе сотрудника
        function update_inf_MILITARY_SPECIALITY($empId, $MILITARY_GROUP, $MILITARY_SPECIALITY, $MILITARY_CATEG, $MILITARY_SOST, $MILITARY_RANK, $MILITARY_VOENKOM, $MILITARY_SPEC_UCH, $MILITARY_SPEC_UCH_NUM, $MILITARY_FIT)
        {
            $db = new My_sql_db();
            $sql = "update EMPLOYEES set MILITARY_GROUP = '$MILITARY_GROUP',
                                      MILITARY_SPECIALITY = '$MILITARY_SPECIALITY',
                                      MILITARY_CATEG = '$MILITARY_CATEG', 
                                      MILITARY_SOST = '$MILITARY_SOST',
                                      MILITARY_RANK = '$MILITARY_RANK',
                                      MILITARY_VOENKOM = '$MILITARY_VOENKOM',
                                      MILITARY_SPEC_UCH = '$MILITARY_SPEC_UCH',
                                      MILITARY_SPEC_UCH_NUM = '$MILITARY_SPEC_UCH_NUM',
                                      MILITARY_FIT = '$MILITARY_FIT'
                                      where id = $empId";
        
            $listEmployee = $db -> Execute($sql);
            
            return $sql;
        }

        //функция set_inf_to_DB_fam() добавляет данные о члене семьи в базу
        function set_inf_to_DB_fam($idPersFam, $LASTNAMEfam, $FIRSTNAMEfam, $MIDDLENAMEfam, $BIRTHDATEfamMemb, $TYP_RODSTV)
        {
            $db = new My_sql_db();
            $id = $this->id;
            //стаж
            $sqlFam = "insert into FAMILY_STRUCT (ID, ID_PERSON, LASTNAME, FIRSTNAME, MIDDLENAME, BIRTHDATE, TYP_RODSTV)
                        values ('', 
                                $idPersFam, 
                                '$LASTNAMEfam', 
                                '$FIRSTNAMEfam', 
                                '$MIDDLENAMEfam', 
                                '$BIRTHDATEfamMemb', 
                                '$TYP_RODSTV')";
            $listFam = $db -> Execute($sqlFam);
        }

        //выводит таблицу со стажем
        function show_data_table_Fam($listFam)
        {
           foreach($listFam as $q => $w)
           {
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
        }

        //функция get_inf_from_DB_holidays() возвращает массив с данными об отпусками
        function get_inf_from_DB_holidays()
        {
            $db = new My_sql_db();
            $id = $this->id;
            //отпуска сотрудника
            $sqlHolidays = "select holid.DOC_CONTENT, holid.ID, holid.ID_PERSON, holid.DATE_BEGIN, holid.DATE_END, holid.CNT_DAYS, holid.PERIOD_BEGIN, holid.PERIOD_END, holid.ORDER_NUM, holid.ORDER_DATE, holid.EMP_ID, holid.VID, kind.NAME K_NAME from PERSON_HOLIDAYS holid, DIC_KIND_HOLIDAY kind where holid.VID = kind.ID and id_person = $id order by DATE_END";
            $listHolidays = $db -> Select($sqlHolidays);
            return $listHolidays;
        }

        //выводит таблицу с отпусками
        function show_data_table_Holidays($listHolidays)
        {
            foreach($listHolidays as $x => $z)
            {
            $db = new My_sql_db();
            //$sqlReturn = "select * from RETURN_FROM_HOLY where ID_HOLY = ".$z['ID'];
            //$listReturn = $db -> Select($sqlReturn);
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
                                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle btn-xs" type="button">Сгенерировать<span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="edit_doc?temp_id=25&employee_id=<?php echo $empId; ?>&HOLIDAYS_ID=<?php echo $z['ID']; ?>">Печать(с леч.пособием)</a></li>
                                            <li><a href="edit_doc?temp_id=26&employee_id=<?php echo $empId; ?>&HOLIDAYS_ID=<?php echo $z['ID']; ?>">Печать(без леч.пособия)</a></li>
                                        </ul>
                                    </div>
                                    <form method="POST" action="edit_doc">
                                        <textarea hidden="" name="text_for_edit"><?php echo $z['DOC_CONTENT'];?></textarea>
                                        <input hidden="" name="holi_id" value="<?php echo $z['ID'];?>"/>
                                        <button class="btn-white btn btn-xs <?php if($z['DOC_CONTENT'] == ''){echo 'disabled';} ?>">Печать с базы</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                                /*
                                foreach($listReturn as $n => $m){
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
                */
            }
        }

        //функция set_inf_to_DB_Holidays() добавляет данные об отпуске
        function set_inf_to_DB_Holidays($ID_PERSONholi, $DATE_BEGINholi, $DATE_ENDholi, $CNT_DAYSholi, $PERIOD_BEGINholi, $PERIOD_ENDholi, $ORDER_NUMholi, $ORDER_DATEholi, $EMP_IDholi, $BRANCH_ID, $DEPARTMENT, $POSITION, $AUTHOR_ID, $today_date, $HOLY_TYPE, $HOLY_KIND){
            $db = new My_sql_db();
            $id = $this->id;

            //добавляем отпуск в таблицу отпусков
            $sqlHoli = "insert into PERSON_HOLIDAYS (ID, ID_PERSON, DATE_BEGIN, DATE_END, CNT_DAYS, PERIOD_BEGIN, PERIOD_END, ORDER_NUM, ORDER_DATE, EMP_ID, VID)
                        values ('',
                                '$ID_PERSONholi',
                                '$DATE_BEGINholi',
                                '$DATE_ENDholi',
                                '$CNT_DAYSholi',
                                '$PERIOD_BEGINholi',
                                '$PERIOD_ENDholi',
                                '$ORDER_NUMholi',
                                '$ORDER_DATEholi',
                                '$AUTHOR_ID',
                                '$HOLY_KIND')";
            $listHoli = $db ->  Execute($sqlHoli);

            $seqArray = $db -> Select("SELECT * FROM PERSON_HOLIDAYS ORDER BY ID DESC LIMIT 1");
            $sequance = $seqArray[0]['ID'];

            //запись в таблицу T2 card
            $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ACT_ID, ID_MISS, BRANCH_ID, DEPARTMENT, POSITION, ID_PERSON, EMP_ID, ORDER_NUM, ORDER_DATE) values 
                                      ('', '$today_date','7', '$sequance', '$BRANCH_ID', '$DEPARTMENT', '$POSITION', '$ID_PERSONholi', '$AUTHOR_ID', '$ORDER_NUMholi', '$ORDER_DATEholi')";
            $update_history = $db -> Execute($sql_update_history);

            //добавляем отпуск в табель
            $sqlHoliToTable = "update TABLE_OTHER set VALUE = '$HOLY_TYPE' where DAY_DATE between '$DATE_BEGINholi' and '$DATE_ENDholi' and EMP_ID = '$ID_PERSONholi'";
            $listHoliToTable = $db -> Execute($sqlHoliToTable);

            return $seqArray;
        }

        //функция обновления информации в БД о об отпуске
        function update_inf_DB_Holidays($ID_PERSONholiEdit, $DATE_BEGINholiEdit, $DATE_ENDholiEdit, $CNT_DAYSholiEdit, $PERIOD_BEGINholiEdit, $PERIOD_ENDholiEdit, $ORDER_NUMholiEdit, $EMP_IDholiEdit, $IDholiEdit, $BRANCH_ID, $DEPARTMENT, $POSITION){
            $db = new My_sql_db();
            $sql = "update PERSON_HOLIDAYS set    ID_PERSON = '$ID_PERSONholiEdit',
                                                  DATE_BEGIN = '$DATE_BEGINholiEdit',
                                                  DATE_END = '$DATE_ENDholiEdit', 
                                                  CNT_DAYS = '$CNT_DAYSholiEdit',
                                                  PERIOD_BEGIN = '$PERIOD_BEGINholiEdit',
                                                  PERIOD_END = '$PERIOD_ENDholiEdit',
                                                  ORDER_NUM = '$ORDER_NUMholiEdit',
                                                  EMP_ID = '$EMP_IDholiEdit'
                                                  where id = $IDholiEdit";
        
            $listEmployee = $db -> Execute($sql);
            
            $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ACT_ID, ID_MISS, BRANCH_ID, DEPARTMENT, POSITION, ID_PERSON) values (SEQ_T2_CARD.nextval, '13.04.2017','7', '$ID_PERSONholiEdit', '$BRANCH_ID', '$DEPARTMENT', '$POSITION', '$ID_PERSONholi')";
            $update_history = $db -> Execute($sql_update_history);
            
            return $sql;
        }
        
        //функция delete_inf_in_DB_holi() удаляет данные об отпуске из базы
        function delete_inf_in_DB_holi($id){
            $db = new My_sql_db();
            $sqldeleteHoliId = "delete from PERSON_HOLIDAYS where id = $id";
            $listdeleteHoliId = $db -> Execute($sqldeleteHoliId);
        }

        //функция get_inf_from_DB_HOSPITAL() возвращает массив с данными о больнчных
        function get_inf_from_DB_HOSPITAL(){
            $db = new My_sql_db();
            $id = $this->id;
            //отпуска сотрудника
            $sqlHOSPITAL = "select * from PERSON_HOSPITAL where ID_PERSON = $id order by ID";
            $listHOSPITAL = $db -> Select($sqlHOSPITAL);
            return $listHOSPITAL;
        }

        //функция set_inf_to_DB_Hosp() добавляет данные о больничном
        function set_inf_to_DB_Hosp($ID_PERSONhosp, $DATE_BEGINhosp, $DATE_ENDhosp, $CNT_DAYShosp, $EMP_IDhosp, $today_date, $BRANCH_IDholi, $DEPARTMENTholi, $POSITIONholi, $AUTHOR_ID, $ORDER_DATEhosp, $ORDER_NUMhosp){
            $db = new My_sql_db();
            $id = $this->id;

            //больничный
            $sqlHosp = "insert into PERSON_HOSPITAL (ID, ID_PERSON, DATE_BEGIN, DATE_END, CNT_DAYS, EMP_ID) values('',
                                $ID_PERSONhosp,
                                '$DATE_BEGINhosp',
                                '$DATE_ENDhosp',
                                '$CNT_DAYShosp',
                                '$AUTHOR_ID')";

            $listHosp = $db -> Execute($sqlHosp);

            $seqArray = $db -> Select("SELECT * FROM PERSON_HOSPITAL ORDER BY ID DESC LIMIT 1");
            $sequance = $seqArray[0]['ID'];

            //больничный в табель
            $sqlHospToTable = "update TABLE_OTHER set VALUE = 'Б' where DAY_DATE between '$DATE_BEGINhosp' and '$DATE_ENDhosp' and EMP_ID = '$ID_PERSONhosp'";

            $listHospToTable = $db -> Execute($sqlHospToTable);

            $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ACT_ID, EMP_ID, ID_MISS, BRANCH_ID, DEPARTMENT, POSITION, ID_PERSON, ORDER_DATE, ORDER_NUM) values 
                             ('', '$today_date', '6', '$AUTHOR_ID', '$sequance', '$BRANCH_IDholi', '$DEPARTMENTholi', '$POSITIONholi', '$ID_PERSONhosp', '$ORDER_DATEhosp', '$ORDER_NUMhosp')";
            $update_history = $db -> Execute($sql_update_history);

            echo $sql_update_history;
        }

        //функция обновления данныx о больничном
        function update_inf_DB_Hosp
        ($ID_PERSONhospEdit, $DATE_BEGINhospEdit, $DATE_ENDhospEdit, $CNT_DAYShospEdit, $EMP_IDhospEdit, $IDhospEdit, $today_date, $AUTHOR_ID, $BRANCH_IDholiEdit, $JOB_SPholiEdit, $JOB_POSITIONholiEdit)
        {
            $db = new My_sql_db();
            $sqlHosp = "update PERSON_HOSPITAL set
                            DATE_BEGIN = '$DATE_BEGINhospEdit', 
                            DATE_END = '$DATE_ENDhospEdit',
                            CNT_DAYS = '$CNT_DAYShospEdit',
                            EMP_ID = '$EMP_IDhospEdit'
                            where 
                            id = $IDhospEdit";

            $listHosp = $db -> Execute($sqlHosp);

            $sql_update_history = "insert into T2_CARD (ID, EVENT_DATE, ACT_ID, EMP_ID, ID_MISS, BRANCH_ID, DEPARTMENT, POSITION, ID_PERSON, OTPR) values
                             (SEQ_T2_CARD.nextval, '$today_date', '6', '$AUTHOR_ID', '$IDhospEdit', '$BRANCH_IDholiEdit', '$JOB_POSITIONholiEdit', '$JOB_SPholiEdit', '$ID_PERSONhospEdit', '0') ";
            $update_history = $db -> Execute($sql_update_history);

            //больничный в табель
            $sqlHospToTable = "update TABLE_OTHER set VALUE = 'Б' where DAY_DATE between '$DATE_BEGINhospEdit' and '$DATE_ENDhospEdit' and EMP_ID = '$ID_PERSONhospEdit'";
            $listHospToTable = $db -> Execute($sqlHospToTable);

            return $sql_update_history;
        }

        //выводит таблицу с больничными
        function show_data_table_HOSPITAL($listHOSPITAL)
        {
            foreach($listHOSPITAL as $x => $z)
            {
            ?>
                <tr data="<?php echo $z['ID']; ?>">
                    <td class="text-center"><?php echo $z['ID']; ?></td>
                    <td class="text-center"><?php echo $z['DATE_BEGIN']; ?></td>
                    <td class="text-center"><?php echo $z['DATE_END']; ?></td>
                    <td class="text-center"><?php echo $z['CNT_DAYS']; ?> дн.</td>
                    <td class="text-center small">
                        <div class="btn-group">
                            <a data-toggle="modal" data-target="#editHealthMod" onclick="getHospInfForModal(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Редактировать</a>
                            <a id="deleteHoliId" onclick="deleteHosp(<?php echo $z['ID']; ?>);" class="btn-white btn btn-xs">Удалить</a>
                        </div>
                    </td>
                </tr>
            <?php
            }
        }

        //функция delete_inf_in_DB_hosp() удаляет данные о больничном
        function delete_inf_in_DB_hosp($id)
        {
            $db = new My_sql_db();
            $sqldeleteHosp = "delete from PERSON_HOSPITAL where id = $id";
            $listdeleteHospId = $db -> Execute($sqldeleteHosp);
        }

        //функция обновления общей информации в БД сотрудника
        function update_emp_to_DB_trivial($empIdTrivial, $LASTNAME, $FIRSTNAME, $middlename, $IIN, $BIRTHDATE, $NACIONAL, $BIRTH_PLACE, $DOCTYPE, $CONTRACT_JOB_NUM, $CONTRACT_JOB_DATE, $BRANCHID, $JOB_SP, $JOB_POSITION, $ID_RUKOV, $EMAIL, $FAX, $WORK_PHONE, $HOME_PHONE, $MOB_PHONE, $BANK_ID, $ACCOUNT_TYPE, $ACCOUNT, $OKLAD, $FAMILY, $STATE, $REG_ADDRESS_COUNTRY_ID, $REG_ADDRESS_CITY, $REG_ADDRESS_STREET, $REG_ADDRESS_BUILDING, $REG_ADDRESS_FLAT, $FACT_ADDRESS_COUNTRY_ID, $FACT_ADDRESS_CITY, $FACT_ADDRESS_STREET, $FACT_ADDRESS_BUILDING, $FACT_ADDRESS_FLAT, $SEX, $DOCPLACE, $DOCNUM, $LASTNAME2, $FIRSTNAME2, $PERSONAL_EMAIL, $DATE_LAYOFF, $DOCDATE, $DATE_POST)
        {
            $db = new My_sql_db();
            $sqlTrivial = "update EMPLOYEES
                            set 
                                LASTNAME = '$LASTNAME',
                                FIRSTNAME = '$FIRSTNAME',
                                middlename = '$middlename',
                                IIN = '$IIN',
                                BIRTHDATE = '$BIRTHDATE',
                                NACIONAL = '$NACIONAL',
                                BIRTH_PLACE = '$BIRTH_PLACE',
                                DOCTYPE = '$DOCTYPE',
                                CONTRACT_JOB_NUM = '$CONTRACT_JOB_NUM',
                                CONTRACT_JOB_DATE = '$CONTRACT_JOB_DATE',
                                EMAIL = '$EMAIL',
                                FAX = '$FAX',
                                WORK_PHONE = '$WORK_PHONE',
                                HOME_PHONE = '$HOME_PHONE',
                                MOB_PHONE = '$MOB_PHONE',
                                BANK_ID = '$BANK_ID',
                                ACCOUNT_TYPE = '$ACCOUNT_TYPE',
                                ACCOUNT = '$ACCOUNT',
                                OKLAD = '$OKLAD',
                                FAMILY = '$FAMILY',
                                STATE = '$STATE',
                                REG_ADDRESS_COUNTRY_ID = '$REG_ADDRESS_COUNTRY_ID',
                                REG_ADDRESS_CITY = '$REG_ADDRESS_CITY',
                                REG_ADDRESS_STREET = '$REG_ADDRESS_STREET',
                                REG_ADDRESS_BUILDING = '$REG_ADDRESS_BUILDING',
                                REG_ADDRESS_FLAT = '$REG_ADDRESS_FLAT',
                                FACT_ADDRESS_COUNTRY_ID = '$FACT_ADDRESS_COUNTRY_ID',
                                FACT_ADDRESS_CITY = '$FACT_ADDRESS_CITY',
                                FACT_ADDRESS_STREET = '$FACT_ADDRESS_STREET',
                                FACT_ADDRESS_BUILDING = '$FACT_ADDRESS_BUILDING',
                                FACT_ADDRESS_FLAT = '$FACT_ADDRESS_FLAT',
                                SEX = '$SEX',
                                DOCPLACE = '$DOCPLACE',
                                DOCNUM = '$DOCNUM',
                                PERSONAL_EMAIL = '$PERSONAL_EMAIL',
                                DATE_LAYOFF = '$DATE_LAYOFF',
                                DOCDATE = '$DOCDATE',
                                DATE_POST = '$DATE_POST',
                                JOB_SP = '$JOB_SP',
                                JOB_POSITION = '$JOB_POSITION'
                            where
                                id = $empIdTrivial";

            $listTrivial = $db -> Execute($sqlTrivial);

            if
            (
                $LASTNAME != '' and
                $FIRSTNAME != '' and
                $middlename != '' and
                $IIN != '' and
                $BIRTHDATE != '' and
                $NACIONAL != '' and
                $DOCTYPE != '' and
                $CONTRACT_JOB_NUM != '' and
                $CONTRACT_JOB_DATE != '' and
                $EMAIL != '' and
                $MOB_PHONE != '' and
                $BANK_ID != '' and
                $ACCOUNT_TYPE != '' and
                $ACCOUNT != '' and
                $OKLAD != '' and
                $FAMILY != '' and
                $STATE != '' and
                $REG_ADDRESS_COUNTRY_ID != '' and
                $REG_ADDRESS_CITY != '' and
                $REG_ADDRESS_STREET != '' and
                $REG_ADDRESS_BUILDING != '' and
                $REG_ADDRESS_FLAT != '' and
                $FACT_ADDRESS_COUNTRY_ID != '' and
                $FACT_ADDRESS_CITY != '' and
                $FACT_ADDRESS_STREET != '' and
                $FACT_ADDRESS_BUILDING != '' and
                $FACT_ADDRESS_FLAT != '' and
                $SEX != '' and
                $DOCPLACE != '' and
                $DOCNUM != '' and
                $PERSONAL_EMAIL != '' and
                $DOCDATE != ''
            )
            {
                $sqlTrivial = "update USERS 
                            set 
                                STATE = '0'
                            where
                                EMP_ID = $empIdTrivial";

                $listTrivial = $db -> Execute($sqlTrivial);
                $_SESSION[USER_STATE] = '0';
            }
                else
            {
                $sqlTrivial = "update USERS 
                            set 
                                STATE = '1'
                            where
                                EMP_ID = $empIdTrivial";

                $listTrivial = $db -> Execute($sqlTrivial);
                $_SESSION[USER_STATE] = '1';
                $create_year = date("Y");
                $create_month = date("m");
                $create_date = $create_year.'-'.$create_month.'-';
                //create_other_table("$create_date", "$empIdTrivial");
            }

            return $sqlTrivial;
        }
    }
?>