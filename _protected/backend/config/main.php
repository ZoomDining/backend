<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'=>'system-event/timeline',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'class'           => 'yii\web\User',
            'identityClass'   => 'common\models\User',
            'loginUrl'        => ['sign-in/login'],
            'enableAutoLogin' => true,
        ],
        /*
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        */
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'as globalAccess'=>[
        'class'=>'\common\components\behaviors\GlobalAccessBehavior',
        'rules'=>[
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['error']
            ],
            [
                'controllers'=>['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'roles' => ['admin'],
            ],

            /*
            [
                'controllers'=>['user'],
                'allow' => true,
                'roles' => ['admin'],
            ],
            [
                'controllers'=>['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['manager'],
            ]
            */
        ]
    ],
    'params' => $params,
];
