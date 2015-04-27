<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $userRule = new \common\rbac\UserGroupRule;
        $auth->add($userRule);

        // add the rule
        $controllerAccessRule = new \common\rbac\ControllerAccess;
        $auth->add($controllerAccessRule);


        // add the "controllerAccess" permission and associate the rule with it.
        $controllerAccess = $auth->createPermission('controllerAccess');
        $controllerAccess->description = 'controller Access';
        $controllerAccess->ruleName = $controllerAccessRule->name;
        $auth->add($controllerAccess);

        // USER
        $user = $auth->createRole('user'); // Create role
        $user->ruleName = $userRule->name; // Add rule "UserGroupRule" in roles
        $auth->add($user);                 // Add roles in Yii::$app->authManager

        // MANAGER
        $manager = $auth->createRole('manager');
        $manager->ruleName = $userRule->name;
        $auth->add($manager);
        $auth->addChild($manager, $user);
        $auth->addChild($manager, $controllerAccess);

        // RESTAURANT
        $restaurant = $auth->createRole('restaurant');
        $restaurant->ruleName = $userRule->name;
        $auth->add($restaurant);
        $auth->addChild($restaurant, $manager);
        $auth->addChild($restaurant, $controllerAccess);

        // ADMIN
        $admin = $auth->createRole('admin');
        $admin->ruleName = $userRule->name;
        $auth->add($admin);
        $auth->addChild($admin, $restaurant);
        $auth->addChild($admin, $controllerAccess);

        Console::output('Success! RBAC roles has been added.');
    }
} 