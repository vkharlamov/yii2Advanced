<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

// Test behavior for Class via container
//Yii::$container->set(yii\web\Controller::className(), [
//	'as behaviorViaContainer' => [
//		'class' => 'common\behaviors\forclassBehavior',
//	]
//]);


return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
		'log',
		'\frontend\components\MyBootstrapNotificator'
	],

    'controllerNamespace' => 'frontend\controllers',
	'modules'=>[
		'gii' =>[
			'class' => 'yii\gii\Module',
			'allowedIPs' => ['127.0.0.1','::1', '*'] // adjust this to your needs
		]
	],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
			'on afterLogin' => ['\common\models\User', 'updateLastLogin'],
        ],
		'MyComponent' => [
            'class' => 'frontend\components\Loader',
			'config' => ['firstParamValue', 'secondParamValue'],
			'on succsess' => function (\yii\base\Event $event) {
				print_r(__FUNCTION__);
				echo '<br>  -on succsess- FROM CONFIG  ========== sender OBJ';
				var_dump($event->sender);
				echo '<br>  END FROM CONFIG ';
			}
		],

		'db'=>array(
//            'connectionString' => 'mysql:host=localhost;dbname=test',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '123456',
        ),
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [

				[
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                    'categories' => ['binary'],
					'logVars' => [],
                    'logFile' => '@frontend/runtime/logs/mylog.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//		'urlManager' => [
//			'class' => 'yii\web\UrlManager',
//			'enablePrettyUrl' => true,
//			'showScriptName' => true
//
//		]
		'authManager' => [
			'class' => 'yii\rbac\PhpManager',
		],
    ],

//	'on	afterRequest'	=> 	function (\yii\base\Event $event) {
//		echo '<br> beforeRequest FOR APP . FROM CONFIG  ========== sender OBJ';
//		var_dump($event->sender);
//		echo '<br>  END FROM CONFIG ';
//		die();
//	},
    'params' => $params,

];

