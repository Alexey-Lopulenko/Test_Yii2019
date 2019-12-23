<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FilmAndGenre;

/**
 * FilmAndGenreSearch represents the model behind the search form of `app\models\FilmAndGenre`.
 */
class FilmAndGenreSearch extends FilmAndGenre
{

    public $film_title;
    public $genre_title;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'film_id', 'genre_id'], 'integer'],
            [['genre_title', 'film_title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FilmAndGenre::find()->joinWith(['film', 'genre']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        $dataProvider->setSort([
            'attributes' => array_merge($dataProvider->getSort()->attributes, [
                'film_title' => [
                    'asc' => ['film.title' => SORT_ASC],
                    'desc' => ['film.title' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'genre_title' => [
                    'asc' => ['genre.title' => SORT_ASC],
                    'desc' => ['genre.title' => SORT_DESC],
                    'default' => SORT_ASC,

                ],
            ]),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'film_id' => $this->film_id,
            'genre_id' => $this->genre_id,
        ]);

        $query->andFilterWhere(['like', 'film.title', $this->film_title])//правило фильтрации film-таблица, title-поле
        ->andFilterWhere(['like', 'genre.title', $this->genre_title]);
        return $dataProvider;
    }
}
