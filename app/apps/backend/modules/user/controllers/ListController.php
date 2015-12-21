<?php

class ListController extends Controller {

    const CSV_TIME_LIMIT = 1000;

	public $defaultAction = 'index';

    public function actionLoadlist(){
        $list = Yii::app()->db->createCommand()
			->select('id, email as text')
			->from(User::model()->tableName())
			->queryAll();
        echo CJSON::encode($list);
    }

    public function actionGet() {
		$q = Yii::app()->request->getParam('q', false);
		$ids = Yii::app()->request->getParam('ids', false);
		$where = '';
		
		if ($ids !== false) {
			$where = "id in ({$ids})";
		} else {
			$where = array('like', 'email', "%{$q}%");
		}
		
        $list = Yii::app()->db->createCommand()
			->select('id, email as text')
			->from(User::model()->tableName())
			->where($where)
			->limit(10)
			->queryAll();
        echo CJSON::encode($list);
    }
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'update' page.
	 */
	public function actionCreate()
	{
        $this->breadcrumbs = array(
            'Список пользователей'=>array('/user'),
            'Новая запись'
        );

		$model=new User('register');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

            if($model->save()){
                if( isset($_POST['go_to_list']) ){
                    $this->redirect('/admin/user' );
                } else {
                    $this->redirect( '/admin/user/list/update/id/' . $model->id );
                }
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
        $this->breadcrumbs = array(
            'Список пользователей'=>array('/user'),
            'Редактирование'
        );

		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{

            //Проверяем изменился ли статус. Если изменился - отправляем сообщение на почту.
            if($model->state != $_POST['User']['state']){
                $text_status = 'Ваш акант на сайте активирован администратором.<BR> Теперь Вы можете войти на сайт используя свой логии/пароль указанный при регистрации.';
                if ((int)$_POST['User']['state'] == 2){
                    $text_status = 'Ваш акант на сайте заблокирован администратором.<BR> Теперь Вы не можете войти на сайт.';
                }
                $body = '<p>Уважаемый пользователь '.$model->first_name.' '.$model->last_name.'!</p><BR>'.$text_status;
                Yii::app()->mailer->send(array('email'=>$model->email, 'subject'=>'Ваш акаунт активирован на сайту '.SITE_NAME_FULL, 'body'=>$body));
            }

			$model->attributes=$_POST['User'];

            if($model->save()){

            if( isset($_POST['go_to_list']) ){
                $this->redirect('/admin/user' );
            } else {
                $this->redirect( '/admin/user/list/update/id/' . $model->id );
            }

            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
		    $id = Yii::app()->request->getParam('id', array());
		    $list = is_array($id) ? $id : array($id);
			foreach($list as $id){
                //удаляем сообщения пользователя
                WebsiteMessages::model()->deleteAll('recipient_id = '.$id.' OR author_id = '.$id);
                //удаляем из  tbl_user_access
                UserAccess::model()->deleteAll('user_id = '.$id);
                //удаляем обращения пользователя
                UserRequests::model()->deleteAll('from_user_id = '.$id);
                //удаляем контактные данные пользователя
                UserContact::model()->deleteAll('user_id = '.$id);
                //Удаляем коментарии
                UserComment::model()->deleteAll('user_id = '.$id);

                //удаляем самого пользователя
			    $this->loadModel($id)->delete();
            }
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	    }
	}

    public function actionExport() {

        $filter = new UserFilterModel();

        if(isset($_POST['UserFilterModel'])) {

            $filter->attributes = $_POST['UserFilterModel'];
            $filter->validate();

            $search = Yii::createComponent(array(
                'class' => 'JSearchManager',
                'search' => $filter,
                'expressions' => UserFilterModel::expressions(),
            ));

            $criteria = $search->change();
            $this->buildCsv($criteria);
        } else {
            throw new CException('unkown error');
        }
    }

    public function buildCsv(CDbCriteria $criteria) {

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="users.csv"');

        set_time_limit(self::CSV_TIME_LIMIT);

        $count = User::model()->count($criteria);
        $criteria->limit = 10;
        $criteria->offset = 0;

        echo "\xEF\xBB\xBFID,e-mail,Телефон,Дата рождения,Имя пользователя,Дата регистрации\r\n";

        while ($criteria->offset < $count) {

            $users = User::model()->findAll($criteria);
            foreach ($users as $user) {

                echo $user->id.','.$user->email.','.$user->phone.','.$user->birthday.','.
                     $user->username.','.$user->created;

                echo "\r\n";
            }
            $criteria->offset += $criteria->limit;
        }

        Yii::app()->end();
    }

    /**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $this->breadcrumbs = array(
            'Список пользователей'=>array('/user'),
        );

		$model=new User();
		$model->unsetAttributes();  // clear any default values

        $filter = new UserFilterModel();

        if(isset($_GET['User'])){
            $model->attributes = $_GET['User'];
        }

        $provider=new CActiveDataProvider('User', array(
          'sort'=>array(
            'defaultOrder'=>'id DESC',
          ),
          'Pagination' => array (
            'PageSize' => 5,
           ),
        ));

        $provider->criteria = $model->search();

		$this->render('list',array(
			'model'=>$model,
            'filter'=>$filter,
            'provider'=>$provider,
		));
	}

    public function actionRole(){
        $model = new UserRole();
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['UserRole'])){
            $model->attributes = $_GET['UserRole'];
        }

        $provider=new CActiveDataProvider('UserRole', array(
            'sort'=>array(
                'defaultOrder'=>'id DESC',
            ),
            'Pagination' => array (
                'PageSize' => 5,
            ),
        ));

        $provider->criteria = $model->search('name not like "guest"');

        $this->render('listrole',array(
            'model'=>$model,
            'provider'=>$provider,
        ));
    }

    public function actionCreaterole()
    {
        $model = new UserRole();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['UserRole']))
        {
            if (isset($_POST['UserRole']['name'])){ $_POST['UserRole']['name'] = mb_strtolower($_POST['UserRole']['name']); }
            $model->attributes=$_POST['UserRole'];


            if($model->save()){
                if( isset($_POST['go_to_list']) ){
                    $this->redirect('/admin/user/list/role' );
                } else {
                    $this->redirect( '/admin/user/list/updaterole/id/' . $model->id );
                }
            }
        }

        $this->render('createrole',array(
            'model'=>$model,
        ));
    }

    public function actionUpdaterole($id)
    {
        $model = $this->loadModelRole($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['UserRole']))
        {
            if (isset($_POST['UserRole']['name'])){ $_POST['UserRole']['name'] = mb_strtolower($_POST['UserRole']['name']); }
            $model->attributes=$_POST['UserRole'];

            if($model->save()){

                if( isset($_POST['go_to_list']) ){
                    $this->redirect('/admin/user/list/role' );
                } else {
                    $this->redirect( '/admin/user/list/updaterole/id/' . $model->id );
                }

            }
        }

        $this->render('updaterole',array(
            'model'=>$model,
        ));
    }

    public function actionDeleterole()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);
            foreach($list as $id){

                $modelRole = $this->loadModelRole($id);

                //Удаляем пользователей с этой ролью
                foreach ( User::model()->findAll('role_id = "'.$modelRole->name.'"') as $data ){

                    //удаляем сообщения пользователя
                    WebsiteMessages::model()->deleteAll('recipient_id = '.$data->id.' OR author_id = '.$data->id);
                    //удаляем из  tbl_user_access
                    UserAccess::model()->deleteAll('user_id = '.$data->id);
                    //удаляем обращения пользователя
                    UserRequests::model()->deleteAll('from_user_id = '.$data->id);
                    //удаляем контактные данные пользователя
                    UserContact::model()->deleteAll('user_id = '.$data->id);
                    //Удаляем коментарии
                    UserComment::model()->deleteAll('user_id = '.$data->id);

                    //удаляем самого пользователя
                    $this->loadModel($data->id)->delete();

                }

                //удаляем роль
                $modelRole->delete();

            }
        }
        else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);

		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}

		return $model;
	}

    public function loadModelRole($id)
    {
        $model=UserRole::model()->findByPk($id);

        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }

        return $model;
    }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='User-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
