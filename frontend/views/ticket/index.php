<?php
    use yii\helpers\Html;
    use yii\bootstrap\Modal;
    use yii\widgets\Pjax;


    $place_id_by_order=[];
?>

<h1 class="text-center">Film</h1>

                <?php
                /** @var \app\models\Film $film */
                foreach ($film as $film):?>
                    <div class="col-md-4" data-toggle="modal" data-target="#<?=$film->id?>" >
                        <div class="product-item">
                            <img style="width: 320px; height: 300px"
                                 src="<?php
                                        echo $film->logo_img ? $film->logo_img : "https://i.ytimg.com/vi/Dm9Ekro7ubo/hqdefault.jpg";
                                        ?>" alt="<?=$film->title ?>">
                            <div class="product-list d-inline">
                                    <h4><?=$film->title?></h4>
                            </div>
                        </div>
                    </div>
                    <?php
                    Modal::begin([
                            'size' =>'modal-lg',
                            'header' => '<h2 class="text-center">'.$film->title.'</h2>',
                            'id' => $film['id'],
//                            'footer' => Yii::$app->request->post('date')? $this->render('post'): "",
                        ]);
                        ?>

                            <img style="width: 150px; height: 150px"
                                 src="<?php
                                 echo $film->logo_img ? $film->logo_img : "https://i.ytimg.com/vi/Dm9Ekro7ubo/hqdefault.jpg";
                                 ?>" alt="<?=$film->title ?>">

                                <p>
                                    <?=$film->description?>
                                </p>

                                <?php
                                $date_arr = [];
                                /** @var \app\models\Date $date */
                                foreach ($date as $dates){
                                    if($film->id == $dates->film_id){
                                        $date_arr[$dates->id]=$dates->date_session;
                                    }
                                }?>

                        <?php Pjax::begin(); ?>
                            <?= Html::beginForm(['/ticket/index'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
                                <?=Html::dropDownList('date', Yii::$app->request->post('date'), $date_arr,['class'=>'btn btn-primary dropdown-toggle'])?>
                                <?=Html::submitButton('✔', ['class' => 'btn btn-md btn-primary']) ?>


                                <?php
                                /** @var \app\models\Session $session */
                                foreach ($session as $sessions){
                                    $session_price = Yii::$app->request->post('date')==$sessions->date_id ? $sessions->price."₴" : "";
                                        $time_session = Yii::$app->request->post('date')==$sessions->date_id ? $sessions->time : null;
                                            echo $time_session ? Html::a($sessions->time."<br>".$session_price, ['/ticket/index'], [
                                                'class'=>'btn btn-md btn-warning',
                                                'data' => [
                                                    'method' => 'post',
                                                    'params' => [
                                                        'session_id' => $sessions->id,
                                                    ],]
                                            ]):"";

                                    }
                                    $session_id_by_order = Yii::$app->request->post('session_id');

                                    echo "<pre>";
                                                print_r(Yii::$app->request->post());
                                    /** @var \app\models\Ticket $ticket */
                                    $test_i = 0;
                                                foreach ($ticket as $tickets){
//                                                    echo Yii::$app->request->post('session_id')==$tickets->session_id ? "ticket_id ".$tickets->id." place_id ".$tickets->place_id.", status : ".$tickets->status."<br>" : "";
                                                    $test_i +=Yii::$app->request->post('session_id')==$tickets->session_id ? 1 :0;
                                                }
                                                echo "количество билетов:".$test_i."<br>";
                                                print_r($place_id_by_order);
                                    echo "</pre>";
                                            ?>


                                <?php if(Yii::$app->request->post('session_id')):?>
                                                <!--place-->
                        <div class="alert alert-success text-center" style="margin-top: 12px" role="alert">
                            screen
                        </div>
                                    <div class="content" style="margin-top: 12px">
                                        <?php /** @var \app\models\Row $row */
                                         foreach ($row as $rows):?>
                                             <div class="content text-center" style="margin-top: 12px">
                                                <?= $tickets->session_id == $session_id_by_order?'<strong>Ряд №'.$rows->id.'</strong>':'<strong>Билетов нет</strong>';?>
                                                 <?php
                                                 /** @var \app\models\Place $place */
                                                 foreach ($place as $places):?>
                                                     <?php
                                                        foreach ($ticket as $tickets){
                                                                if($places->row_id==$rows->id && $tickets->place_id == $places->id){
                                                                    if($tickets->session_id == $session_id_by_order){
                                                                        $class_btn = $tickets->status=="on_sale" ? 'btn btn-md btn-success' : 'btn btn-primary btn-md disabled';
                                                                            echo  Html::a($places->number_place, ['/ticket/index'], [
                                                                                'class'=> $class_btn,
                                                                                'data' =>
                                                                                    [
                                                                                        'method' => 'post',
                                                                                        'params' => [
                                                                                            'place_id' => $places->id,
                                                                                            'session_id' =>$session_id_by_order,
                                                                                        ],
                                                                                    ]
                                                                            ]);
                                                                    }
                                                                }
                                                            }
                                                        if(Yii::$app->request->post('place_id')){

                                                            if(!(in_array(Yii::$app->request->post('place_id'), $place_id_by_order))){
                                                                echo 'good';
                                                                array_push($place_id_by_order, Yii::$app->request->post('place_id'));
                                                            }else{}

                                                        }
                                                     ?>
                                                 <?php endforeach;
                                                 echo "<br>";
                                                 ?>
                                             </div>
                                         <?php endforeach;

                                         ?>
                                    </div>
                                <?php endif;?>
                            <?= Html::endForm()?>
                        <?php Pjax::end();?>
                    <?php Modal::end(); ?>
                <?php endforeach;?>


