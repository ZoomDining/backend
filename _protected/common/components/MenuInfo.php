<?php

namespace common\components;

use Yii;
use yii\bootstrap\Nav;
use yii\base\Component;


class MenuInfo extends Component{


    /**
     * @return array
     */
    public static function getMenu(){

        $menu = [
            "items" => [
                "menu"          => ['label' => Yii::t('frontend', 'Menu'), 'url' => ['/menu'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "menu" ? true : false],
                "sets"          => ['label' => Yii::t('frontend', 'Sets'), 'url' => ['/sets'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "sets" ? true : false],
                "category"      => ['label' => Yii::t('frontend', 'Categories'), 'url' => ['/category'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "category" ? true : false],
                "specials"      => ['label' => Yii::t('frontend', 'Specials'), 'url' => ['/specials'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "specials" ? true : false],
                "recommended"    => ['label' => Yii::t('frontend', 'Recommended'), 'url' => ['/recommended'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "recommended" ? true : false],
                "taxes"         => ['label' => Yii::t('frontend', 'Taxes'), 'url' => ['/taxes'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "taxes" ? true : false],
//                "extra"         => ['label' => Yii::t('frontend', 'Extra'), 'url' => ['/extra'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "extra" ? true : false],
            ],
            "orders" => [
                "dine-in"       => ['label' => Yii::t('frontend', 'Dine in'), 'url' => ['/dine-in'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "dine-in" ? true : false],
                "take-away"     => ['label' => Yii::t('frontend', 'Take Away'), 'url' => ['/take-away'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "take-away" ? true : false],
                "delivery"      => ['label' => Yii::t('frontend', 'Delivery'), 'url' => ['/delivery'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "delivery" ? true : false],
                "reservations"  => ['label' => Yii::t('frontend', 'Reservations'), 'url' => ['/reservations'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "reservations" ? true : false],
            ],
            "profile" => [
                "restaurant-profile"      => ['label' => Yii::t('frontend', 'Public profile'), 'url' => ['/restaurant-profile'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "restaurant-profile" ? true : false],
                //"restaurant-receipt"      => ['label' => Yii::t('frontend', 'Receipt'), 'url' => ['/restaurant-receipt'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "restaurant-receipt" ? true : false],
                "tables"                  => ['label' => Yii::t('frontend', 'Tables'), 'url' => ['/tables'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "tables" ? true : false],
//                "bank_accounts"           => ['label' => Yii::t('frontend', 'Bank accounts'), 'url' => ['/bank_accounts'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "bank_accounts" ? true : false],
                "restaurant-notification" => ['label' => Yii::t('frontend', 'Email Notification'), 'url' => ['/restaurant-notification'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "restaurant-notification" ? true : false],
//                "receipts"                => ['label' => Yii::t('frontend', 'Receipts'), 'url' => ['/receipts'], 'visible' => !Yii::$app->user->isGuest, 'active' => Yii::$app->controller->id == "receipts" ? true : false],
            ],
        ];

        return $menu;
    }



    /**
     * @return string
     */
    public static function getSubMenu (){

        $result = "";
        $rootMenuName = static::getRootMenuName(Yii::$app->controller->id);
        $menu = static::getMenu();

        if(!empty($rootMenuName)){
            $result = Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => $menu[$rootMenuName],
            ]);
        }

        return $result;
    }

    /**
     * @param string $name name of sub menu item
     * @return string
     */
    public static function getRootMenuName($name){

        $menu = static::getMenu();
        foreach ((array)$menu as $root => $sub) {
            if(isset($sub[$name])){
                return $root;
            }
        }

        return "";
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function isRootMenuActive($name){

        $rootMenuName = static::getRootMenuName(Yii::$app->controller->id);

        if($name == $rootMenuName){
            return true;
        }

        return false;
    }


}
