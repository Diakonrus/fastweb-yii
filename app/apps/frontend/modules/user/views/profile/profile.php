<style>
    .alert-error {
        background-color:#f9558b;
        border-radius:5px;
        padding:10px;
        max-width:700px;
        margin-bottom:10px;
    }
</style>
<p class="tema3">Моя страница</p>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',

)); ?>


<?php echo $form->errorSummary($model); ?>

<div id="position1" style="margin-bottom:20px; width: 170px; height:35px; border-radius:10px; border:2px solid black; background: #e9edf1;">
    <a href="#" onclick="$(this).parent().css('background', '#e9edf1'); $('#position2').css('background', '#FFF'); $('#UrLicoData').show(); return false;" ><span style="position:absolute; margin-top:7px; margin-left:30px;">Юридическое лицо</span></a>
</div>
<div id="position2" style="position:absolute; margin-top:-55px; margin-left:350px; width: 170px; height:35px; border-radius:10px; border:2px solid black; background: #FFF;">
    <a href="#" onclick="$(this).parent().css('background', '#e9edf1'); $('#position1').css('background', '#FFF'); $('#UrLicoData').hide(); return false;" ><span style="position:absolute; margin-top:7px; margin-left:30px;">Физическое лицо</span></a>
</div>

<div id="licData">
    <p class="bline1">Личные данные</p>
    <table class="forma2" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>
                <p>Фамилия:</p>
                <p>
                    <?php echo $form->textField($model, 'last_name', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите фамилию')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Имя:</p>
                <p>
                    <?php echo $form->textField($model, 'first_name', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите имя')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Отчество:</p>
                <p>
                    <?php echo $form->textField($model, 'middle_name', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите отчество')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Телефон:</p>
                <p>
                    <?php echo $form->textField($model, 'phone', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите телефон для связи')); ?>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>


<div id="UrLicoData">
    <p class="bline1">Данные юридического лица</p>

    <table class="forma2" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>
                <p>Организация:</p>
                <p>
                    <?php echo $form->textField($model, 'organization', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите организацию')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Юридический адрес:</p>
                <p>
                    <?php echo $form->textField($model, 'ur_addres', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите юридический адрес')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Физический адрес:</p>
                <p>
                    <?php echo $form->textField($model, 'fiz_addres', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите физический адрес')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>ИНН:</p>
                <p>
                    <?php echo $form->textField($model, 'inn', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите ИНН')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>КПП:</p>
                <p>
                    <?php echo $form->textField($model, 'kpp', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите КПП')); ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>ОКПО:</p>
                <p>
                    <?php echo $form->textField($model, 'okpo', array('class'=>'inputtext field_total', 'placeholder' => 'Укажите ОКПО')); ?>
                </p>
            </td>
        </tr>
        </tbody>
    </table>

</div>



<div class="form-actions">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px; padding:5px;'),
        'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
    )); ?>

</div>

<?php $this->endWidget(); ?>
