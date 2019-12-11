<?php
use yii\helpers\Html;
$sessionActive = Yii::$app->session;
?>


<div class="content">
    <!-- User Data-->
    <div class="col-md-4" style="background-color: rgba(101,200,108,0.67)">
        <h3>my data</h3>
        <p><strong>Name:</strong>
            <?=Yii::$app->user->identity->username?>
        </p>
        <p>
            <strong>E-mail:</strong>
            <?=Yii::$app->user->identity->email?>
        </p>
    </div>

    <!-- User Order-->
    <div class="col-md-8" style="background-color: rgba(158,255,167,0.45)">
        <h3>my order</h3>

        <?php
        /** @var \app\models\Date $dates */
        foreach ($dates as $date) :?>
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card flex-md-row mb-4 box-shadow h-md-250">
                        <img class="card-img-right flex-auto d-none d-md-block" data-src="holder.js/200x250?theme=thumb"
                             alt="Thumbnail [200x250]" style="width: 200px; height: 250px;"
                             src="<?= Yii::getAlias('@images') . '/' . $date->film->logo_img ?>"
                             data-holder-rendered="true">
                        <div class="card-body d-flex flex-column align-items-start">
                            <strong class="d-inline-block mb-2 text-primary"><?= $date->film->title ?></strong>
                            <p class="card-text mb-auto"><?= $date->film->description ?></p>
                        </div>
                    </div>
                    <div class="mb-1 text-muted"><strong> Дата: </strong><?= $date->date_session ?></div>
                </div>
            </div>
        <?php endforeach;
        /** @var \app\models\Session $sessions */
        foreach ($sessions as $session) :?>
            <div class="mb-1 text-muted"><strong> Время сеанса: </strong><?= $session->time ?></div>
            <div class="mb-1 text-muted"><strong> Зал № </strong><?= $session->hall_id ?></div>
        <?php endforeach; ?>

        <table class="table table-inverse">
            <thead>
            <tr class="table-active">
                <th scope="col">Билет №</th>
                <th scope="col">Место</th>
                <th scope="col">Ряд</th>
            </tr>
            </thead>
            <tbody>
            <?php
            /** @var \app\models\Ticket $tickets */
            foreach ($tickets as $ticket):?>
                <tr>
                    <th scope="row"><?= $ticket->id ?></th>
                    <td><?= $ticket->place->number_place ?></td>
                    <td><?= $ticket->place->row_id ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        echo Yii::$app->request->post('enter_order') ? "" : Html::a('Enter', ['/ticket/cabinet'], [
            'class' => 'btn btn-md btn-primary',
            'data' => [
                'method' => 'post',
                'params' => [
                    'enter_order' => true,
                ],]
        ]) ?>
    </div>
</div>
