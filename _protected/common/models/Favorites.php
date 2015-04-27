<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "favorites".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $restaurant_id
 *
 * @property User $user
 * @property User $restaurant
 */
class Favorites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'restaurant_id'], 'required'],
            [['user_id', 'restaurant_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'restaurant_id' => 'Restaurant ID',
        ];
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
        return $this->hasOne(User::className(), ['id' => 'restaurant_id']);
    }


    public static function find()
    {
        if(Yii::$app->user->can("manager")){
            // manager see orders form related to him restaurant
            return parent::find()->where("favorites.restaurant_id=".Yii::$app->user->identity->restaurant_id);
        }else{
            // user can see only their orders
            return parent::find()->where("user_id=".Yii::$app->user->id);
        }
    }

    /**
     * For rest api
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields["restaurant_name"] = function(){
            return RestaurantProfile::findOne(["user_id" => $this->restaurant_id])->name;
        };

        return $fields;
    }

}
