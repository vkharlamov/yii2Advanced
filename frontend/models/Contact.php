<?php

namespace frontend\models;

//use common\models\User;
use Yii;
//use yii\base\Model;
use yii\base\InvalidParamException;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * ContactForm is the model behind the contact form.
 */
class Contact extends ActiveRecord
//class Contact extends Model
{

	//Declare unused
    public $name;
    public $email;
    public $subject;
    public $body;
//    public $verifyCode;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
//            [['name', 'email', 'subject', 'body'], 'required'],
//            [['text', 'text_html'], 'required'],
            [['text'], 'required'],
            // email has to be a valid email address
//            ['email', 'email'],
            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
        ];
    }

	/**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
//		return '{{%contact}}';
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
//        return Yii::$app->mailer->compose()
//            ->setTo($email)
//            ->setFrom([$this->email => $this->name])
//            ->setSubject($this->subject)
//            ->setTextBody($this->body)
//            ->send();
		return 1;
    }
	/**
	 *
	 * Test behavior
	 */
	public function behaviors()
    {
        return [
			'mymark' => [
				'class' => 'common\behaviors\markdownBehavior',
				'fromAttr' => 'text',
				'toAttr' => 'text_html'
			],
//			'fileBehavior' => [
//
//			]
        ];
    }

	public function toArray(array $fields = array(), array $expand = array(), $recursive = true) {

	}

}
