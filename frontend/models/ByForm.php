<?php


namespace frontend\models;


use yii\base\Model;

class ByForm extends Model
{
    public $date;
    public $session;
    public $film;
    public $ticket;
    public $price;

    public static function find(){

    }

    public function rules()
    {
        //return ['date', 'date'];
    }


}