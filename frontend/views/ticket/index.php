<?php
    use yii\helpers\Html;
    use yii\bootstrap\Modal;
    use yii\widgets\Pjax;

$sessionActive = Yii::$app->session;

if(!(isset($sessionActive['place_by_order']))){
    $sessionActive['place_by_order']=[];
    $sessionActive['ticket_id_by_order']=[];
}


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
      <?php Modal::begin([

              'size' =>'modal-lg',
              'header' => '<h2 class="text-center">'.$film->title.'</h2>',
              'id' => $film['id'],
//            'footer' => Yii::$app->request->post('date')? $this->render('post'): "",
      ]);
        $sessionActive['id_film_by_order'] = $film->id;
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
      <?=Html::a('Cancel', ['/ticket/index'], [
              'class'=>'btn btn-md btn-warning',
          'data' => [
                  'method' => 'post',
              'params' => [
                      'cancel_id' => 'cancel',
              ],]
      ]);
      if(Yii::$app->request->post('cancel_id')){
          $sessionActive['place_by_order'] = [];
          $sessionActive['id_film_by_order']=[];
          $sessionActive['id_date_by_order']=[];
          $sessionActive['id_session_by_order']=[];
      }
      ?>


      <?php
      /** @var \app\models\Session $session */
      foreach ($session as $sessions){
          $session_price = Yii::$app->request->post('date')==$sessions->date_id ? $sessions->price."₴" : "";

          //соответствие сессии выбранной дате
          $sessionActive['id_date_by_order'] = Yii::$app->request->post('date');

          $time_session = Yii::$app->request->post('date')==$sessions->date_id ? $sessions->time : null;
          echo $time_session ? Html::a($sessions->time."<br>".$session_price, ['/ticket/index'], [
                  'class'=>'btn btn-md btn-warning',
                  'style'=>'height: 47px;',
                  'data' => [
                      'method' => 'post',
                      'params' => [
                          'session_id' => $sessions->id,
                  ],]
          ]):"";

      }
      $session_id_by_order = Yii::$app->request->post('session_id');
        $sessionActive['id_session_by_order'] = $session_id_by_order;
      echo "<pre>";
      print_r(Yii::$app->request->post());
      /** @var \app\models\Ticket $ticket */
      $test_i = 0;//количество билетов
      foreach ($ticket as $tickets){
          $test_i +=Yii::$app->request->post('session_id')==$tickets->session_id ? 1 :0;
      }
      echo "количество билетов:".$test_i."<br>";
      echo "</pre>";
      ?>


      <?php if(Yii::$app->request->post('session_id')):?>
          <!--place-->
          <div class="alert alert-success text-center" style="margin-top: 12px" role="alert">
              screen
              <?php
                $limit_ticket = null;
                echo isset($limit_ticket) ? '<br>'.$limit_ticket : "";
              ?>
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
                              $status_place = 1;
                              if($places->row_id==$rows->id && $tickets->place_id == $places->id){
                                  if($tickets->session_id == $session_id_by_order){
                                       //если билет продан отключить возможность выбора
                                      $class_btn = $tickets->status=="on_sale" ? 'btn btn-md btn-success' : 'btn btn-primary btn-md disabled';

                                        //смена стиля места при попадании его id в $sessionActive['place_by_order'](нажатие на ячейку места)
                                        if(isset($sessionActive['place_by_order'][$places->id])){
                                            $class_btn = 'btn btn-md btn-danger';
                                            $status_place = 0;
                                        }
                                        //вывод ячейки места
                                      echo  Html::a($places->number_place, ['/ticket/index'], [
                                              'class'=> $class_btn,
                                          'data' =>
                                              [
                                                      'method' => 'post',
                                                      'params' => [
                                                              'ticket_id' => $tickets->id,
                                                              'session_id' =>$session_id_by_order,
                                                              'status_place' => $status_place,

                                                        ],
                                              ]
                                      ]);
                                  }
                              }
                          }
//                          запись мест в ($sessionActive['place_by_order']) при клике на место place_id=>place_id
                          if(Yii::$app->request->post('ticket_id')){
                              if (count($sessionActive['place_by_order']) < 5 ){
                                  $sessionActive['place_by_order'] +=[
                                      Yii::$app->request->post('ticket_id')=>Yii::$app->request->post('ticket_id')
                                  ];
                              }
                          }
                            //удаление мест с сессии
                          if(Yii::$app->request->post('status_place')==0)
                          {
                              unset($_SESSION['place_by_order'][Yii::$app->request->post('ticket_id')]);
                          }
                          ?>

                      <?php endforeach;
                      echo "<br>";
                      ?>
                  </div>
              <?php endforeach;?>
              <?php

                if(count($sessionActive['place_by_order']) >0){
                    if(isset(Yii::$app->user->identity->id)){
                        echo Html::a('Continue order', ['/ticket/cabinet'], ['class' => 'btn btn-primary']);

                    }else{
                        echo Html::a('Login', ['/site/login'], ['class' => 'btn btn-danger']);
                    }
                }
              ?>

          </div>
      <?php endif;?>
      <?= Html::endForm()?>

<!--      --><?php
//           echo "<pre>";
//            print_r($sessionActive['id_film_by_order']);
//         echo "<br>";
//            print_r($sessionActive['id_date_by_order']);
//         echo "<br>";
//            print_r($sessionActive['id_session_by_order']);
//         echo "<br>";
//            print_r($sessionActive['place_by_order']);
//         echo "<br>";
//      ?>

      <?php Pjax::end();?>

      <?php Modal::end(); ?>

  <?php endforeach;?>


