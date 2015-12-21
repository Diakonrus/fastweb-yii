<?php

class BasketController extends Controller
{

    public $layout='//layouts/mainpage';

    public function actionOrders() {

        $this->breadcrumbs = array(
            'Заказы'=>array('/basket/basket/orders'),
        );

        $model=new BasketOrder('search');
        $model->unsetAttributes();  // clear any default values

        // set attributes from get
        if ( !empty($_GET['BasketOrder']) ){
            $model->attributes=$_GET['BasketOrder'];
        }


        $param = array();
        if (!empty($model->created_at)){
            $arrDates = str_replace(" ","",$model->created_at);
            $arrDates = explode("-", $arrDates);
            $param[] = " DATE(created_at) BETWEEN '".date('Y-m-d', strtotime($arrDates[0]))."' AND '".date('Y-m-d', strtotime($arrDates[1]))."' ";
        }


        $provider = new CActiveDataProvider('BasketOrder', array(
            'sort'=>array(
                'defaultOrder'=>'created_at DESC',
            ),
            'Pagination' => array (
                'PageSize' => 50,
            ),
        ));

        $provider->criteria = $model->search(((!empty($param))?(implode(" AND ", $param)):null));

        $this->render('orders',array(
            'model'=>$model,
            'provider'=>$provider,
        ));
    }

    public function actionUpdate($id) {

        $this->breadcrumbs = array(
            'Заказы'=>array('/basket/basket/orders'),
            'Редактирование'
        );

        $model = $this->loadModel($id);
        $modelProduct = BasketItems::model()->findAll('basket_order_id='.$model->id);

        if (isset($_POST['BasketOrder'])){
            //Если изменили статус - меняю значение в поле status_at
            if($model->status !=  $_POST['BasketOrder']['status']){ $model->status_at = date('Y-m-d H:i:s'); }
            $model->attributes = $_POST['BasketOrder'];
            if ($model->save()){
                //Обновляем количество товаров
                unset($_POST['BasketOrder']);
                foreach ($_POST as $key=>$value){
                    $quantity = explode("_", $key);
                    if (isset($quantity[1])){
                        $model = BasketItems::model()->findByPk((int)$quantity[1]);
                        if ($model && (int)$value>0){
                            $model->quantity = (int)$value;

                            //Обновляем цену
                            $model->price = BasketItems::model()->returnPrice((int)$model->item, $model->quantity);


                            $model->save();
                        }
                    }
                }
                $this->redirect('orders');
            }


        }



        $this->render('update',array(
            'model'=>$model,
            'modelProduct'=>$modelProduct,
        ));
    }

    public function actionStat(){

        $model = array();
        $param = null;

        if (isset($_POST['Filter'])){
            $paramArr = array();
            if (isset($_POST['Filter']['status'])){
                $status = array();
                foreach ($_POST['Filter']['status'] as $key=>$val){
                    $status[] = $key;
                }
                $paramArr[] = ' status in ('.(implode(',',$status)).') ';
            }
            if (!empty($_POST['Filter']['period'])){
                $arrDates = str_replace(" ","",$_POST['Filter']['period']);
                $arrDates = explode("-", $arrDates);
                $paramArr[] = " DATE(created_at) BETWEEN '".date('Y-m-d', strtotime($arrDates[0]))."' AND '".date('Y-m-d', strtotime($arrDates[1]))."' ";
            }

            $param = implode(" AND ", $paramArr);
        }


        foreach (BasketOrder::model()->findAll($param) as $data){

            $i = 0;
            foreach (BasketItems::model()->findAll('basket_order_id='.$data->id) as $data_product){

                $product = Yii::app()->db->createCommand()
                    ->select('name')
                    ->from('{{'.$data_product->module.'_elements}}')
                    ->where('id='.(int)$data_product->item)
                    ->queryRow();

                $model[$data->id][$i]['name'] = $product['name'];
                $model[$data->id][$i]['quantity'] = $data_product->quantity;
                $model[$data->id][$i]['date'] = $data->created_at;
                ++$i;
            }

        }

        $this->render('stat',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id)
    {
        $model=BasketOrder::model()->findByPk($id);

        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }

        return $model;
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $id = Yii::app()->request->getParam('id', array());
            $list = is_array($id) ? $id : array($id);
            foreach($list as $id){
                //удаляем товары в заказе
                BasketItems::model()->deleteAll('basket_order_id = '.(int)$id);
                //удаляем саму запись
                $this->loadModel($id)->delete();
            }
        }
        else {
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDeleteproduct($id){
        $model = BasketItems::model()->findByPk($id);
        $modelOrder = $this->loadModel($model->basket_order_id);
        $model->delete();
        //Проверяем есть ли еще товары в заказе - если нет, удаляем заказ
        $model = BasketItems::model()->find('basket_order_id='.$modelOrder->id);
        if (!$model){
            $modelOrder->delete();
            $this->redirect('/admin/basket/basket/orders');
        }
        $this->redirect('/admin/basket/basket/update?id='.$model->id);
    }

}
