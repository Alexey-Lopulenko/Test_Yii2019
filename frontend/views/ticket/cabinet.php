<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//echo  Yii::$app->user->identity->username."<br>".Yii::$app->user->identity->email;
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
            echo "<pre>";

        /** @var \app\models\Session $ses */
       foreach ($ses as $s){
           print_r($s->date);
       }
        echo "<br>";
            print_r($sessionActive['id_film_by_order']);
            echo "<br>";
            print_r($sessionActive['id_date_by_order']);
            echo "<br>";
            print_r($sessionActive['id_session_by_order']);
            echo "<br>";
            print_r($sessionActive['place_by_order']);
            echo "<br>";
            print_r($sessionActive['ticket_id_by_order']);
        ?>
    </pre>
        <strong>Film_id:</strong><?= $sessionActive['id_film_by_order']?><br>
        <strong>Date_id:</strong><?= $sessionActive['id_date_by_order']?><br>
        <strong>Session_id:</strong><?= $sessionActive['id_session_by_order']?><br>
    <strong>Ticket_id:</strong>
    <ul>
        <?php
            foreach ($sessionActive['place_by_order'] as $value){
                echo "<li>".$value."</li>";
            }
        ?>
    </ul>

<br>
<!--    --><?php
//    echo  Html::a('text', ['/ticket/cabinet'], [
//        'class'=> 'btn btn-md btn-primary',
//        'data' =>
//            [
//                'method' => 'post',
//                'params' => [
//                    'film_id'=>$sessionActive['id_film_by_order'],
//                    'ticket_id' => $sessionActive['place_by_order'],
//                    'session_id' => $sessionActive['id_session_by_order'],
//                ],
//            ]
//    ]);
//    ?>





    </div>
</div>
