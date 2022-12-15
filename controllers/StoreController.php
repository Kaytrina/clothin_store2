<?php
namespace app\controllers;
use yii\rest\ActiveController;
use app\controllers\FunctionController;
use Yii;
use app\models\Store;
use yii\filters\auth\HttpBearerAuth;


class StoreController extends FunctionController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only'=>['add','del2']
        ];
        return $behaviors;
    }

    public $modelClass = 'app\models\Store';


    public function actionStore()
    {
        $store = Store::find()
            ->IndexBy('store_id')
            ->all();
        return $this->send(200, ['Store'=>$store]);
    }

    public function actionAdd()
    {
        if (!$this->is_admin()) return $this->send(403,['message'=>'В доступе отказано!']);
        $request=Yii::$app->request->post(); //получение данных из post запроса
        $store=new Store($request); // Создание модели на основе присланных данных
        if (!$store->validate()) return $this->validation($store); //Валидация модели
        $store->save();//Сохранение модели в БД
        return $this->send(201, ['content'=>['code'=>201, 'message'=>'Магазин добавлен']]);//Отправка сообщения пользователю
    }

    public function actionDel2($store_id)
    {
        $store=Store::findOne($store_id);
        if (!$this->is_admin()) return $this->send(403,['message'=>'В доступе отказано!']);
        //$store=Yii::$app->store->identity;
        $store->delete();
        return $this->send(200,['body'=>['data','message'=>'Магазин удалён']]);

    }
}