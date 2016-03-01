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

	public function actionIndex($model = null){

		if (SiteModuleSettings::model()->find('site_module_id = 4 AND `status`=0')){throw new CHttpException(404,'The page can not be found.');}

		$data = array();
		$filters='';


		$data['base_url'] = Pages::getBaseUrl(4);

		if (empty($model))$model = CatalogRubrics::getRoot(new CatalogRubrics());

		//Титл и SEO
		$this->pageTitle =  'Каталог продукции - ' . $this->pageTitle;
		foreach ( explode("/", ( parse_url(Yii::app()->request->requestUri, PHP_URL_PATH ))) as $url  ){
			$this->setSEO($url);
		}


		$data['catalogs'] = $this->getChaildCategory($model);
		$data['model'] = $model;

		$start = ((isset($_GET['page']))?intval($_GET['page']):0);
		$data['elements'] = CatalogElements::model()->findAll(array(
			'condition' => 'parent_id='.$model->id.' AND `status`=1',
			'order' => 'order_id',
			'offset' => (($start>0)?($start+12):(0)),
			'limit' => 12,
		));
		//


		/* Пагинация */
		// 1- Получаем число элементов в разделе всего
		$count = CatalogElements::model()->count("parent_id=".$model->id);
		// 2-
		$criteria = new CDbCriteria();
		$pages=new CPagination($count);
		// элементов на страницу
		$pages->pageSize = 12;
		$pages->applyLimit($criteria);
		$data['pages']=$pages;



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

		$this->setSEO(Yii::app()->request->requestUri, 'Каталог продукции', $model);
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


	private function getChaildCategory($model){
		$menu_top = array();
		foreach ( CatalogRubrics::getCatalogList($model) as $data ){
			$menu_top[$data->id]['name'] = $data->name;
			$menu_top[$data->id]['url'] = $data->url;
		}
		return $menu_top;
	}


}
