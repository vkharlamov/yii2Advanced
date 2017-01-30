<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

// Add behavior for Class via container
Yii::$container->set(frontend\controllers\TestController::className(), [
	'as behaviorViaContainer' => [
		'class' => 'common\behaviors\forclassBehavior',
	]
]);


return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
		'log',

		// Init bootstrap object to add closure for "Loader" class
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
//            'enableAutoLogin' => true,

//			'on afterLogin' => ['\common\models\User', 'updateLastLogin'], // add event ONLY ONE!

			// to add !Several! actions for a ONE event USE BEHAVIORs
			'as afterLogin1' => [
				'class' => 'common\behaviors\lastLoginBehavior1',
				'attribute' => 'logged_at'
			],
			'as afterLogin2' => [
				'class' => 'common\behaviors\lastLoginBehavior2',
				'attribute' => 'updated_at'
			]
        ],
		'loaderComponent' => [
            'class' => 'frontend\components\Loader',
			'config' => ['firstParamValue', 'secondParamValue'],
			'on succsess' => function (\yii\base\Event $event) {
				echo '<hr>RISE Handler 1 <br> : ' . __FILE__ ;

//				var_dump($event->sender);
				echo"<br>END Rise on succsess handler from   <br>" . __FILE__;
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
//                    'logFile' => '@frontend/runtime/logs/mylog.log',
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

