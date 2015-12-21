<?php

class Parsfile extends CApplicationComponent {

    public $XmlMask;
    public $OutArr;
    public $Xml;
    public $XmlMap = array();
    public $XmlFields;
    public $XmlFieldsAdd;
    public $MaxColsArray;
    public $XmlAntiMap;
    public $XmlFieldsHash;
    public $XmlFieldsLine;

    public function pars_exel($tfile){
        require_once (__DIR__ .'/ExcelService/PHPExcel.php');
        require_once (__DIR__ .'/ExcelService/PHPExcel/IOFactory.php');
        $item = null;
        $OutArr = null;
        $MaxCols = 0;
        $objPHPExcel = PHPExcel_IOFactory::load($tfile);
        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();
        foreach($aSheet->getRowIterator() as $row){
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach($cellIterator as $cell){
                $tmp = iconv('utf-8', 'cp1251', $cell->getCalculatedValue());
                if(trim($tmp) != '') $item[] = $tmp;
                else $item[] = ' ';
            }
            if(count($item)>0)
                if(count($item)>$MaxCols)$MaxCols = count($item);
            if(count($item)>0)$OutArr[] = $item;
            $item = null;
        }
        foreach($OutArr as $k => $v){
            if(count($OutArr[$k]) < $MaxCols){
                $razn = $MaxCols - count($OutArr[$k]);
                while($razn > 0){
                    $OutArr[$k][] = '&#160;';
                    $razn --;
                }
            }
        }
        $MaxColsCount = 1;
        while($MaxCols > 0){
            $MaxColsArray[] = $MaxColsCount;
            $MaxCols--;
            $MaxColsCount++;
        }
        $this->MaxColsArray = $MaxColsArray;
        $this->OutArr = $OutArr;
    }
    public function pars_csv($tfile,$splitter){
        $output = null;
        $MaxColsArr = null;
        $MaxColsArray = null;
        $MaxCols = 0;
        $descr = fopen($tfile, 'r');

        while($line=fgets($descr, 10000)){
            $TmpArr = null;
            $TmpArr = explode($splitter,$line);
            $output[] = $TmpArr;
            if(count($TmpArr) > $MaxCols){$MaxCols = count($TmpArr);}
        }
        fclose($descr);

        $MaxColsCount = 1;
        while($MaxCols > 0){
            $MaxColsArray[] = $MaxColsCount;
            $MaxCols--;
            $MaxColsCount++;
        }
        $this->MaxColsArray = $MaxColsArray;
        $this->OutArr = $output;
    }
    public function pars_xml_one($tfile){
        $XMLbuffer = '';
        unset($preout);
        $xmlfile = fopen($tfile, 'r');
        $coun = 0;
        while (!feof($xmlfile)) {
            $XMLbuffer .= fgets($xmlfile);
            $coun++;
        }
        fclose($xmlfile);
        unset($XmlMask);
        //$XMLbuffer = iconv("utf-8","cp1251//IGNORE",$XMLbuffer);
        $p = xml_parser_create();
        xml_parse_into_struct($p,$XMLbuffer,$vals,$index);
        xml_parser_free($p);
        $OpenFlag = 0;
        foreach($vals as $k => $v){
            $XmlMask[] = $v['tag'];
            //foreach($v['attributes'] as $K => $V){$XmlMask[] = $K;}
        }
        $this->XmlMask = array_unique($XmlMask);
    }
    public function pars_xml($tfile, $xmltag){
        $XMLbuffer = '';
        $xmlfile = fopen($tfile, 'r');
        $coun = 0;
        while (!feof($xmlfile)) {
            $XMLbuffer .= fgets($xmlfile);
            $coun++;
        }
        fclose($xmlfile);
        //$XMLbuffer = iconv("utf-8","cp1251//IGNORE",$XMLbuffer);
        $ss = htmlspecialchars($XMLbuffer);
        //print $tfile.'||||||||||||||'.$ss;die;
        $p = xml_parser_create();
        xml_parse_into_struct($p,$XMLbuffer,$vals,$index);
        xml_parser_free($p);
        //print "<pre>";print_r($vals);die;
        $parsTypeFlag = 0;
        $parsTypeFlag2 = 0;
        $RarcCounter = 0;
        foreach($vals as $k => $v){

            if($parsTypeFlag < 9){

                if(trim($v['tag']) == trim($xmltag)){
                    if (isset($v['value'])){
                        $v['value'] = iconv("utf-8","cp1251//IGNORE",$v['value']);
                        $this->XmlMap[] = 'value';
                        $this->XmlFields[] = $v['value'];
                        $this->XmlFieldsHash[$RarcCounter]['value'] = $v['value'];
                        $this->XmlFieldsAdd[$RarcCounter][] = $v['value'];
                    }
                    if (isset($v['attributes'])){
                        foreach($v['attributes'] as $K => $V){
                            $this->XmlMap[] = $K;
                            $V = iconv("utf-8","cp1251//IGNORE",$V);
                            $this->XmlFields[] = $V;
                            $this->XmlFieldsAdd[$RarcCounter][] = $V;
                            $this->XmlFieldsHash[$RarcCounter][$K] = $V;
                        }
                    }
                    if(isset($v['type']) && $v['type'] == 'complete'){
                        $parsTypeFlag = 9;
                    }elseif(isset($v['type']) && $v['type'] == 'open'){
                        $parsTypeFlag = 2;
                        unset($TmpArray);
                    }elseif(isset($v['type']) && $v['type'] == 'close' && $parsTypeFlag == 2){
                        $parsTypeFlag = 9;
                    }
                }
                $RarcCounter++;
            }else{
                if(trim($v['tag']) == trim($xmltag)){
                    if (isset($v['value'])){
                        $v['value'] = iconv("utf-8","cp1251//IGNORE",$v['value']);
                        $this->XmlFieldsAdd[$RarcCounter][] = $v['value'];
                        $this->XmlFieldsHash[$RarcCounter]['value'] = $v['value'];
                        //$this->XmlFieldsHash[$RarcCounter][$k] = $v['value'];
                    }
                    if (isset($v['attributes'])){
                        foreach($v['attributes'] as $K => $V){
                            $V = iconv("utf-8","cp1251//IGNORE",$V);
                            $this->XmlFieldsAdd[$RarcCounter][] = $V;
                            $this->XmlFieldsHash[$RarcCounter][$K] = $V;
                        }
                    }

                    if(isset($v['type']) && $v['type'] == 'complete'){
                        $parsTypeFlag2 = 9;
                    }elseif(isset($v['type']) && $v['type'] == 'open'){
                        $parsTypeFlag2 = 2;
                        unset($TmpArray);
                    }elseif(isset($v['type']) && $v['type'] == 'close' && $parsTypeFlag2 == 2){
                        $parsTypeFlag2 = 9;
                    }
                    $RarcCounter++;
                }
            }
        }
        //print "<pre>";print_r($this->XmlFieldsHash);
        foreach($this->XmlMap as $k => $v){
            $this->Xml[$v] = $this->XmlFields[$k];
            $this->XmlAntiMap[$v] = $k;
        }
        foreach($this->XmlFields as $k => $v){
            $this->XmlFieldsLine[$k+1] = $v;
        }
        //print "<pre>";print_r($this->XmlFieldsAdd);
        //print "<pre>";print_r($this->XmlFieldsAdd);
        $this->OutArr = $this->Xml;
        $this->MaxColsArray = count($this->XmlMap);
    }

}
?>