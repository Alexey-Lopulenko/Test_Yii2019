<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

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
            'description',
            'image',
            'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
