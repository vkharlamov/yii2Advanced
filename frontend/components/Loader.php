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

		//Здесь мы производим инициализацию компонента, необходимые действия
		$this->on($this::EVENT_SUCCSESS, [$this, 'inComponentHandler']);

		parent::init();
	}


	public  function inComponentHandler(\yii\base\Event $event) {
		echo '<hr>RISE Handler 2<br> : ' . __METHOD__;
//		echo '<br> has Event obj in param';
//		var_dump($event);
		echo '<br>END  Handle 2' . __METHOD__;
	}


	public  function load($url) {

//	echo '<hr> '. __METHOD__ . '<br>';

		if($url == 'test.lo') {
			$this->response = "requested url = $url";
			$event = new LoaderEvent();
			$event->errorMessage = '$event->errorMessage - OK!';


			echo '<br><br><br><br><br>--- TRIGGER  EVENT_SUCCSESS --<br>';
			$this->trigger(self::EVENT_SUCCSESS, $event);
			echo '<br>--- END TRIGGER  EVENT_SUCCSESS --<br>';

		} else {
			$this->response = 'error!';
			$event = new LoaderEvent();
			$this->trigger(self::EVENT_ERROR, $event);

		}
		return $url. ' resp- ' . $this->response;
	}


}

?>
