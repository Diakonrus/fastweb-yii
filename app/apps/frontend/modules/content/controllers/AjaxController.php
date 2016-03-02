<?php

class AjaxController extends Controller
{
	public $layout='//layouts/main';


	public function actionIndex()
	{
		//echo 123; exit;

        //Сравнение товаров
        if ( isset($_GET['e']) && isset($_GET['m']) && $_GET['m']=='47' && isset($_GET['u']) ){
            //Пишу в ссесию
            if (empty(Yii::app()->session['compare_selection'])){ Yii::app()->session->add('compare_selection',array()); }
            $compare_selection = Yii::app()->session['compare_selection'];
            $add_compare_selection = array($_GET);
            Yii::app()->session->add('compare_selection',array_merge($compare_selection, $add_compare_selection));
        }

        //Удаление из сравнения товаров
        if ( isset($_GET['id']) && isset($_GET['type']) && $_GET['type'] == "delete" ){
            //Пишу в ссесию
            if (empty(Yii::app()->session['compare_selection'])){ Yii::app()->session->add('compare_selection',array()); }
            $compare_selection = Yii::app()->session['compare_selection'];
            $add_compare_selection = array();
            if (!empty($compare_selection)){
                foreach ( $compare_selection as $key=>$value ){
                    if ($value['e'] == (int)$_GET['id']){continue;}
                    $add_compare_selection[] = $value;
                }
            }

            Yii::app()->session->add('compare_selection',$add_compare_selection);
            echo 'ok';
        }

        //Количество не оформленых товаров в корзине
        if ( isset($_GET['basket']) && $_GET['basket'] == "getcount" ){
            $result = 0;
            $cookies = Yii::app()->request->cookies;
            if (!empty($cookies['basket']) && $basket = $cookies['basket']->value){
                $basket = unserialize($basket);
                foreach ($basket as $key=>$value){
                    $result = (int)$result + (int)$value['quantity'];
                }
            }

            /*
            if (!Yii::app()->user->isGuest){
                $basketCount = 0;
                $arr_id = null;
                foreach( Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('{{basket_order}}')
                    ->where('status=0 AND user_id='.(int)Yii::app()->user->id)
                    ->queryAll() as $val){
                    $arr_id[] = $val['id'];
                }
                if (!empty($arr_id)){
                    $arr_id = implode(",", $arr_id);
                    $basketCount = Yii::app()->db->createCommand()
                        ->select('sum(quantity) as count')
                        ->from('{{basket_items}}')
                        ->where('basket_order_id in ('.$arr_id.')')
                        ->queryRow();
                    $result = (int)((current($basketCount)));
                }
            }
            */
            echo $result;
        }

        //Добавление товара в корзину
        if ( isset($_POST['m']) && $_POST['m'] == "31" && isset($_POST['path']) && isset($_POST['module']) && isset($_POST['parent_id']) ){
        
            $quantity = 1;
            $k = $_POST['path'];

            //Пишем в куки заказаные товары
            $cookies = Yii::app()->request->cookies;

            $basket = array();
            //Получаем заказаные ранее товары из куки
            if ( isset($cookies['basket']) ){
                $basket = $cookies['basket']->value;
                $basket = unserialize($basket);
            }
            //Если есть заказаный ранее такой товар - увеличиваем кол-во на 1
            $basket[$k]['quantity'] = (isset($basket[$k])?((int)$basket[$k]['quantity'] + $quantity):($quantity));
            $basket[$k]['module'] = $_POST['module'];
            $basket[$k]['url'] = $_POST['path'];
            $basket[$k]['item'] = $_POST['parent_id'];
            $basket[$k]['price'] = BasketItems::model()->returnPrice((int)$_POST['parent_id'], $basket[$k]['quantity']);

            $basket = new CHttpCookie('basket',(serialize($basket)));
            $cookies['basket']=$basket;


            echo 'ok';
        }



        Yii::app()->end();
	}

}
