<?php

class FormsController extends Controller
{
	public $layout='//layouts/main';

	public function actionIndex()
	{
        if (isset($_POST['CreatingForm'])){
            $error = '';
            $bodyMsg = array();
            foreach ($_POST['CreatingForm'] as $id=>$val){
                $model = CreatingFormElements::model()->findByPk($id);
                //Проверяю, является ли поле обязательным и заполнено ли оно
                if ( $model->feeld_require == 1 && empty($val) ){
                    $error .= 'Поле `'.$model->name.'` обязательно для заполнения!'."\n";
                    continue;
                }
                //Если поле E-mail - проверяю, что ввели email
                if ( $model->feeld_type == 1 ){
                    preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $val, $match);
                    if (empty($match)){
                        $error .= 'В поле `'.$model->name.'` указан неверный электронный адрес!'."\n";
                        continue;
                    }
                }

                //Пишем тело письма
                $bodyMsg[$model->name] = $val;
            }
            $answer = '';
            if ( !empty($error) ){
                //Есть ошибки - возвращаем их пользователю
                $answer = $error;
            } else {
                //Ошибок нет - отправляем письмо на почту
                $answer = ((empty($model->parent->complete_mess))?('Спасибо! Данные оправлены.'):($model->parent->complete_mess));
                $email = $model->parent->email_recipient;
                $title = $model->parent->subject_recipient;
                if (!empty($email) && !empty($title)){
                    preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $email, $match);
                    if (!empty($match)){
                        $body = 'Сообщение с формы '.$model->parent->name.' сайта: '.SITE_NAME_FULL.'<BR>';
                        $body .= '
                        <table border="1">
                            <thead>
                                <th style="padding: 10px; background: #808080;">Поле</th>
                                <th style="padding: 10px;">Ответ</th>
                            </thead>
                            <tbody>
                        ';
                        foreach ($bodyMsg as $name => $val){
                            $body .= '
                                <tr>
                                    <td style="padding: 10px; background: #808080;">'.$name.'</td>
                                    <td style="padding: 10px;" >'.$val.'</td>
                                </tr>';
                        }

                        $body .= '</tbody></table>';
                        $body .= '<BR>Дата заполнения отчета:'.(date('d-m-Y H:i:s'));
                        Yii::app()->mailer->send(array('email'=>$email, 'subject'=>$title, 'body'=>$body));
                    }
                }
            }


            echo CJavaScript::jsonEncode($answer);
        }
        Yii::app()->end();
	}
}