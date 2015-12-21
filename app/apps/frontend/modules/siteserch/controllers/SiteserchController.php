<?php

class SiteserchController extends Controller
{
	public $layout='//layouts/main';

    public function init(){
        if (SiteModuleSettings::model()->find('site_module_id = 3 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}
        /*
        if (Yii::app()->user->isGuest){
            $this->redirect('/login');
        }
        */
    }

	public function actionIndex()
	{

        $model = array();
        if (isset($_POST['s']) && !empty($_POST['s'])){
            $pattern = trim($_POST['s']);
            $pattern = '/'.$pattern.'/i';

            //Ищем в текстовых страницах
            foreach (Pages::model()->findAll('status=2') as $data){
                $content = $data->content;
                if(preg_match($pattern,$content)){
                    $k = $data->url;
                    $model[$k] = $data->title;
                }
            }
            //Ищем в новостях
            foreach (News::model()->findAll('status=1') as $data){
                if(preg_match($pattern,$data->description)){
                    $k = 'news/'.$data->id.'/';
                    $model[$k] = $data->name;
                }
            }
            //Ищем в врачах
            foreach (DoctorElements::model()->findAll('status=1') as $data){
                if(preg_match($pattern,$data->name) || preg_match($pattern,$data->anonse) || preg_match($pattern,$data->anonse_dop) || preg_match($pattern,$data->description)){
                    $k = 'doctor';
                    $model[$k] = 'Специалисты';
                }
            }

        }

		$this->render('index', array('model'=>$model));
	}




}