<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $restaurant_id
 * @property integer $date
 * @property integer $datestart
 * @property integer $dateend
 * @property integer $table
 * @property integer $guests
 * @property integer $type
 * @property integer $status
 * @property string $promo
 * @property string $address
 *
 * @property OrdersItems[] $ordersItems
 * @property User[] $user
 */
class Orders extends ActiveRecord
{

    const STATUS_NEW        = 0;
    const STATUS_PREPARING  = 1;
    const STATUS_COMPLETE   = 2;
    const STATUS_CANCELED   = 3;


    const TYPE_DINE_IN      = 0;
    const TYPE_TAKE_AWAY    = 1;
    const TYPE_DELIVERY     = 2;
    const TYPE_RESERVATIONS = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'restaurant_id'], 'required'],
            [['promo', 'address'], 'string'],
            [['type'], 'required', 'message' => '{attribute} required. Possible values: 0-Dine in, 1-Take Away, 2-Delivery, 3-Reservations'],

            [['date', 'table', 'guests','type','status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'Order',
            'user_id'       => 'User',
            'restaurant_id' => 'Restaurant',
            'date'          => 'Date',
            'table'         => 'Table',
            'guests'        => 'Guests',
            'promo'         => 'PromoCode',
        ];
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->user_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

    public static function find()
    {
        if(Yii::$app->user->can("manager")){
            // manager see orders form related to him restaurant
            return parent::find()->where("orders.restaurant_id=".Yii::$app->user->identity->restaurant_id);
        }else{
            // user can see only their orders
            return parent::find()->where("user_id=".Yii::$app->user->id);
        }
    }


    public static function getStatuses($status = null){

        $result = [
            self::STATUS_NEW          => "New",
            self::STATUS_PREPARING    => "Preparing",
            self::STATUS_COMPLETE     => "Completed",
            self::STATUS_CANCELED     => "Cancelled",
        ];

        return $status !== null ? ArrayHelper::getValue($result, $status) : $result;
    }

    public static function getTypes($type = null){

        $result = [
            self::TYPE_DINE_IN      => "Dine In",
            self::TYPE_TAKE_AWAY    => "Take Away",
            self::TYPE_DELIVERY     => "Delivery",
            self::TYPE_RESERVATIONS => "Reservations",
        ];

        return $type !== null ? ArrayHelper::getValue($result, $type) : $result;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersItems()
    {
        return $this->hasMany(OrdersItems::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }


    /**
     * For rest api
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields["restaurant_name"] = function(){
            return RestaurantProfile::findOne(["user_id" => $this->restaurant->id])->name;
        };
        $fields[] = "ordersItems";

        return $fields;
    }

    /**
     * @param $order_id integer
     * @return int
     */
    public static function getOrderPrice($order_id)
    {
        $items = OrdersItems::find()->where("order_id =".$order_id)->all();
        if(empty($items)){
            return 0;
        }

        foreach ((array)$items as $_info) {
            $menus_arr[$_info->menu_id] = $_info->menu_id;
        }

        $menus = Menu::find()->where(["id"=>$menus_arr])->all();
        foreach ((array)$menus as $_info) {
            $price_arr[$_info->id] = $_info->price;
        }

        $price = 0;
        foreach ((array)$items as $_info) {
            $price += $_info->count*$price_arr[$_info->menu_id];
        }

        return $price;
    }


    /**
     * @return array|int|mixed
     */
    public function getDateStart(){
        $date_start = Yii::$app->request->post("date_start");
        if(empty($date_start)){
            return $date_start;
        }
        return strtotime($date_start);
    }

    /**
     * @return array|int|mixed
     */
    public function getDateEnd(){
        $date_end = Yii::$app->request->post("date_end");
        if(empty($date_end)){
            return $date_end;
        }
        $date_end_stamp = strtotime($date_end) + 86400;
        return $date_end_stamp;
    }


    /**
     * For rest api
     * @return array
     */

    /*
    public function extraFields()
    {
        return ["ordersItems"];
    }
    */

}
