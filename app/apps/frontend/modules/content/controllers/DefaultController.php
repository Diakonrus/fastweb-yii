<?php

class DefaultController extends Controller
{
	public $layout='//layouts/top';


    public function actionIndex(){

        //Обработка с формы обратной связи
        if (isset($_POST['TopSliderForm'])){
            if (!isset($_POST['TopSliderForm']['phone']) || empty($_POST['TopSliderForm']['phone'])){
                $this->error_slider_top .= '<div class="slide_form_error" style="left: 148px; top: 48px; display: block;">Вы не указали номер телефона.</div>';
            }
            if (!isset($_POST['TopSliderForm']['accept']) || $_POST['TopSliderForm']['accept'] == "off"){
                $this->error_slider_top .= '<div class="slide_form_error" style="left: 20px; top: 215px; display: block;">Пожалуйста, отметьте галочку</div>';
            }
            if (empty($this->error_slider_top)){
                //Ошибок нет - отправляем письмо
                $body_msg = '
                    <table style="border:1px solid black;">
                        <tr><td style="border:1px solid black; background:#9e9e9e;">Имя:</td><td style="border:1px solid black;">'.((!empty($_POST['TopSliderForm']['firstname']))?($_POST['TopSliderForm']['firstname']):('Не указан')).'</td></tr>
                        <tr><td style="border:1px solid black; background:#9e9e9e;">Причина обращения:</td><td style="border:1px solid black;">'.((!empty($_POST['TopSliderForm']['usertext']))?($_POST['TopSliderForm']['usertext']):('Не указана')).'</td></tr>
                        <tr><td style="border:1px solid black; background:#9e9e9e;">Номер телефона:</td><td style="border:1px solid black;">'.($_POST['TopSliderForm']['phone']).'</td></tr>
                        <tr><td style="border:1px solid black; background:#9e9e9e;">Время:</td><td style="border:1px solid black;">'.($_POST['TopSliderForm']['time']).'</td></tr>
                    </table>
                    ';

                $this->sendEmail('salesbt@mail.ru', 'Запись на консультацию', $body_msg);
            }
        }

        $this->render('index');
    }

	public function actionNoaccess()
	{
        $this->render('noaccess',array(
        ));
	}



}