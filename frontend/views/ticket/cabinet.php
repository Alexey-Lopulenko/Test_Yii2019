<?php

use yii\helpers\Html;
$sessionActive = Yii::$app->session;
?>


    <div class="content">
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
    <pre class="col-md-8" style="background-color: #12b897">
        <h3>my order</h3>


    <?php

    /** @var \app\models\Date $dates */
    foreach ($dates as $date) {
        echo "<strong> Дата: </strong>" . $date->date_session;
        echo "<div class=\"col-md-4 text-left\">";
        echo '<img style="width: 250px; height: 250px;"  src="' . $date->film->logo_img . '" alt="' . $date->film->title . '"></div>';
        echo "<div class=\"col-md-8 text-center\"><strong>Фильм: </strong>" . $date->film->title;
        echo '<div class="col-md-8 text-center">';
        echo "<br><strong>Описание: </strong>" . $date->film->description . "</div>";

            }
    echo '</div>';

    echo '<div class="col-md-8 text-center">';
    /** @var \app\models\Session $sessions */
    foreach ($sessions as $session) {
        echo "<strong> Время сеанса: </strong>" . $session->time;
        echo "<br><strong> Зал № </strong>" . $session->hall_id;
    }
    echo '</div>';


    ?>
<div class="col-md-12">
        <table border="1" cellspacing="0" cellpadding="12">
<tr>
<th>Билет №</th>
<th>Место №</th>
<th>Ряд  №</th>
</tr>
    <?php
    /** @var \app\models\Ticket $tickets */
    foreach ($tickets as $ticket) {
        echo '<tr>';
        echo '<td>' . $ticket->id . '</td>';
        echo '<td>' . $ticket->place->number_place . '</td>';
        echo '<td>' . $ticket->place->row_id . '</td>';
        echo '</tr>';
    }
    ?>
</table>

    <?= Html::a('Enter', ['/ticket/cabinet'], [
        'class' => 'btn btn-md btn-primary',
        'data' => [
            'method' => 'post',
            'params' => [
                'enter_order' => true,
            ],]
    ]) ?>


</div>
</div>
    </div>

<?php
echo "<pre>";
print_r(Yii::$app->request->post());
echo "</pre>";
?>