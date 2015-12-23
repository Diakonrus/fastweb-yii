<?php

class FileController extends Controller
{
    /**
     * Добавляем action для файлового менеджера
     */
    public function actions() {
        return array(
            'connector' => "ext.ezzeelfinder.ElFinderConnectorAction"
        );
    }

	/**
	 * Manages all models.
	 */
	public function actionIndex(){
		$this->render('index',array());
	}
}
