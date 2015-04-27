<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tables".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property string $name
 * @property integer $pax
 *
 * @property User $restaurant
 */
class Tables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pax'], 'required'],
            [['restaurant_id', 'pax'], 'integer'],
            [['name'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'Restaurant ID',
            'name' => 'Table Name',
            'pax' => 'Pax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(User::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->restaurant_id = Yii::$app->user->identity->restaurant_id;
        return parent::beforeSave($insert);
    }


    public static function find()
    {
        if(Yii::$app->user->can("manager")){
            // manager see orders form related to him restaurant
            return parent::find()->where("tables.restaurant_id=".Yii::$app->user->identity->restaurant_id);
        }else{
            // user can see only their orders
            return parent::find()->where("user_id=".Yii::$app->user->id);
        }
    }

}
