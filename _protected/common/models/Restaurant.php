<?php
namespace common\models;

use Yii;

/**
 * User model
 *
 * @property integer $id
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
class Restaurant extends User {

    public $password;

    public function rules()
    {
        $result = [
            ['username', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],


            [['username'], 'required'],
            ['username', 'unique', 'targetClass'=>'\common\models\User', 'message' => Yii::t('frontend', 'This username has already been taken.')],


            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'default', 'value' => self::ROLE_RESTAURANT],
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
        return parent::find()->where("role = ".User::ROLE_RESTAURANT);
    }


    public function beforeSave($insert)
    {
        // save password and remember me key
        if(!empty($this->password)){
            $this->setPassword($this->password);
            $this->generateAuthKey();
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            // set restaurant_id the same like id, because we are owner of restaurant
            static::updateAll([
                "restaurant_id" => $this->id,
            ],"id=".$this->id);



            // create profile for restaurant
            $model = new RestaurantProfile();
            $model->user_id = $this->id;
            $model->save(false);

            // create notification for restaurant
            $model = new RestaurantNotification();
            $model->user_id = $this->id;
            $model->save(false);

            // create taxes for restaurant
            $model = new Taxes();
            $model->user_id = $this->id;
            $model->save(false);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantProfile()
    {
        return $this->hasOne(RestaurantProfile::className(), ['user_id' => 'id']);
    }

}
