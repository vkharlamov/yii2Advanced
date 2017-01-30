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
use yii\web\Controller;
use yii\log\Logger;

//use vendor\cebe\markdown\Markdown;


class forclassBehavior extends Behavior {

//	public $fromAttr;
//	public $toAttr;

	/**
	 *
	 * @param type $owner
	 *
	 * Redeclare attach method, but we need to redeclare detach() method too
	 *
	 * BUT! we can use more fashion  - redeclare events() method . See Behavior->attach()
	 * where callback events are attached by yii
	 */
//	public function attach($owner) {
//		parent::attach($owner); //owner - model Contact
//		$owner->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'onBeforeSave']);
//		$owner->on(ActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'onBeforeSave']);
//	}


	/**
	 *
	 * @param type $event
	 *
	 * USE THIS STYLE TO ADD EVENTS CALLBACK FOR MODEL
	 */

	public function events() {
		return [
			yii\web\Controller::EVENT_BEFORE_ACTION => 'onBeforeAction1',
		];
	}

	/**
	 *
	 *
	 * @param type $event
	 */
	public function onBeforeAction1($event) {
//		$model = $this->owner;
		Yii::info(__FUNCTION__ , 'binary');
		echo '<br> RISEd ' . __METHOD__ . '<br>';
	}

}

?>


