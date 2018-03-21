<?php

$params = require(__DIR__ . '/params.php');
$basePath = dirname(__DIR__);

$extensionsFile = $basePath . '/vendor/yiisoft/extensions.php';

$extensions = is_file($extensionsFile) ? include($extensionsFile) : [];

$config = [
    'id' => 'kassaadmin',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'timeZone' => 'Europe/Kiev',
    'defaultRoute' => 'index',
    'extensions' => array_merge($extensions, [
        'sortablelistview' => [
            'name' => 'sortablelistview',
            'version' => '1.0.0',
            'alias' => [
                '@sortablelist' => dirname(__DIR__) . '/extensions/sortable-list-view'
            ]
        ],
        'config' => [
            'name' => 'config',
            'version' => '1.0.0',
            'alias' => [
                '@config' => dirname(__DIR__) . '/extensions/config'
            ]
        ],
        'googlemap' => [
            'name' => 'google map',
            'version' => '1.0.0',
            'alias' => [
                '@googlemap' => dirname(__DIR__) . '/extensions/googlemap'
            ]
        ],
        'ckeditor' => [
            'name' => 'ckeditor',
            'version' => '1',
            'alias' => [
                '@ckeditor' => dirname(__DIR__) . '/extensions/ckeditor'
            ]
        ],
    ]),
    'components' => [
        'request' => [
            'baseUrl'=> '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'CN3b1WqnYzhPuHFxv-ob1aZAQcwdoGKi',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'loginUrl' => '/login',
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'index/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'app\libraries\log\DebugTarget',
                    'levels' => ['info'],
                    'categories' => ['debug']
                ]
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                'api/login' => '/user/auth/login',
                'api/logout' => '/user/auth/logout',
                'api/accounts' => '/user/account/accounts',
                'api/accounts/path' => '/user/account/path',
                'api/accounts/check/<name>' => '/user/account/check-name',
                'api/accounts/create' => '/user/account/create',
                'api/accounts/delete' => '/user/account/delete',

                'api/cashdesks/<acc_id>' => '/api/cashdesk',
                'api/cashdesks/<acc_id>/transfer' => '/api/cashdesk/transfer',


                // Accounting
                'api/accounting/<account_id>' => '/user/accounting/index',
                'api/accounting/<account_id>/operations' => '/user/accounting/operations',
                'api/accounting/<account_id>/transfer' => '/user/accounting/transfer',
                // TODO:


                'api/settings/<acc_id>' => '/api/settings',
                'api/settings/<acc_id>/bet-amount' => '/api/settings/bet-amount',
                // {"value":false/true}
                // success
                'api/accounting/<account_id>/change-minmax-permission' => '/user/accounting/change-minmax-permission',

                // {"value":false/true}
                // success
                'api/accounting/<account_id>/change-accounts' => '/user/accounting/change-accounts-permission',

                'api/accounting/<account_id>/change-bet-settings' => '/user/accounting/change-bet-settings',

                'api/users/<id:\d+>' => '/user/account/users',

                'api/reports/overall' => '/user/reports/overall',
                'api/reports/daily' => '/user/reports/daily',
                'api/reports/sources' => '/user/reports/sources',
                'api/reports/accounts' => '/user/reports/accounts',

                //{"id":730277468,"html":"Пополнение 101002003 на сумму 30 000.00 KZT","info":{"betAmount":30000,"status":"not_defined","possibleWin":0,"payAmount":null},"operations":[{"id":1650247607,"note":"Прием ставки номер 730277468","stamp":"2017-01-31 10:14:13","amount":30000,"cashier":"."}]}
                'api/slips/view/<id:\d+>' => '/user/bet/details',
                'api/barcode/<code>' => '/user/bet/barcode',

                'api/cafe/exchange-rates' => '/user/cafe/exchange-rates',

                // api/users/check/12
                'api/users/check/<name>' => '/user/users/check-name',
                // {"exists":true} / {"exists":false}

                'api/users/<id:\d+>/save' => '/user/users/save',

                // routes for remote calls
                'POST api/bet' => '/api/bet/save',
                'POST api/bet/pay' => '/api/bet/pay',
                'api/round/results/<game_id:\d+>' => '/api/round/results',
                'api/round/results' => '/api/round/results',
                'api/round/save/<game_id:\D+\d*\D+>/' => '/api/round/save',
                'api/round/save/<game_id:\d+>/' => '/api/round/saved',
                'api/account/status' => '/user/account/status',
                'api/info' => '/api/info/info'
            ]
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'i18n' => [
            'class' => 'yii\i18n\I18N',
            'translations' => [
                'user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/modules/user/messages',
                ]
            ]
        ],
    ],
    'modules' => [
        'user' => 'app\modules\user\Module',
        'admin' => 'app\modules\admin\Module',
        'api' => 'app\modules\api\Module',
    ],
    'params' => $params,
    'on beforeRequest' => function ($event) {
        $app = $event->sender;
        $app->db->on(\yii\db\Connection::EVENT_AFTER_OPEN, function($event) {
            $event->sender->createCommand("SET TIMEZONE TO 'Europe/Kiev';")->execute();
        });
    }
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment


    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
