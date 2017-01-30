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


//use vendor\cebe\markdown\Markdown;


class markdownBehavior extends Behavior {
	//put your code here

	public $fromAttr;
	public $toAttr;

//	 public function init() {
//		parent::init();
//	}

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
			ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
			ActiveRecord::EVENT_BEFORE_VALIDATE => 'onBeforeValidate'
		];
	}


	/**
	 * Init field before validation to block error if  rule exists
	 *
	 * @param type $event
	 */
	public function onBeforeValidate($event) {
		$model = $this->owner;
//		$model->{$this->toAttr} = 'init';
	}

	public function onBeforeSave($event) {
		$model = $this->owner;
		$parser = new \cebe\markdown\Markdown();
//		var_dump($model);
//		var_dump($this->toAttr);
//		die();
		// put parsed string to model field text_html
		$model->{$this->toAttr} = $parser->parse($model->{$this->fromAttr});

	}
}

?>


