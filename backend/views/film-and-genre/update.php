<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilmAndGenre */

$this->title = 'Update Film And Genre: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Film And Genres', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="film-and-genre-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
