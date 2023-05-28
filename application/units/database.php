<?php
	class DB
    {
        private $DB;        
        public $message = '';        
        public $row;
        public $bind_param = array();
        public $sql = '';
        public $connect_text = '';   
        private $user;     
               
	    public function __constructor()
        {
            $this->connect_text = "(DESCRIPTION =
            (ADDRESS_LIST =
                (ADDRESS = (PROTOCOL = TCP)(HOST = ".DB_HOST.")(PORT = 1521))
            )
                (CONNECT_DATA =
                (SID = ".DB_DATABASE.")
                (SERVER = DEFAULT)
                )
            )
            "; 
            
            //$this->DB = OCILogon(DB_USERNAME, DB_PASS, $this->connect_text, DB_CHARSET) or die(oci_error());
            $this->DB = oci_pconnect(DB_USERNAME, DB_PASS, $this->connect_text, DB_CHARSET) or die(oci_error());            
            if(!$this->DB) 
            {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            $this->OpenSession();
        }
        
        public function OpenSession()
        {
            $stmt = oci_parse ($this->DB, 'BEGIN dbms_application_info.set_action (:action); END;');
            oci_bind_by_name ($stmt, ':action', $_SERVER["REMOTE_ADDR"]);
            oci_execute($stmt);
        }
        
        public function Connect()
        {
            $this->connect_text = "(DESCRIPTION =
            (ADDRESS_LIST =
                (ADDRESS = (PROTOCOL = TCP)(HOST = ".DB_HOST.")(PORT = 1521))
            )
                (CONNECT_DATA =
                (SID = ".DB_DATABASE.")
                (SERVER = DEFAULT)
                )
            )
            "; 
            
            //$this->DB=OCILogon(DB_USERNAME, DB_PASS, $this->connect_text, DB_CHARSET) or die(oci_error());
            $this->DB = oci_pconnect(DB_USERNAME, DB_PASS, $this->connect_text, DB_CHARSET) or die(oci_error());                        
            //$this->DB = oci_connect(DB_USERNAME, DB_PASS, DB_HOST.":1521".'/'.DB_DATABASE, DB_CHARSET);            
            if(!$this->DB) 
            {
                $e = oci_error();
                var_dump($e);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }    
            $this->OpenSession();   
            
            global $active_user_dan;
            $this->user = $active_user_dan;     
        }
                                
        function kill_session()
        {                        
            $nyip = $_SERVER["REMOTE_ADDR"];        
            $stmt = oci_parse($this->DB, '
                begin 
                    for x in ( 
                        select sid, serial#, machine, program from v$session where action = '."'$nyip'".' 
                    )loop
                        execute immediate '."Alter System Kill Session '''|| x.Sid || ',' || x.Serial# || ''' IMMEDIATE'".';
                    end loop;
                end;');
            oci_execute($stmt);                                 
        }
        
        public function Select($sql)
        {
            $this->ClearParams();
            
            $this->sql = $sql;
            if(empty($this->DB)){            
                $this->Connect();    
            } 
            $q = oci_parse($this->DB, "ALTER SESSION SET NLS_DATE_FORMAT='dd.mm.yyyy'");
            oci_execute($q);                        
            
            $query = oci_parse($this->DB, $sql);
            if(!oci_execute($query)){                
                $e = oci_error($query); 
                $text = htmlentities($e['message'])."\n<pre>\n".htmlentities($e['sqltext']).printf("\n%".($e['offset']+1)."s", "^")."\n</pre>\n";                                               
                $this->message = $text;
                $this->SetError($this->user['emp'], $text);
                return array();
            }                        
            while($row = oci_fetch_array($query, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS))
            {
                $dan = array();
                foreach($row as $k=>$v){
                    $dan[$k] = str_replace_kaz($v);
                }
                $this->row[] = $dan;
            }                                          
            return $this->row;   
        }
        
        
        public function Select2($sql)
        {
            $this->ClearParams();
            
            $this->sql = $sql;
            if(empty($this->DB)){            
                $this->Connect();    
            } 
            $q = oci_parse($this->DB, "ALTER SESSION SET NLS_DATE_FORMAT='dd.mm.yyyy'");
            oci_execute($q);     
            
            $q = oci_parse($this->DB, "ALTER SESSION SET NLS_CHARACTERSET=".DB_CHARSET);
            oci_execute($q);
                               
            
            $query = oci_parse($this->DB, htmlspecialchars($sql));
            if(!oci_execute($query)){                
                $e = oci_error($query); 
                $text = htmlentities($e['message'])."\n<pre>\n".htmlentities($e['sqltext']).printf("\n%".($e['offset']+1)."s", "^")."\n</pre>\n";                                               
                $this->message = $text;
                $this->SetError($this->user['emp'], $text);
                return array();
            }                        
            while($row = oci_fetch_array($query, OCI_ASSOC+OCI_RETURN_NULLS+OCI_RETURN_LOBS))
            {
                $dan = array();
                foreach($row as $k=>$v){
                    $dan[$k] = str_replace_kaz($v);
                }
                $this->row[] = $dan;
            }                                          
            return $this->row;   
        }
        
        public function ExecProc($sql, $dan = array())
        {      
            if(empty($this->DB)){            
                $this->Connect();    
            }
            
            $stid = oci_parse($this->DB, $sql);
            if(count($dan) > 0){
                foreach($dan as $k=>$v){
                    oci_bind_by_name($stid, ':'.$k, $v);
                }
            }
            $result = array();
            $result['error'] = '';
            $result['exec'] = true;
            
            $exes = oci_execute($stid);
            if (!$exes) { 
                $e = oci_error($stid);
                $result['error'] = htmlentities($e['message'])."<br />".htmlentities($e['sqltext']);
                $result['exec'] = true;
                $this->SetError($this->user['emp'], htmlentities($e['message']));
            }
                        
            oci_free_statement($stid);
            oci_close($this->DB);            
            return $result;
        }
        
        public function Execute($sql)
        {
            if(empty($this->DB)){            
                $this->Connect();    
            }
            
            $stid = oci_parse($this->DB, $sql);
            $exes = oci_execute($stid);
            if (!$exes) { 
                $e = oci_error($stid);
                $this->SetError($this->user['emp'], htmlentities($e['message']));
                return htmlentities($e['message']);                                            
            }            
            return true;
        }     
        
        public function AddClob($sql, $param){            
            if(empty($this->DB)){            
                $this->Connect();    
            }                        
            
            $stid = oci_parse($this->DB, $sql);
            $clob = oci_new_descriptor($this->DB, OCI_D_LOB);
            
            foreach($param as $k=>$v);          
            oci_bind_by_name($stid, ":$k", $clob, -1, OCI_B_CLOB);            
            $exec = oci_execute($stid, OCI_NO_AUTO_COMMIT);            
            $clob->save($v);
            oci_commit($this->DB) or die(oci_error($stid));            
            return true;
        }
        
        public function AddClobArray($sql, $param){            
            if(empty($this->DB)){            
                $this->Connect();    
            }                        
            
            $stid = oci_parse($this->DB, $sql);
            $clob = oci_new_descriptor($this->DB, OCI_D_LOB);
            
            foreach($param as $k=>$v){
                oci_bind_by_name($stid, ":$k", $clob, -1, OCI_B_CLOB);    
            }           
            $exec = oci_execute($stid, OCI_NO_AUTO_COMMIT);            
            $clob->save($v);
            oci_commit($this->DB) or die(oci_error($stid));            
            return true;
        }    
        
        public function ClearParams()
        {
            $this->sql = '';
            $this->row = array();
            $this->bind_param = array();
            $this->message = '';
        }
        
        public function ExecuteReturn($sql, $res)
        {
            if(empty($this->DB)){            
                $this->Connect();    
            }
            
            $stid = oci_parse($this->DB, $sql);
            $d = array();
            
            foreach($res as $k){
                if($res[$k] !== ''){
                    oci_bind_by_name($stid, ":".$k, $v);
                }
            }
            
            foreach($res as $k){                                    
                oci_bind_by_name($stid, ":".$k, $d[$k], 5000);
            }
            $exes = oci_execute($stid);
                    
            oci_free_statement($stid);
            oci_close($this->DB);            
            return $d;
        }
        
        public function ExecReturn($sql, $res)
        {
            if(empty($this->DB)){
                $this->Connect();    
            }
            
            $stid = oci_parse($this->DB, $sql);            
            oci_bind_by_name($stid, $res, $result, 50000);            
            $exes = oci_execute($stid);
            /*
            if (!$exes) { 
                $e = oci_error($stid);
                $result['error'] = ALERTS::WarningMin(htmlentities($e['message'])."<br />".htmlentities($e['sqltext']));
                $result['exec'] = true;                            
            }
            */          
            oci_free_statement($stid);
            oci_close($this->DB);            
            return $result;
        }
        
        private function SetError($id_user, $text)
        {           
            $sql = "INSERT INTO INSURANCE.ERROR_INSUR (EMP_ID, ERROR_TEXT, DATE_ADD) VALUES ('$id_user', :ERROR_TEXT, sysdate)";
            $param['ERROR_TEXT'] = $text;
            $this->AddClob($sql, $param);
        }
	}
?>