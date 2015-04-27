<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "taxes".
 *
 * @property integer $user_id
 * @property string $name
 * @property integer $tax
 * @property integer $status
 *
 * @property User $user
 */
class Taxes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'taxes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'tax'], 'required'],
            [['tax', 'status'], 'integer'],
            [['name'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'tax' => 'Tax',
            'status' => 'Enable Tax',
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
