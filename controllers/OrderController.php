<?php
namespace app\controllers;
use yii\rest\ActiveController;
use app\controllers\FunctionController;
use Yii;
use app\models\Order;
use yii\filters\auth\HttpBearerAuth;

class OrderController extends FunctionController
{
    public $modelClass = 'app\models\Order';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only'=>['order']
        ];
        return $behaviors;
    }

    public function actionOrder()
    {
        $user=Yii::$app->user->identity; //Проверка авторизации
        $request=Yii::$app->request->post(); //получение данных из post запроса
        $order=new Order($request); // Создание модели на основе присланных данных

        if (!$order->validate()) return $this->validation($order); //Валидация модели
        $order->save();//Сохранение модели в БД
        return $this->send(201, ['content'=>['code'=>201, 'order_number'=>$order->order_number, 'message'=>'Заказ принят']]);
    }
}