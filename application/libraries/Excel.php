<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Description of Excel
 *
 * @author sebastian.ituarte@gmail.com
 */

class Excel {

    /*    
         * $header array(letra, info)
         * $body array(array(info))
         * $title string titulo excel
    */     
    public function crearExcel($header, $body, $title) {
        $spreadsheet = new Spreadsheet();
        
        //Header Styles Array
        $styleArrayFirstRow = [
            'font' => [
                'bold' => true,
            ]
        ];    
        
        //Row Styles Array
        $styleArrayAllRow = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];          
        
        // Set document properties
        $spreadsheet->getProperties()->setCreator('Sistema Maletas - version'.VERSION)
            ->setLastModifiedBy('Sistema Maletas - version'.VERSION)
            ->setTitle('XLS '.$title)
            ->setSubject('XLS '.$title)
            ->setDescription('Documento excel generado por'. 'Sistema Maletas - version'.VERSION);
 
        //Header
        foreach($header as $key => $row) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->letraExcel($key)."1", $row);
        }
        
        //Body
        $i = 2;
        foreach ($body as $result) {
            foreach($result as $key => $row) {
                $letra = $this->letraExcel($key);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue($letra.$i, $row);
            }
            $i++;
        }
        
        //Retrieve Highest Column / Row (e.g AE)
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();        
        $highestRow    = $i-1;
        
        //Autosizing columns
        foreach(range('A', $highestColumn) as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        //Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle($title);
        
        //set first row bold
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$highestColumn.'1')->applyFromArray($styleArrayFirstRow);
        
        //align left data on spreadsheet
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$highestColumn.$highestRow)->applyFromArray($styleArrayAllRow);
        
        //Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);        
        
        //Redirect output to a client’s web browser (Xls)
        $filename=$title.date('YmdHis').".xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache        
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');     
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
