
<?php

use yii\helpers\Html;
use skeeks\widget\highcharts\Highcharts;


/* @var $this yii\web\View */
/** @var \app\models\Ticket $tickets */
/** @var \app\models\Place $places */
/** @var \app\models\Row $rows */
/** @var  $id */

$session_id_by_order = $id;
?>



<?php foreach ($rows as $row): ?>
    <p>
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
    </p>
<?php endforeach;
echo '<br>';
?>

<?php

echo '<div class="col-md-6" style="    position: absolute;
    top: 0px;
    right: 382px;">';
echo Highcharts::widget([
    'options' => [
        'title' => [
            'text' => 'Order statistic'
        ],
        'xAxis' => [
            'categories' => [1, 2, 3, 4, 5, 6]
        ],
        'yAxis' => [
            'title' => ['text' => 'subtitle']
        ],
        'series' => [
            ['name' => 'test2',
                'data' => [
                    ['Draggable points', 117],
                    ['Data module for database tables', 118],
                    ['Draw lines over a stock chart', 134]
                ]],
        ],

    ]
]);
echo '</div>';
?>



