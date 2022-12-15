<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cloth".
 *
 * @property int $product_number ид товара
 * @property string $product_name название товара
 * @property string $product_pic изображение товара
 * @property string $characteristic характеристика товара
 * @property string $category категория
 * @property int $prod_amount кол-во товара на складе
 *
 * @property Order[] $orders
 */
class Cloth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cloth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'characteristic', 'category', 'prod_amount'], 'required'],
            [['prod_amount'], 'integer'],
            [['product_name', 'characteristic', 'category'], 'string', 'max' => 100],
            [['product_pic'], 'file']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_number' => 'Product Number',
            'product_name' => 'Product Name',
            'product_pic' => 'Product Pic',
            'characteristic' => 'Characteristic',
            'category' => 'Category',
            'prod_amount' => 'Prod Amount',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['product_number' => 'product_number']);
    }
}
