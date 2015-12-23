<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label = $this->modelClass;
echo "\$this->breadcrumbs=array(
	Yii::t('Bootstrap', 'SECTION.$label')=>array('index'),
	Yii::t('Bootstrap', 'PHRASE.CREATE'),
);\n";
?>

$this->menu=array(
	array('label' => Yii::t('Bootstrap', 'LIST.<?php echo $this->modelClass; ?>'), 'url'=>$this->listUrl('index')),
);

echo '<h1>';
echo Yii::t("Bootstrap", "CREATE.<?php echo $this->modelClass; ?>");
echo '</h1>';
?>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
