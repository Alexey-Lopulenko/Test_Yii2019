<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "date".
 *
 * @property int $id
 * @property string $date_session
 * @property int $film_id
 *
 * @property Film $film
 * @property Order[] $orders
 * @property Session[] $sessions
 */
class Date extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_session'], 'required'],
            [['date_session'], 'safe'],
            [['film_id'], 'integer'],
            [['film_id'], 'exist', 'skipOnError' => true, 'targetClass' => Film::className(), 'targetAttribute' => ['film_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_session' => 'Date Session',
            'film_id' => 'Film ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilm()
    {
        return $this->hasOne(Film::className(), ['id' => 'film_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessions()
    {
        return $this->hasMany(Session::className(), ['date_id' => 'id']);
    }
}