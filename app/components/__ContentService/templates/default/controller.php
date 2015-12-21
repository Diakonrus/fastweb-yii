<?php

class [%nameController%]Controller extends Controller
{
	public $layout='//layouts/[%layout%]';


	public function actionIndex()
	{
        $model = [%nameModel%];

        if ($model){
            //Проверка прав доступа
            if ($model->access_lvl>1 && Yii::app()->user->isGuest){
                $this->redirect('/login');
            }
        }

        //Проверяем есть ли фотогалерея, если есть - меняем содержимое страницы
        $model->content = $this->addPhotogalery($model->content);


		$this->render('[%nameView%]', array('model'=>$model));
	}



}