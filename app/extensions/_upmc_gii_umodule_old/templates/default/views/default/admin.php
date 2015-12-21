<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->modelClass;
echo "\$this->breadcrumbs=array(
	Yii::t('Bootstrap', 'SECTION.$label')=>array('index'),
	Yii::t('Bootstrap', 'PHRASE.MANAGE'),
);\n";
?>

$this->menu=array(
	array('label' => Yii::t("Bootstrap", "CREATE.<?php echo $this->modelClass; ?>" ),'url'=>$this->listUrl('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo '<?php echo Yii::t("Bootstrap", "LIST.' . $this->modelClass . '" ) ?>'; ?></h1>

<p>
<!--
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
-->

<?php echo '<?php echo Yii::t("Bootstrap", "PHRASE.SEARCH_HINT") ?></p>' ?>
</p>

<!-- search-form -->

<?php echo "<?php"; ?>

$assetsDir = Yii::app()->basePath;
$labels = <?php echo $this->modelClass ?>::model()->attributeLabels();
<?php
    $withList = array();
    foreach( $this->tableSchema->columns as $column ){
        if( $relationClass = $this->getLinked($column) ){
            $withList[] = mb_substr($column->name, 0, -3);
        }
    }
?>

<?php

    $class = $this->modelClass;
    $relationList = $class::model()->relations();
    $childrenList = array();

    foreach( $relationList as $name => $relation ){
        if( $relation[0] == $class::HAS_MANY ){
            $childrenList[] = array(
                'module' => $this->moduleID,
                'controller' => $relation[1],
                'model' => $relation[1],
                'column' => $relation[2],
            );
        }
    }
?>

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model<?php foreach($withList as $name){ echo '->with("' . $name . '")'; } ?>->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
    $count=0;
?>

<?php foreach($this->tableSchema->columns as $column): ?>

	<?php if(++$count==7):
		//echo "\t\t/*\n";
	endif ?>

    <?php if( $this->isImageFile($column) ): ?>
        array(
            'header'=> $labels["<?php echo $column->name; ?>"],
            'name'=>'<?php echo $column->name ?>',
            'type'=>'html',
            'value'=>'(!empty($data-><?php echo $column->name ?>)) ? CHtml::image("$data-><?php echo $column->name ?>", "", array( "style"=>"width: 150px" )) : "no image"',
        ),
        <?php continue; ?>

    <?php elseif( $this->isText($column) ): ?>
		<?php continue; ?>

    <?php elseif( $relationClass = $this->getLinked($column) ):
        $linkName = mb_substr($column->name, 0, -3);
    ?>
		array(
            'header'=> $labels["<?php echo $column->name; ?>"],
            'name' => '<?php echo $column->name ?>',
            'value' => '$data-><?php echo $linkName ?> ? $data-><?php echo $linkName ?>->title : ""',
            'filter' => CHtml::listData( <?php echo $relationClass ?>::model()->findAll( array('order'=>'title') ), 'id', 'title'),
        ),
		<?php continue; ?>

    <?php elseif( $this->isCheckbox($column) ): ?>
		array(
			'class' => 'bootstrap.widgets.TbDataColumn',
			'name' => '<?php echo $column->name ?>',
			'type' => 'raw',
			'value'=> '($data["<?php echo $column->name ?>"]) ? \'<span class="icon-ok"></span>\' : \'\'',
                        'filter' => array(0=>'Нет', 1=>'Да'),
		),
		<?php continue; ?>

    <?php else: ?>
        array(
            'header'=> $labels["<?php echo $column->name; ?>"],
            'name'=> "<?php echo $column->name ?>",
        ),
        <?php continue; ?>

    <?php endif ?>

	<?php if(++$count==7): ?>
	    <?php //echo "\t\t*/\n"; ?>
	<?php endif ?>

<?php endforeach ?>

<?php foreach($childrenList as $item): ?>

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{link}',
            'buttons' => array(
                'link' => array(
                    'label'=> '<?php echo $item['model'] ?>',
                    'options'=>array(
                        'class' => 'btn btn-small update',
                        'target' => '_blank',
                    ),
                    'url' => 'Yii::app()->controller->itemUrl( "/<?php echo $item['module'] ?>/<?php echo $item['controller'] ?>/index?<?php echo $item['model'] ?>[<?php echo $item['column'] ?>]=" . $data->id )',
                ),
            ),
            'htmlOptions'=>array('style'=>'width: 80px'),
        ),

<?php endforeach ?>

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'Yii::app()->controller->itemUrl("<?php echo $this->controller; ?>/update/id/" . $data->id)',
                    'options'=>array(
                        'class'=>'btn btn-small update'
                    ),
                ),
                'delete' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.DELETE'),
                    'options'=>array(
                        'class'=>'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'width: 80px'),
        ),
	),
)); ?>
