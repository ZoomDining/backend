<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "restaurant_receipt".
 *
 * @property integer $user_id
 * @property integer $show_description
 *
 * @property User $user
 */
class RestaurantReceipt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant_receipt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['show_description'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'show_description' => 'Show Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
