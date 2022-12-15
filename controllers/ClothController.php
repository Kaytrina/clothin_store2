<?php
namespace app\controllers;
use yii\rest\ActiveController;
use app\controllers\FunctionController;
use Yii;
use app\models\Cloth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UploadedFile;

class ClothController extends FunctionController
{
    public $modelClass = 'app\models\Cloth';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only'=>['prod','product','del3']
        ];
        return $behaviors;
    }


    public function actionCloth()
    {
        $cloth = Cloth::find()
            ->IndexBy('product_number')
            ->all();
        return $this->send(200, ['Cloth'=>$cloth]);
    }


    public function actionProd()
    {
        if (!$this->is_admin()) return $this->send(403,['message'=>'В доступе отказано!']);
        $request=Yii::$app->request->post(); //получение данных из post запроса
        $cloth=new Cloth($request); // Создание модели на основе присланных данных
        $cloth->product_pic = UploadedFile::getInstanceByName('product_pic');
        $image_name='/controllers/pic/'. Yii::$app->getSecurity()->generatePasswordHash($cloth->product_pic->baseName) .
            '.' . $cloth->product_pic->extension;
        $cloth->product_pic->saveAs(Yii::$app->basePath.$image_name);
        $cloth->product_pic=$image_name;
        if (!$cloth->validate()) return $this->validation($cloth); //Валидация модели
        $cloth->save();//Сохранение модели в БД
        return $this->send(201, ['content'=>['code'=>201, 'message'=>'Товар добавлен']]);//Отправка сообщения пользователю
    }

    public function actionProduct($product_number)
    {
        if (!$this->is_admin()) return $this->send(403,['message'=>'В доступе отказано!']);
        $request=Yii::$app->request->getBodyParams();
        $cloth=Cloth::findOne($product_number);
        foreach ($request as $key => $value){
            $cloth->$key=$value;
        }
        if (!$cloth->validate()) return $this->validation($cloth); //Валидация модели
        $cloth->save();//Сохранение модели в БД
        return $this->send(201, ['content'=>['code'=>201, 'message'=>'Товар изменен']]);//Отправка сообщения пользователю
    }

    public function actionDel3($product_number)
    {
        $cloth=Cloth::findOne($product_number);
        if (!$this->is_admin()) return $this->send(403,['message'=>'В доступе отказано!']);
        $cloth->delete();
        return $this->send(200,['body'=>['data','message'=>'Товар удалён']]);
    }
}