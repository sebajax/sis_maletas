<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/phpexcel/PHPExcel.php";

/**
 * Description of excel
 *
 * @author sebastianituartebonfrisco
 */
class excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * $header array(letra, info)
     * $body array(array(info))
     * $title string titulo excel
     */
    public function crearExcel($header, $body, $title) {
        $objPHPExcel = new excel();
        //activate worksheet number 1
        $objPHPExcel->setActiveSheetIndex(0);        
        //name the worksheet
        $objPHPExcel->getActiveSheet()->setTitle($title);
        //header
        foreach($header as $key => $row) {
            $objPHPExcel->getActiveSheet()->setCellValue($this->letraExcel($key)."1", $row);
        }
        //body
        $i = 2;
        foreach ($body as $result) {
            foreach($result as $key => $row) {
                $letra = $this->letraExcel($key);
                $objPHPExcel->getActiveSheet()->setCellValue($letra.$i, $row);
            }
            $i++;
        }
        
        $filename=$title.date('YmdHis')."xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache        
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        ob_end_clean();
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        exit();
    }
    
    private function letraExcel($key) {
        $letra = '';
        switch($key) {
            case 0: $letra = 'A'; break;
            case 1: $letra = 'B'; break;
            case 2: $letra = 'C'; break;
            case 3: $letra = 'D'; break;
            case 4: $letra = 'E'; break;
            case 5: $letra = 'F'; break;
            case 6: $letra = 'G'; break;
            case 7: $letra = 'H'; break;
            case 8: $letra = 'I'; break;
            case 9: $letra = 'J'; break;
            case 10: $letra = 'K'; break;
            case 11: $letra = 'L'; break;
            case 12: $letra = 'M'; break;
            case 13: $letra = 'N'; break;
            case 14: $letra = 'O'; break;
            case 15: $letra = 'P'; break;
            case 16: $letra = 'Q'; break;
            case 17: $letra = 'R'; break;
            case 18: $letra = 'S'; break;
            case 19: $letra = 'T'; break;
            case 20: $letra = 'U'; break;
            case 21: $letra = 'V'; break;
            case 22: $letra = 'W'; break;
            case 23: $letra = 'X'; break;
            case 24: $letra = 'Y'; break;
            case 25: $letra = 'Z'; break;
        }
        return $letra;
    }
}
