<?php


namespace api\modules\v1\controllers;

//use api\modules\v1\models\Users;
//use yii\rest\ActiveController;
use api\modules\v1\components\ApiController;

class UserController extends ApiController
{
    public $modelClass = 'api\modules\v1\models\User';

    public function actionTest()
    {
        return 'test';
    }
}