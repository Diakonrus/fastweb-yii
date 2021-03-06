<?php

class CatalogController extends Controller
{

    public $layout='//layouts/main';


	/*
		Функция для дыстрого заказа в 1 клик товара
	*/
	public function actionAjaxfastorder($id)
	{
		$ret = array();
		$ret['error'] = '';

		$id = intval($id);
		if (!$id)
		{
			$ret['error'] = 'Неверный ID товара';
			echo json_encode($ret);
			exit;
		}

		$model_catalog_element = CatalogElements::model()->find("id=".$id);
		if (!$model_catalog_element)
		{
			$ret['error'] = 'Товар '.$id.' не существует';
			echo json_encode($ret); exit;
		}

		$_name = (isset($_POST['name'])?$_POST['name']:'');
		$_phone = (isset($_POST['phone'])?$_POST['phone']:'');
		$_email = (isset($_POST['email'])?$_POST['email']:'');

		if (strlen($_name)<3)
		{
			$ret['error'] = 'Имя не может бть короче 3 символов';
			echo json_encode($ret); exit;
		}

		if (strlen($_phone)<6)
		{
			$ret['error'] = 'Телефон не может быть короче 6 символов';
			echo json_encode($ret); exit;
		}

		if (strlen($_email)<6)
		{
			$ret['error'] = 'Email не может быть короче 6 символов';
			echo json_encode($ret); exit;
		}

		$comment = "На сайте ".$_SERVER['HTTP_HOST']." сделан заказ с помощью формы быстрого заказа"."\r\n".
			"Имя: ".$_name."\r\n".
			"Email: ".$_email."\r\n".
			"Телефон: ".$_phone."\r\n".
			"Товар: ".$model_catalog_element->name."\r\n".
			"Цена товара: ".$model_catalog_element->price."\r\n".
			"Страница товара: http://".
			$_SERVER['HTTP_HOST'].'/catalog/'.$model_catalog_element->id."\r\n".
			"Свяжитесь с клиентом для уточнения деталей заказа.";

		$message = $comment;

		$sms = SiteModuleSettings::model()->find('site_module_id = 4');
		if ($sms)
		{
			$email = $sms->email;
			mail($email, 'Cделан быстрый заказ на сайте '.$_SERVER['HTTP_HOST'], $message);
			$ret['confirm'] = 'OK';

			if (Yii::app()->user->isGuest){
				//Регистрируем пользователя, если он не был зарегистрирован
				if ( !$model = User::model()->find('email LIKE "'.$_email.'"') ){
					$password = Yii::app()->helper->random(6, '0123456789');
					$model = new User();
					$model->email = $_email;
					$model->password = $password;
					$model->password_repeat = $model->password;
					$model->role_id = 'user';
					$model->username = $model->email;
					$model->state = 1;  //Сразу активируем аккаунт
					if ( $model->save() ){
						//отправляем заказчику письмо с новым паролем
						$message = "На сайте ".$_SERVER['HTTP_HOST']." был создан Ваш профиль:"."\r\n".
							"Логин: ".$model->email."\r\n".
							"Пароль: ".$password."\r\n";
						mail($_email, 'Вы были зарегистрированы на сайте '.$_SERVER['HTTP_HOST'], $message);
					}
				}
			} else {
				$model = User::model()->findByPk(Yii::app()->user->id);
			}

			$message = "Данные о Вашем заказе:"."\r\n".
				"Имя: ".$_name."\r\n".
				"Email: ".$_email."\r\n".
				"Телефон: ".$_phone."\r\n".
				"Товар: ".$model_catalog_element->name."\r\n".
				"Цена товара: ".$model_catalog_element->price."\r\n".
				"Страница товара: http://".
				$_SERVER['HTTP_HOST'].'/catalog/'.$model_catalog_element->id."\r\n".
				"Мы свяжемся с Вами в ближайшее время!";
			mail($_email, 'Данные о Вашем заказе на  сайте '.$_SERVER['HTTP_HOST'], $message);


			//Фиксируем заказ в БД
			$modelOrder = new BasketOrder();
			$modelOrder->user_id = $model->id;
			$modelOrder->phone = $_phone;
			$modelOrder->comments = $comment;
			$modelOrder->status_at = date('Y-m-d H:i:s');
			if ($modelOrder->save()){
				$modelItem = new BasketItems();
				$modelItem->basket_order_id = $modelOrder->id;
				$modelItem->module = 'catalog';
				$modelItem->url = '/catalog/'.$model_catalog_element->id;
				$modelItem->quantity = 1;
				$modelItem->price = $model_catalog_element->price;
				$modelItem->save();
			}



			echo json_encode($ret); exit;
		}
		else
		{
			$ret['confirm'] = 'Error';
			echo json_encode($ret); exit;
		}
	}

	public function actionIndex($model = null) {

		if (SiteModuleSettings::model()->find('site_module_id = 4 AND `status`=0')){
			throw new CHttpException(404,'The page can not be found.');
		}

		$data = array();
		$filters='';

		$data['base_url'] = Pages::getBaseUrl(4);

		if (empty($model)) {
			$model = CatalogRubrics::getRoot();
		}

		//Титл и SEO
		$this->setSEOData($model);


		$criteria = new CDbCriteria();
		$criteria->condition = "parent_id = :parent_id AND status = 1";
		$criteria->params = array(":parent_id"=>$model->id);
		$criteria->order = "order_id, id";

		$count = CatalogElements::model()->count($criteria);

		$pages = new CPagination($count);
		$pages->pageSize = 12;
		$pages->applyLimit($criteria);

		$data['elements'] = CatalogElements::model()->findAll($criteria);
		$data['pages']=$pages;
		$data['catalogs'] = $this->getChaildCategory($model, 1);
		$data['model'] = $model;

		$this->render('index', $data);
	}


	public function actionElement($param){

		//разбираем URL
		$paramArr = explode("/", $param);
		$url = array_pop($paramArr);

		if ( $model = CatalogRubrics::model()->find('url LIKE ("'.$url.'")') ){
			//Это раздел - выводим список
			$this->actionIndex($model);
			exit();
		}

		//Это карточка товара
		if ( !$model = CatalogElements::model()->find('url LIKE "'.$url.'" OR id = '.(int)$url) ){ throw new CHttpException(404,'The page can not be found.'); }

		$this->setSEOData($model);
		//$modelRubric = CatalogRubrics::model()->findByPk($model->parent_id);
		if (!$model)
		{
			throw new CHttpException(404,'The page can not be found.');
		}
		$modelChars = CatalogChars::model()->findAll('parent_id='.$model->id.' AND status = 1');

		$data['modelChars'] = $modelChars;
		$data['model'] = $model;
		$data['modelImages'] = CatalogElementsImages::model()->findAll('elements_id = '.$model->id);
		$this->render('show', $data);
	}


	private function getChaildCategory($model, $level = null) {
		$menu_top = array();
		foreach ( CatalogRubrics::getCatalogList($model, $level) as $data ) {
			$menu_top[$data->id]['name'] = $data->name;
			$menu_top[$data->id]['url'] = $data->url;
		}
		return $menu_top;
	}

	/**
	 * Получение кода для 3D картинок товара
	 * @param $id
	 */
	public function actionGetcodethreed($id) {
		$model = CatalogElements::model()->findByPk((int) $id);
		header('Content-Type: application/json');
		echo CJSON::encode(!empty($model) ? $model->code_3d : '');
		Yii::app()->end();
	}
}
