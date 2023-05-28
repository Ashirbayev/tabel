<?php
	require_once dirname(__FILE__).'/Excel/PHPExcel.php';
    
    class EXCEL
    {
        private $db;
        private $excel;
        public $filename;
        
        public function __construct()
        {
            $this->db = new DB3();
            $this->excel = new PHPExcel();    
        }
        
        public function createfile($name)
        {
            if($name == ''){
                $s = date();
                $s = sha1($s);
                $filename = $s.".xlsx";
            }else{
                $filename = $name.".xlsx";
            }
            $this->filename = $filename;
            
            $this->excel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
            
            echo date('H:i:s') , " Add some data" , EOL;
            $this->excel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'Hello')
                        ->setCellValue('B2', 'world!')
                        ->setCellValue('C1', 'Hello')
                        ->setCellValue('D2', 'world!');
            // Miscellaneous glyphs, UTF-8
            $this->excel->setActiveSheetIndex(0)
                        ->setCellValue('A4', 'Miscellaneous glyphs')
                        ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
            // Rename worksheet
            echo date('H:i:s') , " Rename worksheet" , EOL;
            $this->excel->getActiveSheet()->setTitle('Simple');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $this->excel->setActiveSheetIndex(0);
            // Save Excel 2007 file
            echo date('H:i:s') , " Write to Excel2007 format" , EOL;
            $callStartTime = microtime(true);
            
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
            $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
            $callEndTime = microtime(true);
            $callTime = $callEndTime - $callStartTime;
            echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
            echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
            // Echo memory usage
            echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
            // Save Excel5 file
            echo date('H:i:s') , " Write to Excel5 format" , EOL;
            $callStartTime = microtime(true);
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save(str_replace('.php', '.xls', __FILE__));
            $callEndTime = microtime(true);
            $callTime = $callEndTime - $callStartTime;
            echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
            echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
            // Echo memory usage
            echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
            // Echo memory peak usage
            echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;
            // Echo done
            echo date('H:i:s') , " Done writing files" , EOL;
            echo 'Files have been created in ' , getcwd() , EOL;                                                
        }
        
    }
    
    $e = new EXCEL();
    $e->createfile('');
?>