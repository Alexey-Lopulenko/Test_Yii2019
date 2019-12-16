<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\web\UploadedFile;
use vova07\imperavi\Widget;
use kartik\file\FileInput;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Film */
/* @var $form yii\widgets\ActiveForm */

/** @var \app\models\User $users_id */
/** @var \app\models\Comment $comments */

$js = <<<JS
$(document).ready(function(){
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#myTab a[href="' + activeTab + '"]').tab('show');
	}
});
JS;
$this->registerJs($js);


$css = <<<CSS
.bs-example{
		margin: 20px;
	}
CSS;
$this->registerCss($css);


//$user_id = ArrayHelper::map($users_id, 'id', 'username');
//$params_user_id = [
//    'prompt' => 'Username',
//];
//
//
//$film_id = ArrayHelper::map($model, 'id', 'title');
//$params_film_id = [
//    'prompt' => 'Film',
//    'onchange' => '
//                $.post("index.php?r=order/lists_date&id=' . '"+$(this).val(), function(data){
//                    $("select#order-date_id").html(data);
//                });',
//];
?>
<div class="bs-example">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a data-toggle="tab" href="#sectionFilm">Film</a></li>
        <li><a data-toggle="tab" href="#sectionComment">Comments</a></li>
        <li><a data-toggle="tab" href="#sectionTest">Section test</a></li>
    </ul>
    <div class="tab-content">
        <!--FilmSection-->
        <div id="sectionFilm" class="tab-pane fade in active">
            <div class="film-form">

                <?php

                ?>
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


                <?= $form->field($model, 'description')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 200,
                        'plugins' => [
                            'clips',
                            'fullscreen',
                        ],
                        'clips' => [
                            ['Lorem ipsum...', 'Lorem...'],
                            ['red', '<span class="label-red">red</span>'],
                            ['green', '<span class="label-green">green</span>'],
                            ['blue', '<span class="label-blue">blue</span>'],
                        ],
                    ],
                ]); ?>

                <?php if ($model['logo_img'] != ''): ?>
                    <img
                            src="<?php echo \yii\helpers\Url::to(['film/glide', 'path' => 'images/film/' . $model['logo_img'], 'w' => 250]); ?>">
                    <p><br>
                        <?= Html::a('Delete image', ['film/delete-img', 'img' => $model['logo_img']], ['class' => 'btn btn-danger']) ?>
                    </p>
                <?php endif; ?>

                <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                ]); ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
                <hr>
                <h3>Add comment</h3>
                <div style="width: 700px;">
                    <?= $form->field($model, 'schedule')->widget(MultipleInput::className(), [
                        'max' => 4,
                        'columns' => [
                            [
                                'name' => 'user_id',
                                'type' => 'dropDownList',
                                'title' => 'User',
                                'defaultValue' => 1,
                                'items' => [
                                    1 => 'User 1',
                                    2 => 'User 2'
                                ]
                            ],
                            [
                                'name' => 'priority',
                                'title' => 'Priority',
                                'enableError' => true,
                                'options' => [
                                    'class' => 'input-priority'
                                ]
                            ]
                        ]
                    ]);
                    ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <?php
                echo '<pre>';
                $test = $model->getComment();
                print_r($test);
                echo '</pre>';
                ?>
            </div>
        </div>
        <!--endFilmSection-->
        <!--CommentSection-->
        <div id="sectionComment" class="tab-pane fade">
            <h3>Comment</h3>
            <div class="comment-form">
                <!--                    --><?php
                //                        foreach ($comments as $comment){
                //                            echo '<pre>';
                //                            echo $comment->comment.'<br>';
                //                            echo '</pre>';
                //                        }
                //                    ?>
            </div>
        </div>
        <!--endCommentSection-->
        <!--TestSection-->
        <div id="sectionTest" class="tab-pane fade">
            <h3>Section Test</h3>
            <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut,
                mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum
                turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis.
                Nunc facilisis leo at faucibus adipiscing.</p>
        </div>
        <!--endTestSection-->
    </div>
</div>
</div>
