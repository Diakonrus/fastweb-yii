<?php

class PDFService extends CApplicationComponent
{

    //public $pdfPath = '/var/www/in-tub/data/www/yii.in-tub.ru/uploads/filestorage/pdf/';
    public $pdfPath;

    public $orientation = 'L';
    public $format = 'A4';

    public function generate($html)
    {
        $this->pdfPath = YiiBase::getPathOfAlias('webroot').'/uploads/filestorage/pdf/';
        /** @var HTML2PDF $html2pdf */
        $html2pdf = Yii::app()->ePdf->HTML2PDF($this->orientation, $this->format);
        $html2pdf->setDefaultFont('freesans');
        $html2pdf->WriteHTML($html);
        $fileName = md5(uniqid('pdf')) . '.pdf';
        $html2pdf->Output($this->pdfPath . $fileName, 'F');
        return $fileName;
    }

}