<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string $title
 *
 * @property FilmAndGenre[] $filmAndGenres
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string'],
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
        ];
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getFilmAndGenres()
//    {
//        return $this->hasMany(FilmAndGenre::className(), ['genre_id' => 'id']);
//    }

    public function getFilms()
    {
        return $this->hasMany(Film::className(), ['id' => 'film_id'])
            ->viaTable('film_and_genre', ['genre_id' => 'id']);
    }
}
