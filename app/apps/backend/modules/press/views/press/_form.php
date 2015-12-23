<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'press-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),

)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>

<?php echo $form->dropDownListRow($model, "group_id",
    CHtml::listData( PressGroup::model()->findAll(), "id", "name"),
    array('class'=>'span5', "empty" => "Нет группы")
); ?>

<?php //echo '<label class="control-label required">Главные новости</label> <div class="controls">' . $form->dropDownList($model,'primary', array('0'=>'Нет','1'=>'Да'), array('name' => 'Press[primary]', 'title' => 'Главные новости')) . '</div>'; ?>

<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

echo $form->label($model,'brieftext');
$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'brieftext',

    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/press/press/imageUpload'),
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
    ),
));

echo '<HR>';

echo $form->label($model,'description');
$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'description',
    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/press/press/imageUpload'),
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
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
    ),
));

?>

<div class="control-group">
    <label class="control-label" for="CatalogRubrics_status">Картинка</label>
    <div class="controls">
        <?php
        $base_url_img = '/../uploads/filestorage/press/elements/';
        ?>
        <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
            //Проверяем файл, если нет картинки - ставим заглушку
            $url_img = "/images/nophoto_100_100.jpg";
            if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.$model->id.'.'.$model->image )) {
                $url_img = $base_url_img.'small-'.$model->id.'.'.$model->image;
            }
            echo '<a href="'.$base_url_img.$model->id.'.'.$model->image.'" target="_blank"><img src="'.$url_img.'"></a>';
        } ?>
        <br>
        <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
    </div>
</div>


<?php echo $form->DatePickerRow($model, 'maindate', array(
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


<?php
echo $form->dropDownListRow($model,'status',Press::model()->getStatuslist(),
    array('class'=>'span5'));
?>


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

