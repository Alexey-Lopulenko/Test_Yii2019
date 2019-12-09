<?php


namespace api\modules\v1\controllers;

use api\modules\v1\models\Order;
use app\models\Film;
use Yii;
use api\modules\v1\components\ApiController;
use api\modules\v1\models\User;
use yii\base\ErrorException;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

use api\modules\v1\models\Ticket;


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
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],

        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['create', 'update', 'delete', 'buy'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'delete', 'buy'],
                    'roles' => ['admin'],
                ],
            ],
        ];
        return $behaviors;
    }

    /**
     * Test action
     * @param null $id
     * @return void
     */
    public function actionUsers($id = null)
    {
        if ($id) {
            return $users = Order::find()->where(['like', 'user_id', $id])->all();
        }
    }

    /**
     * @param array $ticket
     */
    public function actionBuy(array $ticket)
    {
        $date_id = $ticket['date_id'];
        $session_id = $ticket['session_id'];

        unset($ticket['date_id']);
        unset($ticket['session_id']);


        $user_id = Yii::$app->user->getId();

        foreach ($ticket as $value) {

            $ticketInDb = Ticket::findOne($value);

            if ($ticketInDb->status == 'on_sale') {
                $order = new Order();
                $order->user_id = (int)$user_id;
                $order->date_id = (int)$date_id;
                $order->session_id = (int)$session_id;
                $order->ticket_id = (int)$value;
                $ticketInDb->status = 'sold_out';

                $order->save();
                $ticketInDb->save();
            } else {
                echo 'Error! Place №' . $value . '  sold_out.       ';
            }

        }

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