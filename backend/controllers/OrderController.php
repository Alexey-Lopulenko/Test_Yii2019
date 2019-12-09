<?php

namespace backend\controllers;

use app\models\Date;
use app\models\Film;
use app\models\Place;
use app\models\Row;
use app\models\Session;
use app\models\Ticket;
use app\models\User;
use Yii;
use app\models\Order;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'update',
                            'delete',
                            'create',
                            'lists_date',
                            'lists_session',
                            'lists_ticket'
                        ],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);
        $searchModel = new Order();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        $users_id = User::find()->all();
        $dates_id = [];
        $sessions = [];
        $tickets = [];
        $films = Film::find()->all();


        if (Yii::$app->request->post()) {

            $ticketsId = explode(',', Yii::$app->request->post('bufTicket'));
            $postOrder = Yii::$app->request->post('Order');


            if (count($ticketsId) > 1) {
                foreach ($ticketsId as $ticketId) {
                    $ticketInDb = Ticket::findOne($ticketId);
                    if ($ticketInDb->status == 'on_sale') {

                        $order = new Order();
                        $order->ticket_id = (int)$ticketId;

                        $order->user_id = (int)$postOrder['user_id'];
                        $order->date_id = (int)$postOrder['date_id'];
                        $order->session_id = (int)$postOrder['session_id'];


                        if ($order->save()) {
                            $ticketInDb->status = 'sold_out';
                            $ticketInDb->save();
                        } else {
                            echo 'failed';
                            print_r($order->attributes);
                            print_r($order->errors);

                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Билет был продан ранее!');
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Не выбран билет!');
            }

//            return $this->redirect(['index']);//, 'id' => $model->id
//        }
        }


//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            echo "<pre>";
//                    print_r(Yii::$app->request->post());
//            echo "</pre>";
//            die;
//            return $this->redirect(['index']);//, 'id' => $model->id
//        }

        return $this->render('create', [
            'model' => $model,
            'users_id' => $users_id,
            'dates_id' => $dates_id,
            'sessions' => $sessions,
            'tickets' => $tickets,
            'films' => $films,
        ]);
    }


    /**
     * @param $id
     * @return string
     */
    public function actionLists_date($id)
    {

        $countDates = Date::find()
            ->where(['film_id' => $id])
            ->count();
        $dates = Date::find()
            ->where(['film_id' => $id])
            ->all();
        echo "<option>Select date</option>";
        if ($countDates > 0) {
            foreach ($dates as $date) {
                echo "<option value='" . $date->id . "'>" . $date->date_session . "</option>";
            }
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function actionLists_session($id)
    {

        $countSession = Session::find()
            ->where(['date_id' => $id])
            ->count();
        $sessions = Session::find()
            ->where(['date_id' => $id])
            ->all();

        echo "<option>Select session</option>";
        if ($countSession > 0) {

            foreach ($sessions as $session) {
                echo "<option value='" . $session->id . "' id='" . $session->id . "'>" . $session->time . "</option>";
            }
        }

    }


    /**
     * @param $id
     * @return string
     */
    public function actionLists_ticket($id)
    {
        $rows = Row::find()->all();
        $places = Place::find()->all();

        $countTicket = Ticket::find()
            ->where(['session_id' => $id])
            ->count();
        $tickets = Ticket::find()
            ->where(['session_id' => $id])
            ->all();
        if ($countTicket > 0) {
            return $this->renderAjax('_place', $params = [
                'tickets' => $tickets,
                'rows' => $rows,
                'places' => $places,
                'id' => $id,
            ]);
        }
    }


    public function actionSave_ticket($ticket_id, $session_id)
    {

//       $this->redirect('index.php?r=order/create');
        return $this->actionLists_ticket($session_id);
    }


    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $films = Film::find()->all();
        $users_id = User::find()->all();
        $dates_id = Date::find()->where(['status' => 'active'])->all();
        $sessions = Session::find()->where(['date_id' => $model->date_id])->all();
        $tickets = Ticket::find()->where(['status' => 'on_sale'])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'users_id' => $users_id,
            'dates_id' => $dates_id,
            'sessions' => $sessions,
            'tickets' => $tickets,
            'films' => $films,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

//    public function actionDate()
//    {
//        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        $out = [];
//        if (isset($_POST['depdrop_parents'])) {
//            $parents = $_POST['depdrop_parents'];
//            if ($parents != null) {
//                $film_id = $parents[0];
//                $out = self::getDate($film_id);
//
//                return ['output' => $out, 'selected' => ''];
//            }
//        }
//        return ['output' => '', 'selected' => ''];
//    }
//
//
//    /**
//     * @return array
//     * *the getSessionList function will query the database based on the
//     * cat_id and sub_cat_id and return an array like below:
//     *  [
//     *      'out'=>[
//     *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
//     *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
//     *       ],
//     *       'selected'=>'<prod-id-1>'
//     *  ]
//     */
//    public function actionSession()
//    {
//        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        $out = [];
//        if (isset($_POST['depdrop_parents'])) {
//            $ids = $_POST['depdrop_parents'];
//            $date_id = empty($ids[0]) ? null : $ids[0];
//            $session_id = empty($ids[1]) ? null : $ids[1];
//            if ($date_id != null) {
//                $data = Session::getSessionList($date_id, $session_id);
//
//                return ['output' => $data['out'], 'selected' => $data['selected']];
//            }
//        }
//        return ['output' => '', 'selected' => ''];
//    }


}
