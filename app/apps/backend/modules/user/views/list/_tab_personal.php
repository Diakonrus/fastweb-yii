
	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>128)); ?>
	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>128)); ?>

    <?php echo $form->DatePickerRow($model, 'birthday', array(

        // additional javascript options for the date picker plugin
        'options'=>array(
            'autoclose' => true,
            //'showAnim'=>'fold',
            'type' => 'Component',
            'format'=>'yyyy-mm-dd',
        ),
        'htmlOptions'=>array(
            'value'=> strlen($model->birthday) > 0 ? Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->birthday) : '',
            //'class'=>'span2'
        ),
    ));	?>

    <?php echo $form->dropDownListRow($model, 'sex', array('1'=>Yii::t('Phrases', 'MAN'), '2'=>Yii::t('Phrases', 'WOMAN'))) ?>

    <div class="control-group">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'control-label')) ?>

    <div class="controls">
    <?php
    $this->widget('CMaskedTextField', array(
        'model' => $model,
        'attribute' => 'phone',
        'mask' => '+9(999)9999999',
        'htmlOptions' => array('class'=>'span5', 'maxlength' => 20, 'value'=>$model->phone,)
    ));
    ?>
    </div>
    </div>

	<?php echo $form->dropDownListRow($model,'state', $model->getStateList(), array('class'=>'span5')); ?>
	<?php echo $form->toggleButtonRow($model, 'subscribe'); ?>