<?php
	class TABLE
    {
        private $DB;
        public $colnames;
        public $rows;
        
        public $message = '';
        public $html;
        public $html2;        
        public $sql;
        public $arrayname = '';                
        public $colViews = array();
        public $notColViews = array();
        public $indexCol;
        public $URLOnDbClick = '';                
        
        public function __construct($db)
        {
            if(!$db){
                $this->DB = new DB();
            }else{
                $this->DB = $db;
            } 
            global $js_loader, $css_loader;           
            array_push($js_loader, 'styles/js/plugins/jqGrid/i18n/grid.locale-en.js', 'styles/js/plugins/jqGrid/jquery.jqGrid.min.js');
            array_push($css_loader,'styles/css/plugins/jqGrid/ui.jqgrid.css', 'styles/css/plugins/jQueryUI/jquery-ui-1.10.4.custom.min.css');            
            $this->html = '<div class="jqGrid_wrapper"><table id="table_list"></table><div id="pager_list"></div></div>'; 
        }            
        
        public function ViewResult()
        {            
            $this->html = '<div class="jqGrid_wrapper"><table id="'.$this->arrayname.'_table"></table><div id="'.$this->arrayname.'_panel"></div></div>';
                        
            $this->rows = $this->DB->Select($this->sql);
            if(count($this->rows) <= 0){
                $this->html = "<center><h1>Ничего не найдено</h1></center>";
                return false;                
            } 
            $this->message = $this->DB->message;
                                              
            $js = '
            $(document).ready(function(){
                $("#'.$this->arrayname.'_table").jqGrid({
                    data: '.$this->arrayname.',
                    datatype: "local",
                    height: 500,
                    autowidth: true,
                    shrinkToFit: true,
                    rowNum: 30,
                    rowList: [20, 50, 100],                
                    colNames:['.$this->ColNamesJs().'],                    
                    colModel:['.$this->ColModelJs().'],                    
                    pager: "#'.$this->arrayname.'_panel",
                    viewrecords: true,
                    hidegrid: false
            ';
            //Если 2 раза кликнули тогда прописываем переход на другую форму
            if(isset($this->indexCol)){
                $js .= ",".$this->GetProcedure('
                    var rowData = jQuery(this).getRowData(id); 
                    var cnct = rowData["'.$this->indexCol.'"];
                    cnct = cnct.replace(/&/g, "``");
                    cnct = cnct.replace(/#/, "__"); 
                    document.location.href = "'.$this->URLOnDbClick.'?'.$this->indexCol.'="+cnct;                    
                ');
            }
                                            
            $js .='
                });

                // Add selection
                $("#'.$this->arrayname.'_table").setSelection(4, true);        
    
                // Setup buttons
                //$("#'.$this->arrayname.'_table").jqGrid("navGrid", "#'.$this->arrayname.'_panel", {height: 200, reloadAfterSubmit: true});
                
                '.$this->NotViewsColumns(); //.$this->NotEditingTableJs().
                
            $js .='                                
                // Add responsive to jqGrid
                $(window).bind("resize", function () {
                    var width = $(".jqGrid_wrapper").width();                
                    $("#'.$this->arrayname.'_table").setGridWidth(width);
                });
                                                
            });';
            
            
            
            $js_params = "var ".$this->arrayname." = [".$this->VarJS()."];";            
            $result = "
                <script>
                    $js_params
                    $js
                </script>
            ";              
            global $othersJs;
            $othersJs .= $result;                                    
        }
        
        private function ColNamesJs()
        {    
            if(count($this->colViews) > 0){
              $cn = $this->colViews;
            }else{
              $cn = $this->rows;  
            }
            $i = 0;
            $name = '';            
            foreach($cn as $k=>$v){
                $z = '';
                if($i > 0){$z = ',';}
                $name .= "$z'$v'";
                $i++;                
            }
            return $name;                                    
        } 
        
        private function ColModelJs()
        {
            $cn = $this->rows[0];
            $i = 0;
            $name = '';            
            foreach($cn as $k=>$v){
                $z = '';
                if($i > 0){$z = ',';}
                $name .= "$z{name:'$k',index:'$k'}";
                $i++;                
            }
            return $name;
        }
        
        private function VarJS()
        {
            $js = '';
            $i = 0;
            foreach($this->rows as $k=>$v){                                  
                 $zp = '';
                 if($i > 0){$zp = ',';}                 
                 $js .= $zp."{";
                 
                 $s = 0;
                 foreach($v as $t=>$r){
                    $zp = '';
                    if($s > 0){$zp = ',';}                                        
                    $js .= "$zp $t:'$r'";
                    $s++;
                 }
                 $i++;
                 $js .= "}";
            }
            return $js;
        }
        
        private function NotEditingTableJs()
        {
            return 'jQuery("#'.$this->arrayname.'_table").jqGrid("navGrid","#'.$this->arrayname.'_panel",{edit:false,add:false,del:false});';
        }        
        
        private function NotViewsColumns()
        {                        
            $text = '';
            $cn = $this->notColViews;
            foreach($cn as $s){
                $text .= '$("#'.$this->arrayname.'_table").jqGrid("hideCol","'.strtoupper($s).'").trigger("reloadGrid");';
                //$text .= 'jQuery("#'.$this->arrayname.'_table").jqGrid("navGrid","hideCol","'.strtoupper($s).'");'; 
            }               
            return $text;
        }  
        
        private function GetProcedure($proc)
        {
            //return '$("#'.$this->arrayname.'_table").jqGrid("setGridParam", {ondblClickRow: function(rowid,iRow,iCol,e){console.log(e);}});';
            return 'ondblClickRow: function(id){'.$proc.'},';
        }      
    }
    
?>