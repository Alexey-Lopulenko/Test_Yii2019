<?php


namespace frontend\controllers;


use app\models\FilmAndGenre;
use app\models\Genre;
use app\models\Order;
use app\models\Place;
use app\models\Row;
use app\models\Ticket;
use yii\web\Controller;
use frontend\models\ByForm;
use app\models\Film;
use app\models\Date;
use app\models\Session;
use Yii;


class TicketController extends Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'glide' => 'trntv\glide\actions\GlideAction'
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {


        $model = new ByForm();
        $film = Film::find()->all();
        $date = Date::find()->where(['status' => 'active'])->all();
        $session = Session::find()->where(['status_session' => 'active'])->all();
        $ticket = Ticket::find()->all();
        $place = Place::find()->orderBy(['id' => SORT_ASC])->all();
        $row = Row::find()->all();
        $genres = Genre::find()->all();
        $filmGenres = FilmAndGenre::find()->all();

        return $this->render('index', [
            'model' => $model,
            'film' => $film,
            'date' => $date,
            'session' => $session,
            'ticket' => $ticket,
            'place' => $place,
            'row' => $row,
            'genres' => $genres,
            'filmGenres' => $filmGenres,
        ]);
    }

    /**
     * @return string
     */
    public function actionCabinet()
    {

        $dates = Date::find()->with('film')->where(['id' => $_SESSION['id_session_by_order']])->all();
        $sessions = Session::find()->where(['id' => $_SESSION['id_session_by_order']])->all();
        $tickets = Ticket::find()->with('place')->where(['id' => $_SESSION['place_by_order']])->all();
        $orders = Order::find()->where(['user_id' => Yii::$app->user->identity->id])->all();


        if (Yii::$app->request->post('enter_order')) {

            /** @var Ticket $tickets */
            foreach ($tickets as $ticket) {
                /**
                 * if the ticket status is “on sale”, write it in the 'order' table and change the ticket status to “sold_out”
                 */
                if ($ticket->status == 'on_sale') {
                    $ticket->status = 'sold_out';
                    $order = new Order();
                    $order->ticket_id = (int)$ticket->id;
                    $order->user_id = (int)Yii::$app->user->identity->id;
                    $order->date_id = (int)$_SESSION['id_date_by_order'];
                    $order->session_id = (int)$_SESSION['id_session_by_order'];
                    $order->created_at = 2019;
                    $order->updated_at = 2019;
                    $ticket->save();
                    $order->save();
                    Yii::$app->session->setFlash('success', 'Покупка оформлена');//message display in the basket(Success)

                } else {
                    Yii::$app->session->setFlash('error', 'Билет продан');//message display in the basket (Error)
                    break;
                }
            }
            $_SESSION['place_by_order'] = [];//clear order data

            foreach ($orders as $order_data) {

            }
        }
        return $this->render('cabinet', [
            'dates' => $dates,
            'sessions' => $sessions,
            'tickets' => $tickets,
            'orders' => $orders,

        ]);
    }


    public function actionFilmGenre($idGenre)
    {

        $filmGenre = FilmAndGenre::find()->where(['genre_id' => $idGenre])->all();
        $genres = Genre::find()->all();

        return $this->render('genre', [
            'filmGenre' => $filmGenre,
            'genres' => $genres,
        ]);
    }

}