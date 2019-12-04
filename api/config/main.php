<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module',
        ]
    ],
    'components' => [

        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => false,
//            'enableSession' => false,
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
//            'enableSession' => false,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,

            'rules' => [
                [
                    'class' => '\yii\rest\UrlRule',
                    'controller' => ['v1/user', 'v1/order'],
                    'pluralize' => false,
//                    'controller' => ['v1/u'=>'v1/user', 'v1/o' => 'v1/order'],
//                    'extraPatterns' => [
//                        'GET (request)' => 'action',
//                        'POST (request)' => 'action',
//                    ]

                ],
//                '<module:(v1)>/<controller>/<action>/<id:\d+>' => '<module>/<controller>/<action>',
//                '<module:(v1)>/<controller>/<action>' => '<module>/<controller>/<action>',

            ],
        ]
    ],
    'params' => $params,
];