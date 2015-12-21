<?php

class SmsService extends CApplicationComponent {

    public $phone = array();
    public $text;

    public function setPhone($phone){
        $this->phone[] = $phone;
        return true;
    }
    public function setText($text){
        $this->text = $text;
        return true;
    }

    /**
    С помощью массива $params, помимо текста сообщения, можно передать следующие параметры:
    action — принимает значения 'send' (отправить СМС, выбрано по-умолчанию) или 'check' (только проверить возможность отправки);
    datetime — дата и время отправки смс в формате (ГГГГ-ММ-ДД ЧЧ:ММ:СС);
    source — имя отправителя;
    onlydelivery (по-умолчанию 0 — платить за все смски, можно задать 1 — платить только за доставленные);
    regionalTime (по-умолчанию 0 — отправлять по вашему местному времени, можно задать 1 — отправлять по местному времени абонента);
    stop (по-умолчанию 1 — не отправлять абонентам, находящимся в Стоп-листах);
    smsid — желаемый id смски;
    use_alfasource (1 - отправлять через дорогой канал с согласованным именем отправителя. 0 - дешёвый канал.).
    allowed_opsos - перечисление операторов сотовой связи, которым можно отправлять это сообщение, через запятую, без пробелов.
    Например: "megafon,beeline". Остальным операторам сообщение отправляться не будет.
    exclude_opsos - перечисление операторов сотовой связи, которым запрещено отправлять это сообщение, через запятую, без пробелов.
    Например: "megafon,beeline". Остальным операторам сообщение будет отправлено.
     */
    public function sendsms(){

        if($this->phone == null || $this->text == null) { return false; exit; }
        require_once (__DIR__ .'/SmsService/transport.php');
        $api = new Transport();
        /*
        $params = array(
            "text" => $text
        );
        */
        //$send = $api->send($params,$phones);
        $send = $api->send(array('text'=>$this->text),$this->phone);
        return $send;

    }


}



