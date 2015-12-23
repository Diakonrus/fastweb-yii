<!-- Modal -->
<div id="menuModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="menuModalLabel"></h3>
    </div>
    <div class="modal-body">
        <div id="menuModalBody">

        </div>
        <input type="hidden" value="" name="action_type">
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
        <!--<button class="btn btn-primary">Применить</button>-->
    </div>
</div>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'menu-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

    <!-- Fields with <span class="required">*</span> are required. -->
	<!--<p class="help-block"><?php echo Yii::t("Bootstrap", "PHRASE.FIELDS_REQUIRED") ?></p>-->

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150));; ?>

<div style="margin-top:40px">
    <?php echo $form->textAreaRow($model,'script',array('rows'=>6, 'cols'=>50, 'style'=>'width:100%;')); ?>
    <?php echo $form->textAreaRow($model,'style',array('rows'=>6, 'cols'=>50, 'style'=>'width:100%;')); ?>
</div>
<?php if(!$model->isNewRecord){
    echo $form->textAreaRow($model,'body',array('rows'=>6, 'cols'=>50, 'style'=>'width:100%;'));
} ?>

<?php if($model->isNewRecord){
    $model->base_template_head = $model->base_template_head_val;
    $model->base_template_body_link = $model->base_template_body_link_val;
    $model->base_template_body_menu = $model->base_template_body_menu_val;
} ?>
<?php echo $form->textAreaRow($model,'base_template_head',array('rows'=>6, 'cols'=>50, 'style'=>'width:100%;')); ?>
<?php echo $form->textAreaRow($model,'base_template_body_link',array('rows'=>6, 'cols'=>50, 'style'=>'width:100%;')); ?>
<?php echo $form->textAreaRow($model,'base_template_body_menu',array('rows'=>6, 'cols'=>50, 'style'=>'width:100%;')); ?>

<!--Создаю форму меню-->
<div id="menu_form_create" style="min-height:100px;padding: 10px; ">
    <?php
        if(!$model->isNewRecord && !empty($model->param_menu)){
            $numElm = 0;
            $getParamArr = MenuTemplate::model()->getModelsByParam($model->param_menu);
            $elm_img = array('menu'=>'/../uploads/filestorage/menu/rubrics/', 'link'=>'/../uploads/filestorage/menu/elements/');
            foreach ($getParamArr as $value){
                foreach ($value as $key=>$data){
                ?>
                    <div class="btn btn-mini"  style="<?=($model->float==1)?'float:left;':'';?> margin-left: 10px; text-align: center;">
                        <p>
                            <?=((!empty($data->image))?('<img width=15px; src="'.($elm_img[$key]).'menu-'.$data->id.'.'.$data->image.'" />'):(''));?>
                            <?=($key=='menu'?$data->name:$data->title);?>
                            <img class="delete-obj" data-num="<?=$numElm;?>" data-type="<?=$key;?>" data-val="<?=$data->id;?>" style="position:absolute; margin-top:-5px; margin-left:-2px;" width="15px;" src="/images/delete_img.png">
                        </p>
                    </div>
                <?php
                    ++$numElm;
                }

            }

        }
    ?>
</div>

<div style="background: #d3d3d3; border-radius: 5px; padding: 10px; margin-top:10px;">
    <br><b>Ориентация меню</b><br>
    <a href="#" class="btn btn-mini btn-primary orientir_btn" id="orienntir_gor">Горизонтальное</a>
    <a href="#" class="btn btn-mini btn-primary orientir_btn" id="orienntir_ver">Вертикальное</a>

    <br><b>Вставить пункт меню</b><br>
    <a href="#" class="btn btn-mini btn-primary" id="add_link">Ссылка</a>
    <a href="#" class="btn btn-mini btn-primary" id="add_menu">Меню</a>
</div>


<?php echo $form->checkBox($model,'status'); ?><div style="margin-left: 20px; margin-top: -17px;">Использовать шаблон на сайте</div>


<!-- пишет в инпуты данные формы -->
<?php echo $form->hiddenField($model,'param_menu'); ?>
<?php echo $form->hiddenField($model,'float'); ?>




	<div class="form-actions">

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions' => array('style' => 'margin-right: 20px', 'class'=>' applyForm'),
			'label'=>$model->isNewRecord ? Yii::t('Bootstrap', 'PHRASE.BUTTON.CREATE') : Yii::t('Bootstrap', 'PHRASE.BUTTON.SAVE'),
		)); ?>


        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>Yii::t('Bootstrap', 'PHRASE.BUTTON.RETURN'),
			'url' =>$this->listUrl('index'),
		)); ?>

	</div>

<?php $this->endWidget(); ?>

<?php
if (!$model->isNewRecord){

}

?>

