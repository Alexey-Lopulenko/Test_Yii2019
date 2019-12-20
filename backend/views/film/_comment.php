<div class="content" id="content">
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
    <div id="commentContent">
        <?php

        foreach ($showComments as $comment):?>
            <?php $statusComment = $comment->status == 1 ? '#c5ced4' : '#585858' ?>
            <div style="min-height: 100px; width: 900px; margin-top: 10px;    display: flex;" id="<?= $comment->id ?>">
                <div class="col-md-2" style="min-height: 100px;background-color: #72787b;">
                    <span>userId: </span>
                    <h3><?= $comment->user_id . '<br>'; ?></h3>
                </div>
                <div class="col-md-6 text-left"
                     style="min-height: 100px;background-color:  <?= $statusComment ?>;min-width: 900px">
                    <?= '<br>' . $comment->comment . '<br><br><br>' . date('Y-m-d H:i:s', $comment->created_at) . '<br>'; ?>

                    <?= Html::button('<i class="glyphicon glyphicon-remove-circle"></i>', [
                        'class' => 'btn btn-danger',
                        'style' => '    position: absolute;top: 7px; left: 850px;',
                        'commentId' => $comment->id,
                        'filmId' => $filmId,
                        'id' => 'js-delete-comment',
                    ]) ?>
                    <?php
                    if (!$comment->status == 1) {
                        echo Html::button('<i class="glyphicon glyphicon-ok-circle"></i>', [
                            'class' => 'btn btn-success',
                            'id' => 'js-update-comment',
                            'commentId' => $comment->id,
                            'filmId' => $filmId,
                            'style' => 'position: absolute;top: 7px; left: 800px;',
                        ]);
                    } else {
                        echo Html::button('<i class="glyphicon glyphicon-ban-circle"></i>', [
                            'class' => 'btn btn-warning',
                            'style' => 'position: absolute;top: 7px; left: 800px;',
                            'id' => 'js-update-comment',
                            'commentId' => $comment->id,
                            'filmId' => $filmId,
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
    </div>

    <!--modal start-->
    <div class="modal modal-info" id="refactor-comment" style="display: none; padding-right: 15px;">
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
    <!--modal end-->

    <?php
    $urlCommentUpdate = Yii::$app->urlManager->createUrl(['comment/update', 'id' => '']);
    $urlUpdateStatus = Yii::$app->urlManager->createUrl(['film/update-status', 'commentId' => '', 'filmId' => '']);
    $urlDeleteComment = Yii::$app->urlManager->createUrl(['film/delete-comment', 'commentId' => '']);

    $jsRefactorComment = <<<JS
$('body').on('click', '.js-comment-btn', function(){
    var  data  = $(this).attr('id');
    
    $('#refactor-comment').modal('show');
    $('#refactor-comment').find('.modal-title').text(data);
    $('#refactor-comment').find('.modal-body').load('$urlCommentUpdate' +data);
      
      console.log(data);
});

$('body').on('click','#js-update-comment', function() {
 var commentId = $(this).attr('commentId');
 var filmId = $(this).attr('filmId');

 
  if($(this).hasClass('btn-success')){
        $(this).html('<i class="glyphicon glyphicon-ban-circle"></i>');
        $(this).toggleClass('btn-warning').removeClass('btn-success');
        // console.log('btn-success');
    }else{
      
        $(this).html('<i class="glyphicon glyphicon-ok-circle"></i>');
        $(this).toggleClass('btn-success').removeClass('btn-warning');
       
        // console.log('btn-warning');
  }
 
   $.ajax({
    url:'$urlUpdateStatus',
    data : {
        commentId: commentId,
        filmId: filmId
    },
    type : "GET",

     success: function(res) {
        console.log('success');
         },
     error: function() { alert('Error!'); }
   });
});

$('body').on('click','#js-delete-comment', function() {
 var commentId = $(this).attr('commentId');
 
 
    var answer = confirm("Are you sure you want to delete this item?"); 
     if (answer){ 
        $("div#"+commentId).remove();
           $.ajax({
            url:'$urlDeleteComment',
            data : {
            commentId: commentId,
            },
            type : "GET",

            success: function(res) {
            console.log('success');
                },
             error: function() { console.log('Error Ajax not send!') }
   });
     } 
     else 
     { 
        console.log('Delete failed'); 
     } 
     
});
JS;
    $this->registerJs($jsRefactorComment);
    ?>
</div>