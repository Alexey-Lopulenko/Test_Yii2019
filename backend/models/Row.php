<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "row".
 *
 * @property int $id
 * @property int $number_row
 * @property int $hall_id
 *
 * @property Place[] $places
 * @property Hall $hall
 */
class Row extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'row';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number_row'], 'required'],
            [['number_row', 'hall_id'], 'integer'],
            [['hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hall::className(), 'targetAttribute' => ['hall_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number_row' => 'Number Row',
            'hall_id' => 'Hall ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::className(), ['row_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHall()
    {
        return $this->hasOne(Hall::className(), ['id' => 'hall_id']);
    }
}
