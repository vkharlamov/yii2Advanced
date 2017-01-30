<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\Contact;

use frontend\models\Agreement;



use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\log\Logger;
//use vendor\vova\Loader;



//use frontend\components\Loader;

/**
 * Site controller
 */
class SiteController extends Controller
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
	public function actionClosure()
    {

//
//		Load from config
		$loaderObject = Yii::$app->loaderComponent;

// load class by hand
//		Yii::setAlias('@component', '@frontend/components');
//		var_dump(Yii::getAlias('@component'));
//		$path = Yii::getAlias('@component/Loader.php');
//		require_once($path);
//		$loaderObject = new Loader();


// Add handlers for $loader Component

		// Handler via Closure
		$attach = ['one','three'];
		$loaderObject->on($loaderObject::EVENT_SUCCSESS, function($event){

//			$event->handled = true; // to stop execution next event handlers
//			echo $event->sender->response;
//			echo $event->errorMessage;

			// access to attach
			echo '<hr> RISE Handler 3 <br> via Closure: '. __METHOD__;
//			var_dump($event->data);
		}, $attach, true);// false - to add handler first

		// Handler with local handler
		$loaderObject->on($loaderObject::EVENT_SUCCSESS, [$this, 'inClassHandler']);

		// Do Request
		$resp = $loaderObject->load('test.lo');
        return $this->render('test', [
			'from Component Loader' => $resp
		]);
    }

	protected function inClassHandler(){
			echo '<hr>RISE Handler 4 <br> inClassHandler $event->handler via this : ' . __METHOD__;
			echo '<hr>';
	}

	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//			'basicAuth1' => [
//				'class' => \yii\filters\auth\HttpBearerAuth::className(),
//				'class' => \yii\filters\auth\QueryParamAuth::className(),
//				'realm' => 'Protected Area basic',
//				'auth' => function ($username, $password){
//					$user = User::findByUsername($username);
//					Yii::info($user['id'], 'binary');
//					return $user;
//				}
//				],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [ // creates AccessRule object
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
						'matchCallback' => function ($rule, $action) {

								// $rule - this rule, $action - current action
								return 1;

						},
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }



    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
		if (!Yii::$app->user->isGuest) {
			Yii::$app->user->logout();
			return $this->goHome();
		}
    }

	public function actionBehavior() {

//		Yii::info(__FUNCTION__, 'binary');

		  $model = new Contact();

//		  $res = Contact::findOne(48);

		  $res = $model->find()->asArray()->all();
		  foreach ($model->find()->batch(3) as $res) {
			// $customer is a Customer object

			echo '<hr>';
			$r[] = $res;
//			foreach ($res as $val) {
//				print '<br>'; var_dump($val->id);
//			}
		}
			return $this->render('test', [
                'test' => $r,
            ]);
	}

	public function actionTest() {

//		$res = User::find()
//				->with(['paymentAggregation'])
//				->all();

//
		$res = User::findOne(5);
//				->amountSum; // virtual field in model

		return $this->render('test', [
                'test' => $res,
            ]);

//		$res = Agreement::getScoring();
//		var_dump($res);
//		return $this->render('test', [
//                'test' => $res,
//            ]);
	}
	/**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
//		var_dump('sdsd');
        $model = new Contact();
		// both queries are performed against the master
//    $rows = $db->createCommand('SELECT * FROM contact LIMIT 10')->queryAll();

		$model->user_id = 99;
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ($model->load(Yii::$app->request->post())) {


//			var_dump(Yii::$app->request->post());
//			var_dump($model);
//			die();


			 if(!$model->save()){
				  print_r($model->getErrors());
				 die();
			 }
//			 var_dump($model);
//			 die(0);
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionLoader()
    {


		$loader = new \LoaderEvent();
        return $this->render('test');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
//		var_dump($model);
//		die();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
