<?php


namespace frontend\models;


use yii\base\Model;

class ByForm extends Model
{
    public $film;
    public $date;

    public function rules()
    {
        return [
            // тут определяются правила валидации
        ];
    }
}