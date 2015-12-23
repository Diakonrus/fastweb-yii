<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
//$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->modelClass;
echo "\$this->breadcrumbs=array(
	Yii::t('Bootstrap', 'SECTION.$label')=>array('index'),
	Yii::t('Bootstrap', 'PHRASE.UPDATE'),
);\n";
?>

$this->menu=array(
	array('label' => Yii::t('Bootstrap', 'LIST.<?php echo $this->modelClass ?>'), 'url' => $this->listUrl('index')),
	array('label' => Yii::t('Bootstrap', 'CREATE.<?php echo $this->modelClass ?>'), 'url' => $this->listUrl('create')),
);

// $model->{$this->tableSchema->primaryKey}
echo '<h1>';
echo Yii::t('Bootstrap', 'UPDATE.<?php echo $this->modelClass ?>');
echo '&nbsp;#'. $model-><?php echo $this->tableSchema->primaryKey ?>;
echo '</h1>';
?>

<?php echo "<?php echo \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>