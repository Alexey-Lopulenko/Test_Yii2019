<?php


namespace api\modules\v1\controllers;

//use api\modules\v1\models\Users;
//use yii\rest\ActiveController;
use api\modules\v1\components\ApiController;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;


class UserController extends ApiController
{
    public $modelClass = 'api\modules\v1\models\User';

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => HttpBasicAuth::className(),
//        ];
//        return $behaviors;
//    }

}