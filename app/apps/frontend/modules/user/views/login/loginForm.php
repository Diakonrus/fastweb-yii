<?
$this->pageTitle = 'Авторизация - '.$_SERVER['HTTP_HOST'];
?>

<h1 class="lined nopaddingtop" style="margin-top: 10px;">Авторизация</h1>

<div class="block_content">

	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		  'id'=>'login-form'
	)); ?>


	<?php if( Yii::app()->user->getFlash('accept_email_message') ): ?>
	<div class="row accept-message">
		  Ссылка для активации аккаунта отправлена на ваш email
	</div>
	<?php endif ?>




	<div class="form-group <?php echo $model->hasErrors('username') ? 'error' : '' ?>">
		<label>Имя пользователя (логин):</label>
		<?php echo $form->textField($model, 'username', array('class'=>'form-control', 'placeholder' => 'Введите email')); ?>
		<?php if($model->hasErrors('username')): ?><span class="help-inline"><?php echo $model->getError('username') ?></span><?php endif ?>
	</div>
	



	<div class="form-group <?php echo $model->hasErrors('password') ? 'error' : '' ?>">
		<label>Ваш пароль:</label>
		<?php echo $form->PasswordField($model, 'password', array('class'=>'form-control', 'placeholder' => 'Введите пароль')); ?>
		<?php if($model->hasErrors('password')): ?><span class="help-inline"><?php echo $model->getError('password') ?></span><?php endif ?>
	</div>
	



	<div class="form-group">
		<label>
			<?php echo $form->Checkbox($model, 'rememberMe'); ?> Запомнить
		</label>
	</div>

	<div class="form-group">
		<?php echo CHtml::submitButton('Войти', array( 'class' => 'btn btn-primary')); ?>
	</div>
	
    <p>
        <a href="/login/restore">Восстановить пароль</a>
        |
        <a href="/register">Зарегистрироваться</a>
    </p>




<?php $this->endWidget(); ?>

</div>
