<?php
namespace app\controllers;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use Yii;
use app\models\User;
use app\models\LoginForm;
use app\controllers\FunctionController;

class UserController extends FunctionController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only'=>['delete'],
            'only'=>['del']
        ];
        return $behaviors;
    }

    public function actionRegister()
    {
        $request=Yii::$app->request->post(); //получение данных из post запроса
        $user=new User($request); // Создание модели на основе присланных данных
        if (!$user->validate()) return $this->validation($user); //Валидация модели
        $user->password=Yii::$app->getSecurity()->generatePasswordHash($user->password); //хэширование пароля
        $user->save();//Сохранение модели в БД
        return $this->send(201, ['content'=>['code'=>201, 'message'=>'Вы зарегистрировались']]);//Отправка сообщения пользователю
    }
    public function actionAuth()
    {
        $request=Yii::$app->request->post();//Здесь не объект, а ассоциативный массив
        $loginForm=new LoginForm($request);
        if (!$loginForm->validate()) return $this->validation($loginForm);
        $user=User::find()->where(['phone'=>$request['phone']])->one();
        if (isset($user) && Yii::$app->getSecurity()->validatePassword($request['password'], $user->password)){
            $user->token=Yii::$app->getSecurity()->generateRandomString();
            $user->save(false);
            return $this->send(200, ['content'=>['token'=>$user->token],'message'=>'Пользователь авторизован']);//['user'=>$user]
        }
        return $this->send(401, ['content'=>['code'=>401, 'message'=>'Неверный телефон или пароль']]);
    }

    public function actionDelete()
    {
        $user=Yii::$app->user->identity;
        $user->delete();
        return $this->send(200,['body'=>['data','message'=>'Пользователь удалён']]);
    }

    public function actionDel()
    {
        if (!$this->is_admin())
            return $this->send(403,['message'=>'В доступе отказано']);  //Проверка на админа
        $user=Yii::$app->user->identity;
        $user->delete();
        return $this->send(200,['body'=>['data','message'=>'Пользователь удалён']]);
        
    }

    public function actionEdit($user_id)
    {
        $request=Yii::$app->request->getBodyParams();
        $user=User::findOne($user_id);
        foreach ($request as $key => $value){
            $user->$key=$value;
        }
        $user->password=Yii::$app->getSecurity()->generatePasswordHash($user->password);  //хэширование пароля
        if (!$user->validate())
            return $this->validation($user);   //Валидация модели
        $user->save();  //Сохранение модели в БД
        return $this->send(201, ['content'=>['code'=>200, 'message'=>'Данные изменены']]);  //Отправка сообщения пользователю
    }

}