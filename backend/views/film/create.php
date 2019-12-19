<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Film */
/** @var \app\models\User $users */
///** @var \app\models\Comment $showComment */

$this->title = 'Create Film';
$this->params['breadcrumbs'][] = ['label' => 'Films', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
//        'showComment'=>$showComment,
    ]) ?>

</div>
