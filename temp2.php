<?php

    require_once 'include/connect.php'; 
    require_once 'include/function.php';
    export();
    function export() {
        global $database;
        
        $data = $database->selects("sell a inner join sell_date b on a.sell_date_id = b.sell_date_id", "where b.sell_date > '2018-05-14' and b.sell_date < '2018-09-25' and  a.type_pay = 2 and a.status = 1 and  a.status_pay = 2 group by a.sell_id");
//        pr(count($data));
//        pr($data[0]);exit;
        require_once 'vendor/PHPExcel/Classes/PHPExcel.php';
        $objWorkbook = new PHPExcel();
        
        //Create Work Sheet
        $objWorkSheet = $objWorkbook->createSheet();        
        // Rename worksheet
        $objWorkSheet->setTitle("Sheet1");
        
        
        $columns[] = ['text' => "sell_id", 'width' => '15'];
        $columns[] = ['text' => "วันที่สั่ง", 'width' => '15'];
        $columns[] = ['text' => "แหล่งที่มา", 'width' => '20'];
        $columns[] = ['text' => "ชื่อแหล่งที่มา", 'width' => '40'];
        $columns[] = ['text' => "ชื่อ- นามสกุล", 'width' => '40'];        
        $columns[] = ['text' => "เบอร์โทร", 'width' => '40'];
        $columns[] = ['text' => "COD", 'width' => '20'];
        $columns[] = ['text' => "ร้านส่ง", 'width' => '20'];
        $columns[] = ['text' => "เลขพัสดุ", 'width' => '40'];
        
        
        $row = 1;
        $index = "A";
        $styleborder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );        
       
        
        foreach ($columns as $column) {           
            $objWorkSheet->setCellValue($index . $row, $column['text']);                    
            $objWorkSheet->getStyle($index . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => (isset($column['background']) ? $column['background'] : "FDE9D9"))
                        ),
                        'font' => array(
                            'bold' => true,
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        )
                    )
            );
            $objWorkSheet->getColumnDimension($index)->setWidth($column['width']);
            $objWorkSheet->getStyle($index . $row)->applyFromArray($styleborder);
            $index++; // index of excel column
        }
        
        
       
        
        $row = 2;
        foreach ($data as $key => $value) {
            $index = "A";
            $objWorkSheet->setCellValue($index++ . $row, $value['sell_id']);
            $objWorkSheet->setCellValue($index++ . $row, $value['sell_date']);
            $objWorkSheet->setCellValue($index++ . $row, $value['refer']);
            $objWorkSheet->setCellValue($index++ . $row, $value['name_refer']);
            $objWorkSheet->setCellValue($index++ . $row, $value['customer_name']);
            $objWorkSheet->setCellValue($index++ . $row, $value['customer_tel']);
            $objWorkSheet->setCellValue($index++ . $row, $value['customer_pay']);
            $objWorkSheet->setCellValue($index++ . $row, $value['partner']);
            $objWorkSheet->setCellValue($index++ . $row, "");
            

            $row++;
        }
        
        
        
        
        // output excel
        $download_name = "horse-".date('Y-m-d')."_".time();
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $download_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        //        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Expires: 0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        
        $objWorkbook->setActiveSheetIndex(0);
        $objWorkbook->removeSheetByIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objWorkbook, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        
    }
