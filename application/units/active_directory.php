<?php

class LDAP
{
    private $server = '192.168.5.200';
    private $domain = 'gak.local';
    private $admin_login = 'ldap';
    private $admin_pass = 'Astana2016';

    private $control;

    public $user;
    public $pass;
    public $dc = array();
    public $OU = array();
    public $filter;
    public $colums = array();
    

    public function __construct()
    {
        $this->control = ldap_connect($this->server); // must be a valid LDAP server!
        ldap_set_option($this->control, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->control, LDAP_OPT_REFERRALS, 0);

        $this->dc = array('gak', 'local');
        $this->filter = "sn=*";
        $this->colums = array('cn', 'mail', 'title', 'department', 'company', 'telephoneNumber', 'mobile', '*');
        $this->user = $this->admin_login;
        $this->pass = $this->admin_pass;
        //$dn = "dc=gak, dc=local";
    }
    
    public function lists()
    {
        $dan = array();                
        $dn = $this->gen_dc();
        
        if ($this->control)
        {            
            $r = ldap_bind($this->control, $this->user.'@'.$this->domain, $this->pass);
            if(!$r){                 
                return false;                
            }            
            
            $result = ldap_search($this->control, $dn, $this->filter, $this->colums);
            $r_d = ldap_get_entries($this->control, $result);
            ldap_unbind($this->control);
            $dan = $r_d;
            return $dan;
        }
        
        return false;
    } 
    
    private function gen_dc()
    {
        $s = '';
        if(count($this->OU) > 0){
            foreach($this->OU as $ou){
                $s .= 'OU='.$ou.' ';
            }
        }
        
        foreach($this->dc as $dc){
            $s .= 'dc='.$dc.' ';
        }
        return $s;
    }
}

?>