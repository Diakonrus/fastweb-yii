<?php
/**
 * @var $this PagesController
 * @var $form TbActiveForm
 * @var $form TbActiveForm
 * @var $root Pages
 * @var $model Pages
 * @var $categories array
 */


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pages-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model,'parent_id', $categories, array('class'=>'span5', 'encode'=>false)); ?>
    <?php echo $form->dropDownListRow($model,'type_module',Pages::model()->getTypeModule(), array('class'=>'span5')); ?>
    <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>150));; ?>

    <div class="control-group">
        <label>
            <a style="margin-left:560px;" class="translits_href" href="#">транслит url</a>
        </label>
    </div>

    <?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>250)); ?>
    <?php echo $form->textFieldRow($model,'header',array('class'=>'span5','maxlength'=>350));; ?>
    <?php echo $form->dropDownListRow($model,'status',array(0=>'Отключено', 1=>'Активно'), array('class'=>'span5')); ?>

<?php

Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');

$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'content',

    'options' => array(
        'lang' => 'ru',
        'cleanOnPaste'=>false,
        'cleanStyleOnEnter'=>false,
        'cleanSpaces'=>false,
        'replaceDivs' => false,
        'imageUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/imageUpload'),
        'fileUpload' => Yii::app()->createAbsoluteUrl('/pages/pages/fileUpload'),
        'imageManagerJson'=> Yii::app()->createAbsoluteUrl('/pages/pages/getImageLibray'),
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
        'filemanager' => array(
            'js' => array('filemanager.js',),
        ),
        'myphotogalery' => array(
            'js' => array('myphotogalery.js',),
        ),
        'imagemanager' => array(
            'js' => array('imagemanager.js',),
        ),
        'myforms' => array(
            'js' => array('myforms.js',),
        ),
    ),
));

?>


<div class="control-group">
    <label class="control-label" for="CatalogRubrics_status">Картинка</label>
    <div class="controls">
        <?php
        $base_url_img = '/../uploads/filestorage/menu/elements/';
        ?>
        <?php if ($model->isNewRecord) { ?><img src="/images/nophoto_100_100.jpg"><?php } else {
            //Проверяем файл, если нет картинки - ставим заглушку
            $url_img = "/images/nophoto_100_100.jpg";
            if (file_exists( YiiBase::getPathOfAlias('webroot').$base_url_img.$model->id.'.'.$model->image )) {
                $url_img = $base_url_img.'menu-'.$model->id.'.'.$model->image;
            }
            echo '<a href="'.$base_url_img.$model->id.'.'.$model->image.'" target="_blank"><img src="'.$url_img.'"></a>';
        } ?>
        <br>
        <?php echo CHtml::activeFileField($model, 'imagefile', array('style'=>'cursor: pointer;') ); ?>
    </div>
</div>

<div class="main_block_url block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#" data-type="plus"><span style="color: #fff; margin-left: 10px; font-weight: bold;"><img src="/images/admin/icons/plus.gif" style="padding-right: 10px;" />Вкладки</span></a>
</div>

