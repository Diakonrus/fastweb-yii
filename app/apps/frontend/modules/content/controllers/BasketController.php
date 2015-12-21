<?php

class BasketController extends Controller
{
	public $layout='//layouts/main';

    public function init(){

        /*
        if (Yii::app()->user->isGuest){
            $this->redirect('/login');
        }
        */
    }

	public function actionIndex()
	{

        //Не оформленые товары
        //$modelBasketOrder = BasketOrder::model()->find('status=0 AND user_id = '.(int)Yii::app()->user->id);
        //$modelBasket = BasketItems::model()->findAll('basket_order_id='.$modelBasketOrder->id);

        $modelBasketOrder = new BasketOrder;
        $modelBasket = new BasketItems;
        $product = array();

        //Тянем из куки заказаные товары
        $cookies = Yii::app()->request->cookies;
        $basket = array();
        if ( isset($cookies['basket']) ){
            $basket = $cookies['basket']->value;
            $basket = unserialize($basket);
        }



        if (isset($_POST['BasketOrder']) || isset($cookies['basket_addres'])){

            if (isset($_POST['BasketOrder'])){
                $basket_addres = array();
                $basket_addres['address'] = $_POST['BasketOrder']['address'];
                $basket_addres['phone'] = $_POST['BasketOrder']['phone'];
                $basket_addres['comments'] = $_POST['BasketOrder']['comments'];
                $basket_addres = new CHttpCookie('basket_addres',(serialize($basket_addres)));
                $cookies['basket_addres'] = $basket_addres;
            }


            //Если пользователь не авторизован - перенаправляем на авторизацию
            if (Yii::app()->user->isGuest){
                $this->redirect('/login');
            }


            //Получаем значения из куки
            $basket = $cookies['basket']->value;
            $basket = unserialize($basket);
            $basket_addres = $cookies['basket_addres']->value;
            $basket_addres = unserialize($basket_addres);

            //Убиваем куки
            unset($cookies['basket']);
            unset($cookies['basket_addres']);

            //Пишим в БД
            $modelBasketOrder->user_id = Yii::app()->user->id;
            $modelBasketOrder->address = $basket_addres['address'];
            $modelBasketOrder->phone = $basket_addres['phone'];
            $modelBasketOrder->comments = $basket_addres['comments'];
            $modelBasketOrder->status = 1;
            $modelBasketOrder->status_at = date('Y-m-d H:i:s');
            if ( $modelBasketOrder->save() ){

                foreach ( $basket as $key=>$val ){
                    $modelBasket = new BasketItems;
                    $modelBasket->basket_order_id = $modelBasketOrder->id;
                    $modelBasket->module = $val['module'];
                    $modelBasket->url = $val['url'];
                    $modelBasket->quantity = (int)$val['quantity'];
                    $modelBasket->item = $val['item'];

                    //Цена есть в куки, но мы ее пересчитаем сами - защита от "умных" пользователей
                    $modelBasket->price = BasketItems::model()->returnPrice($modelBasket->item, $modelBasket->quantity);
                    $modelBasket->trueprice = CatalogElements::model()->findByPk($val['item'])->price;

                    $modelBasket->save();

                }
                //отправляем письмо админу о заказе
                $this->sendEmailAdmin($modelBasketOrder->id);
                $this->redirect('/basket/success');
            }


        }

        $i = 0;
        $discount = array();
        foreach ($basket as $key=>$val){

            //Получаем о товаре данные
            $table_name = 'catalog_elements';

            $requests = Yii::app()->db->createCommand()
                ->select('name, code, qty, price, price_entering')
                ->from('{{'.$table_name.'}}')
                ->where('id = '.(int)$val['item'])
                ->queryRow();

            $product[$i]['element'] = (int)$val['item'];
            $product[$i]['key'] = $key;
            $product[$i]['quantity'] = $val['quantity'];
            $product[$i]['name'] = $requests['name'];
            $product[$i]['code'] = $requests['code'];
            $product[$i]['qty'] = $requests['qty'];
            $product[$i]['price'] = $val['price'];
            ++$i;
        }

        if (!Yii::app()->user->isGuest){
            $user_data = User::model()->findByPk(Yii::app()->user->id);
            $modelBasketOrder->phone = $user_data->phone;
            $modelBasketOrder->address = (!empty($modelBasketOrder->address))?$modelBasketOrder->address:$user_data->fiz_addres;
        }


        $this->render('index', array(
            'model'=>$product,
            'discount'=>$discount,
            'modelBasketOrder'=>$modelBasketOrder,
        ));
	}

