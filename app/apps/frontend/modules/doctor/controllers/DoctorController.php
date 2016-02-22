<?php

class DoctorController extends Controller
{
	public $layout='//layouts/main';


	public function actionIndex()
	{

        /*
$model = Yii::app()->db->createCommand()
    ->select('tbl_doctor_rubrics.*')
    ->from('{{doctor_specialization}}')
    ->leftJoin('{{doctor_rubrics}}', '{{doctor_rubrics}}.id = {{doctor_specialization}}.doctor_rubrics_id')
    ->leftJoin('{{doctor_elements}}', '{{doctor_elements}}.id = {{doctor_specialization}}.doctor_elements_id')
    ->where('{{doctor_rubrics}}.`status` = 1')
    ->order('{{doctor_rubrics}}.name')
    ->queryAll();
*/
        $model = array();
        //получаем список специализаций где есть врачи
        $arrayID = array();
        foreach (DoctorSpecialization::model()->findAll() as $data){
            $arrayID[] = $data->doctor_rubrics_id;
        }
        if (empty($arrayID)){
            throw new CHttpException(404,'The page can not be found.');
        }
        $model['group'] = DoctorRubrics::model()->findAll(
            array(
                "condition" => "id in(".(implode(",", $arrayID)).") AND `status`=1 ",
                "order" => "name ASC",
        ));

        //получаем врачей в группах
        $model['element'] = array();
        //И список всех специализаций врача
        $model['spec'] = array();

        foreach ($model['group'] as $data){
            $arrayID = array();
            foreach (DoctorSpecialization::model()->findAll('doctor_rubrics_id='.$data->id) as $dataSpec){
                $arrayID[] = $dataSpec->doctor_elements_id;
            }
            $model['element'][$data->id] = DoctorElements::model()->findAll("id in(".(implode(",", $arrayID)).") AND `status`=1");
            foreach ($model['element'][$data->id] as $dataSpec){
                $model['spec'][$dataSpec->id] = Yii::app()->db->createCommand()
                    ->select('{{doctor_rubrics}}.name, {{doctor_rubrics}}.url')
                    ->from('{{doctor_specialization}}')
                    ->leftJoin('{{doctor_rubrics}}', '{{doctor_rubrics}}.id = {{doctor_specialization}}.doctor_rubrics_id')
                    ->leftJoin('{{doctor_elements}}', '{{doctor_elements}}.id = {{doctor_specialization}}.doctor_elements_id')
                    ->where('{{doctor_rubrics}}.`status` = 1 AND {{doctor_elements}}.id = '.$dataSpec->id)
                    ->order('{{doctor_rubrics}}.name ')
                    ->queryAll();
            }
        }

		$this->render('index', array('model'=>$model));
	}

    public  function actionElement($param){
        //Если параметр текст - это каталог, если число - элемент
        $paramArr = explode("/", $param);
        $paramArr =  array_pop($paramArr);

        if (is_numeric($paramArr)){
            //Число - это элемент

            $render = 'view';
        }
        else {
            //Список новостей категории

            $render = 'index';
        }


        if (empty($model)){throw new CHttpException(404,'The page can not be found.');}
        $this->render($render, array('model'=>$model));
    }


}