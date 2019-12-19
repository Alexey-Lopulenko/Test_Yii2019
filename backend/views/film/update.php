<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Film */
/** @var \app\models\Film $film_id */
/** @var \app\models\User $users */
/** @var \app\models\Comment $showComments */

$this->title = 'Update Film: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Films', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="film-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'film_id' => $film_id,
        'users' => $users,
        'showComments' => $showComments,
    ]) ?>

</div>
