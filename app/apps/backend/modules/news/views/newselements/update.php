<legend><?php echo Yii::t('Bootstrap', 'UPDATE.NewsElements') ?></legend><?php $this->menu[] = array(
	'label'=>Yii::t('Bootstrap', 'UPDATE.NewsElements') . ' #' . $model->id,
	'url'=>array('update', 'id'=>$model->id), 'active' => true 
	); ?> 
<?php echo $this->renderPartial('_form',array('model'=>$model, 'root'=>$root, 'catalog' => $catalog)); ?>