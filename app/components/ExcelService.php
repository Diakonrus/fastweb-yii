<?php
 /* Инициализация: $xls = Yii::app()->excel->create();
 *  Запись: Yii::app()->excel->save($xls, Yii::app()->baseUrl.'export/');  1 параметр - данне которые надо записать на лист (строятся через create), 2 - путь куда сохранять файл, 3-тип файла эксель, по умолчанию сохраняет как эксель 2007
 */

class ExcelService extends CApplicationComponent {

    public function init(){
    }

    /*
     * инициирует и устанавливает первичные данные документа
     */
    public function create ($page_name='Лист 1') {

        require_once (__DIR__ .'/ExcelService/PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        //начальные хначения докумена/страницы
        $objPHPExcel->getProperties()->setCreator("PHP")
            ->setLastModifiedBy("UPMC")
            ->setTitle($page_name)
            ->setSubject($page_name)
            ->setDescription($page_name)
            ->setKeywords($page_name)
            ->setCategory($page_name);
        return $objPHPExcel;
    }

    /*
     * сохраняет документ
     */
    public function save ($data=array(), $patch_to_file=NULL, $type_file="Excel2007") {
        /* $data - данные для записи на лист, создаются через функцию create
         * $patch_to_file - путь куда писать файл
         * $type_file - тип сохраняемого экселевского файла. По усолчанию сохраняеется как файл офиса 2007, для сохранения как эксель 97-2003 укажите 'Excel5'
         */

        require_once (__DIR__ .'/ExcelService/PHPExcel/IOFactory.php');
        $objWriter = PHPExcel_IOFactory::createWriter($data, $type_file);
        $atr_file = ($type_file=="Excel2007") ? 'xlsx' : 'xls';
        $file_name=md5(date('yyyy-mm-dd hh:mm:ss'));
        $file_excel = $file_name.'.'.$atr_file;
        $objWriter->save($patch_to_file.'/'.$file_excel);
        return $file_excel;
    }

    /*
     * Импорт докуменета
     */
    public function importInit($patch_to_file){
        require_once (__DIR__ .'/ExcelService/PHPExcel/IOFactory.php');
        $objPHPExcel = PHPExcel_IOFactory::load($patch_to_file);
        $arrayData = array();
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
        {
            $highestRow         = $worksheet->getHighestRow();
            $highestColumn      = $worksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            for ($row = 1; $row <= $highestRow; ++ $row){
                for ($i=0; $i<=$highestColumnIndex; ++$i){
                    $arrayData[$row][$i] = trim($worksheet->getCellByColumnAndRow($i, $row)->getValue());
                    //$arrayData[$row][$i] = iconv ('utf-8', $code_tyle, $arrayData[$row][$i]);
                }

            }
        }

        return $arrayData;
    }

}

