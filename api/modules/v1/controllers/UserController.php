<?php


namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\Users;
//use yii\rest\ActiveController;
use api\modules\v1\components\ApiController;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use common\models\User;


class UserController extends ApiController
{
    public $modelClass = 'api\modules\v1\models\User';


    /**
     * Test action
     * @param null $username
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetUserByName($username = null)
    {
//        return User::find()
//            ->andFilterWhere(['like', 'username', $username])
//            ->createCommand()->rawSql;

        return $users = User::find()
            ->andFilterWhere(['like', 'username', $username])
            ->all();
    }

}