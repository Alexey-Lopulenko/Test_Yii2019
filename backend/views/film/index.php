<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Films';
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    'id',
    'title',
    'description',
];
?>
<div class="film-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <!--    --><?php
    //    echo '<pre>';
    //    print_r($dataProvider);
    //    echo '</pre>';
    //    ?>
    <p>
        <?= Html::a('Create Film', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Get Excel', ['get-excel'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php
    $getRenderer = function ($view) {
        return function ($model) use ($view) {
            return $this->render($view, ['model' => $model]);
        };
    };
    ?>

    <?=
    ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,

    ]) . "<hr>\n" .

    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:html',
//            'description:html',
//         return strip_tags($data->description);
//            'logo_img',
            [
                'label' => 'logo_img',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->logo_img ? Html::img(\yii\helpers\Url::to(['film/glide', 'path' => 'images/film/' . $data->logo_img, 'w' => 80, 'h' => 80]), [
                        'alt' => 'logo',
//                            'style' => 'width:50px;'
                    ]) : 'please set image';
                },

            ],
            ['attribute' => 'genres', 'value' => 'genresAsString'],
            'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
