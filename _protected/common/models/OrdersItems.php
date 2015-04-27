<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders_items".
 *
 * @property integer $order_id
 * @property integer $menu_id
 * @property integer $count
 * @property string $price
 * @property integer $tax
 *
 *
 * @property Menu $menu
 * @property Orders $order
 */
class OrdersItems extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'menu_id', 'count'], 'required'],
            [['price'], 'string'],
            [['order_id', 'menu_id', 'count','tax'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'menu_id' => 'Menu ID',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->count * $this->price;
    }

    /**
     * For rest api
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields["item_name"] = function(){
            return $this->menu->name;
        };

        return $fields;
    }

}
