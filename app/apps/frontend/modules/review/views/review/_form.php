<h1>Оставить отзыв</h1><BR>
Поля отмеченные звездочкой (*) - обязательны для заполнения

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'review-elements-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',

)); ?>

<table>
    <tr>
        <td>Ваше имя *:</td>
        <td><?php echo $form->textField($modelAuthor, 'name'); ?></td>
    </tr>
    <tr>
        <td>Ваш E-mail *:</td>
        <td><?php echo $form->textField($modelAuthor, 'email'); ?></td>
    </tr>
    <tr>
        <td>Отзыв:</td>
        <td>
            <?php echo $form->dropDownList($modelQuestion, "parent_id",
                CHtml::listData( ReviewRubrics::model()->findAll(), "id", "group_name")
            ); ?>
        </td>
    </tr>
    <tr>
        <td>Полный текст сообщения *:</td>
        <td><?php echo $form->textArea($modelQuestion, 'review',array('rows'=>6, 'cols'=>50)); ?></td>
    </tr>
</table>

<BR>

    <div class="form-actions">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'htmlOptions' => array('class' => 'send_form_btn'),
            'label'=>'Отправить',
        )); ?>

    </div>

<?php $this->endWidget(); ?>

<script>
    $(document).on('click','.send_form_btn',function(){
        if ( $('#ReviewAuthor_name').val().length == 0 || $('#ReviewAuthor_email').val().length == 0 || $('#ReviewElements_review').val().length == 0   ){
            alert('Заполните все обязательные поля!');
            return false;
        }
    });
</script>