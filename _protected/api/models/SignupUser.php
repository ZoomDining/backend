<?php
namespace api\models;

use common\models\User;
use common\models\UserProfile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupUser extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone;
    public $date_of_birth;
    public $address;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass'=>'\common\models\User', 'message' => Yii::t('frontend', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass'=> '\common\models\User', 'message' => Yii::t('frontend', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'string'],

            ['date_of_birth', 'integer', 'message' => '{attribute} must be in UNIX TIMESTAMP format. For example "1423071985"'],

            ['address', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>Yii::t('frontend', 'Username'),
            'email'=>Yii::t('frontend', 'E-mail'),
            'password'=>Yii::t('frontend', 'Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {

            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            $user->afterSignup();

            UserProfile::updateAll([
                "phone"         => $this->phone,
                "date_of_birth" => $this->date_of_birth,
                "address"       => $this->address,
                "device_id"     => Yii::$app->request->post("device_id"),
            ], "user_id=".$user->id);

            return $user;
        }

        return null;
    }
}


/*

curl -X POST -d username=new_user11 -d email=mikola@dsf.df3 -d password=qwe012 -d date_of_birth=1423071985 -d phone=1215454542 -d date_of_birth=123123123123 -d address=sdfhjsdkfhjskdfsdf http://restaurant.dev/api/sign-up

 */