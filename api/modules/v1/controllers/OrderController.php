<?php


namespace api\modules\v1\controllers;

//use yii\rest\ActiveController;
use api\modules\v1\models\Order;
use api\modules\v1\components\ApiController;

class OrderController extends ApiController
{
    public $modelClass = 'api\modules\v1\models\Order';


    public function actionTest()
    {
        return 'test';
    }

}