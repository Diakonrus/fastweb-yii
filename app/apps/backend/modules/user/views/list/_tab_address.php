
	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>128)); ?>
	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>128)); ?>

    <?php echo CHtml::activeLabel($model, 'birthday') ?>
    <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'model'=>$model,
        'attribute'=>'birthday',
        // additional javascript options for the date picker plugin
        'options'=>array(
            //'showAnim'=>'fold',
            'dateFormat'=>'dd.mm.yy',
            'yearRange'=>'1950:2013',
            'changeYear'=>true,
            'changeMonth'=>true,
        ),
        'htmlOptions'=>array(
            'value'=> empty($model->birthday) ? date('d.m.Y', $model->birthday ) : null,
            'class'=>'span2'
        ),
    ));	?>

        <?php echo $form->dropDownListRow($model, 'sex', array('man'=>Yii::t('Phrases', 'MAN'), 'woman'=>Yii::t('Phrases', 'WOMAN'))) ?>

	   <?php //echo CHtml::activeLabel($model, 'city_id')?>
        <?php /* $this->widget('WSettlements', array(
            'model'=>$model,
            'attribute'=>'city_id',
            'htmlOptions'=>array('class'=>'span5'),
        ))*/ ?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>15)); ?>

	<?php //echo $form->dropDownListRow($model,'mail_confirm', array(0=>Yii::t('Phrases', 'NO'), 1=>Yii::t('Phrases', 'YES')),array('class'=>'span5')); ?>

	<?php //echo $form->dropDownListRow($model,'subscribe', array(0=>Yii::t('Phrases', 'NO'), 1=>Yii::t('Phrases', 'YES')),array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'state', $model->getStateList(), array('class'=>'span5')); ?>

	<?php //echo $form->dropDownListRow($model,'blocked', array(0=>Yii::t('Phrases', 'NO'), 1=>Yii::t('Phrases', 'YES')), array(
	    //'class'=>'span5',
	//)); ?>

    <div class="admin-field-block">
	<?php echo $form->labelEx($model,'subscribe');echo $form->checkbox($model,'subscribe',array()); ?>
    </div>

