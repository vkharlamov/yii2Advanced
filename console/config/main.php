<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [

		'db' => array(
//			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
		),
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		// to create acl files for phpManager class rbac
		'user' => [
			'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
			'enableSession' => false,
        ],
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
		],

    ],
    'params' => $params,
];
