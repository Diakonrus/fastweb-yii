<legend><?php echo Yii::t('Bootstrap', 'UPDATE.PressGroup') ?></legend><?php $this->menu[] = array(
	'label'=>Yii::t('Bootstrap', 'UPDATE.PressGroup') . ' #' . $model->id,
	'url'=>array('update', 'id'=>$model->id), 'active' => true 
	); ?> 
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>