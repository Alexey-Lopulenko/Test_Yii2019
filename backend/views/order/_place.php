<h3 class="text-center">place</h3>
<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/** @var \app\models\Ticket $tickets */
/** @var \app\models\Place $places */
/** @var \app\models\Row $rows */
/** @var  $id */


$session_id_by_order = $id;
?>



<?php foreach ($rows as $row): ?>
    <div class="content text-center" style="margin-top: 12px">
        <?= '<strong>Ряд №' . $row->id . '</strong>' ?>
        <?php foreach ($places as $place): ?>
            <?php foreach ($tickets as $ticket) {
                $status_place = 1;
                if ($place->row_id == $row->id && $ticket->place_id == $place->id) {
                    if ($ticket->session_id == $session_id_by_order) {
                        //если билет продан отключить возможность выбора
                        $class_btn = $ticket->status == "on_sale" ? 'btn btn-md btn-success' : 'btn btn-primary btn-md disabled';
                        //смена стиля и статуса места при попадании его id в $sessionActive['place_by_order'](нажатие на ячейку места)
                        if (isset($sessionActive['place_by_order'][$ticket->id])) {
                            $class_btn = 'btn btn-md btn-danger';
                            $status_place = 0;
                        }
                        //вывод ячейки места
                        echo Html::button($place->number_place, ['class' => $class_btn . ' js-ticket-btn', 'data-ticket_id' => $ticket->id]);
                    }
                }
            }
            ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>




