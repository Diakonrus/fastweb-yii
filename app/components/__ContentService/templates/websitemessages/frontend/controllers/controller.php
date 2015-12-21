<?php

class WebsitemessagesController extends Controller
{

    public $module_template_name = 'websitemessages';
	public $layout='//layouts/[%layout%]';
    public $rule = 1;  //1 - чтение, 2- чтение+запись, 3-удаление

    public function init(){
        if (Yii::app()->user->isGuest){
            $this->redirect('/');
        }
        $modleRole = UserRole::model()->find('name LIKE "'.Yii::app()->user->role.'"')->id;
        $modelSiteModel = SiteModule::model()->find('templates LIKE "'.$this->module_template_name.'"');
        if ($modleRole && $modelSiteModel){
            $modelRule = UserGroupRule::model()->find('user_role_id = '.$modleRole.' AND module_id='.$modelSiteModel->id);
            if($modelRule){ $this->rule = $modelRule->access_type; }
        }
    }

    public function actionCreate()
    {
        $model=new WebsiteMessages;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // set attributes from get
        if(isset($_GET['WebsiteMessages'])){
            $model->attributes=$_GET['WebsiteMessages'];
        }

        if(isset($_POST['WebsiteMessages']))
        {
            $model->attributes=$_POST['WebsiteMessages'];
            $errFlag = 0;
            $delivery_name = md5(date('Y-m-d H:i:s'));
            //Создаю сообщения для пользователей в группах
            $modelUsers = User::model()->findAll( ($model->recipient_id=="all_users_BD")?'':'role_id LIKE ("'.$model->recipient_id.'")');
            foreach ($modelUsers as $data){

                $model=new WebsiteMessages;
                $model->author_id = Yii::app()->user->id;
                $model->recipient_id = $data->id;
                $model->title = $_POST['WebsiteMessages']['title'];
                $model->body = $_POST['WebsiteMessages']['body'];
                $model->delivery_name = $delivery_name;
                $model->read = 0;
                if ($model->validate()) {
                    $model->save();
                } else { $errFlag = 1; }
            }

            if ($errFlag == 0){
                $this->redirect( $this->listUrl('index') );
                /*
                $url = isset($_POST['go_to_list'])
                    ? $this->listUrl('index')
                    : $this->itemUrl('update', $model->id);
                $this->redirect( $url );
                */
            }

        }



        $this->render('create',array(
            'model'=>$model,
        ));
    }


    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);
            foreach($list as $id){
                $model = $this->loadModel($id);
                WebsiteMessages::model()->deleteAll("delivery_name LIKE ('".$model->delivery_name."')");
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
    $dataProvider=new CActiveDataProvider('EmailMessages');
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
        $model['inbox'] = WebsiteMessages::model()->findAll('recipient_id = '.Yii::app()->user->id.' ORDER BY id DESC');  //Входящие
        $model['outbox'] = WebsiteMessages::model()->findAll('author_id = '.Yii::app()->user->id.' ORDER BY id DESC');  //Исходящие

        $this->render('index',array(
            'model'=>$model,
            'rule'=>$this->rule,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=WebsiteMessages::model()->findByPk();
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='email-messages-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjax(){
        if(Yii::app()->request->isPostRequest)
        {
            $type = Yii::app()->request->getParam('type', array());
            if (isset($type)){
                $id = Yii::app()->request->getParam('id', array());
                switch ($type) {
                    case 'confRead':
                        $model = WebsiteMessages::model()->findByPk($id);
                        if ($model){
                            $model->read = 1;
                            $model->save();
                        }
                        break;
                    case 'answerMsg':
                        if ($this->rule==1){ break; }
                        $msg = Yii::app()->request->getParam('msg', array());
                        $modelMessages = WebsiteMessages::model()->findByPk((int)$id);

                        $model=new WebsiteMessages;
                        $model->author_id = Yii::app()->user->id;
                        $model->recipient_id = $modelMessages->author_id;
                        $model->title = 'RE: '.$modelMessages->title;
                        $model->body = $msg;
                        $model->delivery_name = $modelMessages->delivery_name;
                        $model->read = 0;
                        $model->save();

                        $modelMessages->read = 1;
                        $modelMessages->save();
                        break;
                    case 'deleteMsg':
                        if ($this->rule==1 || $this->rule==2){ break; }
                        $model = WebsiteMessages::model()->findByPk($id);
                        if ($model){
                            $model->delete();
                        }
                        break;
                }
                echo 'ok';
                Yii::app()->end();
            }



        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


    public function actionImageUpload() {

        $webFolder = '/uploads/websitemessages/';
        $tempFolder = Yii::app()->basePath . '/../www' . $webFolder;

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder.'chunks', 0777, TRUE);

        Yii::import("ext.image.CImageComponent");

        $image=CUploadedFile::getInstanceByName('file');
        $filename = 'a_'.date('YmdHis').'_'.substr(md5(time()), 0, rand(7, 13)).'.'.$image->extensionName;
        $path = $tempFolder.$filename;
        $image->saveAs($tempFolder.$filename);

        if ( $result = $this->widget('application.extensions.kyimages.KYImages',array('patch'=>$webFolder, 'file'=>$filename)) ){
            //ToDo Вернет данные о ресайзеном изображении (патч и имя файла). Если надо использовать - то тут
        }

        $array = array( 'filelink' => Yii::app()->request->hostInfo.$webFolder.$filename, 'filename' => $filename );
        echo stripslashes(json_encode($array));
    }



}