<script>
    $(document).ready(function(){
        var param = [];

        <?php
            if (!$model->isNewRecord){
                echo 'var str = "'.$model->param_menu.'"; ';
                echo 'var param = str.split("|");';
            }
        ?>

        var numElm = <?=(!$model->isNewRecord)?$numElm:'0';?>;
        var float = 'float: left';

        /** Реакция на кноку вставить на форме добавления элемента меню */
        $(document).on('click','.addElemetnsOnForm', function(){
            var elm_type = $(this).data('type');
            var elm_val = $(this).data('val');
            var elm_name = $(this).data('name');
            var elm_img = $(this).data('img');

            addElementForm(elm_type, elm_val, elm_name, elm_img);
        });

        /** Реакция на нажатие кнопки удаления элемента с формы */
        $(document).on('click', '.delete-obj', function (){
            var elm_type = $(this).data('type');
            var elm_val = $(this).data('val');
            var elm_num = $(this).data('num');

            $(this).parent().parent().remove();
            removeElemetForm(elm_num);
        });

        /**
         *
         * @param elm_type  - тип элемента (меню, ссылка)
         * @param elm_val   - ID элемента
         * @param elm_name  - имя элемента (для визуального представления на форме)
         * @param elm_img   - изображение элемента (для визуального представления на форме)
         */
        function addElementForm(elm_type, elm_val, elm_name, elm_img){

            param[numElm] = elm_type+'='+elm_val;


            //Получаем меню
            var html = $('#menu_form_create').html();
            html += '<div class="btn btn-mini"  style="'+float+'; margin-left: 10px; text-align: center;"><p>'+((elm_img.length>0)?"<img width=15px; src='"+elm_img+"' />":"")+elm_name+'<img class="delete-obj" data-num="'+numElm+'" data-type="'+elm_type+'" data-val="'+elm_val+'" style="position:absolute; margin-top:-5px; margin-left:-2px;" width="15px;" src="/images/delete_img.png"></p></div>';

            ++numElm;

            $('#menu_form_create').empty().append(html);

        }

        /**
         *
         * @param elm_type
         * @param elm_val
         */
        function removeElemetForm(elm_num){
            //console.log(param);
            var k = elm_num;
            delete param[k];
            //param.splice( $.inArray(k, param), 1 );  //Удаялет по значению элемента
            //console.log(param);

            //Если массив пустой 0 обнуляем счетчик
            /*
            if (param.length == 0){
                param = [];
                numElm = 0;
            }
            */
        }



        /** Добавление меню */
        $(document).on('click', '#add_menu', function(){
            $('#menuModalLabel').empty();
            $('#menuModalBody').empty();
            $('#menuModalLabel').append('Вставить пункт меню');
            //Получаю пункты меню
            $.ajax({
                type: 'POST',
                url: '/admin/pages/template/ajax',
                data: { action:'get_menu' },
                success: function(data) {
                    $('#menuModalBody').append(data);
                }
            });


            $('#menuModal').modal('show');
        });

        /** Добавление ссылки */
        $(document).on('click', '#add_link', function(){
            $('#menuModalLabel').empty();
            $('#menuModalBody').empty();
            $('#menuModalLabel').append('Вставить ссылку');
            //Получаю пункты меню
            $.ajax({
                type: 'POST',
                url: '/admin/pages/template/ajax',
                data: { action:'get_links' },
                success: function(data) {
                    $('#menuModalBody').append(data);
                }
            });


            $('#menuModal').modal('show');
        });

        /** Ориентация меню **/
        $(document).on('click', '.orientir_btn', function(){
            var id = $(this).attr('id');
            if (id == 'orienntir_gor'){
                float = 'float: left';
                $('#menu_form_create').find('div').css("float", "left");
                $('.menu_form_create_float').remove();
            } else {
                float = '';
                var html = '<div class="menu_form_create_float" style="clear: both;"> </div>';
                $('#menu_form_create').find('div').css("float", "");
                $('#menu_form_create').find('div').after(html);
            }
        });

        /** Нажали кнопку Сохранить - проверяем и отправляем данные **/
        $(document).on('click','.applyForm', function () {
            var error = '';
            var name_input = $('#MenuTemplate_name').val();
            if (name_input.length == 0){
                error += 'Вы не укащали название меню!\n';
            }
            if (param.length == 0){
                error += 'Вы не создали меню через конструктор!\n';
            }
            if (error.length >0){
                alert(error);
                return false
            }
            else {
                //Все ок - пишем данные
                var param_val = param.join('|');
                var float_val = (float.length > 0) ? 1 : 2;
                $('#MenuTemplate_param_menu').val(param_val);
                $('#MenuTemplate_float').val(float_val);
            }
        });


    });
</script>
