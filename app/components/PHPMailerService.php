<?php

class PHPMailerService extends CApplicationComponent {



    public $From;
    public $FromName;
    public $AddAddress;
    public $AddReplyTo;
    public $CharSet;
    public $Host = "smtp.d-ed.ru";
    public $Port = 27;
    public $Username = "corp";
    public $Password="PwCorspEmail1";
    public $Subject;
    public $AltBody;
    public $Body;
    public $SMTPDebug=3;
    public $SMTPAuth=true;
    public $SMTPSecure='ssl';
    public $SetFrom="corp@d-ed.ru";


        function send($data = array())
        {
            //$this->Subject = $Subject;
            $this->Subject = $data['subject'];
            //$this->Body = $Body;
            $this->Body = $data['body'];
            $email = $data['email'];

            /*
            $this->Host = SettingsMail::model('name="host"')->find()->val;
            $this->Port = SettingsMail::model('name="port"')->find()->val;
            $this->Username = SettingsMail::model('name="username"')->find()->val;
            $this->Password = SettingsMail::model('name="password"')->find()->val;
            */

            $mail = Yii::createComponent('application.components.MailService.EMailer');
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = $this->SMTPDebug; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = $this->SMTPAuth;
            //$mail->SMTPSecure = $this->SMTPSecure;
            $mail->Host = $this->Host;
            $mail->Port = $this->Port; // or 587
            $mail->IsHTML(true);
            $mail->Username = $this->Username;
            $mail->Password = $this->Password;
            $mail->SetFrom($this->SetFrom);
            $mail->CharSet = "UTF-8";
            $mail->Subject = $this->Subject;
            $mail->Body = $this->Body;
            $mail->AddAddress($email);
            if(!$mail->Send())
            {
                $msg_result = "Mailer Error: " . $mail->ErrorInfo;
                print_r($msg_result);
                //die();
            }
            else
            {
                $msg_result = "Message has been sent";
            }
            return $msg_result;
        }
}

