<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;

class ProgressController extends Controller {

	public function actionIndex($param) {
		$res = $this->prompt("start ?");
		if ($res == 'y') {
			Console::startProgress(0, 10);
			foreach (range(0,100) as $v) {
				usleep(10);
				Console::updateProgress($v,100);
			}
			Console::endProgress('end'.PHP_EOL);
		}
		return parent::EXIT_CODE_NORMAL;
//		return parent::EXIT_CODE_ERROR;
	}

}
?>
