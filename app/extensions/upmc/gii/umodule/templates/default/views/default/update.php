<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<legend><?php echo Yii::t('Bootstrap', 'UPDATE.{$this->modelClass}') ?></legend>" ?>
<?php
echo "<?php \$this->menu[] = array(
	'label'=>Yii::t('Bootstrap', 'UPDATE.{$this->modelClass}') . ' #' . \$model->id,
	'url'=>array('update', 'id'=>\$model->id), 'active' => true 
	); ?> \n";
?>
<?php echo "<?php echo \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>