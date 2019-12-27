<?php

namespace app\models;

use Yii;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


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
            [['id', 'title'], 'required'],
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'logo_img'], 'string', 'max' => 250],
            [['description'], 'string', 'max' => 1000],
            [['title'], 'unique'],
            [['id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['id' => 'genre_id'])
            ->viaTable('film_and_genre', ['film_id' => 'id']);
    }


    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSimilarFilms()
    {
        $genres = $this->genres;
        $arrGenres = [];
        $arrFilmId = [];
        foreach ($genres as $genre) {
            array_push($arrGenres, $genre->id);
        }

        $filmGenre = FilmAndGenre::find()->where(['in', 'genre_id', $arrGenres])->andWhere(['not in', 'film_id', $this->id])->all();

        foreach ($filmGenre as $item) {
            array_push($arrFilmId, $item->film->id);
        }

        $arrId = array_count_values($arrFilmId);//массив где индекс это `id` а значение - число повторений

        arsort($arrId);//сортировка по значению
        $arrSortId = array_keys($arrId);//запись ключей в качестве элементов

        if ($arrId) {
            return Film::find()->where(['in', 'id', $arrSortId])->orderBy([new Expression('FIELD (id, ' . implode(',', $arrSortId) . ')')])->all();//вывод с сортировкой

        } else {
            return Film::find()->where(['in', 'id', $arrSortId])->orderBy(['id' => $arrSortId])->all();
        }
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSimilarFilms2()
    {
        $arrGenres = ArrayHelper::getColumn($this->genres, 'id');

        $query = Film::find()->leftJoin('film_and_genre', '`film`.`id` = `film_and_genre`.`film_id`');
        $query->where(['in', 'genre_id', $arrGenres]);
        $query->andWhere(['!=', 'film_id', $this->id]);

        $query->orderBy(new Expression('(
        SELECT COUNT(*) FROM `film_and_genre` WHERE `genre_id` IN (' . implode(',', $arrGenres) . ') AND `film_id` = film.id
        ) DESC, film.title ASC'));

        return $query->all();
    }

}