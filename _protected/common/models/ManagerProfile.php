<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "manager_profile".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property integer $id_number
 * @property integer $access_home
 * @property integer $access_orders
 * @property integer $access_schedule
 *
 * @property User $user
 */
class ManagerProfile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'manager_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_number', 'access_home', 'access_orders', 'access_schedule', 'access_items'], 'required'],
            [['id_number', 'access_home', 'access_orders', 'access_schedule', 'access_items'], 'integer'],
            [['firstname', 'lastname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'id_number' => 'Id Number',
            'access_home' => 'Access Home',
            'access_orders' => 'Access Orders',
            'access_schedule' => 'Access Schedule',
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
