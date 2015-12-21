<h3 style="font-family:Arial; font-size: 15px; color: #888888; margin-top:0;line-height: 22px">Здравствуйте, <?php echo $model->first_name ?>!</h3>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    На сайте <?php echo CHtml::link( $_SERVER['HTTP_HOST'] , Yii::app()->createAbsoluteUrl('/')) ?> по Вашему запросу был изменен пароль.
</p>

<p style="font-family:Arial; font-size: 15px; color: #888888;line-height: 22px">
    Ваш новый пароль для входа на сайт:<b><?=$password; ?></b>
</p>