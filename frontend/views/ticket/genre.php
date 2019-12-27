<?php

use yii\helpers\Html;

?>
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
<?php if ($filmGenre): ?>
<div class="col-md-10">
    <?php foreach ($filmGenre as $item): ?>
        <div class="col-md-4" data-toggle="modal" data-target="#<?= $item->film->id ?>"
             data-genre="<?php foreach ($item->film->genres as $one) {
                 echo $one->title . ' ';
             } ?>">
            <div class="product-item">
                <img style="width: 210px; height: 200px"
                     src="<?php //Yii::$app->glide->outputImage('images/film/'. $film->logo_img, ['w' => 188, 'fit' => 'fill']);
                     echo $item->film->logo_img ? '/test/backend/web/uploads/images/film/' . $item->film->logo_img : "https://i.ytimg.com/vi/Dm9Ekro7ubo/hqdefault.jpg";
                     ?>" alt="<?= $item->film->title ?>">
                <div class="product-list d-inline">
                    <h4><?= $item->film->title ?></h4>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <h4>фильмов с данным жанром нет</h4>
    <?php endif; ?>
</div>
