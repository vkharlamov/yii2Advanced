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

class lastLoginBehavior1 extends \yii\base\Behavior {

	public $attribute = 'logged_at';

	public function events() {
//		parent::events();
		return [
			\yii\web\User::EVENT_AFTER_LOGIN => 'onAfterLogin1',
		];
	}

	public function onAfterLogin1(\yii\web\UserEvent $event) {
		/** @var app\models\User $user **/
		$user = $event->identity;
		$user->updateAttributes(['logged_at' => time()]);
	}
}

?>
