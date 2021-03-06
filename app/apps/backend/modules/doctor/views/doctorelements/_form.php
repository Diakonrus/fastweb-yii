<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'doctor-elements-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),

)); ?>


    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php
$specModel = DoctorElements::model()->getSpecialization( ($model->isNewRecord)?null:$model );
echo $form->listBoxRow($model,'doctor_rubrics_id', $specModel['data'], array('class' => 'span5', 'multiple' => 'true', 'options' => $specModel['selected']));
?>



<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>350));; ?>


<?php
echo $form->dropDownListRow($model,'chief_doctor',array(0=>'Нет', 1=>'Да'),
    array('class'=>'span5'));
?>


<?php
Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

echo $form->labelEx($model,'anonse');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'anonse',

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


echo $form->labelEx($model,'anonse_dop');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'anonse_dop',

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

echo $form->labelEx($model,'description');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'description',

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



<div class="control-group">
    <label class="control-label" for="CatalogRubrics_status">Картинка врача</label>
    <div class="controls">
        <?php
        $base_url_img = '/../uploads/filestorage/doctor/elements/';
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

<?php
echo $form->dropDownListRow($model,'status',array(0=>'Не авктивно', 1=>'Активно'),
    array('class'=>'span5'));
?>

<?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5','maxlength'=>350));; ?>
<?php echo $form->textAreaRow($model,'meta_keywords',array('class'=>'span5')); ?>
<?php echo $form->textAreaRow($model,'meta_description',array('class'=>'span5')); ?>



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
