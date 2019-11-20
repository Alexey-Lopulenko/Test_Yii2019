<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property string $time
 * @property int $date_id
 * @property int $price
 * @property int $hall_id
 *
 * @property Order[] $orders
 * @property Hall $hall
 * @property Date $date
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['date_id', 'price', 'hall_id'], 'integer'],
            [['price'], 'required'],
            [['hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hall::className(), 'targetAttribute' => ['hall_id' => 'id']],
            [['date_id'], 'exist', 'skipOnError' => true, 'targetClass' => Date::className(), 'targetAttribute' => ['date_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'date_id' => 'Date ID',
            'price' => 'Price',
            'hall_id' => 'Hall ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['session_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHall()
    {
        return $this->hasOne(Hall::className(), ['id' => 'hall_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDate()
    {
        return $this->hasOne(Date::className(), ['id' => 'date_id']);
    }
}