<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmAndGenre */
/** @var \app\models\Film $films */
/** @var \app\models\Genre $genres */

$this->title = 'Create Film And Genre';
$this->params['breadcrumbs'][] = ['label' => 'Film And Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-and-genre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'films' => $films,
        'genres' => $genres,
    ]) ?>

</div>
