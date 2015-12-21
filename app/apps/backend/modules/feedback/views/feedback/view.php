<legend>Сообщение #<?php echo $model->id ?></legend>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'email',
		'name',
		'subject.title',
		'body',
	),
)); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'feedback-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal',
)); ?>

    <?php echo $form->dropDownListRow(
        $model,
        'status_id',
        array(0 => 'Новое') + CHtml::listData( FeedbackStatus::model()->findAll(), 'id', 'title')
    ); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'htmlOptions' => array('style' => 'margin-right: 20px'),
            'label'=>$model->isNewRecord ? $this->t('MODULE.OPERATIONS.CREATE') : $this->t('MODULE.OPERATIONS.SAVE'),
        )); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
            'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
        )); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'link',
            'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
            'url' => $this->listUrl('admin'),
        )); ?>

    </div>

<?php $this->endWidget(); ?>