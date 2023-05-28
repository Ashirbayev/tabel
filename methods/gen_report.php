<?php
	class REPORT
    {
        private $html;
        private function __construct()
        {
            $this->html = '';
        }
        
        public function add($dan)
        {
            $this->html .= $dan;
        }
        
        public function init()
        {
            return $this->html;
        }
        
        public function table($head, $params, $dan)
        {
            $h = '';
            $h .= '<table';
            if(count($params) > 0){
                foreach($params as $k=>$v){
                    $h .= $k.'="'.$v.'"';    
                }                 
            }
            
            $h.= '><thead><th>';
            foreach($head as $k=>$v){
                $h .= '<tr>'.$v.'</tr>';
            }
            $h .= '</th></thead><tbody>';
            
            foreach($dan as $k=>$v){
                $h.= '<tr>';
                foreach($v as $i=>$d){
                    $h.= '<td>'.$d.'</td>';
                }
                $h.= '</tr>';
            }            
            $h .= '</tbody></table>';
            $this->html .= $h;                                    
            
        }
        
    }
?>