<?
$this->pageTitle = 'Регистрация на сайте - '.$_SERVER['HTTP_HOST'];
?>

<h1 class="lined nopaddingtop" style="margin-top: 10px;">Регистрация</h1>












<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'registration-form'
)); ?>



<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#fizlic" role="tab" data-toggle="tab">Физическое лицо</a></li>
    <li><a href="#urlic" role="tab" data-toggle="tab">Юридическое лицо</a></li>
  </ul>

	<div style="padding:15px; padding-bottom: 0px;">
	
	
		<div class="form-group  <?php echo $model->hasErrors('email') ? 'error' : '' ?>">
			<label>Введите E-Mail адрес (на него будет выслан пароль): <span class="red">*</span></label>
			<?=$form->textField($model, 'email', array('class'=>'form-control', 
			                                           'placeholder' => 'Введите email')); ?>
			<?php if($model->hasErrors('email')): ?>
				<span class="help-inline">
					<?php echo $model->getError('email') ?>
				</span>
			<?php endif ?>
		</div>



		<div class="form-group <?php echo $model->hasErrors('first_name')?'error':''?>">
			<label>Имя: <span class="red">*</span></label>
			<?=$form->textField($model, 'first_name', array('class'=>'form-control', 
			                                                'placeholder' => 'Введите имя'));?>
			<?php if($model->hasErrors('first_name')): ?>
				<span class="help-inline">
					<?php echo $model->getError('first_name') ?>
				</span>
			<?php endif ?>
		</div>



	</div>


	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="fizlic"></div>
		<div role="tabpanel" class="tab-pane" id="urlic" style="padding-left: 15px; padding-right: 15px;">




			<div class="form-group <?php echo $model->hasErrors('organization')?'error':''?>">
				<label>Организация:</label>
				<?=$form->textField($model, 'organization', array('class'=>'form-control',
				                                                  'placeholder' => 'Укажите организацию')); ?>
				<?php if($model->hasErrors('organization')): ?>
					<span class="help-inline">
						<?php echo $model->getError('organization') ?>
					</span>
				<?php endif ?>
			</div>





			<div class="form-group <?php echo $model->hasErrors('ur_addres')?'error':''?>">
				<label>Юридический адрес:</label>
				<?=$form->textField($model, 'ur_addres', array('class'=>'form-control', 
				                                               'placeholder' => 'Укажите юридический адрес')); ?>
				<?php if($model->hasErrors('ur_addres')): ?>
					<span class="help-inline">
						<?php echo $model->getError('ur_addres') ?>
					</span>
				<?php endif ?>
			</div>







			<div class="form-group <?php echo $model->hasErrors('fiz_addres')?'error':''?>">
				<label>Физический адрес:</label>
				<?=$form->textField($model, 'fiz_addres', array('class'=>'form-control', 
				                                                'placeholder' => 'Укажите физический адрес')); ?>
				<?php if($model->hasErrors('fiz_addres')): ?>
					<span class="help-inline">
						<?php echo $model->getError('fiz_addres') ?>
					</span>
				<?php endif ?>
			</div>






			<div class="form-group <?php echo $model->hasErrors('inn')?'error':''?>">
				<label>ИНН:</label>
				<?=$form->textField($model, 'inn', array('class'=>'form-control', 'placeholder' => 'Укажите ИНН')); ?>
				<?php if($model->hasErrors('inn')): ?>
					<span class="help-inline">
						<?php echo $model->getError('inn') ?>
					</span>
				<?php endif ?>
			</div>





			<div class="form-group <?php echo $model->hasErrors('kpp') ? 'error' : '' ?>">
				<label>КПП:</label>
				<?=$form->textField($model, 'kpp', array('class'=>'form-control', 'placeholder' => 'Укажите КПП')); ?>
				<?php if($model->hasErrors('kpp')): ?>
					<span class="help-inline">
						<?php echo $model->getError('kpp') ?>
					</span>
				<?php endif ?>
			</div>








			<div class="form-group <?php echo $model->hasErrors('okpo') ? 'error' : '' ?>">
				<label>ОКПО:</label>
				<?=$form->textField($model, 'okpo', array('class'=>'form-control','placeholder'=> 'Укажите ОКПО')); ?>
				<?php if($model->hasErrors('okpo')): ?>
					<span class="help-inline">
						<?php echo $model->getError('okpo') ?>
					</span>
				<?php endif ?>
			</div>







		</div>
	</div>

</div>


<div style="padding: 15px; text-align: center;">
    <?php echo CHtml::submitButton('Регистрация', array( 'class' => 'btn btn-primary')); ?>
		<p style="margin-top:15px;">
		Уже регистрировались?
		<a href="/login">Войти на сайт</a>
		|
		<a href="/login/restore">Восстановить пароль</a>
		</p>
</div>





<?php $this->endWidget(); ?>



