<?
//$this->pageTitle = 'Интернет магазин перочинных ножей, купить перочинные ножи с доставкой - '.$_SERVER['HTTP_HOST'];
//Yii::app()->clientScript->registerMetaTag('В интернет магазине '.$_SERVER['HTTP_HOST'].' вы сможете купить перочинные ножи по выгодной цене с доставкой.', 'description');
?>

<style>
    .alert-error {
        background-color:#f9558b;
        border-radius:5px;
        padding:10px;
        max-width:700px;
    }
</style>
<p class="tema3">Мои настройки профиля</p>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',

)); ?>


<?php echo $form->errorSummary($model); ?>


<table class="forma2" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td>
            <p>Логин, он же адрес электронной почты (e-mail):</p>
            <p>
                <?php echo $form->textField($model,'email',array('class'=>'inp','maxlength'=>254)); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p>Имя:</p>
            <p>
                <?php echo $form->textField($model,'first_name',array('class'=>'inp','maxlength'=>254)); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p>Пароль:</p>
            <p>
                <?php echo $form->passwordField($model,'password',array('class'=>'inp','maxlength'=>64, 'value'=>'')); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p>Подтверждение пароля:</p>
            <p>
                <?php echo $form->passwordField($model,'password_repeat',array('class'=>'inp','maxlength'=>64, 'value'=>'')); ?>
            </p>
        </td>
    </tr>
    </tbody>
</table>



<div class="form-actions">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px; padding:5px;'),
        'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
    )); ?>

</div>

<?php $this->endWidget(); ?>
