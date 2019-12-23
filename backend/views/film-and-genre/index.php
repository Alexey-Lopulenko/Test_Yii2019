<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FilmAndGenreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Film And Genres';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-and-genre-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Film And Genre', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'film_id',
            [
                'attribute' => 'film_title',
                'value' => 'filmTitle',
            ],
            'genre_id',
            [
                'attribute' => 'genre_title',
                'value' => 'genreTitle',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
