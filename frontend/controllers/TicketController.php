<?php


namespace frontend\controllers;
use app\models\Place;
use app\models\Row;
use app\models\Ticket;
use yii\web\Controller;
use frontend\models\ByForm;
use app\models\User;
use app\models\Film;
use app\models\Date;
use app\models\Session;

class TicketController extends Controller
{
    public function actionIndex(){


        $model = new ByForm();
        $user = User::find()->all();
        $film = Film::find()->all();
        $date = Date::find()->where(['status'=>'active'])->all();
        $session = Session::find()->where(['status_session' => 'active'])->all();
        $ticket = Ticket::find()->all();
        $place = Place::find()->orderBy(['id' => SORT_ASC])->all();
        $row = Row::find()->all();



        return $this->render('index', ['model' => $model, 'user'=>$user, 'film' =>$film, 'date'=>$date, 'session'=>$session, 'ticket'=>$ticket, 'place'=>$place, 'row'=>$row]) ;
    }

}