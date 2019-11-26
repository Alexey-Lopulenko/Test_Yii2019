<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
/** @var \app\models\User $users_id */
/** @var \app\models\Date $dates_id */
/** @var \app\models\Session $sessions */
/** @var \app\models\Ticket $tickets */
?>

<div class="order-form">

    <?php
    $user_id = ArrayHelper::map($users_id, 'id', 'username');
    $params_user_id = [
        'prompt' => 'Username'
    ];

    $date_id = ArrayHelper::map($dates_id, 'id', 'date_session');
    $params_date_id = [
        'prompt' => 'Date session'
    ];

    $session_id = ArrayHelper::map($sessions, 'id', 'time');
    $params_session_id = [
        'prompt' => 'Time session'
    ];

    $ticket_id = ArrayHelper::map($tickets, 'id', 'id');
    $params_ticket_id = [
        'prompt' => 'Ticket id'
    ];
    ?>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'user_id')->dropDownList($user_id, $params_user_id) ?>

    <?= $form->field($model, 'date_id')->dropDownList($date_id, $params_date_id) ?>

    <?= $form->field($model, 'session_id')->dropDownList($session_id, $params_session_id) ?>

    <?= $form->field($model, 'ticket_id')->dropDownList($ticket_id, $params_ticket_id) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
