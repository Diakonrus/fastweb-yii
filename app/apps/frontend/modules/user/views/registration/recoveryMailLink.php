<h3 style="font-family:Arial; font-size: 15px; color: #888888; margin-top:0;line-height: 22px">Здравствуйте, <?php echo $model->first_name ?>!</h3>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Команде поддержки сайта <?php echo CHtml::link( $_SERVER['HTTP_HOST'] , Yii::app()->createAbsoluteUrl('/')) ?> поступила информация об изменении пароля, указанного Вами при регистрации.
</p>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Если это действительно так, пройдите по <a style="color: #207dbc; text-decoration: underline;" href="<?php echo Yii::app()->createAbsoluteUrl('/recoverypassword/' . $model->recovery_code ) ?>"><strong>ссылке</strong></a> для восстановления доступа.
</p>