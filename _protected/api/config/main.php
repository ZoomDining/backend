<?php

#####################
/*
 * dirty log api
 */
if(YII_ENV === "dev"){

    $path= "./api_log.txt";
    $string = "\n######## ".date("Y-m-d H.i.s", time())." ########\n";
    if(isset($_SERVER["REQUEST_URI"])){
        $string .= "REQUEST_URI: ".$_SERVER["REQUEST_URI"]."\n";
    }
    if(isset($_SERVER["PHP_AUTH_USER"])) {
        $string .= "PHP_AUTH_USER: ".$_SERVER["PHP_AUTH_USER"]."\n";
    }
    if(isset($_SERVER["PHP_AUTH_PW"])) {
        $string .= "PHP_AUTH_PW: ".$_SERVER["PHP_AUTH_PW"]."\n";
    }
    if(!empty($_POST)){
        $string .= "--- POST ---\n";
        foreach ((array)$_POST as $_key => $_val) {
            $string .= $_key.": ".$_val."\n";
        }
    }
    file_put_contents($path, strip_tags($string), FILE_APPEND | LOCK_EX);
}
#####################



$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'user' => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession'   => false,
            'loginUrl'        => null,
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

        /*
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        */
        'response' => [
            'format' => 'json'
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['favorites'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['menu'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['orders'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['orders-items'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['restaurant'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['sign-up'], 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule', 'controller' => ['user-profile'], 'pluralize' => false],
            ],
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'restaurantszoom@gmail.com',
                'password' => 'E057fbBE56',
                'port' => '465', // Port 25 is a very common port too
                'encryption' => 'ssl', // It is often used, check your provider or mail server specs
            ],
        ],
    ],
    'params' => $params,
];
