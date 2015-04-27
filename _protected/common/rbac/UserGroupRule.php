<?php
namespace common\rbac;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if(!Yii::$app->user->isGuest && !empty($user) && Yii::$app->user->id == $user){
            $user = Yii::$app->user->identity;
        }else{
            $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        }


        if ($user) {

            $role = $user->role;
            $needRole = $this->getIdByRoleName($item->name);

            if($role >= $needRole){
                return true;
            }

            /*
            if ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            } elseif ($item->name === 'manager') {
                return $role == User::ROLE_ADMIN|| $role == User::ROLE_MANAGER;
            } elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MANAGER || $role == User::ROLE_USER;
            }
            */
        }
        return false;
    }

    public function getIdByRoleName($name){
        $roles = User::getRoles();

        $roles = array_flip($roles);
        return $roles[$name];
    }
}
