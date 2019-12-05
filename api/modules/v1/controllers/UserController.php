<?php


namespace api\modules\v1\controllers;

use Yii;
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
//       return [
//           'access'=>[
//             'class'=>AccessControl::class,
//             'only'=>['test'],
//             'rules'=>[
//                 [
//                     'actions'=>['test'],
//                     'allow'=>true,
//                     'roles'=>['?'],
//                 ]
//             ],
//           ],
//       ];
//    }

    /**
     * Test action
     *
     */
    public function actionTest()
    {
        return 'Hello World';
    }

}