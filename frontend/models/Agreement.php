<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;

class Agreement extends ActiveRecord {



	/**
     * @inheritdoc
     */
    public static function tableName() {
		return '{{%agreement}}';
	}

	 public function getUser() {
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}


	public static function getScoring()
    {
//		return array(1,4,6);
//		$agreement = Agreement::findOne(['id' => 3]);
//		return $agreement->user;

		return Agreement::find()->with('user')->all();
    }



}
?>
