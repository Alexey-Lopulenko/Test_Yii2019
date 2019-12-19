<div class="content">
    <?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;
    use unclead\multipleinput\MultipleInput;
    use yii\helpers\ArrayHelper;

    /** @var \app\models\Comment $showComments */
    /* @var $filmId app\models\Film */
    /** @var \app\models\User $users */


    $user_id = ArrayHelper::map($users, 'id', 'username');
    ?>




    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <h3>Add comment</h3>
    <div style="width: 700px;">
        <?php
        echo $form->field($model, 'schedule')->widget(MultipleInput::className(), [
            'max' => 10,
            'columns' => [
                [
                    'name' => 'user_id',
                    'type' => 'dropDownList',
                    'title' => 'User',
                    'defaultValue' => 'User',
                    'items' => $user_id
                ],
                [
                    'name' => 'comment',
                    'title' => 'Comment',
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
    <?php ActiveForm::end(); ?>
    <?php
    Pjax::begin();
    foreach ($showComments as $comment):?>
        <?php $statusComment = $comment->status == 1 ? '#c5ced4' : '#585858' ?>
        <div style="min-height: 100px; width: 900px; margin-top: 10px;    display: flex;">
            <div class="col-md-2" style="min-height: 100px;background-color: #72787b;">
                <span>userId: </span>
                <h3><?= $comment->user_id . '<br>'; ?></h3>
            </div>
            <div class="col-md-6 text-left"
                 style="min-height: 100px;background-color:  <?= $statusComment ?>;min-width: 900px">
                <?= '<br>' . $comment->comment . '<br><br><br>' . date('Y-m-d H:i:s', $comment->created_at) . '<br>'; ?>

                <?= Html::a('Delete <i class="glyphicon glyphicon-remove-circle"></i>', ['film/delete-comment', 'commentId' => $comment->id, 'filmId' => $filmId,], [
                    'class' => 'btn btn-danger',
                    'style' => '    position: absolute;top: 7px; left: 800px;',
                ]) ?>
                <?php
                if (!$comment->status == 1) {
                    echo Html::a('Enable <i class="glyphicon glyphicon-ok-circle"></i>', ['film/update-status', 'commentId' => $comment->id, 'filmId' => $filmId,], [
                        'class' => 'btn btn-success',
                        'style' => 'position: absolute;top: 47px; left: 800px;',
                    ]);
                } else {
                    echo Html::a('Disable <i class="glyphicon glyphicon-ban-circle"></i>', ['film/update-status', 'commentId' => $comment->id, 'filmId' => $filmId], [
                        'class' => 'btn btn-warning',
                        'style' => '    position: absolute;top: 47px; left: 800px;',
                    ]);
                }
                ?>
                <?= Html::button('<i class="glyphicon glyphicon-pencil"></i>', [
                    'class' => 'btn btn-primary js-comment-btn',
                    'id' => $comment->id,
                    'style' => 'position: absolute;top: 7px; left: 750px;',
                ]) ?>

            </div>
        </div>
    <?php endforeach; ?>

    <?php Pjax::end(); ?>


    <div class="modal modal-info" id="refactor-comment" style="display: none; padding-right: 15px;color:black">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Info Modal</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body…</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <?php
    $url = Yii::$app->urlManager->createUrl(['comment/update', 'id' => '']);

    $jsRefactorComment = <<<JS


$('body').on('click', '.js-comment-btn', function(){
    var  data  = $(this).attr('id');
    
    $('#refactor-comment').modal('show');
    $('#refactor-comment').find('.modal-title').text(data);
    $('#refactor-comment').find('.modal-body').load('$url' +data);
      // alert('click '+dataDelete);
      console.log(data);
    

});
JS;
    $this->registerJs($jsRefactorComment);
    ?>
</div>