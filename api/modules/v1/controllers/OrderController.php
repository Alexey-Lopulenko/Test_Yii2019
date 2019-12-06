<?php


namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\components\ApiController;
use api\modules\v1\models\User;
use yii\base\ErrorException;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;

class OrderController extends ApiController
{


    /**
     * @var string
     */
    public $modelClass = 'api\modules\v1\models\Order';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['create', 'update', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'delete'],
                    'roles' => ['admin'],
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * Test action
     * @return array
     */
    public function actionTest()
    {
//        $users = User::find()->all();
//        return [
//            'result' => $users,
//        ];

        return Yii::$app->user->getId();
    }


    public function actionLogin()
    {
        if ($user = User::findByUsername(\Yii::$app->request->get('username')) and
            $user->validatePassword(\Yii::$app->request->get('password'))) {
            return $user->auth_key;
        } else {
            throw new ErrorException("Данного пользователя не существует");
        }
    }

}