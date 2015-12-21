<div class="block_content">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'login-form'
)); ?>

<div class="kabinet">
    <h1>Вход в кабинет</h1>
</div>

<?php if( Yii::app()->user->getFlash('accept_email_message') ): ?>
<div class="row accept-message">
    Ссылка для активации аккаунта отправлена на ваш email
</div>
<?php endif ?>

<div class="row control-group <?php echo $model->hasErrors('username') ? 'error' : '' ?>" style="padding-bottom: 40px;">
    <span class="row_name">Имя пользователя (логин):</span>
    <div class="input">
        <?php echo $form->textField($model, 'username', array('class'=>'inp', 'placeholder' => 'Введите email')); ?>
        <?php if($model->hasErrors('username')): ?><span class="help-inline"><?php echo $model->getError('username') ?></span><?php endif ?>
    </div>
</div>

<div class="row control-group <?php echo $model->hasErrors('password') ? 'error' : '' ?>" style="padding-bottom: 40px;">
    <span class="row_name">Ваш пароль:</span>
    <div class="input">
        <?php echo $form->PasswordField($model, 'password', array('class'=>'inp', 'placeholder' => 'Введите пароль')); ?>
        <?php if($model->hasErrors('password')): ?><span class="help-inline"><?php echo $model->getError('password') ?></span><?php endif ?>
    </div>
</div>

<div class="row control-group " style="padding-bottom: 10px;">
    <label>
    <?php echo $form->Checkbox($model, 'rememberMe'); ?> Запомнить
    </label>
</div>


    <p>
        <a href="/login/restore">Восстановить пароль</a>
        |
        <a href="/register">Зарегистрироваться</a>
    </p>


<div class="row">
     <?php echo CHtml::submitButton('Войти', array( 'class' => 'button', 'style'=>'padding:10px;' )); ?>
</div>

<?php $this->endWidget(); ?>

</div>