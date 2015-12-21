<?php

class MailService extends CApplicationComponent {

    public $smtp = array();
    public $host = 'localhost:25';
    public $sender = 'noreply@server.ru';
    public $name_sender = 'Robot';
    public $pathViews = null;
    public $pathLayouts = null;

    public function send($data = array()) {

        $mailer = Yii::createComponent('application.components.MailService.EMailer');

        $mailer->IsHTML(true);

        if (is_array($this->smtp)) {
            $mailer->IsSMTP();

            if (!empty($this->smtp)) {
                //
            }
        }

        $mailer->From = $this->sender;
        $mailer->FromName = $this->name_sender;
        $mailer->AddReplyTo($this->sender);
        $mailer->AddAddress($data['email']);
        $mailer->Subject = $data['subject'];
        $mailer->CharSet = 'UTF-8';
        $mailer->Body = $data['body'];
        $mailer->Send();
        return true;
    }
}

