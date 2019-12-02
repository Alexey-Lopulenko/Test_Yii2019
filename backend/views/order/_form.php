<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

//use yii\widgets\Pjax;


$sessionActive = Yii::$app->session;


/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
/** @var \app\models\User $users_id */
/** @var \app\models\Date $dates_id */
/** @var \app\models\Session $sessions */
/** @var \app\models\Ticket $tickets */
/** @var \app\models\Film $films */
?>

<div class="order-form">
    <?php
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

    $date_id = ArrayHelper::map($dates_id, 'id', 'date_session');
    $params_date_id = [
        'prompt' => 'Date session',
        'onchange' => '
                $.post("index.php?r=order/lists_session&id=' . '"+$(this).val(), function(data){
                    $("select#order-session_id").html(data);
                });',
    ];

    $session_id = ArrayHelper::map($sessions, 'id', 'time');
    $params_session_id = [
        'prompt' => 'Session',
        'onchange' => '
                $.post("index.php?r=order/lists_ticket&id=' . '"+$(this).val(), function(data){
                    $("div#order-ticket_id").html(data);
                });',
    ];

    $ticket_id = ArrayHelper::map($tickets, 'id', 'id');
    $params_ticket_id = [
        'prompt' => 'Ticket',
    ];
    ?>


    <?php $form = ActiveForm::begin([
        'id' => 'get_order'
    ]); ?>

    <?= $form->field($model, 'user_id')->dropDownList($user_id, $params_user_id) ?>

    <?= $form->field($model, 'film')->dropDownList($film_id, $params_film_id) ?>

    <?= $form->field($model, 'date_id')->dropDownList($date_id, $params_date_id) ?>

    <?= $form->field($model, 'session_id')->dropDownList($session_id, $params_session_id) ?>

    <?= $form->field($model, 'ticket_id')->dropDownList($ticket_id, $params_ticket_id) ?>


    <?= Html::textInput('bufTicket', '', ['id' => 'bufTicket', 'class' => 'form-control', 'type' => 'hidden']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

    <?php //Pjax::begin();?>
    <div id="order-ticket_id" class="col-md-12" name="Order[ticket_id]">
    </div>
    <!--    --><?php
    ////    $js = <<<JS
    ////  $.post("index.php?r=order/lists_ticket&id=' . '"+$(this).val(), function(data){
    ////                    $("div#order-ticket_id").html(data);
    //// });
    ////JS;
    ////    $this->registerJs($js);
    //    ?>
    <?php //Pjax::end();?>

</div>

<?php
$js = <<<JS

var ArrTicket =[];

$('body').on('click', '.js-ticket-btn', function(e){
    var  dataTicket  = $(this).attr('data-ticket_id');
           
         if($(this).hasClass('disabled')){
    alert('Билет на данное место продан');
    }else{
      
    $(this).toggleClass('btn-danger');

         if(ArrTicket.length !== 0){
             //if element in array, delete this element
            if($.inArray(dataTicket, ArrTicket) !== -1 ){
                ArrTicket = jQuery.grep(ArrTicket, function(value) {
                  return value !== dataTicket;
                })
            }else {
                ArrTicket.push(dataTicket);
            }
         }else {
              ArrTicket.push(dataTicket);//first push in array
         }
    }
         var strTicket = ArrTicket.join(',');
    $("input#bufTicket").val(strTicket);
    console.log(ArrTicket);
});
JS;


$this->registerJs($js) ?>