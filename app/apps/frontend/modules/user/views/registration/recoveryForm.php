<div class="block_content">
    <div class="text">
        <h1>Восстановление пароля</h1>

        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'remind-password-form'
        )); ?>

        Для восстановления забытого пароля укажите Ваш логин или адрес электронной почты и нажмите на кнопку "Отправить".<BR>
        Будет сгенерирован новый пароль и отправлен на ваш e-mail.<BR>

        Введите имя пользователя или e-mail:*<BR>

        <div>
            <?php echo $form->textField($model, 'email', array('class'=>'inp', 'placeholder' => 'Введите email')); ?>
            <?php if($model->hasErrors('email')): ?><span class="help-inline"><?php echo $model->getError('email') ?></span><?php endif ?>
        </div>


        <div class="row">
            <?php echo CHtml::submitButton('Восстановить', array( 'class' => 'send', 'style' => "margin-left:10px; padding:5px;" )); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>
