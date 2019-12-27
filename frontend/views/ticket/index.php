<?php
    use yii\helpers\Html;
    use yii\bootstrap\Modal;
    use yii\widgets\Pjax;

$sessionActive = Yii::$app->session;


if (!(isset($sessionActive['place_by_order']))) {
    $sessionActive['place_by_order'] = [];
    $sessionActive['ticket_id_by_order'] = [];

}

$js = <<<JS
var ArrCheckbox =[];
//
// $('body').on('click','#checkbox', function() {
//  var genre = $(this).attr('genre');
//
//
//  if(ArrCheckbox.length !== 0){
//              //if element in array, delete this element
//             if($.inArray(genre, ArrCheckbox) !== -1 ){
//                 ArrCheckbox = jQuery.grep(ArrCheckbox, function(value) {
//                   return value !== genre;
//                 })
//             }else {
//                 ArrCheckbox.push(genre);
//             }
//          }else {
//              ArrCheckbox.push(genre);//first push in array
//          }
// });

let filter = $("[data-filter]");
                filter.on("click", function() {
                    let genre = $(this).data('filter');
                    
                     if(ArrCheckbox.length !== 0){
                         //if element in array, delete this element
                        if($.inArray(genre, ArrCheckbox) !== -1 ){
                            ArrCheckbox = jQuery.grep(ArrCheckbox, function(value) {
                              return value !== genre;
                            })
                        }else {
                            ArrCheckbox.push(genre);
                        }
                     }else {
                         ArrCheckbox.push(genre);//first push in array
                     }
                     
                     if(ArrCheckbox.length === 0){
                         console.log('pusto');
                         $("[data-genre]").removeClass('hide');
                     }
                     
                    $('[data-genre]').each(function() {
                        let workGenre = $(this).data("genre");
                        // console.log(workGenre);
                        // $(ArrCheckbox).each(function() {
                        //     let activeGenre = $(this).data("genre");
                        //   
                        // });
                        if(!(workGenre.indexOf(genre) + 1)) 
                        { 
                            $(this).addClass('hide');
                        }else {
                            $(this).removeClass('hide');
                        }
                    });
                });

//    $("#filters :checkbox").click(function() {
//
//       var re = new RegExp($("#filters :checkbox:checked").map(function() {
//                              return this.value;
//                           }).get().join(" ") );
//       $("div").each(function() {
//          var = $(this);
//          
//       });
//    });
JS;
$this->registerJs($js);

$css = <<<CSS
.hide {
display: none;
}
CSS;
$this->registerCss($css);

?>

