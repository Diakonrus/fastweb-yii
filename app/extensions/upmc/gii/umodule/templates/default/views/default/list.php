<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>

<legend><?php echo '<?php echo Yii::t("Bootstrap", "LIST.' . $this->modelClass . '" ) ?>'; ?></legend>

<?php
echo "<?php\n";
$label=$this->modelClass;
?>

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


$this->widget('backendfilterWidget', array(
    'listId' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
    'model' => $model,
    'columns'=>array(

<?php foreach($this->tableSchema->columns as $column): ?>

    <?php if( in_array($column->name, array('id')) ): ?>
        <?php continue; ?>

    <?php elseif( $this->isUser($column) ): ?>
        array(
            '<?php echo $column->name?>',
            'user'
        ),
        // для фильтрации по множеству пользователей
        /*
        array(
            '<?php echo $column->name?>s',
            'user',
            'multiple'=>true,
        ),
        */
        <?php continue; ?>

    <?php elseif( $this->isDate($column) ): ?>
        array(
            '<?php echo $column->name?>',
            'date',
            'range'=>true
        ),
        <?php continue; ?>

    <?php elseif( $this->isBoolean($column) ): ?>
        array(
            '<?php echo $column->name?>',
            'checkbox',
            'htmlOptions'=>array(
                'enabledLabel'=>'Да',
                'disabledLabel'=>'Нет',
            )
        ),
        <?php continue; ?>

    <?php elseif( $this->isRelatedList($column) && $relationClass = $this->getLinked($column) ): ?>
        array(
            '<?php echo $column->name?>',
            'select',
            'listData' => CHtml::listData( <?php echo $relationClass?>::model()->findAll( array('order'=>'title') ), 'id', 'title'),
            'htmlOptions'=>array('class'=>'span5')
        ),
        <?php continue; ?>

    <?php else: ?>
        array(
            '<?php echo $column->name?>',
            'htmlOptions'=>array('class'=>'span5')
        ),
        <?php continue; ?>

    <?php endif ?>

<?php endforeach ?>

    ),
));


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
    'template' => "{items}\n{pager}",
    'enableHistory' => true,

	'dataProvider'=>$model<?php foreach($withList as $name){ echo '->with("' . $name . '")'; } ?>->search(),
    'filter'=>null,
    //'filter'=>$model,
    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),

	'columns'=>array(
<?php
    $count=0;
?>

<?php foreach($this->tableSchema->columns as $column): ?>

	<?php if(++$count==7):
		//echo "\t\t/*\n";
	endif ?>

    <?php if( $this->isUser($column) ):
        $relationClass = $this->getLinked($column);
        $linkName = mb_substr($column->name, 0, -3);
    ?>
        array(
            'header'=> $labels["<?php echo $column->name; ?>"],
            'name' => '<?php echo $column->name ?>',
            'value' => '$data-><?php echo $linkName ?> ? $data-><?php echo $linkName ?>->username : ""',
            'filter' => CHtml::listData( <?php echo $relationClass ?>::model()->findAll( array('order'=>'username') ), 'id', 'username'),
        ),
        <?php continue; ?>

    <?php elseif( $this->isImageFile($column) ): ?>
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
                        //'class' => 'btn btn-small update',
                        'target' => '_blank',
                    ),
                    'url' => 'CHtml::normalizeUrl(array("index", "<?= $item['model'] ?>[<?= $item['column'] ?>]" => $data->id))', //'Yii::app()->controller->itemUrl( "/<?php echo $item['module'] ?>/<?php echo $item['controller'] ?>/index?<?php echo $item['model'] ?>[<?php echo $item['column'] ?>]=" . $data->id )',
                ),
            ),
            'htmlOptions'=>array('style'=>'width: 80px'),
        ),

<?php endforeach ?>

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}  {delete}',

            'buttons' => array(
                'update' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.UPDATE'),
                    'url'=>'CHtml::normalizeUrl(array("update", "id" => $data->id))', //'Yii::app()->controller->itemUrl("<?php echo $this->controller; ?>/update/id/" . $data->id)',
                    'options'=>array(
                        //'class'=>'btn btn-small update'
                    ),
                ),
                'delete' => array(
                    'label'=> yii::t('Bootstrap', 'PHRASE.DELETE'),
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
	),
)); ?>
