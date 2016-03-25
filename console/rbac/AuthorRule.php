<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AthorRule
 *
 * @author vkharlamov
 */

namespace app\rbac;
use yii\rbac\Rule;

class AuthorRule extends Rule{
	//put your code here

	public $name = 'isAuthor';
	public function execute($userId, $item, $params) {
		return isset($params['post']) ? $params['post']->user_id == $userId : false ;
	}
}

?>