<h1 class="text-center">Film</h1>
<div class="container-fluid">
    <div class="col-md-2">
        <?php foreach ($genres as $genre): ?>
            <div class="checkbox" id="checkbox" genre="<?= $genre->title ?>" data-filter="<?= $genre->title ?>">
                <label><input type="checkbox" value=""><?= $genre->title ?></label>
                <?= Html::a(count($genre->filmAndGenres), ['film-genre', 'idGenre' => $genre->id], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'method' => 'post',
                    ],
                ]) ?>
            </div>

        <?php endforeach; ?>
    </div>
    <div class="col-md-10">
        <?php
        /** @var \app\models\Film $film */
        foreach ($film as $film):?>
            <div class="col-md-4" data-toggle="modal" data-target="#<?= $film->id ?>"
                 data-genre="<?php foreach ($film->genres as $one) {
                     echo $one->title . ' ';
                 } ?>">
                <div class="product-item">
                    <img style="width: 210px; height: 200px"
                         src="<?php //Yii::$app->glide->outputImage('images/film/'. $film->logo_img, ['w' => 188, 'fit' => 'fill']);
                         echo $film->logo_img ? '/test/backend/web/uploads/images/film/' . $film->logo_img . '?filt=sepia' : "https://i.ytimg.com/vi/Dm9Ekro7ubo/hqdefault.jpg";
                         ?>" alt="<?= $film->title ?>">
                    <div class="product-list d-inline">
                        <h4><?= $film->title ?></h4>
                    </div>
                </div>
            </div>
            <?php Modal::begin([

                'size' => 'modal-lg',
                'header' => '<h2 class="text-center">' . $film->title . '</h2>',
                'id' => $film['id']
            ]);
            $sessionActive['id_film_by_order'] = $film->id;
            ?>

            <img style="width: 150px; height: 150px"
                 src="<?php
                 echo $film->logo_img ? '/test/backend/web/uploads/images/film/' . $film->logo_img : "https://i.ytimg.com/vi/Dm9Ekro7ubo/hqdefault.jpg";
                 ?>" alt="<?= $film->title ?>">

            <p>
                <?php
                echo '<strong>Genre:</strong><br>';
                foreach ($film->genres as $one) {
                    echo $one->title . '<br>';
                }
                ?>
                <?php
                echo '<strong>Description:</strong><br>';
                echo $film->description ?>
            </p>

            <div class="content">
                <ol>
                    <?php
                    $counter = 0;
                    $showMaxFilm = 5;
                    foreach ($film->getSimilarFilms2() as $similarFilm) {
                        if ($counter < $showMaxFilm) {
                            ?>

                            <li>
                                <?php echo $similarFilm->title ?> <?= $similarFilm->id ?>
                            </li>
                            <ul><?php
                                foreach ($similarFilm->genres as $genre) {
                                    echo '<li>' . $genre->title . '</li>';
                                } ?>
                            </ul>


                            <?php
                            $counter++;
                        } else {
                            break;
                        }
                    }
                    ?>
                </ol>
            </div>


            <?php
            $date_arr = [];
            /** @var \app\models\Date $date */

            foreach ($date as $dates) {
                if ($film->id == $dates->film_id) {

                    $date_arr[$dates->id] = $dates->date_session;
                }
            } ?>

            <?php Pjax::begin(); ?>
            <?= Html::beginForm(['/ticket/index'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
            <?= Html::dropDownList('date', Yii::$app->request->post('date'), $date_arr, ['class' => 'btn btn-primary dropdown-toggle']) ?>
            <?= Html::submitButton('✔', ['class' => 'btn btn-md btn-primary']) ?>
            <?= Html::a('Cancel', ['/ticket/index'], [
                'class' => 'btn btn-md btn-warning',
                'data' => [
                    'method' => 'post',
                    'params' => [
                        'cancel_id' => 'cancel',
                    ],]
            ]);
            if (Yii::$app->request->post('cancel_id')) {
                $sessionActive['place_by_order'] = [];
                $sessionActive['id_film_by_order'] = [];
                $sessionActive['id_date_by_order'] = [];
                $sessionActive['id_session_by_order'] = [];
            }
            ?>


            <?php
            /** @var \app\models\Session $session */
            foreach ($session as $sessions) {
                $session_price = Yii::$app->request->post('date') == $sessions->date_id ? $sessions->price . "₴" : "";

                //соответствие сессии выбранной дате
                $sessionActive['id_date_by_order'] = Yii::$app->request->post('date');

                $time_session = Yii::$app->request->post('date') == $sessions->date_id ? $sessions->time : null;
                echo $time_session ? Html::a($sessions->time . "<br>" . $session_price, ['/ticket/index'], [
                    'class' => 'btn btn-md btn-warning',
                    'style' => 'height: 47px;',
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'session_id' => $sessions->id,
                        ],]
                ]) : "";
            }
            $session_id_by_order = Yii::$app->request->post('session_id');
            $sessionActive['id_session_by_order'] = $session_id_by_order;

            /** @var \app\models\Ticket $ticket */
            $number_of_tickets = 0;//количество билетов
            foreach ($ticket as $tickets) {
                $number_of_tickets += Yii::$app->request->post('session_id') == $tickets->session_id ? 1 : 0;
            }

            ?>


            <?php if (Yii::$app->request->post('session_id')): ?>
                <!--place-->
                <div class="alert alert-success text-center" style="margin-top: 12px" role="alert">
                    screen
                    <?php
                    $limit_ticket = null;
                    echo isset($limit_ticket) ? '<br>' . $limit_ticket : "";
                    ?>
                </div>

                <div class="content" style="margin-top: 12px">
                    <?php /** @var \app\models\Row $row */
                    foreach ($row as $rows):?>
                        <div class="content text-center" style="margin-top: 12px">
                            <?= $number_of_tickets > 0 ? '<strong>Ряд №' . $rows->id . '</strong>' : '<strong>Билетов нет</strong>'; ?>
                            <?php
                            /** @var \app\models\Place $place */
                            foreach ($place as $places):?>
                                <?php
                                foreach ($ticket as $tickets) {
                                    $status_place = 1;
                                    if ($places->row_id == $rows->id && $tickets->place_id == $places->id) {
                                        if ($tickets->session_id == $session_id_by_order) {
                                            //если билет продан отключить возможность выбора
                                            $class_btn = $tickets->status == "on_sale" ? 'btn btn-md btn-success' : 'btn btn-primary btn-md disabled';

                                            //смена стиля и статуса места при попадании его id в $sessionActive['place_by_order'](нажатие на ячейку места)
                                            if (isset($sessionActive['place_by_order'][$tickets->id])) {
                                                $class_btn = 'btn btn-md btn-danger';
                                                $status_place = 0;
                                            }
                                            //вывод ячейки места
                                            echo Html::a($places->number_place, ['/ticket/index'], [
                                                'class' => $class_btn,
                                                'data' =>
                                                    [
                                                        'method' => 'post',
                                                        'params' => [
                                                            'ticket_id' => $tickets->id,
                                                            'session_id' => $session_id_by_order,
                                                            'status_place' => $status_place,
                                                        ],
                                                    ]
                                            ]);
                                        }
                                    }
                                }
//                          запись мест в ($sessionActive['place_by_order']) при клике на место place_id=>place_id
                                if (Yii::$app->request->post('ticket_id')) {
                                    if (count($sessionActive['place_by_order']) < 5) {
                                        $sessionActive['place_by_order'] += [
                                            Yii::$app->request->post('ticket_id') => Yii::$app->request->post('ticket_id')
                                        ];
                                    }
                                }

                                //удаление мест из сессии
                                if (Yii::$app->request->post('status_place') == 0) {
                                    unset($_SESSION['place_by_order'][Yii::$app->request->post('ticket_id')]);
                                }
                                ?>

                            <?php endforeach;
                            echo "<br>";
                            ?>
                        </div>
                    <?php endforeach; ?>
                    <?php
                    //вывод навигации для продолжения покупки
                    if (count($sessionActive['place_by_order']) > 0 && $number_of_tickets > 0) {
                        if (isset(Yii::$app->user->identity->id)) {
                            echo Html::a('Continue order', ['/ticket/cabinet'], ['class' => 'btn btn-primary']);

                        } else {
                            echo Html::a('Login', ['/site/login'], ['class' => 'btn btn-danger']);
                        }
                    } else {
                        echo "Click in place";
                    }
                    ?>
                </div>
            <?php endif; ?>
            <?= Html::endForm() ?>
            <?php Pjax::end(); ?>
            <?php Modal::end(); ?>
        <?php endforeach; ?>
    </div>
    <nav class="text-center" aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>



