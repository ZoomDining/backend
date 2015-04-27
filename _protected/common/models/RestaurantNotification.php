<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "restaurant_notification".
 *
 * @property integer $user_id
 * @property integer $daily_summary
 * @property integer $events_info
 * @property integer $customer_feedback
 * @property integer $transaction_email
 * @property string $email
 *
 * @property User $user
 */
class RestaurantNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['daily_summary', 'events_info', 'customer_feedback', 'transaction_email', 'email'], 'required'],
            [['daily_summary', 'events_info', 'customer_feedback', 'transaction_email'], 'integer'],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'daily_summary' => 'Daily Summary',
            'events_info' => 'Events Info',
            'customer_feedback' => 'Customer Feedback',
            'transaction_email' => 'Transaction Email',
            'email' => 'Email',
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
