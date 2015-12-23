<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>

<?php
$hasFile = false;
foreach($this->tableSchema->columns as $column){
    if( $this->isImageFile($column) ){
        $hasFile = true;
        break;
    }
}
?>

<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	". ( $hasFile ? "'htmlOptions'=>array('enctype'=>'multipart/form-data')," : "" ) ."
)); ?>\n"; ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo '<?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?>' ?></p>-->

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php foreach($this->tableSchema->columns as $column) {
	if($column->autoIncrement)
		continue;
	echo "<?php ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n";
} ?>

	<div class="form-actions">

		<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>\$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>\n"; ?>

		<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			//'type'=>'primary',
			'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
			'label'=>\$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
		)); ?>\n"; ?>

        <?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>\$this->listUrl('index'),
		)); ?>\n"; ?>

	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
