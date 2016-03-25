<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\components;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use frontend\components\classes\LoaderEvent;


class Loader extends Component {
	const EVENT_SUCCSESS = 'succsess';
	const EVENT_ERROR = 'error';

	public $response;
	public $errMsg;
	public $config;

	public function __construct($config = []) {
		// ... инициализация происходит перед тем, как будет применена конфигурация.

		parent::__construct($config);
	}

	public function init() {
//		var_dump(__FUNCTION__);
//		echo('<br/>');

//		Yii::info(__FUNCTION__,'my_category');


		//Здесь мы производим инициализацию компонента, необходимые действия
		$this->on($this::EVENT_SUCCSESS, [$this, 'inComponentHandler']);
		parent::init();
	}


	public  function inComponentHandler(\yii\base\Event $event) {
		echo '<hr>INIT COMPONENT<br>$event->handler via this : ' . __METHOD__;
		var_dump($event);
	}
	public  function hello() {
		echo 'Hello SOSISKA!';
//		var_dump(\Yii::$app->params);
//		var_dump(\Yii::$app->runtimePath);

	}
	public  function load($url) {

		if($url == 'test.lo') {
			$this->response = 'ok????';
			$event = new LoaderEvent();
			$event->errorMessage = '<br>$event->errorMessage';
			echo '<hr><br>LoaderEvent obj: ';
			var_dump($event);
			$this->trigger(self::EVENT_SUCCSESS, $event);
		} else {
			$this->response = 'error!';
			$event = new LoaderEvent();
			$this->trigger(self::EVENT_ERROR, $event);

		}
		return $url. ' resp- ' . $this->response;
	}


}

?>
