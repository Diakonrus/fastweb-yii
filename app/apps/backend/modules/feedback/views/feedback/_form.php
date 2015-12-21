

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'feedback-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>
<style>
    .feedBack td {padding: 10px; font-size: 20px;}
</style>
<table class="feedBack">

    <tr><td>ФИО</td><td><?=$model->fio;?></td></tr>
    <tr><td>Телефон</td><td><?=$model->phone;?></td></tr>
    <tr><td>E-mail</td><td><?=$model->email;?></td></tr>
    <tr><td>Вопрос</td><td><?=$model->question;?></td></tr>

</table>

<?php
    if ($model->status == 2){
        echo '<b>На данное обращение уже был дан ответ '.(date('d-m-Y H:i:s', strtotime($model->answer_at)));
        echo '<BR>';
        echo 'Ответ (был отправлен на посчту пользователю):<BR>';
        echo $model->answer;
    } else {
?>

<b>Ответить на обращение:</b>
<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'answer',

    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
        'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
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
    ),
));

?>
<?php } ?>

	<div class="form-actions">

        <?php if ($model->status!=2){ ?>

            <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>'Ответить',
		)); ?>

        <?php } ?>


        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>
