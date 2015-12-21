<?php

Yii::import('bootstrap.widgets.TbActiveForm');

class TbActiveFormForFilter extends TbActiveForm
{

    /**
     * a little hack which is required for removing asterisks from required fields
     */
    public function labelEx($model,$attribute,$htmlOptions=array())
    {
        return CHtml::activeLabel($model,$attribute,$htmlOptions);
    }

}
