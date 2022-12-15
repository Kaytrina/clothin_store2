<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $order_number ид заказа
 * @property int $product_number ид заказываемого продукта
 * @property int $amount кол-во заказанного продукта
 * @property int $store_id ид магазина
 * @property int $user_id
 * @property string $order_status
 *
 * @property Cloth $productNumber
 * @property Store $store
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_number', 'amount', 'store_id', 'user_id', 'order_status'], 'required'],
            [['product_number', 'amount', 'store_id', 'user_id'], 'integer'],
            [['order_status'], 'string', 'max' => 100],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'store_id']],
            [['product_number'], 'exist', 'skipOnError' => true, 'targetClass' => Cloth::className(), 'targetAttribute' => ['product_number' => 'product_number']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_number' => 'Order Number',
            'product_number' => 'Product Number',
            'amount' => 'Amount',
            'store_id' => 'Store ID',
            'user_id' => 'User ID',
            'order_status' => 'Order Status',
        ];
    }

    /**
     * Gets query for [[ProductNumber]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductNumber()
    {
        return $this->hasOne(Cloth::className(), ['product_number' => 'product_number']);
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
