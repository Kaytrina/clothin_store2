<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $user_id ид пользователя
 * @property string $first_name имя пользователя
 * @property string $last_name фамилия пользователя
 * @property string $patronymic отчество пользователя
 * @property string $email почта пользователя
 * @property string $phone телефон пользователя
 * @property int $store_id ид адреса магазина
 * @property string $password пароль пользователя
 * @property int|null $is_admin админ - 1
 пользователь - 0
 *
 * @property Order[] $orders
 * @property Store $store
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return;
    }

    public function validateAuthKey($authKey)
    {
        return;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'patronymic', 'email', 'phone', 'store_id', 'password'], 'required'],
            [['store_id', 'is_admin'], 'integer'],
            [['first_name', 'last_name', 'patronymic', 'email', 'password'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 12],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'store_id']],
            [['token'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'patronymic' => 'Patronymic',
            'email' => 'Email',
            'phone' => 'Phone',
            'store_id' => 'Store ID',
            'password' => 'Password',
            'is_admin' => 'Is Admin',
            'token' => 'Token',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Store]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['store_id' => 'store_id']);
    }
}