<div id="main_block_url" style="display:none; margin-top: 10px; padding: 10px;">

    <div id="selectdFormTabs">
        <?php $i = 0; ?>
        <?php if (!empty($modelTabs)){ ?>
            <?php foreach ($modelTabs as $data) { ?>
                <?php ++$i; ?>
                <div class="rowFormTabs" data-id="<?=$i;?>" style="border-radius: 3px; padding:10px; margin-bottom: 10px;  background: #d3d3d3;">

                    <div class="control-group">
                        <label class="control-label">Заголовок: </label>
                        <div class="controls">
                            <input type="text" id="PagesTabs_title-<?=$i;?>" name="PagesTabs[title][<?=$i;?>][]" value="<?=$data->title;?>" >
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Текст: </label>
                        <div class="controls">
                            <textarea rows="10" cols="45" id="PagesTabs_description-<?=$i;?>" name="PagesTabs[description][<?=$i;?>][]"><?=$data->description;?></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Порядок: </label>
                        <div class="controls">
                            <input type="text" id="PagesTabs_order_id-<?=$i;?>" name="PagesTabs[order_id][<?=$i;?>][]" value="<?=$data->order_id;?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Оформление: </label>
                        <div class="controls">
                            <select name="PagesTabs[template_id][<?=$i;?>][]" id="PagesTabs_template_id-<?=$i;?>">
                                <?php foreach (PagesTabs::model()->getTemplateSelect() as $key=>$val) { ?>
                                    <option value="<?=$key;?>" <?=$data->template_id == $key?'selected':'';?>><?=$val;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Модуль: </label>
                        <div class="controls">
                            <select id="PagesTabs_site_module_id-<?=$i;?>" class="selectFormClass" name="PagesTabs[site_module_id][<?=$i;?>][]">
                                <?php foreach (PagesTabs::model()->getModuleSelect() as $key=>$val) { ?>
                                    <option value="<?=$key;?>" <?=$data->site_module_id == $key?'selected':'';?>><?=$val;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group" id="PagesTabs_site_module_value-<?=$i;?>">
                        <label class="control-label">Значения: </label>
                        <div class="controls">
                                <?php
                                    //Массив выбранных значений
                                    $module_val = array();
                                    foreach ( (explode("|", $data->site_module_value)) as $dataModuleVal ){
                                        if (empty($dataModuleVal)){ continue; }
                                        $module_val[$dataModuleVal] = 1;
                                    }
                                ?>
                            <?php foreach (PagesTabs::model()->getModuleValue($data->site_module_id) as $key=>$val){ ?>
                                <input type="checkbox" name="PagesTabs[site_module_value][<?=$i;?>][]" <?=((isset($module_val[$val['id']]))?' checked ':'');?> value="<?=$val['id'];?>"><span style="margin-left:3px;"><?=$val['name'];?></span><BR>
                            <?php } ?>
                        </div>
                    </div>

                    <a href="#" onclick="$(this).parent().remove(); return false;" class="btn" style="background-image: linear-gradient(to bottom, #0088cc, red);">Удалить блок</a>

                </div>
            <?php } ?>
        <?php } ?>

    </div>

    <a href="#" class="btn addNewBlock">Добавить вкладку</a>



</div>





<div class="block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#" data-type="plus"><span style="color: #fff; margin-left: 10px; font-weight: bold;"><img src="/images/admin/icons/plus.gif" style="padding-right: 10px;" />Настройки</span></a>
</div>
<div style="margin-top: 10px; padding: 10px; display: none;">
    <?php
    echo $form->dropDownListRow($model,'main_page',array(0=>'Нет', 1=>'Да'),
        array('class'=>'span5'));
    ?>
    <?php echo $form->textFieldRow($model,'main_template',array('class'=>'span5','maxlength'=>50)); ?>
    <?php echo $form->dropDownListRow($model, 'access_lvl', UserRole::model()->getLvlAccess(), array(
        'class'=>'span5'
    )); ?>
</div>


<div class="block_url" style="width: 100%; background-color: #3689d8; margin-bottom: 5px; cursor: pointer;">
    <a href="#" data-type="plus"><span style="color: #fff; margin-left: 10px; font-weight: bold;"><img src="/images/admin/icons/plus.gif" style="padding-right: 10px;" />SEO</span></a>
</div>
<div style="margin-top: 10px; padding: 10px; display: none;">
    <?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5')); ?>
    <?php echo $form->textAreaRow($model,'meta_keywords',array('class'=>'span5')); ?>
    <?php echo $form->textAreaRow($model,'meta_description',array('class'=>'span5')); ?>
</div>


	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>


        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>

<script>
    var base_template = '' +
        '<div id="cloneFormTabs"> ' +
        '   <div class="rowFormTabs" data-id="%num%" style="border-radius: 3px; padding:10px; margin-bottom: 10px; background: #d3d3d3;"> ' +
        '       <div class="control-group"> ' +
        '           <label class="control-label">Заголовок: </label> ' +
        '           <div class="controls"> ' +
        '               <input type="text" id="PagesTabs_title-%num%" name="PagesTabs[title][%num%][]"> ' +
        '           </div> ' +
        '       </div> ' +
        '   <div class="control-group"> ' +
        '       <label class="control-label">Текст: </label> ' +
        '       <div class="controls"> ' +
        '           <textarea rows="10" cols="45" id="PagesTabs_description-%num%" name="PagesTabs[description][%num%][]"></textarea> ' +
        '       </div> ' +
        '   </div> ' +
        '   <div class="control-group"> ' +
        '       <label class="control-label">Порядок: </label> ' +
        '       <div class="controls"> ' +
        '           <input type="text" id="PagesTabs_order_id-%num%" name="PagesTabs[order_id][%num%][]" value="0"> ' +
        '       </div> ' +
        '   </div> ' +
        '   <div class="control-group"> ' +
        '       <label class="control-label">Оформление: </label> ' +
        '       <div class="controls"> ' +
        '           <select name="PagesTabs[template_id][%num%][]" id="PagesTabs_template_id-%num%"> ' +
        '               <?php foreach (PagesTabs::model()->getTemplateSelect() as $key=>$val) { ?><option value="<?=$key;?>"><?=$val;?></option><?php } ?>'+
        '           </select>' +
        '       </div> ' +
        '   </div> ' +
        '   <div class="control-group"> ' +
        '       <label class="control-label">Модуль: </label> ' +
        '       <div class="controls"> ' +
        '           <select name="PagesTabs[site_module_id][%num%][]" id="PagesTabs_site_module_id-%num%" class="selectFormClass" > ' +
        '               <?php foreach (PagesTabs::model()->getModuleSelect() as $key=>$val) { ?><option value="<?=$key;?>"><?=$val;?></option><?php } ?>'+
        '           </select>' +
        '       </div> ' +
        '   </div> ' +
        '   <a href="#" onclick="$(this).parent().remove(); return false;" class="btn" style="background-image: linear-gradient(to bottom, #0088cc, red);">Удалить блок</a> ' +
        '</div>';



    $(document).ready(function(){
        var num = <?=$i;?>;

        $(document).on('click','.addNewBlock', function(){
            num = num + 1;
            var template = base_template;
            template = template.replace(/%num%/g, num);
            $("#selectdFormTabs").append(template);
            return false;
        });


        $(document).on('change','.selectFormClass', function(){
            //Меняют в поле выбора - тянем значения
            var element_id = $(this).attr('id');
            var data_id = $(this).parent().parent().parent().data('id');
            $.ajax({
                type: 'POST',
                url: '/admin/<?=Yii::app()->controller->module->id;?>/<?=Yii::app()->controller->id;?>/ajaxform',
                dataType: "json",
                data: {module_select: $(this).val()},
                success: function (data) {
                    $('#PagesTabs_site_module_value-'+data_id).remove();
                    var html = '<div class="control-group" id="PagesTabs_site_module_value-'+data_id+'">';
                    html += '<label class="control-label">Значения: </label>';
                    html += '<div class="controls" style="overflow: scroll; width: 600px; height: 250px;padding: 5px; border: solid 1px black;">';
                    // html += '<select name="PagesTabs[site_module_value]['+data_id+'][]" id="PagesTabs_site_module_value-'+data_id+'"  multiple size="3" >';
                    $.each(data, function( index, value ) {
                        html += '<input type="checkbox" name="PagesTabs[site_module_value]['+data_id+'][]" value="'+value['id']+'"><span style="margin-left:3px;">'+value['name']+'</span><BR>';
                        //html += '<option value="'+index+'">'+value+'</option>';
                    });
                    //html += '</select>' +
                    '</div>';
                    $('#'+element_id).parent().parent().append(html);

                }
            });
        });



        function HideShowFeelds(show){
            var feeld_id = ['#Pages_main_template', '#Pages_main_page', '#Pages_access_lvl'];
            var feeld_class = ['.main_block_url', '.redactor-box'];
            $.each(feeld_id, function( index, value ) {
                if (show==1){ $(value).parent().parent().show(); }
                else { $(value).parent().parent().hide(); }
            });
            $.each(feeld_class, function( index, value ) {
                if (show==1){ $(value).show(); }
                else { $(value).hide(); }
            });
        }

        $(document).on('change','#Pages_type_module',function(){
            if( $(this).val() == 8 ){
                HideShowFeelds(0);
            } else { HideShowFeelds(1); }
        });

        if ($('#Pages_type_module').val()==8){
            setTimeout(function() { HideShowFeelds(0) }, 1000);
        }
    });
</script>
