<style>
    .popupMsg {
        position: relative;
        max-width: 100%;
        border: 1px solid #71653a;
        border-radius: 5px;
        padding: 20px;
        color: #71653a;
        background-color: #fff1be;
        box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
    }​
    .authorMsg {
             background:#fafad2;
             border-radius:5px;
             padding: 5px;
    }
</style>
<?php


    foreach($model as $data){

        echo '
        <div class="popupMsg">
            <span class="authorMsg"><i>'.(User::model()->findByPk($data->author_id)->email).' ['.(date('d-m-Y H:i:s', strtotime($data->created_at))).']</i></span>
            <BR>
            <b>'.$data->title.'</b><BR>
            '.$data->body.'
        </div>';

        echo '<HR style="border: 1px dashed">';
    }


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'website-messages-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',

));

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

$this->widget('ImperaviRedactorWidget', array(
    'name' => 'WebsiteMessages[body]',
    'attribute' => 'body',

    'options' => array(
        'lang' => 'ru',
        'imageUpload' => Yii::app()->createAbsoluteUrl('/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/imageUpload'),
    ),
    'plugins' => array(
        'fullscreen' => array(
            'js' => array('fullscreen.js',),
        ),
        'video' => array(
            'js' => array('video.js',),
        ),
        'table' => array(
            'js' => array('table.js',),
        ),
        'fontcolor' => array(
            'js' => array('fontcolor.js',),
        ),
        'fontfamily' => array(
            'js' => array('fontfamily.js',),
        ),
        'fontsize' => array(
            'js' => array('fontsize.js',),
        ),
    ),
));
?>

<div class="form-actions">

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'submit',
    'type'=>'primary',
    'htmlOptions' => array('style' => 'margin-right: 20px'),
    'label'=>'Ответить',
)); ?>


<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
    'url' =>$this->listUrl('index'),
)); ?>

</div>
<?php $this->endWidget(); ?>