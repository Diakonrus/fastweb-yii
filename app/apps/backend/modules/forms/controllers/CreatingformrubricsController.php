<?php

class CreatingformrubricsController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	public function actionView($id)
	{
		// set attributes from get
		if(isset($_GET['CreatingFormRubrics'])){
			$model->attributes=$_GET['CreatingFormRubrics'];
        }

	    $model = $this->loadModel($id);

		$this->render('view',array(
			'model'=>$model,
		));
	}
	*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'update' page.
	 */
	public function actionCreate()
	{
		$model=new CreatingFormRubrics;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['CreatingFormRubrics'])){
			$model->attributes=$_GET['CreatingFormRubrics'];
        }

		if(isset($_POST['CreatingFormRubrics']))
		{
			$model->attributes=$_POST['CreatingFormRubrics'];

			if($model->save()){
				$url = isset($_POST['go_to_list'])
					? $this->listUrl('index')
					: $this->itemUrl('update', $model->id);
				$this->redirect( $url );
		    }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'update' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		// set attributes from get
		if(isset($_GET['CreatingFormRubrics'])){
			$model->attributes=$_GET['CreatingFormRubrics'];
        }

		if(isset($_POST['CreatingFormRubrics']))
		{
			$model->attributes=$_POST['CreatingFormRubrics'];

			if($model->save()){
					$url = isset($_POST['go_to_list'])
						? $this->listUrl('index')
						: $this->itemUrl('update', $model->id);
					$this->redirect( $url );
		    }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    /**
     * File uploader controller
     */
	public function actionUpload(){

        $webFolder = '/uploads/creatingformrubrics/';
        $tempFolder = Yii::app()->basePath . '/../www' . $webFolder;

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder.'chunks', 0777, TRUE);

        Yii::import("ext.EFineUploader.qqFileUploader");

        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('jpg','jpeg', 'png', 'gif');
        $uploader->sizeLimit = 2 * 1024 * 1024;//maximum file size in bytes
        $uploader->chunksFolder = $tempFolder.'chunks';

        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();
        $result['folder'] = $webFolder;

        $uploadedFile=$tempFolder.$result['filename'];

        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id = null)
	{
		if(Yii::app()->request->isPostRequest)
		{
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);
            foreach($list as $id){
				//Удаляю поля формы
				CreatingFormElements::model()->deleteAll('parent_id='.$id);

				$this->loadModel($id)->delete();
            }
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 *
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CreatingFormRubrics');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	*/

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new CreatingFormRubrics('search');
        $model->attachBehavior('dateComparator', array(
            'class' => 'DateComparator',
        ));
		$model->unsetAttributes();  // clear any default values

		// set attributes from get
		if(isset($_GET['CreatingFormRubrics'])){
			$model->attributes=$_GET['CreatingFormRubrics'];
        }

		$this->render('list',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CreatingFormRubrics::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='creating-form-rubrics-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionAjax()
	{
		if (isset($_POST)) {
			switch ((int)$_POST['type']) {
				case 1:
					//Смена статуса
					$model = $this->loadModel((int)$_POST['id']);
					$model->status = (($model->status==1)?0:1);
					$model->save();
					//Меняем статус для полей в форме
					foreach (CreatingFormElements::model()->findAll('parent_id = '.$model->id) as $data){
						$data->status = $model->status;
						$data->save();
					}
					break;
			}

			echo CJavaScript::jsonEncode('ok');
		}

		Yii::app()->end();
	}

	/**  Для виджета в редакторе */
	public function actionAjaxafrm(){
		if (isset($_POST)){
			$result = '
            <div id="formModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
              <div class="modal-header">
                <a href="#" onclick="$(\'#formModal\').remove();" class="close">×</a>
                <h3 id="myModalLabel">Формы</h3>
              </div>
              <div class="modal-body">
            ';

			$result .= '<table class="content_table hover_table" cellspacing="0">';
			$result .= '
            <thead>
            <tr>
                <th>Название</th><th>Действие</th>
            </tr>
            </thead>
            ';

			$result .= '<tbody>';
			foreach (CreatingFormRubrics::model()->findAll('status=1') as $data ){
				$result .= '<tr>';
				$result .= '
                <td style="padding-left:20px; padding-right:20px;">
                    <b>'.$data->name.':</b></br>
                ';
				$result .= '
                </td>
                <td style="padding-left:20px; padding-right:20px;">
                    <a href="#" data-id="'.$data->id.'" data-class="'.$_POST['request'].'"  class="addMyForm">Вставить</a>
                </td>
                ';

				$result .= '</tr>';
			}
			$result .= '</tbody>';


			$result .= '</table>';
			$result .= '
              </div>
            </div>
            ';


			//Скрипт обработки нажатия 'Вставить'
			$result .= '
				<script>
				    $(document).on("click",".addMyForm",function(){
					var html = "{myforms id="+$(this).data("id")+"}";
					var className = $(this).data("class");
					//Вставка фотогалереи
					$(".redactor-editor").redactor({
						focus: true
					});
					$("."+className).redactor("insert.html", html);
					$("#formModal").remove();
					$(".redactor-editor").each(function(index, value){
						$("#redactor-toolbar-"+(index+2)).remove();
					});

					return false;
				});
				</script>
			';

			echo $result;
			//echo CJavaScript::jsonEncode($result);
		}
		Yii::app()->end();
	}
}
