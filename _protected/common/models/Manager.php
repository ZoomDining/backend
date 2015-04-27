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
class Manager extends User {

    public $password;

    public function rules()
    {
        $result = [
            ['username', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],


            [['username','email'], 'required'],
            ['username', 'unique', 'targetClass'=>'\common\models\User', 'message' => Yii::t('frontend', 'This username has already been taken.')],


            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'default', 'value' => self::ROLE_MANAGER],
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
        return parent::find()->where("role = ".User::ROLE_MANAGER)->andWhere("restaurant_id=".Yii::$app->user->id);
    }


    public function beforeSave($insert)
    {
        // save password and remember me key
        if(!empty($this->password)){
            $this->setPassword($this->password);
            $this->generateAuthKey();
        }

        $this->restaurant_id = Yii::$app->user->id;

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {

        if($insert){
            // create profile for restaurant
            $model = new ManagerProfile();
            $model->user_id = $this->id;
            $model->save(false);
        }

        // save permissions
        Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), ['access_home' => 0], 'user_id = '.$this->id)->execute();
        Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), ['access_orders' => 0], 'user_id = '.$this->id)->execute();
        Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), ['access_schedule' => 0], 'user_id = '.$this->id)->execute();
        Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), ['access_items' => 0], 'user_id = '.$this->id)->execute();

        if(!empty($_POST["Manager"]["permissions"])){
            foreach ((array)$_POST["Manager"]["permissions"] as $name) {
                Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), [$name => 1], 'user_id = '.$this->id)->execute();
            }
        }

        Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), ['firstname' => $_POST["Manager"]["firstname"]], 'user_id = '.$this->id)->execute();
        Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), ['lastname' => $_POST["Manager"]["lastname"]], 'user_id = '.$this->id)->execute();
        Yii::$app->db->createCommand()->update(ManagerProfile::tableName(), ['id_number' => $_POST["Manager"]["id_number"]], 'user_id = '.$this->id)->execute();

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManagerProfile()
    {
        return $this->hasOne(ManagerProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }


    public function getPermissions(){

        $result = "";

        if(!$this->isNewRecord){
            if($this->managerProfile->access_home){
                $result[] = "access_home";
            }
            if($this->managerProfile->access_orders){
                $result[] = "access_orders";
            }
            if($this->managerProfile->access_schedule){
                $result[] = "access_schedule";
            }
            if($this->managerProfile->access_items){
                $result[] = "access_items";
            }
        }

        return $result;
    }


    /**
     * @return string
     */
    public function getFirstname()
    {
        if(!$this->isNewRecord) {
            return $this->managerProfile->firstname;
        }
    }

    /**
     * @return string
     */
    public function getId_number()
    {
        if(!$this->isNewRecord) {
            return $this->managerProfile->id_number;
        }
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        if(!$this->isNewRecord) {
            return $this->managerProfile->lastname;
        }
    }


}
