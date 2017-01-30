<?php
/**
 * See video https://www.youtube.com/watch?v=cDoMRIjSe90
 *
 * Description of postBehavior
 *
 * @author vkharlamov
 */

namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class lastLoginBehavior2 extends \yii\base\Behavior {

//	public $attribute = 'updated_at';
	public $attribute; // will set from param in main.php - components->user->
//	'as afterLogin2' => [
//		'class' => 'common\behaviors\lastLoginBehavior2',
//		'attribute' => 'updated_at'
//	]

	public function events() {
//		parent::events();
		return [
			\yii\web\User::EVENT_AFTER_LOGIN => 'onAfterLogin2',
		];
	}

	// THIS public METHOD AVAILABLE In model->onAfterLogin2
	// Ie in User MOdel try  Yii->app->User->onAfterLogin2() ie without

	public function onAfterLogin2(\yii\web\UserEvent $event) {
		/** @var app\models\User $user **/
		$user = $event->identity;
//		print_r($this->attribute); // set up  from config
//		var_dump($event);
//		die();
		$user->updateAttributes([$this->attribute => time()]);
	}

}

?>