<?php
	class SQLS
    {
        function PA($cnct_id)
        {
            $sql_body = "select 
                d.cnct_id,
                d.osns_head,
                emp_name(d.emp_id) emp_name, 
                BRANCH_name(d.branch_id) BRANCH_name, 
                LGOT_name(d.lgot) LGOT_name, 
                birthdat_annuit(d.id_annuit) birthdate,  
                case 
                    when substr(d.contract_num,length(d.contract_num)-2, 1) = 'Д'  then substr(d.contract_num,length(d.contract_num)-1, 2) 
                    else substr(d.contract_num,length(d.contract_num), 1) 
                end dop_num,  
                nvl(to_char(d.date_begin,'dd.mm.yyyy'),'__.__.____ г.') date_begin_dogov, 
                state_name(d.state) state_name, 
                progr_name(d.paym_code) progr_name, 
                bank_name(d.BANK_ID) bank_name, 
                level_name(d.level_r) level_name, 
                progr_name(substr(d.paym_code,1,4)) strah_name, 
                client_name(d.id_paym) poluch_name, 
                reason_dops_name(d.reason_dops) reason_dops_name, 
                nvl(to_char(d.date_end,'dd.mm.yyyy'),'пожизненно') d_end, 
                d.pay_sum_p - nvl(d.FIRST_VIPL,0) sum_ost, 
                d.sum_ost sum_ost_evr, 
                client_name(d.id_annuit) annuit, 
                client_name(d.id_bread_win) uk,
                FOND_name(d.id_insur) contag_name,  
                FOND_name_2(d.id_insur) contag_sh_name, 
                FOND_name(d.ID_FIRST_INSUR) FIRST_INSUR,
                reason_name(d.id_reason) reason_name, 
                calcul_name(d.id_calcul) calc_name,  
                annuitt_state_name(IZHD_STATE) IZHD_STATE_nam, 
                d.SUM_P_KSZ, 
                d.SUM_P_F,   
                case 
                    when d.account_type = 1 then 'Лицевой' 
                    when d.account_type =2 then  'Карточный' 
                    when d.account_type =3 then  'Транзитный'   
                    when d.account_type =4 then 'Депозитный' 
                end  acc_type,
                (select group_id from contr_agents where id = d.id_insur) insur_group_id, 
                d.*, 
                cl.*";
            
            $sql_params = "where 
                d.ID_ANNUIT = (select id_annuit from contracts d where d.cnct_id = $cnct_id union all select id_annuit from contracts_maket d where d.cnct_id = $cnct_id) 
                and d.ID_ANNUIT = cl.sicid";
            
            $sql = "$sql_body, 'Макет договора' ISFile from contracts_maket d, clients cl $sql_params  
                    union all 
                    $sql_body, 'Договор' ISFile from contracts d, clients cl $sql_params  
                    order by 1";
            
            $db = new DB3();
            $dan = $db->Select($sql);    
    
            foreach($dan as $k=>$v){                
                $d = $db->Select('
                    select  
                        gbdfl.ADDRES_insur (cl.REG_ADDRESS_DISTRICTS_ID,cl.REG_ADDRESS_REGION_ID,cl.REG_ADDRESS_CITY) ADDR,
                        docum(g.sicid) docum_rus, docum_kz(g.sicid) docum_kaz, 
                        g.*, 
                        cl.*
                    from 
                        get_obtain g, 
                        clients cl
                    where 
                        g.cnct_id = '.$v['CNCT_ID'].'
                        and g.sicid = cl.sicid
                        order by g.cnt'); 
        
                $dan[$k]['vigodopreob'] = $d;                   
            }
            return $dan;
        }
        
        function OSOR($cnct_id)
        {
            $sql_body = "select 
                d.cnct_id,
                d.osns_head,
                emp_name(d.emp_id) emp_name, 
                BRANCH_name(d.branch_id) BRANCH_name, 
                LGOT_name(d.lgot) LGOT_name, 
                birthdat_annuit(d.id_annuit) birthdate,  
                case 
                    when substr(d.contract_num,length(d.contract_num)-2, 1) = 'Д'  then substr(d.contract_num,length(d.contract_num)-1, 2) 
                    else substr(d.contract_num,length(d.contract_num), 1) 
                end dop_num,  
                nvl(to_char(d.date_begin,'dd.mm.yyyy'),'__.__.____ г.') date_begin_dogov, 
                state_name(d.state) state_name, 
                progr_name(d.paym_code) progr_name, 
                bank_name(d.BANK_ID) bank_name, 
                level_name(d.level_r) level_name, 
                progr_name(substr(d.paym_code,1,4)) strah_name, 
                client_name(d.id_paym) poluch_name, 
                reason_dops_name(d.reason_dops) reason_dops_name, 
                nvl(to_char(d.date_end,'dd.mm.yyyy'),'пожизненно') d_end, 
                d.pay_sum_p - nvl(d.FIRST_VIPL,0) sum_ost, 
                d.sum_ost sum_ost_evr, 
                client_name(d.id_annuit) annuit, 
                client_name(d.id_bread_win) uk,
                FOND_name(d.id_insur) contag_name,  
                FOND_name_2(d.id_insur) contag_sh_name, 
                FOND_name(d.ID_FIRST_INSUR) FIRST_INSUR,                   
                reason_name(d.id_reason) reason_name, 
                calcul_name(d.id_calcul) calc_name,  
                annuitt_state_name(IZHD_STATE) IZHD_STATE_nam, 
                d.SUM_P_KSZ, 
                d.SUM_P_F,   
                case 
                    when d.account_type = 1 then 'Лицевой' 
                    when d.account_type =2 then  'Карточный' 
                    when d.account_type =3 then  'Транзитный'   
                    when d.account_type =4 then 'Депозитный' 
                end  acc_type,
                (select group_id from contr_agents where id = d.id_insur) insur_group_id, 
                d.*, 
                cl.*";
            
            $sql_params = "where 
                d.ID_ANNUIT = (select id_annuit from contracts d where d.cnct_id = $cnct_id union all select id_annuit from contracts_maket d where d.cnct_id = $cnct_id) 
                and d.ID_ANNUIT = cl.sicid";
            
            $sql = "$sql_body, 'Макет договора' ISFile from contracts_maket d, clients cl $sql_params
                    union all
                    $sql_body, 'Договор' ISFile from contracts d, clients cl $sql_params order by 1";
                        
            $db = new DB3();
            $dan = $db->Select($sql);
            
            foreach($dan as $k=>$v){
                $db->ClearParams();
                $d = $db->Select('
                    select  
                        gbdfl.ADDRES_insur (cl.REG_ADDRESS_DISTRICTS_ID,cl.REG_ADDRESS_REGION_ID,cl.REG_ADDRESS_CITY) ADDR,
                        docum(g.sicid) docum_rus, docum_kz(g.sicid) docum_kaz, 
                        g.*, 
                        cl.*
                    from 
                        get_obtain g, 
                        clients cl
                    where 
                        g.cnct_id = '.$v['CNCT_ID'].'
                        and g.sicid = cl.sicid
                        order by g.cnt');             
                $dan[$k]['vigodopreob'] = $d;                   
            }
            
            return $dan;   
        }
        
        function OSNS($cnct_id, $db)
        {
            $sql_body = "
            select 
                d.cnct_id,round(cl.gfot_aup + cl.gfot_pp + cl.gfot_vp,2) gfot_all,
                cl.cnt_aup+cl.cnt_pp+cl.cnt_vp cnt_all,  
                nvl(cl.prem_aup,round(cl.sum_aup/100*cl.tarif_aup*to_number(nvl('',1))/nvl(cl.kol_d_year,1)*nvl(cl.kol_ost_d,1),2)) prem_aup,   
                nvl(cl.prem_vp,round(cl.sum_vp/100*cl.tarif_vp*to_number(nvl('',1))/nvl(cl.kol_d_year,1)*nvl(cl.kol_ost_d,1),2)) prem_vp,     
                nvl(cl.prem_pp,round(cl.sum_pp/100*cl.tarif_pp*to_number(nvl('',1))/nvl(cl.kol_d_year,1)*nvl(cl.kol_ost_d,1),2)) prem_pp,     
                round(nvl(cl.prem_aup,cl.sum_aup/100*cl.tarif_aup/nvl(cl.kol_d_year,1)*nvl(cl.kol_ost_d,1)) +   nvl(cl.prem_vp,cl.sum_vp/100*cl.tarif_vp/nvl(cl.kol_d_year,1)*nvl(cl.kol_ost_d,1)) +     nvl(cl.prem_pp,cl.sum_pp/100*cl.tarif_pp/nvl(cl.kol_d_year,1)*nvl(cl.kol_ost_d,1)),2) prem_all, 
                cl.tarif_aup*to_number(nvl('',1)) tarif_s_nadb_aup, 
                cl.tarif_pp*to_number(nvl('',1)) tarif_s_nadb_pp, 
                cl.tarif_vp*to_number(nvl('',1)) tarif_s_nadb_vp,   
                emp_name(d.emp_id) emp_name, 
                BRANCH_name(d.branch_id) BRANCH_name, 
                t.name_oked oked_name,  
                case 
                    when substr(d.contract_num,length(d.contract_num)-2, 1) = 'Д' then  substr(d.contract_num,length(d.contract_num)-1, 2) 
                    else substr(d.contract_num,length(d.contract_num), 1) 
                end dop_num, 
                level_name(d.level_r) level_name, 
                state_name(d.state) state_name, 
                progr_name(d.paym_code) progr_name, 
                categ_osns_name(cl.categor) categ_osns, 
                progr_name(substr(d.paym_code,1,4)) strah_name, 
                ca.NAME contag_name,
                d.*,                   
                t.name ved_name, 
                t.*, 
                cl.*, 
                ( select nvl((select sum(cl.zarab_p) from contracts c, osns_calc cl where c.id_head = d.id_head and cl.cnct_id = c.cnct_id and cl.cnct_id <= d.cnct_id and c.state <> 13),0) 
                + nvl((select sum(cl.zarab_p) from contracts_maket c, osns_calc cl where c.id_head = d.id_head and cl.cnct_id = c.cnct_id and cl.cnct_id <=  d.cnct_id and c.state <> 13 ),0)  
                from dual
                ) zarab_p_all, 
                (select DK.LASTNAME||' '||DK.FIRSTNAME||' '||DK.MIDDLENAME from CONTRACTS_PERSON_KOS pk, DIC_PERSON_KOS dk where PK.ID_PERSON = DK.ID and PK.CNCT_ID = d.cnct_id) otv_lico,
                reason_dops_name(d.reason_dops) reason_dops_name";
            
            $sql_params = "where 
                d.id_insur = (select id_insur from contracts d where d.cnct_id = $cnct_id union all select id_insur from contracts_maket d where d.cnct_id = $cnct_id)  
                and substr(paym_code,1,4) = '0701' 
                and d.cnct_id = cl.cnct_id  
                and d.ID_INSUR = ca.ID  
                and d.oked_id = t.id";
            
            $sql = "$sql_body, 'Макет договора' ISFile from  contracts_maket d, osns_calc cl, contr_agents ca, dic_oked_afn t $sql_params
                    union all
                    $sql_body, 'Договор' ISFile from  contracts d, osns_calc cl, contr_agents ca, dic_oked_afn t $sql_params";
            
            if(!$db){      
                $db = new DB3();
            }
            $dan = $db->Select($sql);
            $ds = $dan;
            
            foreach($ds as $k=>$v){
                
                $dan[$k]['OSNS_CALC_NEW'] = $db->Select("select case when o.id_filial = 0 then o.id_filial||' - Страхователь' else o.id_filial||' - '||c.name end name, o.* from 
                                                         OSNS_CALC_NEW o, contr_agents_filial c where c.id(+) = o.id_filial and o.cnct_id = ".$v['CNCT_ID']);                                
                
                
                $dan[$k]['PRIL2'] = $db->Select("select case when o.id_filial = 0 then o.id_filial||' - Страхователь' else o.id_filial||' - '||(select name from contr_agents_filial p where id = o.id_filial) 
                    end name, o.* from OSNS_pril2 o where  o.cnct_id = ".$v['CNCT_ID']." and O.ID_FILIAL is not null
                    union all
                    select d.id||' - '||d.short_name name, o.* from OSNS_pril2 o, DIC_CATEG_PERSONAL d where o.cnct_id = ".$v['CNCT_ID']." and o.categor = d.id  and O.ID_FILIAL is null");  
                    
                
                $dan[$k]['AGENT_DAN'] = $db->Select("select case when a.vid in(1, 5) then lastname || ' '||firstname || ' '||middlename || ' ' || birthdate || ' г.р. ' else a.org_name end fio,
                            'Договор №'||a.contract_num || ' от '|| a.contract_date_begin||' г.' dogovor, a.*
                            from agents a where a.id = ".$v['SICID_AGENT']);
             
                
                $dan[$k]['ACT_N1'] = $db->Select("select d.id||' - '||d.short_name name, o.* from  osns_act_n1 o, DIC_CATEG_PERSONAL d where o.cnct_id = ".$v['CNCT_ID']." and o.DOLZHN = d.id");
                                
                $dan[$k]['TRANSH'] = $db->Select("select t.*, tlsc.money_word(t.pay_sum) sum_word, tlsc.money_word_kaz(t.pay_sum) sum_word_kaz from TRANSH t where cnct_id = ".$v['CNCT_ID']);
                                
                $dan[$k]['BAD_SLUCH_LIST'] = $db->Select("
                    select d.id||' - '||d.short_name name, o. * from osns_stat_accident o, DIC_CATEG_PERSONAL d
                    where o.cnct_id = ".$v['CNCT_ID']." and o.DOLZHN = d.id and o.id_filial is null 
                    union all
                    select case when o.id_filial = 0 then o.id_filial||' - Страхователь' else o.id_filial||' - '||c.name end name, o.* 
                    from contr_agents_filial c, OSNS_STAT_ACCIDENT o where o.id_filial = c.id(+) and o.cnct_id = ".$v['CNCT_ID']." and o.id_filial is not null
                ");
                
                //Если reins_id = 4 тогда выводить "Договор взят на собственное удержание"                
                $dan[$k]['REINSURANCE'] = $db->Select("
                select 
                    s.id ||' - '||s.r_name contag_name, reyting_ag__name(s.estimation, 1) RAG_NAME,
                    reyting_ag__name(s.estimation, 2) ESTIMATION, 
                    r.*,
                    (select B.CONTRACT_NUM from bordero_contracts b, bordero_contracts_list l where L.ID_CONTRACTS = B.ID and L.CNCT_ID = r.cnct_id) bordero_num,
                    (select B.id from bordero_contracts b, bordero_contracts_list l where L.ID_CONTRACTS = B.ID and L.CNCT_ID = r.cnct_id) bordero_id
                from reinsurance r, dic_REINSURANCE s where r.cnct_id = ".$v['CNCT_ID']." and r.REINSUR_ID = s.ID
                ");
                                
                $dan[$k]['OSNS_NS'] = $db->Select("select id,cl.lastname || ' ' || cl.firstname || ' ' || cl.middlename fio, n.zakl_nom, n.zakl_date, n.n1_nom,
                    n.n1_date, n.mse_nom, n.mse_date, n.supt, n.pay_sum, n.diagnos from osns_ns n, clients cl where n.sicid = cl.sicid and n.cnct_id = ".$v['CNCT_ID']);

                $dan[$k]['AGENT_COMMIS'] = $db->Select("select a.NOM_ACT, a.DATE_ACT, p.SUM_PREM_COM, p.COMMIS_PERC from agents_payments p, AGENT_ACTS a  
                where p.cnct_id = ".$v['CNCT_ID']." and p.ACT_ID = a.ID");       
                                  
            }                                    
            return $dan;            
        }
        
        function HRANITEL($cnct)
        {
            $dan = array();
            $db = new DB3();
            $q = $db->Select("select * from LIST_DOBR_DOGOVORS where cnct_id = $cnct");
            $dan['contract'] = $q[0];
            $dan['clients'] = $db->Select("select * from LIST_DOBR_DOGOVORS_CLIENTS where cnct_id = $cnct");
            foreach($dan['clients'] as $k=>$v){
                $dan['clients'][$k]['obtain'] = $db->Select("
                select d.*, C.LASTNAME, C.FIRSTNAME, C.MIDDLENAME, C.IIN, C.BIRTHDATE, C.ADDRESS_RUS, C.SIC, C.RNN 
                from DOBR_OBTAIN d, clients c where c.sicid = d.sicid and d.cnct_id = $cnct and d.sicid_client = ".$v['ID_ANNUIT']);
                
                $dan['clients'][$k]['NAGRUZ'] = $db->Select("select * from DOBR_DOGOVORS_CLIENTS_NAGRUS where cnct_id = $cnct and id_annuit = ".$v['ID_ANNUIT']);
                
                $dan['clients'][$k]['CALC'] = $db->Select("select     
                    case 
                        when d.type_pokr = 0 then 'Основное покрытие' 
                        else 'Дополнительное покрытие' 
                    end name_type_pokr,
                    case 
                        when d.type_pokr = 0 then (select naimen from DOBR_SPR_OSN_P where id = d.id_pokr) 
                        else (select naimen from DOBR_DOP_STRAH where id = d.id_pokr) 
                    end name_pokr,
                    d.*
                from 
                    DOBR_DOGOVORS_CLIENTS_CALC d 
                where 
                    cnct_id = $cnct
                    and d.sicid = ".$v['ID_ANNUIT']);
            }
            
            $dan['reinsurance'] = $db->Select("
                select s.id ||' - '||s.r_name contag_name, reyting_ag__name(s.estimation, 1) RAG_NAME,
                reyting_ag__name(s.estimation, 2) ESTIMATION, r.* from reinsurance r, dic_REINSURANCE s
                where r.cnct_id = $cnct
                and r.REINSUR_ID = s.ID");            
            return $dan;
        }
        
        function BranchRegName()
        {
            $db = new DB3();            
            $sql1 = "select substr(RFBN_ID, 1, 2) kod, main_reg from dic_branch where asko is null and main_reg is not null group by main_reg, substr(RFBN_ID, 1, 2)"; 
            return $db->Select($sql1);
        }
        
        function ChartDate($d1)
        {
            $sql = "select main_reg, kod_branch, pa, osor, osns, plan_PA, plan_osor, plan_osns, 
            round(pa / plan_pa * 100, 2) proc_pa, 
            round(osor / plan_osor * 100, 2) proc_osor,        
            round(osns / plan_osns * 100, 2) proc_osns
            from(  
                select 
                    main_reg, kod_branch, pa, osor, osns,   
                    (select sum_plan from plan_branch_new pb where PB.RFBN_ID = kod_branch and PB.RFPM_ID = '01' and pb.period between trunc(to_date('$d1', 'dd.mm.yyyy'),'mm') and last_day('$d1')) plan_PA,
                    (select sum_plan from plan_branch_new pb where PB.RFBN_ID = kod_branch and PB.RFPM_ID = '02' and pb.period between trunc(to_date('$d1', 'dd.mm.yyyy'),'mm') and last_day('$d1')) plan_OSOR,
                    (select sum_plan from plan_branch_new pb where PB.RFBN_ID = kod_branch and PB.RFPM_ID = '07' and pb.period between trunc(to_date('$d1', 'dd.mm.yyyy'),'mm') and last_day('$d1')) plan_OSNS
                from(
                    select 
                        main_reg, substr(db.RFBN_ID, 1, 2) kod_branch,
                        grafik_sotr(trunc(to_date('$d1', 'dd.mm.yyyy'),'mm'), last_day('$d1'), '01', substr(db.RFBN_ID, 1, 2)) pa,
                        grafik_sotr(trunc(to_date('$d1', 'dd.mm.yyyy'),'mm'), last_day('$d1'), '02', substr(db.RFBN_ID, 1, 2)) osor, 
                        grafik_sotr(trunc(to_date('$d1', 'dd.mm.yyyy'),'mm'), last_day('$d1'), '07', substr(db.RFBN_ID, 1, 2)) osns         
                        from dic_branch db where db.main_reg is not null
                        group by main_reg, substr(db.RFBN_ID, 1, 2)
                    order by 1
            ))";            
            $db = new DB3();
            $db->ClearParams();
            return $db->Select($sql);           
        }
        
        function ChartRegion3($region)
        {                
            $sql = "select mes main_reg, pa, osor, osns, plan_PA, plan_osor, plan_osns, 
            round(pa / plan_pa * 100, 2) proc_pa, 
            round(osor / plan_osor * 100, 2) proc_osor, 
            round(osns / plan_osns * 100, 2) proc_osns
            from(
            select mes, pa, osor, osns,   
            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = '$region' and PB.RFPM_ID = '01' and pb.period = mes) plan_PA,
            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = '$region' and PB.RFPM_ID = '02' and pb.period = mes) plan_OSOR,
            (select sum_plan from plan_branch_new pb where PB.RFBN_ID = '$region' and PB.RFPM_ID = '07' and pb.period = mes) plan_OSNS 
            from(    
                select trunc(kv.DATE_DOHOD,'mm') mes,  
                round(sum(case when substr(d.paym_code,1,2) = '01' then kv.pay_sum_d  else 0 end) / 1000) pa,   
                round(sum(case when substr(d.paym_code,1,2) = '02' then kv.pay_sum_d  else 0 end) / 1000) osor,
                round(sum(case when substr(d.paym_code,1,2) = '07' then kv.pay_sum_d  else 0 end) / 1000) osns
                from 
                contracts d, gak_pay_doc pl, plat_to_1c kv    
                where    
                kv.DATE_DOHOD between '01.01.2016' and '31.12.2016'
                and substr(d.branch_id, 1, 2) = '$region'
                and kv.cnct_id = d.cnct_id
                and pl.mhmh_id = kv.mhmh_id
                group by trunc(kv.DATE_DOHOD,'mm')
            ))order by 1";
            $db = new DB();
            $db->ClearParams();
            return $db->Select($sql);    
        }                
    }
?>