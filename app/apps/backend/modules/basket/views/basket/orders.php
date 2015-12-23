<legend>Список заказов</legend>


<?php
/*
$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'template' => "{items}\n{pager}",

    'id'=>'basket-grid',
    'enableHistory' => true,
    'dataProvider'=>$provider,
    'filter'=>$model,
    'type' => 'bordered striped',

    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),

    'columns'=>array(

        array(
            'header' => '#',
            'name' => 'id',
            'htmlOptions' => array(
                'style' => 'min-width: 50px'
            )
        ),


        array(
            'name' => 'user_id',
            'type'=>'raw',
            'value' => function($data){
                $model = User::model()->findByPk($data->user_id);
                $html = '';
                if ($model){
                    $html = '<a href="/admin/user/list/update?id='.$model->id.'">'.$model->email.'</a>';
                    if (!empty($model->first_name)){$html .= '<BR>'.$model->first_name;}
                }
                return $html;
            },

        ),

        array(
            'name' => 'created_at',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model,
                    'attribute'=>'created_at',
                    'language' => 'ru',
                    'htmlOptions' => array(
                        'size' => '10',
                    ),
                    'defaultOptions' => array(
                        'showOn' => 'focus',
                        'dateFormat' => 'yy/mm/dd',
                        'showOtherMonths' => true,
                        'selectOtherMonths' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'showButtonPanel' => true,
                    )
                ),
                true),
        ),

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{print}',
            'buttons' => array(
                'update' => array(
                    'label'=> 'Изменить',
                    'options'=>array(
                        //'class'=>'btn btn-small'
                    ),
                    'url' => function($data){
                        return Yii::app()->controller->itemUrl('update', $data->id);
                    }
                ),
                'delete' => array(
                    'label'=> 'Удалить',
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    )
                ),
                'print' => array(
                    'label'=> 'Печать',
                    'url'=>'Yii::app()->createUrl("/basket/basket/print", array("id"=>$data->id))',
                    'imageUrl'=>'/images/admin/printer.png',
                    'options'=>array(
                        //'class'=>'btn btn-small'
                    )
                )
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
    ),
));
*/


$this->widget('bootstrap.widgets.TbExtendedGridView',array(

    'template' => "{items}\n{pager}",

    'id'=>'product-grid',
    'dataProvider'=>$provider,
    'filter'=>$model,
    'type' => 'bordered striped',

    'bulkActions' => array(
        'actionButtons' => $this->bulkRemoveButton(),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),

    'afterAjaxUpdate'=>'function (){
        $("#BasketOrder_created_at").daterangepicker({"language":"ru"}, function(){
            $(this.element).change();
            });
    }',

    'columns'=>array(

        array(
            'header' => '#',
            'name' => 'id',
            'htmlOptions' => array(
                'style' => 'min-width: 50px'
            )
        ),


        array(
            'name' => 'user_id',
            'type'=>'raw',
            'value' => function($data){
                $model = User::model()->findByPk($data->user_id);
                $html = '';
                if ($model){
                    $html = '<a href="mailto:'.$model->email.'">'.$model->email.'</a>';
                    if (!empty($model->first_name)){$html .= '<BR><a href="/admin/user/list/update?id='.$model->id.'">'.$model->last_name.' '.$model->first_name.' '.$model->middle_name.'</a>';}
                }
                return $html;
            },
        ),


        array(
            'header' => 'Заказаные товары',
            'type'=>'raw',
            'value' => function($data){
                $html = '';
                foreach (BasketOrder::model()->getProductInOrder($data->id) as $val){
                    $productName = Yii::app()->db->createCommand()
                        ->select('name')
                        ->from('{{'.$val['module'].'_elements}}')
                        ->where('id='.(int)$val['item'])
                        ->queryRow();
                    $html .= '<a href="/'.$val['url'].'" target="_blank">'.$productName['name'].'</a><BR>';

                }

                return $html;
            },
        ),

        array(
            'name' => 'status',
            'value' => 'BasketOrder::model()->getDownliststatus($data->status)',
            'filter' => BasketOrder::model()->getStatus(),
        ),

        array(
            'name'=> "created_at",
            'value'=>'date("d-m-Y",strtotime($data->created_at))',
            'filter'=>$this->widget('bootstrap.widgets.TbDateRangePicker', array(
                'model'=>$model,
                'attribute'=>'created_at',
                'options' => array(
                    'language' => 'ru'
                ),
                'callback' => 'js:function(){$(this.element).change();}'
            ),true),
        ),



        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            //'template' => '{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{print}',
            'template' => '{update}&nbsp;&nbsp;{delete}',
            'buttons' => array(
                'update' => array(
                    'label'=> 'Изменить',
                    'options'=>array(
                        //'class'=>'btn btn-small'
                    ),
                    'url' => function($data){
                        return Yii::app()->controller->itemUrl('update', $data->id);
                    }
                ),
                'delete' => array(
                    'label'=> 'Удалить',
                    'options'=>array(
                        //'class'=>'btn btn-small delete'
                    )
                ),
                /*
                'print' => array(
                    'label'=> 'Печать',
                    'url'=>'Yii::app()->createUrl("/basket/basket/print", array("id"=>$data->id))',
                    'imageUrl'=>'/images/admin/printer.png',
                    'options'=>array(
                        //'class'=>'btn btn-small'
                    )
                )
                */
            ),
            'htmlOptions'=>array('style'=>'white-space: nowrap'),
        ),
    ),
));

?>