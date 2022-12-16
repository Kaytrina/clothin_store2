<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$config = [
    'id' => 'basic',
    'name'=>'clothing_store',
    'language'=>'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
'cookieValidationKey' => '1110-20',
'parsers' => [
    'application/json' => 'yii\web\JsonParser',
]
],
'cache' => [
    'class' => 'yii\caching\FileCache',
],

/*Добавьте этот компонент для формирования ответа
здесь формируется ответ если пользователь неавторизован
см. Методические указания стр. 21*/
'response' => [
    'class' => 'yii\web\Response',
    'on beforeSend' => function ($event) {
        $response = $event->sender;
        if ($response->data !== null && $response->statusCode==401) {
            $response->data = ['error'=>['code'=>403, 'message'=>'Unauthorized']];
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
        }
    },
],

'user' => [
    'identityClass' => 'app\models\User',
    'enableAutoLogin' => true,
],
'errorHandler' => [
    'errorAction' => 'site/error',
],
'mailer' => [
    'class' => 'yii\swiftmailer\Mailer',
// send all mails to a file by default. You have to set
// 'useFileTransport' to false and configure transport
// for the mailer to send real emails.
'useFileTransport' => true,
],
'log' => [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'targets' => [
        [ 'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
        ],
    ],
],
'db' => $db,

'urlManager' => [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
        'GET user' => 'user/account',  //просмотр пользователя
        'POST register' => 'user/register', //регистрация пользователя
        'POST auth' => 'user/auth', //авторизация пользователя

        'PUT edit/<user_id>' => 'user/edit',  //редактирование данных польз.
        'DELETE delete' => 'user/delete',  //удаление польз.
        'DELETE del/<user_id>' => 'user/del',  //удаление польз. адм.

        'POST order' => 'order/order',  //оформление заказа

        'POST prod' => 'cloth/prod',  //добавление товара адм.
        'DELETE del3/<product_number>' => 'cloth/del3',  //удаление товара адм.
        'PUT product/<product_number>' => 'cloth/product',  //редактирование товара адм.
        'GET cloth' => 'cloth/cloth',  //просмотр товаров

        'POST add' => 'store/add',  //добавление магазина адм.
        'DELETE del2/<store_id>' => 'store/del2',  //удаление магазина адм.
        'GET store' => 'store/store',  //просмотр магазинов
    ],
]
],
'params' => $params,
];
if (YII_ENV_DEV) {
// configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
// uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '*'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
// uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','*' ],
    ];
}
return $config;