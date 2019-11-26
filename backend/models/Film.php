<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "film".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $logo_img
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Date[] $dates
 */
class Film extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'film';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'logo_img'], 'string', 'max' => 250],
            [['description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'logo_img' => 'Logo Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDates()
    {
        return $this->hasMany(Date::className(), ['film_id' => 'id']);
    }
}
