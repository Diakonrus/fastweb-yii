<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>

<?php echo "<legend><?php echo Yii::t('Bootstrap', 'CREATE.{$this->modelClass}') ?></legend>" ?>
<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
