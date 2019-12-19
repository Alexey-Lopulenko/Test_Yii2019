<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */
/** @var \app\models\User $users_id */
/** @var \app\models\Film $films */


$user_id = ArrayHelper::map($users_id, 'id', 'username');
$params_user_id = [
    'prompt' => 'Username',
];


$film_id = ArrayHelper::map($films, 'id', 'title');
$params_film_id = [
    'prompt' => 'Film',
    'onchange' => '
                $.post("index.php?r=order/lists_date&id=' . '"+$(this).val(), function(data){
                    $("select#order-date_id").html(data);
                });',
];
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList($user_id, $params_user_id) ?>

    <?= $form->field($model, 'film_id')->dropDownList($film_id, $params_film_id) ?>

    <?= $form->field($model, 'comment')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'style' => 'color:black',
            'plugins' => [
                'clips',
                'fullscreen',
            ],
            'clips' => [
                ['Lorem ipsum...', 'Lorem...'],
                ['red', '<span class="label-red">red</span>'],
                ['green', '<span class="label-green">green</span>'],
                ['blue', '<span class="label-blue">blue</span>'],
            ],
        ],
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
