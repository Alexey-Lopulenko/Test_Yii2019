<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Film */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Films', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="film-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            'SmallImage:image',
//            'value' => function () {
//             return Html::img('/test/backend/web/upload/images/film/prefix'.$this->logo_img, ['width' => '70px']);
//             },
//            'logo_img',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <img src="<?php
    if ($model['logo_img'] != '') {
        echo \yii\helpers\Url::to(['film/glide', 'path' => 'images/film/' . $model['logo_img'], 'w' => 300]);
    }
    ?>">
</div>
