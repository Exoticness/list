<?php
$config = [
    'name' => 'madeasy',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    'bootstrap' => ['log'],
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}'
        ],

        'cache' => [
            'class' => 'yii\caching\DummyCache'
        ],

        'formatter' => [
            'class' => 'yii\i18n\Formatter'
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => getenv('ADMIN_EMAIL')
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'port' => '587',
                'username' => getenv('ROBOT_EMAIL'),
                'password' => getenv('PASSWD'),
                'encryption' => 'tls'
            ]
        ],

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'tablePrefix' => getenv('DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => true,

            // Duration of schema cache.
            'schemaCacheDuration' => 3600,

            // Name of the cache component used to store schema information
            'schemaCache' => 'cache'
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}'
                ]
            ]
        ],

        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages'
                ],
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                        'backend' => 'backend.php',
                        'frontend' => 'frontend.php'
                    ]
                ],
                /* Uncomment this code to use DbMessageSource
                 '*'=> [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable'=>'{{%i18n_source_message}}',
                    'messageTable'=>'{{%i18n_message}}',
                    'enableCaching' => YII_ENV_DEV,
                    'cachingDuration' => 3600
                ],
                */

            ],
        ],

        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@backendUrl')
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@frontendUrl')
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        )
    ],

    'params' => [
        'adminEmail' => getenv('ADMIN_EMAIL'),
        'robotEmail' => getenv('ROBOT_EMAIL'),
        'availableLocales' => [
            'en-US' => 'English (US)',
            'ru-RU' => 'Русский (РФ)'
        ],
    ],
];

if (YII_ENV_PROD) {
    $config['components']['cache'] = [
        'class' => 'yii\caching\FileCache',
        'cachePath' => '@common/runtime/cache',
        'fileMode' => 777
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module'
    ];

    /*$config['components']['log']['targets']['email'] = [
        'class' => 'yii\log\EmailTarget',
        'except' => ['yii\web\HttpException:*'],
        'levels' => ['error', 'warning'],
        'message' => ['from' => getenv('ROBOT_EMAIL'), 'to' => getenv('ADMIN_EMAIL')]
    ];*/
}

return $config;