<?php $form = $this->beginWidget('ext.backendfilter.TbActiveFormForFilter', array(
    'action' => Yii::app()->createUrl(Yii::app()->controller->route),
    'method' => 'get',
    'type' => 'horizontal',
    'htmlOptions'=>array(
        'class'=>'filter-form'
    )
)); ?>

<?php Yii::app()->clientScript->registerScript($form->id . '-filter-script', "
		$('#{$form->id}').on('submit', function(e) {

			e.preventDefault();

			var rawData = $('#{$form->id}').serializeArray(),
				grid = $('#{$listId}'),
				data = {};

				$.each(rawData, function (key, value) {
					data[value.name] = value.value;
				});

				grid.yiiGridView('update', {data: data, complete: function(jqXHR, textStatus){
					if( textStatus == 'success' ){
                        var url = $('#{$listId}').yiiGridView('getUrl');
                        window.History.pushState(null, document.title, decodeURIComponent(url) );
					}
				} });
		});
	", CClientScript::POS_READY) ?>

<?php foreach ($columns as $columnData): ?>

    <?php echo $this->getFilterControl($form, $columnData) //$form->textFieldRow($model, $fieldName, array('class'=>'span5','maxlength'=>11)); ?>
<?php endforeach ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Применить',
    )); ?>
</div>

<?php $this->endWidget(); ?>
