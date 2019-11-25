<?php


namespace frontend\controllers;

use app\models\DataByOrder;
use app\models\Order;
use app\models\Place;
use app\models\Row;
use app\models\Ticket;
use yii\web\Controller;
use frontend\models\ByForm;
use app\models\Film;
use app\models\Date;
use app\models\Session;


class TicketController extends Controller
{
    public function actionIndex(){


        $model = new ByForm();
        $film = Film::find()->all();
        $date = Date::find()->where(['status'=>'active'])->all();
        $session = Session::find()->where(['status_session' => 'active'])->all();
        $ticket = Ticket::find()->all();
        $place = Place::find()->orderBy(['id' => SORT_ASC])->all();
        $row = Row::find()->all();


        return $this->render('index', ['model' => $model, 'film' =>$film, 'date'=>$date, 'session'=>$session, 'ticket'=>$ticket, 'place'=>$place, 'row'=>$row]) ;
    }

    public function actionCabinet()
    {


        $order = new Order();

//        $order->user_id = '6';
//        $order->date_id='2';
//        $order ->session_id='2';
//        $order->ticket_id = '9'
//        $order->save(false);


//        if($order->load(Yii::$app->request->post('execute'))){
//            if($order->save(false)){
//                Yii::$app->session->setFlash('success', 'Покупка оформлена');
//                return $this->refresh();
//            }else{
//                Yii::$app->session->setFlash('error','Ошибка');
//            }
//        }


        $dates = Date::find()->with('film')->where(['id' => $_SESSION['id_session_by_order']])->all();

//        $films = Film::find()->where(['id' => $_SESSION['id_film_by_order']])->all();

        $sessions = Session::find()->where(['id' => $_SESSION['id_session_by_order']])->all();

        $tickets = Ticket::find()->with('place')->where(['id' => $_SESSION['place_by_order']])->all();

        return $this->render('cabinet', ['order' => $order, 'dates' => $dates, 'sessions' => $sessions, 'tickets' => $tickets]);
    }

}