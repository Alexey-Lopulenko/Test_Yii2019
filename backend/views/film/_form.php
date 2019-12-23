<?php

use app\models\Comment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Film */
/* @var $form yii\widgets\ActiveForm */

/** @var \app\models\User $users_id */
/** @var \app\models\Comment $comments */

/** @var \app\models\User $users */
/** @var \app\models\Comment $showComments */

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


$user_id = ArrayHelper::map($users, 'id', 'username');
$params_user_id = [
    'prompt' => 'Username',
];
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

                <?php
                $test = $model->genre;
                //                echo '<pre>';
                var_dump($test);
                //                echo '</pre>';

                $data = [
                    "red" => "red",
                    "green" => "green",
                    "blue" => "blue",
                    "orange" => "orange",
                    "white" => "white",
                    "black" => "black",
                    "purple" => "purple",
                    "cyan" => "cyan",
                    "teal" => "teal"
                ];

                var_dump($data);


                echo '<label class="control-label">Genre</label>';
                echo Select2::widget([
                    'name' => 'color_3',
                    'value' => $data, // initial value
                    'data' => $data,
                    'maintainOrder' => true,
                    'toggleAllSettings' => [
                        'selectLabel' => '<i class="fas fa-ok-circle"></i> Tag All',
                        'unselectLabel' => '<i class="fas fa-remove-circle"></i> Untag All',
                        'selectOptions' => ['class' => 'text-success'],
                        'unselectOptions' => ['class' => 'text-danger'],
                    ],
                    'options' => ['placeholder' => 'Select a genre...', 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
                ?>

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
                    <p>
                        <br>
                        <?= Html::a('Delete image', ['film/delete-img', 'img' => $model['logo_img']], ['class' => 'btn btn-danger']) ?>
                    </p>
                <?php endif; ?>

                <?= $form->field($model, 'image')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*'],
                ]); ?>

                <div class="form-group">

                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

                    <?php ActiveForm::end(); ?>

                </div>

            </div>
        </div>
        <!--endFilmSection-->
        <!--CommentSection-->
        <div id="sectionComment" class="tab-pane fade">
            <div class="container-fluid">
                <h3>Comment</h3>
                <div class="comment-form">
                    <?php
                    $showComments = Comment::find()->where(['film_id' => $model->id])->all();
                    echo $this->render('_comment', [
                        'showComments' => $showComments,
                        'filmId' => $model->id,
                        'users' => $users,
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--endCommentSection-->
        <!--TestSection-->
        <div id="sectionTest" class="tab-pane fade">
            <h4>
                test
            </h4>
        </div>
        <!--endTestSection-->
    </div>
</div>
</div>