    //пересчет товаров в корзине
    public function actionAjaxrecount(){

        if ($_POST){

            $cookies = Yii::app()->request->cookies;
            $basket = $cookies['basket']->value;
            $basket = unserialize($basket);

            foreach($_POST as $key=>$quantity){
                //Проверяю что количество >0
                if ((int)$quantity<=0){continue;}
                $basket[$key]['quantity'] = (int)$quantity;
                //Пересчитываем цену
                $basket[$key]['price'] = BasketItems::model()->returnPrice((int)$basket[$key]['item'], $basket[$key]['quantity']);
            }
            $basket = new CHttpCookie('basket',(serialize($basket)));
            $cookies['basket'] = $basket;
        }
        echo 'ok';
        Yii::app()->end();
    }


    // удаление товара из корзины
    public function actionAjaxdelete(){

        if ($_POST && isset($_POST['id'])){
            $key = $_POST['id'];
            $cookies = Yii::app()->request->cookies;
            $basket = $cookies['basket']->value;
            $basket = unserialize($basket);
            unset($basket[$key]);
            if (empty($basket)){
                unset($cookies['basket']);
            } else {
                $basket = new CHttpCookie('basket',(serialize($basket)));
                $cookies['basket'] = $basket;
            }

        }
        echo 'ok';
        Yii::app()->end();
    }

    //Товары успешно оформлены
    public function actionSuccess(){
        $this->render('success', array());
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=BasketOrder::model()->findByPk($id);

        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }

        return $model;
    }

    public function loadModelItems($id)
    {
        $model=BasketItems::model()->findByPk($id);

        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }

        return $model;
    }


    //Отправляет письмо админу
    private function sendEmailAdmin($id){
        $email = "info@admin.ru";
        $subject = "Новый заказ товаров";


        $model = $this->loadModel((int)$id);
        $bayerName = User::model()->findByPk((int)Yii::app()->user->id);

        $body = "<b>Заказ товара покупателем: ".((!empty($bayerName->first_name))?($bayerName->first_name):('не указан'))."</b><BR>";
        $body_address =
            'Адрес доставки заказа: '.$model->address.'<BR>
                Телефон: '.$model->phone.'<BR>
                Примечания: '.$model->comments.'<BR>
                ';
        $body .= '<table style="border: 1px solid #000000">';
        $body .= '<thead><tr><th>Название</th><th>Ссылка на товар</th><th>Заказаное количество</th></tr></thead>';
        $body .= '<tbody>';
        foreach ( BasketItems::model()->findAll('basket_order_id = '.$model->id) as $data  ){
            $productModel = Yii::app()->db->createCommand()
                ->select('name')
                ->from('{{'.$data->module.'_elements}}')
                ->where('id='.(int)$data->item)
                ->queryRow();
            $body .= '
                <tr>
                    <td>'.$productModel['name'].'</td>
                    <td>'.SITE_NAME_FULL.'/'.$data->url.'</td>
                    <td>'.$data->quantity.'</td>
                </tr>
                ';
        }
        $body .= '
            </tbody>
            </table>';
        $body .= '<b>Указаные при заказе данные о доставки товара:</b><BR>';
        $body .= $body_address;

        $body .= '<b>Информация о пользователе:</b><BR>';
        $body .= "
                            Покупатель: ".((!empty($bayerName->first_name))?($bayerName->first_name):('не указан'))."<BR>
                            Организация: ".((!empty($bayerName->organization))?($bayerName->organization):('не указана'))."<BR>
                            Юр. адрес: ".((!empty($bayerName->ur_addres))?($bayerName->ur_addres):('не указан'))."<BR>
                            Физ. адрес: ".((!empty($bayerName->fiz_addres))?($bayerName->fiz_addres):('не указан'))."<BR>
                            ИНН: ".((!empty($bayerName->inn))?($bayerName->inn):('не указан'))."<BR>
                            КПП: ".((!empty($bayerName->kpp))?($bayerName->kpp):('не указан'))."<BR>
                            ОКПО: ".((!empty($bayerName->okpo))?($bayerName->okpo):('не указан'))."<BR>
                            Email: ".$bayerName->email."<BR>
                            ";

        Yii::app()->mailer->send(array('email'=>$email, 'subject'=>$subject, 'body'=>$body));

        return true;
    }

}