<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of postBehavior
 *
 * @author vkharlamov
 */

namespace frontend\components;
use Yii;
//use yii\base\Component;
use yii\db\ActiveRecord;
use yii\base\InvalidConfigException;

use yii\base\Behavior;

//use vendor\cebe\markdown\Markdown;


// MarkdownBehavior in lesson
//class postBehavior extends Behavior {
class markdownBehavior extends Behavior {
	//put your code here

	public $fromAttr;
	public $toAttr;

	 public function init() {
		parent::init();
	}

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
		];
	}



	public function onBeforeSave($event) {
		$model = $this->owner;


//		var_dump($this->fromAttr);
//		var_dump($this->toAttr);
//		var_dump($model);


//die();
//		var_dump(__FUNCTION__);
//		var_dump($model);
		$parser = new \cebe\markdown\Markdown();
//		$parser = new Markdown();
//		var_dump($parser);
//		var_dump($model->{$this->fromAttr});
//		echo'<hr>';
//		var_dump($parser->parse($model->{$this->fromAttr}));

		// put parsed string to model field 'text_html'
		$model->{$this->toAttr} = $parser->parse($model->{$this->fromAttr});
//return true;
		var_dump($model->{$this->toAttr});

//		die();
	}
}

?>


