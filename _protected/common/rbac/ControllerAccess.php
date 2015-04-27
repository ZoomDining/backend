<?php
namespace common\rbac;
use common\models\ManagerProfile;
use common\models\User;
use Yii;
use yii\rbac\Item;
use yii\rbac\Rule;

class ControllerAccess extends Rule
{
    /** @var string */
    public $name = 'controllerAccess';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if(!isset(Yii::$app->user->id)){
            return false;
        }

        if(Yii::$app->user->can("restaurant")){
            return true;
        }else{
            false;
        }

        // access special for managers
        if(Yii::$app->user->identity->role == User::ROLE_MANAGER && isset($params["controller"])){
            if($params["controller"] == "home" && ManagerProfile::findOne(Yii::$app->user->id)->access_home){return true;}
            if($params["controller"] == "orders" && ManagerProfile::findOne(Yii::$app->user->id)->access_orders){return true;}
            if($params["controller"] == "schedule" && ManagerProfile::findOne(Yii::$app->user->id)->access_schedule){return true;}
            if($params["controller"] == "items" && ManagerProfile::findOne(Yii::$app->user->id)->access_items){return true;}
        }

        return false;
    }
}