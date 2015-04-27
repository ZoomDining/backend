<?php
use common\models\User;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */


?>



<?php

NavBar::begin([
    //                'brandLabel' => Yii::t('frontend', Yii::$app->name),
    //                'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default navbar-main-ag',
    ],
    'innerContainerOptions' => [
        'class' => '',
    ],

]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items'   => [
        /*
            [
                'label'=>Yii::t('frontend', 'Language'),
                'items'=>array_map(function($code){
                    return [
                        'label'=>Yii::$app->params['availableLocales'][$code],
                        'url'=>['/site/set-locale', 'locale'=>$code],
                        'active'=>Yii::$app->language == $code
                    ];
                }, array_keys(Yii::$app->params['availableLocales']))
            ],
        */
//                        ['label' => Yii::t('frontend', 'Login'), 'url' => ['/user/sign-in/login'], 'visible'=>Yii::$app->user->isGuest],
        [
            'label'   => Yii::$app->user->isGuest ? '' : ucfirst(Yii::$app->user->identity->getPublicIdentity()),
            'visible' => !Yii::$app->user->isGuest,
            'items'   => [
                [
                    'label' => Yii::t('frontend', 'Account'),
                    'url'   => ['/user/default/index']
                ],
                [
                    'label' => Yii::t('frontend', 'Profile'),
                    'url'   => ['/restaurant-profile'],
                    'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == User::ROLE_RESTAURANT)?true:false,

                ],
//                [
//                    'label'   => Yii::t('frontend', 'Backend'),
//                    'url'     => Yii::getAlias('@backendUrl'),
//                    'visible' => Yii::$app->user->can('admin')
//                ],
                [
                    'label'       => Yii::t('frontend', 'Logout'),
                    'url'         => ['/user/sign-in/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ]
            ]
        ]
    ],
]);


if(Yii::$app->user->can("admin")){

    // ADMIN MENU
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items'   => [
            ['label' => Yii::t('frontend', 'DashBoard'), 'url' => ['/admin-dash-board']],
            ['label' => Yii::t('frontend', 'Manage Accounts'), 'url' => ['/manage-restaurant-account']],
            ['label' => Yii::t('frontend', 'Reports'), 'url' => ['/reports']],
        ],
    ]);


}else {

    // MENU FOR RESTAURANT AND MANAGER
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items'   => [
            //for manager and restaurant
            ['label' => Yii::t('frontend', 'Home'), 'url' => ['/dash-board'], 'visible' => Yii::$app->user->can("controllerAccess",["controller"=>"dash-board"]), 'active' => Yii::$app->controller->id == "dash-board" ? true : false],
            ['label' => Yii::t('frontend', 'Orders'), 'url' => ['/dine-in'], 'visible' => Yii::$app->user->can("controllerAccess",["controller"=>"orders"]), 'active' => \common\components\MenuInfo::isRootMenuActive("orders")],
            ['label' => Yii::t('frontend', 'Schedule'), 'url' => ['/schedule'], 'visible' => Yii::$app->user->can("controllerAccess",["controller"=>"schedule"]), 'active' => Yii::$app->controller->id == "schedule" ? true : false],
            ['label' => Yii::t('frontend', 'Items'), 'url' => ['/menu'], 'visible' => Yii::$app->user->can("controllerAccess",["controller"=>"items"]), 'active' => \common\components\MenuInfo::isRootMenuActive("items")],


            // only for restaurant
            ['label' => Yii::t('frontend', 'Customers'), 'url' => ['/manage-customers'], 'visible' => Yii::$app->user->can("restaurant")],
            ['label' => Yii::t('frontend', 'Employee'), 'url' => ['/manage-managers-account'], 'visible' => Yii::$app->user->can("restaurant"), 'active' => Yii::$app->controller->id == "manage-managers-account" ? true : false],
            ['label' => Yii::t('frontend', 'Reports'), 'url' => ['/reports'], 'visible' => Yii::$app->user->can("restaurant"), 'active' => Yii::$app->controller->id == "reports" ? true : false],
        ],
    ]);

}



NavBar::end();


NavBar::begin([
    //                'brandLabel' => Yii::t('frontend', Yii::$app->name),
    //                'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default navbar-menu-ag',
    ],
    'innerContainerOptions' => [
        'class' => '',
    ],
]);

echo \common\components\MenuInfo::getSubMenu();

NavBar::end();

?>

