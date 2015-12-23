<?php

class PayService extends CApplicationComponent {


    private  $lang = "ru"; //Указываем локализацию (доступно ru | en | fr)
    private $MerchantId = '57211'; // Указываем идентификатор мерчанта
    private $key = '3df0c3fa-de74-4548-8a5f-910883691c6f'; //Указываем приватный ключ (см. в ЛК PayOnline в разделе Сайты -> настройка -> Параметры интеграции)

    private $numOrder = '1242212й33';  //Номер заказа (Строка, макс.50 символов)
    private $currency = 'RUB'; //Валюта (доступны следующие валюты | USD, EUR, RUB)

    private $descript = ""; //Описание заказа (не более 100 символов, запрещено использовать: адреса сайтов, email-ов и др.) необязательный параметр

    private $FailUrl = "http://payonline.ru"; //В случае неуспешной оплаты, плательщик будет переадресован, на данную страницу.
    private $succesUrl = "yandex.ru"; // В случае успешной оплаты, плательщик будет переадресован, на данную страницу.

    public function setparam($param = array()){
        if (empty($param)){return false;}
        if (isset($param['lang'])){$this->lang = $param['lang'];}
        if (isset($param['MerchantId'])){$this->MerchantId = $param['MerchantId'];}
        if (isset($param['key'])){$this->key = $param['key'];}
        if (isset($param['numOrder'])){$this->numOrder = $param['numOrder'];}
        if (isset($param['currency'])){$this->currency = $param['currency'];}
        if (isset($param['descript'])){$this->descript = $param['descript'];}
        if (isset($param['FailUrl'])){$this->FailUrl = $param['FailUrl'];}
        if (isset($param['succesUrl'])){$this->succesUrl = $param['succesUrl'];}
        return true;
    }

    public function sendpay($sum=0){
        if (empty($this->numOrder) || $sum==0){
            return false;
        }

        require_once (__DIR__ .'/PayService/payment.class.php');
        $Language = $this->lang;
        $MerchantId=$this->MerchantId;
        $PrivateSecurityKey=$this->key;
        $OrderId = $this->numOrder;
        $Currency=$this->currency;
        $Amount=$sum; //Сумма к оплате (формат: 2 знака после запятой, разделитель ".")
        $OrderDescription=$this->descript;
        //Срок действия платежа (По UTC+0) необязательный параметр
        //$ValidUntil="2013-10-10 12:45:00";

        $FailUrl=$this->FailUrl;
        $ReturnUrl=$this->succesUrl;

        //Создаем класс
        $pay = new GetPayment;
        //Показываем ссылку на оплату
        $result=$pay->GetPaymentURL(
            $pay->Language=$Language,
            $pay->MerchantId=$MerchantId,
            $pay->PrivateSecurityKey=$PrivateSecurityKey,
            $pay->OrderId=$OrderId,
            $pay->Amount=number_format($Amount, 2, '.', ''),
            $pay->Currency=$Currency,
            $pay->OrderDescription=$OrderDescription,
            //$pay->ValidUntil=$ValidUntil,
            $pay->ReturnUrl=$ReturnUrl,
            $pay->FailUrl=$FailUrl);

        return "<meta http-equiv='refresh'  content=\"0; URL=".$result."\">";
    }


}



