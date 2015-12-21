<br/>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
    'type' => 'horizontal',

)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>254)); ?>
	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>64, 'value'=>'')); ?>
	<?php echo $form->passwordFieldRow($model,'password_repeat',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->dropDownListRow($model, 'role_id', User::model()->getRoles(), array(
	    'class'=>'span5'
    )); ?>

    <?php echo $form->dropDownListRow($model, 'email_group', User::model()->getEmailgroup(), array(
        'class'=>'span5'
    )); ?>

   <?php

    // Tab list
    $tabArray = array();

    $tabArray[] = array(
        'label' => "Личные данные",
        'content' => $this->renderPartial(
            '_tab_personal',
            array('index'=>1, 'form' => $form, 'model' => $model),
            true
        ),
        'active' => true
    );

    /*
    $tabArray[] = array(
        'id'=>'tab2',
        'content'=>$this->renderPartial(
            '_tab_address',
            array('index'=>1, 'form' => $form, 'model' => $model),
            true
        ),
    );
    */

    $this->widget(
        'bootstrap.widgets.TbTabs',
        array(
            'type' => 'tabs', // 'tabs' or 'pills'
            'tabs' => $tabArray,
        )
    );

    ?>

	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			//'type'=>'primary',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' => $this->listUrl('index'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
