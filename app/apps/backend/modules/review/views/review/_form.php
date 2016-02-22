

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'review-elements-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>


<div class="control-group">
    <label class="control-label required" for="CatalogElements_name">
        Категория
        <span class="required">*</span>
    </label>
    <div class="controls">
        <select name="ReviewElements[parent_id]" id="ReviewElements_parent_id" class="span5">

            <?php echo '<option value="'.$root->id.'">/</option>'; ?>
            <? if (!empty($catalog)) : ?>
                <? foreach ($catalog as $category) : ?>
                    <option value="<?=$category->id ?>"
                        <?=!$model->isNewRecord && $model->parent_id == $category['id']? 'selected="selected"' : ''?>>
                        <?=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->level), $category->name?>
                    </option>
                <? endforeach; ?>
            <? endif;?>

        </select>

    </div>
</div>


<?php

if ($model->isNewRecord){
    echo '
    <div class="control-group">
        <label class="control-label required" for="ReviewAuthor_name">
            '.($form->label($model, "author_id")).'
            <span class="required">*</span>
        </label>
        <div class="controls">
            '.($form->textField($modelAuthor,'name',array('class'=>'span5','maxlength'=>450))).'
        </div>
    </div>

    ';
}
else {
    echo $form->dropDownListRow($model, "author_id",
        CHtml::listData( ReviewAuthor::model()->findAll(), "id", "name"),
        array("empty" => "Не выбран", 'class'=>'span5')
    );
}
?>

<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');


echo $form->labelEx($model,'brieftext');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'brieftext',

    'options' => array(
        'lang' => 'ru',
        'cleanOnPaste'=>false,
        'cleanStyleOnEnter'=>true,
        'cleanSpaces'=>false,
        'replaceDivs' => false,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
        'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
        'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
        'video' => array(
            'js' => array('video.js',),
        ),
        'table' => array(
            'js' => array('table.js',),
        ),
        'fontcolor' => array(
            'js' => array('fontcolor.js',),
        ),
        'fontfamily' => array(
            'js' => array('fontfamily.js',),
        ),
        'fontsize' => array(
            'js' => array('fontsize.js',),
        ),
        'filemanager' => array(
            'js' => array('filemanager.js',),
        ),
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
        'imagemanager' => array(
            'js' => array('imagemanager.js',),
        ),
    ),
));



echo $form->labelEx($model,'review');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'review',

    'options' => array(
        'lang' => 'ru',
        'cleanOnPaste'=>false,
        'cleanStyleOnEnter'=>true,
        'cleanSpaces'=>false,
        'replaceDivs' => false,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
        'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
        'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
        'video' => array(
            'js' => array('video.js',),
        ),
        'table' => array(
            'js' => array('table.js',),
        ),
        'fontcolor' => array(
            'js' => array('fontcolor.js',),
        ),
        'fontfamily' => array(
            'js' => array('fontfamily.js',),
        ),
        'fontsize' => array(
            'js' => array('fontsize.js',),
        ),
        'filemanager' => array(
            'js' => array('filemanager.js',),
        ),
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
        'imagemanager' => array(
            'js' => array('imagemanager.js',),
        ),
    ),
));

?>

<?php echo $form->DatePickerRow($model, 'review_data', array(
    'options'=>array(
        'autoclose' => true,
        //'showAnim'=>'fold',
        'type' => 'Component',
        'format'=>'yyyy-mm-dd',
    ),
    'htmlOptions'=>array(
        //'value'=> strlen($model->created_at) > 0 ? Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->created_at) : '',
        //'class'=>'span2'
    ),
));; ?>

	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>


        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>
