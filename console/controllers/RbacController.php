<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RbacController
 *
 * @author vkharlamov
 */

//namespace yii\console\controllers;
//
//use Yii;
//use yii\console\Controller;
//use yii\helpers\Console;

//namespace yii\console\controllers;
namespace console\controllers;

use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;
use common\models\User;
use app\rbac\AuthorRule;
use Yii;

class RbacController extends Controller {
	//put your code here
	public function actionInit($param = null) {


		$auth = Yii::$app->getAuthManager();
		$auth->removeAll();

		$rule = new AuthorRule();
		$auth->add($rule);

		$createPost = $auth->createPermission('createPost');
		$createPost->description = 'create a Post';
		$auth->add($createPost);

		$updatePost = $auth->createPermission('updatePost');
		$updatePost->description = 'update a Post';
		$auth->add($updatePost);

		// User upadates own post ONLY!
		$updateOwnPost = $auth->createPermission('updateOwnPost');
		$updateOwnPost->description = 'update Own Post';
//		$updateOwnPost->ruleName = 'RULE NAME :USER update Own Post';
		$updateOwnPost->ruleName = $rule->name;
		$auth->add($updateOwnPost);

		$auth->addChild($updateOwnPost, $updatePost);

		// USER credentials
		$user = $auth->createRole('user');
		$auth->add($user);

		$auth->addChild($user, $createPost);
		$auth->addChild($user, $updateOwnPost);

		// ADMIN credentials
		$admin = $auth->createRole('admin');
		$auth->add($admin);

		$auth->addChild($admin, $user);
		$auth->addChild($admin, $updatePost);
//		$auth->addChild($admin, $createPost);

		$this->stdout('DONE' . PHP_EOL);
	}

	public function actionTest() {

		Yii::$app->set('request', new \yii\web\Request());
		$auth = Yii::$app->getAuthManager();

		$user = new User(['id' => 1, 'username' => 'User']);
		$admin = new User(['id' => 2, 'username' => 'Admin']);
//		print_r($admin);
//		var_dump(\Yii::$app->user->getId()); // return NULL  if not logged

		// delete all roles for user
		$auth->revokeAll($user->id);
		$auth->revokeAll($admin->id);

		echo 'Roles fo user ' . PHP_EOL;
		print_r($auth->getRolesByUser($user->id));

//		print_r($auth->getRolesByUser(\Yii::$app->user->id));

		// Assign role
		$auth->assign($auth->getRole('user'), $user->id);
		$auth->assign($auth->getRole('admin'), $admin->id);

//		echo 'Can user create post  ' . PHP_EOL;
//		var_dump(Yii::$app->user->can('createPost')); // return False (not logged)

		// LOGIN User
		\Yii::$app->user->login($user);
		echo 'Can USER create post  ' . PHP_EOL;
		var_dump(Yii::$app->user->can('createPost'));

		// LOGIN Admin
		\Yii::$app->user->login($admin);
		echo 'Can ADMIN create post  ' . PHP_EOL;
		var_dump(Yii::$app->user->can('createPost'));


//		echo 'NEW Roles for user ' . PHP_EOL;
//		print_r($auth->getRolesByUser($user->id));

		echo 'NEW Roles for ADMIN ' . PHP_EOL;
		print_r($auth->getRolesByUser($admin->id));

//		var_dump(\Yii::$app->user->identity); // we get model

//		\Yii::$app->user->logout();

		echo PHP_EOL;
	}

}

?>
