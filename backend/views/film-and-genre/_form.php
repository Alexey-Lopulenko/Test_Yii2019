<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\FilmAndGenre */
/* @var $form yii\widgets\ActiveForm */
/** @var \app\models\Film $films */
/** @var \app\models\Genre $genres */


$film_id = ArrayHelper::map($films, 'id', 'title');
$params_film_id = [
    'prompt' => 'Film',
];
$genre_id = ArrayHelper::map($genres, 'id', 'title');
$params_genre_id = [
    'prompt' => 'Film',
];

?>

<div class="film-and-genre-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'film_id')->dropDownList($film_id, $params_film_id) ?>

    <?= $form->field($model, 'genre_id')->dropDownList($genre_id, $params_genre_id) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
