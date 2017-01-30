<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\Agreement;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use vendor\vova\Loader;

/**
 * Site controller
 */
class TestController extends Controller
{


	public function init() {
		parent::init();

		// Test behavior for Class via container
//		Yii::$container->set(\frontend\controllers\SiteController::className(), [
//			'as behaviorViaContainer' => [
//			'class' => 'common\behaviors\forclassBehavior',
//			'fromAttr' => 'text',
//			'toAttr' => 'text_html'
//			]
//		]);
	}
	/**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$this->layout = 'test';
//		echo 'rised method ---------------- ' . __METHOD__;
//		var_dump(User::findByUsername('vova5'));
//die();

		$res = Agreement::getScoring();
		var_dump($res);
//		 return $this->render('index');
    }

			}
?>
