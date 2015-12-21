<style>
    td {padding-left: 10px;}
</style>

<legend>
    Конструктор профиля
</legend>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'edit-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php
    eval($model->content1);

?>
<table class="content_table">
    <thead>
    <tr>
    <?php
    $fields = array();
    ?>
    <?php foreach ( current($fld) as $key=>$value ){ ?>
        <th><?php echo $key; $fields[] = $key; ?></th>
    <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ( $fld as $value ){ ?>
        <tr>
            <?php foreach ($value as $key=>$val){ ?>
                <td><?=$val;?></td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>


<?php
$arr = LoadxmlRubrics::model()->getFeeldsContent2((int)$model->module);
?>

<table class="content_table edit_table">
    <thead>
    <tr>
        <th width="300">
            Привязать к полю модуля
            <img title="Название поля модуля, в которое можно произвести загрузку. Полями модуля можно управлять с помощью опции "Управление полями" из пункта "Управление" главного меню." alt="Название поля модуля, в которое можно произвести загрузку. Полями модуля можно управлять с помощью опции "Управление полями" из пункта "Управление" главного меню." src="/images/admin/pregunta.png" style="padding-left: 15px;">
        </th>
        <th width="250">
            Привязать поле документа
            <img title="Здесь ассоциируются поле модуля, в которое будет производится заливка и столбец (по номеру) верхней таблицы, содержащий заливаемое значение." alt="Здесь ассоциируются поле модуля, в которое будет производится заливка и столбец (по номеру) верхней таблицы, содержащий заливаемое значение." src="/images/admin/pregunta.png" style="padding-left: 15px;">
        </th>
        <th>
            Содержание
            <img title="Здесь задается, как именно происходит заливка: либо информация заливается полностью, либо только числовое значение (например, "21 руб" в заливаемом файле превратится в число 21) либо булево значение поля (единица, если в поле что-то есть) - это необходимо для управления статусами. Например, можно маркировать хиты продаж в специальном поле заливаемого файла (допустим, установив для хитов продаж значение "да" в этом поле а для прочих оставив его пустым), если этому полю присвоено булево значение, то в поле модуля sale_hit будет записана единица для товаров, имеющих этот статус" alt="Здесь задается, как именно происходит заливка: либо информация заливается полностью, либо только числовое значение (например, "21 руб" в заливаемом файле превратится в число 21) либо булево значение поля (единица, если в поле что-то есть) - это необходимо для управления статусами. Например, можно маркировать хиты продаж в специальном поле заливаемого файла (допустим, установив для хитов продаж значение "да" в этом поле а для прочих оставив его пустым), если этому полю присвоено булево значение, то в поле модуля sale_hit будет записана единица для товаров, имеющих этот статус" src="/images/admin/pregunta.png" style="padding-left: 15px;">
        </th>
        <th colspan="3" style="width:10px;">
            Игнорировать пустые
            <img title="Если установить этот флаг, то строка заливаемого файла с пустой колонкой будет целиком проигнорированна." alt="Если установить этот флаг, то строка заливаемого файла с пустой колонкой будет целиком проигнорированна." src="/images/admin/pregunta.png" style="padding-left: 15px;">
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($arr as $key=>$value){ ?>
            <tr>
                <td><?=$value;?></td>
                <td>
                    <select name="LoadxmlRubrics[Field][<?=$key;?>]">
                        <option value="">Ничего не записывать в это поле</option>
                        <?php
                            foreach ($fields as $valFields){
                                $k = strtolower($key);
                                echo '<option value="'.$valFields.'" '.((isset($content2[$k]) && $content2[$k][0]==$valFields)?('selected'):('')).'>Записывать колонку '.$valFields.'</option>';
                            }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
    <?php } ?>
    </tbody>
</table>




<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'htmlOptions' => array('style' => 'margin-right: 20px'),
        'label'=>'Записать данные в профиль',
    )); ?>
</div>

<?php $this->endWidget(); ?>