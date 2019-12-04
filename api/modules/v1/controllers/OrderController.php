<?php


namespace api\modules\v1\controllers;


use api\modules\v1\components\ApiController;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;

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
        return $behaviors;
    }

    /**
     * Test action
     * @return array
     */
    public function actionTest()
    {
        $users = User::find()->all();
        return [
            'result' => $users,
        ];
    }

}