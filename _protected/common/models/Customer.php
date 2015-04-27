<?php
namespace common\models;

use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Customer extends User {

    public $password;

    public function rules()
    {
        $result = [
            ['username', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],


            [['username','email'], 'required'],
            ['username', 'unique', 'targetClass'=>'\common\models\User', 'message' => Yii::t('frontend', 'This username has already been taken.')],


            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'default', 'value' => self::ROLE_USER],
        ];


        if($this->isNewRecord){
            $result[] = ['password', 'required'];
            $result[] = ['password', 'string', 'min' => 6];
        }else{
            $result[] = ['password', 'string', 'min' => 6];
        }

        return $result;
    }


    public static function find()
    {
        return parent::find()->where("role = ".User::ROLE_USER)->andWhere("restaurant_id=".Yii::$app->user->id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
    /**
     * @return string
     */
    public function getFirstname()
    {
        if(!$this->isNewRecord) {
            return $this->userProfile->firstname;
        }
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        if(!$this->isNewRecord) {
            return $this->userProfile->phone;
        }
    }
	
    /**
     * @return string
     */
    public function getAddress()
    {
        if(!$this->isNewRecord) {
            return $this->userProfile->address;
        }
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        if(!$this->isNewRecord) {
            return $this->userProfile->lastname;
        }
    }

}
