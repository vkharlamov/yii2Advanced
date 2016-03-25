<?php

/*
 * ADD events for Class Loader
 *
 * GET /site/closure to see bootstraped EVENTS for class Loader
 *
 * To set up this bootstrap function use config in main.php
 *
 * 'bootstrap' => [
		'log',
		'\frontend\components\MyBootstrapNotificator'],
 *  ]
 */

namespace frontend\components;
//use Yii;
use yii\base\BootstrapInterface;
//use frontend\components\Loader;

class MyBootstrapNotificator implements BootstrapInterface {

	public function bootstrap($app){
		\yii\base\Event::on(
			Loader::className(),
			Loader::EVENT_SUCCSESS,
			[$this, 'oneBootstrapHandler']
		);
		\yii\base\Event::on(
			Loader::className(),
			Loader::EVENT_SUCCSESS,
			[$this, 'twoBootstrapHandler']
		);
	}

	public function oneBootstrapHandler(\yii\base\Event $event){
		echo '<-----ADD events for Class Loader ' . __CLASS__ . '---- >';
		var_dump(__FUNCTION__);
	}

	public function twoBootstrapHandler(\yii\base\Event $event){
		echo '<-----ADD events for Class Loader ' . __CLASS__ . '---- >';
		var_dump(__FUNCTION__);
	}
}

?>
