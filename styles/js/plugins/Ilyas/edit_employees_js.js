    function delete_detail(delete_det_id){
        var empId = $('#empIdMil').val();
        $.post('edit_employee', {"delete_det_id": delete_det_id,
                                 "empId": empId
                                }, function(d){
                                   $('#place_for_trip').html(d);
                                })
    }

    function add_trip_detail(){
        var empId = $('#empIdMil').val();
        var TRIP_DETAIL_ID = $('#TRIP_DETAIL_ID').val();
        var FROM_PLACE = $('#FROM_PLACE').val();
        var TO_PLACE = $('#TO_PLACE').val();
        var TRANSPORT = $('#TRANSPORT').val();
        
        if(FROM_PLACE != '' && TO_PLACE != '' && TRANSPORT != '')
        {
        $.post('edit_employee', {"empId": empId,
                                 "TRIP_DETAIL_ID": TRIP_DETAIL_ID,
                                 "FROM_PLACE": FROM_PLACE,
                                 "TO_PLACE": TO_PLACE,
                                 "TRANSPORT": TRANSPORT
                                }, function(d){
                                   $('#place_for_trip').html(d);
                                })
        }else{
            alert('Не все поля заполнены!');
        }
    }

    function addTripFunc(){
        var ID_PERSONtrip = $('#ID_PERSONtrip').val();
        var DATE_BEGINtrip = $('#DATE_BEGINtrip').val();
        var DATE_ENDtrip = $('#DATE_ENDtrip').val();
        var CNT_DAYStrip = $('#CNT_DAYStrip').val();
        var ORDER_NUMtrip = $('#ORDER_NUMtrip').val();
        var BRANCH_IDtrip = $('#BRANCH_IDtrip').val();
        var JOB_POSITIONtrip = $('#JOB_POSITIONtrip').val();
        var ORDER_DATEtrip = $('#ORDER_DATEtrip').val();
        var EMP_IDtrip = $('#empIdMil').val();
        var AIM = $('#AIM').val();
        var AIM_KAZ = $('#AIM_KAZ').val();
        var FINAL_DESTINATION = $('#FINAL_DESTINATION').val();
        var FINAL_DESTINATION_KAZ = $('#FINAL_DESTINATION_KAZ').val();
                
        //console.log(ID_PERSONtrip+'/'+DATE_BEGINtrip+'/'+DATE_ENDtrip+'/'+CNT_DAYStrip+'/'+ORDER_NUMtrip+'/'+BRANCH_IDtrip+'/'+JOB_POSITIONtrip+'/'+ORDER_DATEtrip+'/'+EMP_IDtrip+'/'+AIM+'/'+AIM_KAZ);
        
        if(ID_PERSONtrip != '' && DATE_BEGINtrip != '' && DATE_ENDtrip != '' && CNT_DAYStrip != '' && ORDER_NUMtrip != '' && BRANCH_IDtrip != '' && JOB_POSITIONtrip != '' && ORDER_DATEtrip != '' && EMP_IDtrip != '' && AIM != '' && AIM_KAZ != '' && FINAL_DESTINATION != '' && FINAL_DESTINATION_KAZ != '')
        {
        $.post('edit_employee', {"ID_PERSONtrip": ID_PERSONtrip,
                                 "DATE_BEGINtrip": DATE_BEGINtrip,
                                 "DATE_ENDtrip": DATE_ENDtrip,
                                 "CNT_DAYStrip": CNT_DAYStrip,
                                 "ORDER_NUMtrip": ORDER_NUMtrip,
                                 "BRANCH_IDtrip": BRANCH_IDtrip,
                                 "JOB_POSITIONtrip": JOB_POSITIONtrip,
                                 "ORDER_DATEtrip": ORDER_DATEtrip,
                                 "EMP_IDtrip": EMP_IDtrip,
                                 "AIM": AIM,
                                 "AIM_KAZ": AIM_KAZ,
                                 "FINAL_DESTINATION": FINAL_DESTINATION,
                                 "FINAL_DESTINATION_KAZ": FINAL_DESTINATION_KAZ                                                                  
                                }, function(d){
                                   $('#place_for_trip').html(d);
                                })
        }else{
            alert('Не все поля заполнены!');
        }
    }

    function addFamilyFunc()
    {
            var idPersFam = $('#idPersFam').val();
            var LASTNAMEfam = $('#LASTNAMEfam').val();
            var FIRSTNAMEfam = $('#FIRSTNAMEfam').val();
            var MIDDLENAMEfam = $('#MIDDLENAMEfam').val();
            var BIRTHDATEfamMemb = $('#BIRTHDATEfamMemb').val();
            var TYP_RODSTV = $('#TYP_RODSTV').val();

            $.post('edit_employee', {"idPersFam": idPersFam,
                                     "LASTNAMEfam": LASTNAMEfam,
                                     "FIRSTNAMEfam": FIRSTNAMEfam,
                                     "MIDDLENAMEfam": MIDDLENAMEfam,
                                     "BIRTHDATEfamMemb": BIRTHDATEfamMemb,
                                     "TYP_RODSTV": TYP_RODSTV
                                    }, function(d){
                                        $('#placeForFamilyMember').html(d);
                                    })
    }

    function addHospFunc()
    {
        var ID_PERSONhosp = $('#ID_PERSONhosp').val();
        var DATE_BEGINhosp = $('#DATE_BEGINhosp').val();
        var DATE_ENDhosp = $('#DATE_ENDhosp').val();
        var CNT_DAYShosp = $('#CNT_DAYShosp').val();
        var EMP_IDhosp = $('#EMP_IDhosp').val();
        var today_date = $('#today_date').val();
        var BRANCH_IDholi = $('#BRANCH_IDholi').val();
        var JOB_SPholi = $('#JOB_SPholi').val();
        var JOB_POSITIONholi = $('#JOB_POSITIONholi').val();
        var AUTHOR_ID = $('#AUTHOR_ID').val();
        var ORDER_DATEhosp = $('#ORDER_DATEhosp').val();
        var ORDER_NUMhosp = $('#ORDER_NUMhosp').val();

            alert('777');
            $.post
                ('edit_employee',
                    {"ID_PERSONhosp": ID_PERSONhosp,
                     "DATE_BEGINhosp": DATE_BEGINhosp,
                     "DATE_ENDhosp": DATE_ENDhosp,
                     "CNT_DAYShosp": CNT_DAYShosp,
                     "EMP_IDhosp": EMP_IDhosp,
                     "today_date": today_date,
                     "BRANCH_IDholi": BRANCH_IDholi,
                     "JOB_SPholi": JOB_SPholi,
                     "JOB_POSITIONholi": JOB_POSITIONholi,
                     "AUTHOR_ID": AUTHOR_ID,
                     "ORDER_DATEhosp": ORDER_DATEhosp,
                     "ORDER_NUMhosp": ORDER_NUMhosp
                    }, 
                function(d)
                {
                    $('#place_for_hosp').html(d);
                })
    }

    function deleteHosp(id){
        var EMP_IDhosp = $('#empIdTrivial').val();
        console.log(id+'/'+EMP_IDhosp);
        $.post('edit_employee', {"deleteHospId": id,
                                 "EMP_IDhosp": EMP_IDhosp
                                    }, function(d){
                                        $('#place_for_hosp').html(d);
                                    })
    }
    
    function updateHosp(){
        var IDhospEdit = $('#IDhospEdit').val();
        var ID_PERSONhospEdit = $('#ID_PERSONhosp').val();
        var DATE_BEGINhospEdit = $('#DATE_BEGINhospEdit').val();
        var DATE_ENDhospEdit = $('#DATE_ENDhospEdit').val();
        var CNT_DAYShospEdit = $('#CNT_DAYShospEdit').val();
        var EMP_IDhospEdit = $('#EMP_IDhospEdit').val();
        var BRANCH_IDholiEdit = $('#BRANCH_IDholi').val();
        var JOB_SPholiEdit = $('#JOB_SPholi').val();
        var JOB_POSITIONholiEdit = $('#JOB_POSITIONholi').val();
        
        console.log(ID_PERSONhospEdit+'/'+IDhospEdit+'/'+DATE_BEGINhospEdit+'/'+DATE_ENDhospEdit+'/'+CNT_DAYShospEdit+'/'+EMP_IDhospEdit);
        
        $.post('edit_employee', {"ID_PERSONhospEdit": ID_PERSONhospEdit,
                                 "IDhospEdit": IDhospEdit,
                                 "DATE_BEGINhospEdit": DATE_BEGINhospEdit,
                                 "DATE_ENDhospEdit": DATE_ENDhospEdit,
                                 "CNT_DAYShospEdit": CNT_DAYShospEdit,
                                 "EMP_IDhospEdit": EMP_IDhospEdit,
                                 "BRANCH_IDholiEdit": BRANCH_IDholiEdit,
                                 "JOB_SPholiEdit": JOB_SPholiEdit,
                                 "JOB_POSITIONholiEdit": JOB_POSITIONholiEdit
                                }, function(d){
                                    $('#place_for_hosp').html(d);
                                })
    }
    
    function getHospInfForModal(id){
        console.log(id);
        $.post('edit_employee', {"IDhospEditMod": id}, function(d){
                            $('#placeForEditHospdMod').html(d);
                        })
    }
    
    function addExpirienceFunc()
    {
            var idPersExp = $('#idPersExp').val();
            var expStartDate = $('#expStartDate').val();
            var expEndDate = $('#expEndDate').val();
            var P_NAME = $('#P_NAME').val();
            var P_DOLZH = $('#P_DOLZH').val();
            var P_ADDRESS = $('#P_ADDRESS').val();
            
            $.post('edit_employee', {"idPersExp": idPersExp,
                                     "expStartDate": expStartDate,
                                     "expEndDate": expEndDate,
                                     "P_NAME": P_NAME,
                                     "P_DOLZH": P_DOLZH,
                                     "P_ADDRESS": P_ADDRESS
                                    }, function(d){
                                        console.log(d);
                                        $('#place_for_formJob').html(d);
                                    })
    }

    function addEducationFunc()
    {
            console.log('addEducationFunc');
            var idPersEdu = $('#idPersEdu').val();
            var INSTITUTION = $('#INSTITUTION').val();
            var YEAR_BEGIN = $('#YEAR_BEGIN').val();
            var YEAR_END = $('#YEAR_END').val();
            var SPECIALITY = $('#SPECIALITY').val();
            var QUALIFICATION = $('#QUALIFICATION').val();
            var DIPLOM_NUM = $('#DIPLOM_NUM').val();

            $.post('edit_employee', {"idPersEdu": idPersEdu,
                                     "INSTITUTION": INSTITUTION,
                                     "YEAR_BEGIN": YEAR_BEGIN,
                                     "YEAR_END": YEAR_END,
                                     "SPECIALITY": SPECIALITY,
                                     "QUALIFICATION": QUALIFICATION,
                                     "DIPLOM_NUM": DIPLOM_NUM
                                    }, function(d)
                                    {
                                        console.log(d);
                                        $('#place_for_edu').html(d);
                                    })
    }

    function deleteEdu(id){
            var empIdDelEdu = $('#empIdTrivial').val();
            $.post('edit_employee', {"deleteEduId": id,
                                     "empIdDelEdu": empIdDelEdu}, function(d){
            $('#place_for_edu').html(d);
        });
    }
    
    function getHoliInfForModalReturn(id){
        var empIdEditHoli = $('#empIdTrivial').val();
        $('#editHoliIdMod').val(id);
        console.log('getHoliInfForModalReturn');
        $.post('edit_employee', {"editHoliIdModReturn": id,
                                 "empIdEditHoli": empIdEditHoli}, function(d){
                //console.log(d);
                $('#placeForReturnHoliIdMod').html(d);
            });
    }
    
    
    
    function getHoliInfForModal(id){
        var empIdEditHoli = $('#empIdTrivial').val();
        $('#editHoliIdMod').val(id);
        console.log('getHoliInfForModal');
        $.post('edit_employee', {"editHoliIdMod": id,
                                 "empIdEditHoli": empIdEditHoli}, function(d){
                $('#placeForReturnHoliIdMod').html(d);
            });
    }
    
    
    
    function updateHoli(){
        var IDholiEdit = $('#IDholiEdit').val();
        var ID_PERSONholiEdit = $('#ID_PERSONholiEdit').val();
        var DATE_BEGINholiEdit = $('#DATE_BEGINholiEdit').val();
        var DATE_ENDholiEdit = $('#DATE_ENDholiEdit').val();
        var CNT_DAYSholiEdit = $('#CNT_DAYSholiEdit').val();
        var PERIOD_BEGINholiEdit = $('#PERIOD_BEGINholiEdit').val();
        var PERIOD_ENDholiEdit = $('#PERIOD_ENDholiEdit').val();
        var ORDER_NUMholiEdit = $('#ORDER_NUMholiEdit').val();
        var EMP_IDholiEdit = $('#EMP_IDholiEdit').val();
        var BRANCH_IDholi = $('#BRANCH_IDholi').val();
        var JOB_SPholi = $('#JOB_SPholi').val();
        var JOB_POSITIONholi = $('#JOB_POSITIONholi').val();
        
        console.log(IDholiEdit+'/'+ID_PERSONholiEdit+'/'+DATE_BEGINholiEdit+'/'+DATE_ENDholiEdit+'/'+CNT_DAYSholiEdit+'/'+PERIOD_BEGINholiEdit+'/'+PERIOD_ENDholiEdit+'/'+ORDER_NUMholiEdit+'/'+EMP_IDholiEdit);
        
        $.post('edit_employee', {"ID_PERSONholiEdit": ID_PERSONholiEdit,
                                 "DATE_BEGINholiEdit": DATE_BEGINholiEdit,
                                 "DATE_ENDholiEdit": DATE_ENDholiEdit,
                                 "CNT_DAYSholiEdit": CNT_DAYSholiEdit,
                                 "PERIOD_BEGINholiEdit": PERIOD_BEGINholiEdit,
                                 "PERIOD_ENDholiEdit": PERIOD_ENDholiEdit,
                                 "ORDER_NUMholiEdit": ORDER_NUMholiEdit,
                                 "EMP_IDholiEdit": EMP_IDholiEdit,
                                 "IDholiEdit": IDholiEdit,
                                 "BRANCH_IDholi": BRANCH_IDholi,
                                 "JOB_SPholi": JOB_SPholi,
                                 "JOB_POSITIONholi": JOB_POSITIONholi
                                 }, function(d){
                                    $('#place_for_holi').html(d);
            });
    }
    
    function deleteHoli(id){
        var empIDholiDelete = $('#empIdTrivial').val();
        
        console.log(id+'/'+empIDholiDelete);
        $.post('edit_employee', {"IDholiDelete": id,
                                 "empIDholiDelete": empIDholiDelete}, function(d){
            $('#place_for_holi').html(d);
        });
        
    }

    function deleteExp(id){
            var empIdDelExp = $('#empIdTrivial').val();
            $.post('edit_employee', {"deleteExpId": id,
                                     "empIdDelExp": empIdDelExp}, function(d){
                $('#place_for_formJob').html(d);
            });
    }

    function deleteFamMemb(id){
            var empIdDelFamMemb = $('#empIdTrivial').val();
            $.post('edit_employee', {"deleteFamMembId": id,
                                     "empIdDelFamMemb": empIdDelFamMemb}, function(d){
                $('#placeForFamilyMember').html(d);
            });
    }

    function addDocs(){
        var formData = new FormData($('form')[0]);
        $.ajax({
              type: "POST",
              processData: false,
              contentType: false,
              url: "edit_employee",
              data:  formData
              })
              .done(function( data ) {
                               console.log(data);
              });
    }

    function getEduInfForModal(id){
        var empIdEditEdu = $('#empIdTrivial').val();
        $('#editEduIdMod').val(id);
        console.log('getEduInfForModal');
        $.post('edit_employee', {"editEduIdMod": id,
                                 "empIdEditEdu": empIdEditEdu}, function(d){
                $('#placeForEditEduIdMod').html(d);
            });
    };

        function updateEdu(){
            var IDholiEdit = $('#IDholiEdit').val();
            var empIdEditEdu = $('#empIdTrivial').val();
            var idEdu = $('#editEduIdMod').val();
            var INSTITUTIONEdit = $('#INSTITUTIONEdit').val();
            var YEAR_BEGINEdit = $('#YEAR_BEGINEdit').val();
            var YEAR_ENDEdit = $('#YEAR_ENDEdit').val();
            var SPECIALITYEdit = $('#SPECIALITYEdit').val();
            var QUALIFICATIONEdit = $('#QUALIFICATIONEdit').val();
            var DIPLOM_NUMEdit = $('#DIPLOM_NUMEdit').val();
            
            console.log(YEAR_ENDEdit);
            $.post('edit_employee', {"IDholiEdit": IDholiEdit,
                                     "empIdEditEdu": empIdEditEdu,
                                     "updateEduIdMod": idEdu,
                                     "INSTITUTIONEdit": INSTITUTIONEdit,
                                     "YEAR_BEGINEdit": YEAR_BEGINEdit,
                                     "YEAR_ENDEdit": YEAR_ENDEdit,
                                     "SPECIALITYEdit": SPECIALITYEdit,
                                     "QUALIFICATIONEdit": QUALIFICATIONEdit,
                                     "DIPLOM_NUMEdit": DIPLOM_NUMEdit
                                     }, function(d){
                $('#place_for_edu').html(d);
                //console.log(d);
            });
        }

    function getExpInfForModal(id)
    {
        var empIdEditExp = $('#empIdTrivial').val();
        $('#editExpIdMod').val(id);
        console.log(id);
        $.post('edit_employee', {"editExpIdMod": id,
                                 "empIdEditExp": empIdEditExp}, function(d){
                $('#placeForEditExpIdMod').html(d);
            });
    }

    $('#updateExperiance').click(
        function(){
            var empIdEditExp = $('#empIdTrivial').val();
            var idExp = $('#editExpIdMod').val();
            var expStartDateEdit = $('#expStartDateEdit').val();
            var expEndDateEdit = $('#expEndDateEdit').val();
            var P_NAMEEdit = $('#P_NAMEEdit').val();
            var P_DOLZHEdit = $('#P_DOLZHEdit').val();
            var P_ADDRESSEdit = $('#P_ADDRESSEdit').val();
            console.log(P_NAMEEdit);
            $.post('edit_employee', {"empIdEditExp": empIdEditExp,
                                     "idExp": idExp,
                                     "expStartDateEdit": expStartDateEdit,
                                     "expEndDateEdit": expEndDateEdit,
                                     "P_NAMEEdit": P_NAMEEdit,
                                     "P_DOLZHEdit": P_DOLZHEdit,
                                     "P_ADDRESSEdit": P_ADDRESSEdit
                                     }, function(d){
                $('#place_for_formJob').html(d);
                console.log(d);
            });
        }
    )

    function getInfFam(id){
        console.log(id);
        var empIdFamExp = $('#empIdTrivial').val();
        $('#editFamIdMod').val(id);
        $.post('edit_employee', {"editFamIdMod": id,
                                 "empIdFamExp": empIdFamExp}, function(d)
            {
                $('#placeForFamMembAjax').html(d);
                //console.log(d);
            });
    }

    $('#updateFamilyMemberDB').click(
        function(){
            var empIdEditUpdate = $('#empIdTrivial').val();
            var idFamUpdate = $('#editFamIdMod').val();
            var LASTNAMEfamedit = $('#LASTNAMEfamedit').val();
            var FIRSTNAMEfamedit = $('#FIRSTNAMEfamedit').val();
            var MIDDLENAMEfamedit = $('#MIDDLENAMEfamedit').val();
            var BIRTHDATEfamMembedit = $('#BIRTHDATEfamMembedit').val();
            var TYP_RODSTVedit = $('#TYP_RODSTVedit').val();
            
            $.post('edit_employee', {"empIdEditUpdate": empIdEditUpdate,
                                     "idFamUpdate": idFamUpdate,
                                     "LASTNAMEfamedit": LASTNAMEfamedit,
                                     "FIRSTNAMEfamedit": FIRSTNAMEfamedit,
                                     "MIDDLENAMEfamedit": MIDDLENAMEfamedit,
                                     "BIRTHDATEfamMembedit": BIRTHDATEfamMembedit,
                                     "TYP_RODSTVedit": TYP_RODSTVedit
                                     }, function(d){
                $('#placeForFamilyMember').html(d);
                console.log(d);
            });
        }
    )

    function addTrivialInfoFunc()
    {
        console.log('tststs');
            var empIdTrivial = $('#empIdTrivial').val();
            var LASTNAME = $('#LASTNAME').val();
            var FIRSTNAME = $('#FIRSTNAME').val();
            var middlename = $('#middlename').val();
            var IIN = $('#IIN').val();
            var BIRTHDATE = $('#BIRTHDATE').val();
            var NACIONAL = $('#NACIONAL').val();
            var BIRTH_PLACE = $('#BIRTH_PLACE').val();
            var DOCTYPE = $('#DOCTYPE').val();
            var CONTRACT_JOB_NUM = $('#CONTRACT_JOB_NUM').val();
            var CONTRACT_JOB_DATE = $('#CONTRACT_JOB_DATE').val();
            var BRANCHID = $('#BRANCHID').val();
            var JOB_SP = $('#JOB_SP').val();
            var JOB_POSITION = $('#JOB_POSITION').val();
            var ID_RUKOV = $('#ID_RUKOV').val();
            var EMAIL = $('#EMAIL').val();
            var FAX = $('#FAX').val();
            var WORK_PHONE = $('#WORK_PHONE').val();
            var HOME_PHONE = $('#HOME_PHONE').val();
            var MOB_PHONE = $('#MOB_PHONE').val();
            var BANK_ID = $('#BANK_ID').val();
            var ACCOUNT_TYPE = $('#ACCOUNT_TYPE').val();
            var ACCOUNT = $('#ACCOUNT').val();
            var OKLAD = $('#OKLAD').val();
            var FAMILY = $('#FAMILY').val();
            var STATE = $('#STATE').val();
            var REG_ADDRESS_COUNTRY_ID = $('#REG_ADDRESS_COUNTRY_ID').val();
            var REG_ADDRESS_CITY = $('#REG_ADDRESS_CITY').val();
            var REG_ADDRESS_STREET = $('#REG_ADDRESS_STREET').val();
            var REG_ADDRESS_BUILDING = $('#REG_ADDRESS_BUILDING').val();
            var REG_ADDRESS_FLAT = $('#REG_ADDRESS_FLAT').val();
            var FACT_ADDRESS_COUNTRY_ID = $('#FACT_ADDRESS_COUNTRY_ID').val();
            var FACT_ADDRESS_CITY = $('#FACT_ADDRESS_CITY').val();
            var FACT_ADDRESS_STREET = $('#FACT_ADDRESS_STREET').val();
            var FACT_ADDRESS_BUILDING = $('#FACT_ADDRESS_BUILDING').val();
            var FACT_ADDRESS_FLAT = $('#FACT_ADDRESS_FLAT').val();
            var SEX = $('input[name=SEX]:checked').val();
            var DOCPLACE = $('#DOCPLACE').val();
            var DOCNUM = $('#DOCNUM').val();
            var LASTNAME2 = $('#LASTNAME2').val();
            var FIRSTNAME2 = $('#FIRSTNAME2').val();
            var PERSONAL_EMAIL = $('#PERSONAL_EMAIL').val();
            var DATE_LAYOFF = $('#DATE_LAYOFF').val();
            var DOCDATE = $('#DOCDATE').val();
            var DATE_POST = $('#DATE_POST').val();

            $.post('edit_employee', 
                       {"empIdTrivial": empIdTrivial,
                        "LASTNAME": LASTNAME,
                        "FIRSTNAME": FIRSTNAME,
                        "middlename": middlename,
                        "IIN": IIN,
                        "BIRTHDATE": BIRTHDATE,
                        "NACIONAL": NACIONAL,
                        "BIRTH_PLACE": BIRTH_PLACE,
                        "DOCTYPE": DOCTYPE,
                        "CONTRACT_JOB_NUM": CONTRACT_JOB_NUM,
                        "CONTRACT_JOB_DATE": CONTRACT_JOB_DATE,
                        "BRANCHID": BRANCHID,
                        "JOB_SP": JOB_SP,
                        "JOB_POSITION": JOB_POSITION,
                        "ID_RUKOV": ID_RUKOV,
                        "EMAIL": EMAIL,
                        "FAX": FAX,
                        "WORK_PHONE": WORK_PHONE,
                        "HOME_PHONE": HOME_PHONE,
                        "MOB_PHONE": MOB_PHONE,
                        "BANK_ID": BANK_ID,
                        "ACCOUNT_TYPE": ACCOUNT_TYPE,
                        "ACCOUNT": ACCOUNT,
                        "OKLAD": OKLAD,
                        "FAMILY": FAMILY,
                        "STATE": STATE,
                        "REG_ADDRESS_COUNTRY_ID": REG_ADDRESS_COUNTRY_ID,
                        "REG_ADDRESS_CITY": REG_ADDRESS_CITY,
                        "REG_ADDRESS_STREET": REG_ADDRESS_STREET,
                        "REG_ADDRESS_BUILDING": REG_ADDRESS_BUILDING,
                        "REG_ADDRESS_FLAT": REG_ADDRESS_FLAT,
                        "FACT_ADDRESS_COUNTRY_ID": FACT_ADDRESS_COUNTRY_ID,
                        "FACT_ADDRESS_CITY": FACT_ADDRESS_CITY,
                        "FACT_ADDRESS_STREET": FACT_ADDRESS_STREET,
                        "FACT_ADDRESS_BUILDING": FACT_ADDRESS_BUILDING,
                        "FACT_ADDRESS_FLAT": FACT_ADDRESS_FLAT,
                        "SEX": SEX,
                        "DOCPLACE": DOCPLACE,
                        "DOCNUM": DOCNUM,
                        "LASTNAME2": LASTNAME2,
                        "FIRSTNAME2": FIRSTNAME2,
                        "PERSONAL_EMAIL": PERSONAL_EMAIL,
                        "DATE_LAYOFF": DATE_LAYOFF,
                        "DOCDATE": DOCDATE,
                        "DATE_POST": DATE_POST
                    }, 
                        function(d)
                    {
                        console.log(DATE_POST);
                        console.log(d);
                    }
                )
        }

        function addMilitaryFunc()
        {
            var empIdMil = $('#empIdMil').val();
            var MILITARY_GROUP = $('#MILITARY_GROUP').val();
            var MILITARY_CATEG = $('#MILITARY_CATEG').val();
            var MILITARY_SOST = $('#MILITARY_SOST').val();
            var MILITARY_RANK = $('#MILITARY_RANK').val();
            var MILITARY_SPECIALITY = $('#MILITARY_SPECIALITY').val();
            var MILITARY_VOENKOM = $('#MILITARY_VOENKOM').val();
            var MILITARY_SPEC_UCH = $('#MILITARY_SPEC_UCH').val();
            var MILITARY_SPEC_UCH_NUM = $('#MILITARY_SPEC_UCH_NUM').val();
            var MILITARY_FIT = $('#MILITARY_FIT').val();
            var idPersMil = $('#empIdTrivial').val();

            $.post('edit_employee', {"MILITARY_GROUP": MILITARY_GROUP,
                                     "MILITARY_SPECIALITY": MILITARY_SPECIALITY,
                                     "MILITARY_CATEG": MILITARY_CATEG,
                                     "MILITARY_SOST": MILITARY_SOST,
                                     "MILITARY_RANK": MILITARY_RANK,
                                     "MILITARY_VOENKOM": MILITARY_VOENKOM,
                                     "MILITARY_SPEC_UCH": MILITARY_SPEC_UCH,
                                     "MILITARY_SPEC_UCH_NUM": MILITARY_SPEC_UCH_NUM,
                                     "MILITARY_FIT": MILITARY_FIT,
                                     "idPersMil": idPersMil,
                                     "empIdMil": empIdMil
                                    }, function(d){
                                        console.log(d);
                                    })
        }