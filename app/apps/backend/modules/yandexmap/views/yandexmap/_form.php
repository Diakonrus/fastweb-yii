

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'yandex-map-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
	
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'coord',array('class'=>'span5','maxlength'=>50));; ?>
<?php     echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css\">";
    $cs = Yii::app()->clientScript; /* @var CClientScript $cs */
    $filemanager = $this->widget("ext.ezzeelfinder.ElFinderScripts", Yii::app()->getModule('filemanager')->clientOptions(array(
        //'selector' => "div#file-uploader",
        'clientOptions' => array(
            'commandsOptions' => array(
                'getfile' => array(
                    'onlyURL' => true,
		            'multiple' => false,
		            'folders' => false,
                    'oncomplete' => 'close' // close/hide elFinder
                ),
            ),
            'getFileCallback' => 'js:function(file) { callback(file,obj); }'
        )
    ))); /* @var ElFinderScripts $filemanager */

    $script = "
        if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};
        RedactorPlugins.extelf = {
            init: function()
            {
                var that = this;
                this.buttonAdd('elfinder', 'ElFinder',function(obj){
                    that.fmOpen(that.Elfresp,that);
                });
            },

            fmOpen: function(callback,obj) {
                //obj.saveSelection();
                var dialog;
                if (!dialog) {
                    dialog = $('<div/>').dialogelfinder(
                        {$filemanager->getJsonClientOptions()}
                    );

            } else {
                dialog.dialogelfinder('open')
            }
        },
        Elfresp:function(url,obj) {
            //console.log(url);
            obj.insertHtml( '<img src=\"' + url + '\" />' );
            //obj.syncCode();
        }
    }";

    $cs->registerScript('editor-filemanager', $script, CClientScript::POS_END);
echo $form->redactorRow($model, 'description', array(
				'editorOptions' => array(
                    'imageUpload' => CHtml::normalizeUrl(array('imageUpload')),
                    'imageUploadParam' => 'image',
                    'autoresize' => false,
                    'plugins' => array('extelf'),
                ),
                'htmlOptions' => array(
                   'style' => 'height: 150px'
                )
            ));; ?>

	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			//'type'=>'primary',
			'htmlOptions' => array('name' => 'go_to_list', 'style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE_RETURN') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE_RETURN'),
		)); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>
