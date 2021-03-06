<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "film".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $logo_img
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Date[] $dates
 */
class Film extends \yii\db\ActiveRecord
{

    public $image;
    public $genre;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
            TimestampBehavior::className(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'film';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'logo_img'], 'string', 'max' => 250],
            [['title'], 'required'],
            [['description'], 'string', 'max' => 1000],
            [['image'], 'file'],//'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'
            [['genre'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description ))',
            'image' => 'Image',
            'genre' => 'Genre',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDates()
    {
        return $this->hasMany(Date::className(), ['film_id' => 'id']);
    }


    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('uploads/store' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if ($image = UploadedFile::getInstance($this, 'image')) {//проверка существует ли файл
            $dir = Yii::getAlias('@images') . '/';
            if (is_file($dir . $this->logo_img)) {//проверка существует ли файл с таким же именем
                unlink($dir . $this->logo_img);//удаление старого файла
            }
//            if (is_file($dir . '50x50/' . $this->logo_img)) {
//                unlink($dir . '50x50/' . $this->logo_img);
//            }
//            if (is_file($dir . '800x/' . $this->logo_img)) {
//                unlink($dir . '800x/' . $this->logo_img);
//            }

            $this->logo_img = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(6) . '.' . $image->extension;//уникальное название файла
            $image->saveAs($dir . $this->logo_img);//сохранение файла


//            $imag = Yii::$app->image->load($dir . $this->logo_img);
//            $imag->background('#fff', 0);
//            $imag->resize('50', '50', Yii\image\drivers\Image::INVERSE);
//            $imag->crop('50', '50');
//            $imag->save($dir . '50x50/' . $this->logo_img, 90);
//            $imag = Yii::$app->image->load($dir . $this->logo_img);
//            $imag->background('#fff', 0);
//            $imag->resize('800', null, Yii\image\drivers\Image::INVERSE);
//            $imag->save($dir . '800x/' . $this->logo_img, 90);
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::className(), ['id' => 'genre_id'])
            ->viaTable('film_and_genre', ['film_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            FilmAndGenre::deleteAll(['film_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }


    public function afterFind()
    {
        $this->genre = $this->genres;
//        $this->genre = ArrayHelper::map($this->genres, 'title', 'title');//вывод в виде заполненых жанров
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        $arr = ArrayHelper::map($this->genres, 'id', 'id');
        if ($this->genre) {
            foreach ($this->genre as $one) {
                if (!in_array($one, $arr)) {
                    $model = new FilmAndGenre();
                    $model->film_id = $this->id;
                    $model->genre_id = $one;
                    $model->save();
                }
                if (isset($arr[$one])) {
                    unset($arr[$one]);
                } else {
                    if (!is_numeric($one)) {
                        if ($create = $this->createNewGenre($one)) {//если создан новый жанр
                            Yii::$app->session->setFlash('success', 'Добавлен новый жанр: ' . $one);
                        } else {
                            Yii::$app->session->setFlash('error', 'Error! Новый жанр:' . $one . ' не добавлен.');
                        }
                    }
                }
            }
        }
        FilmAndGenre::deleteAll(['genre_id' => $arr]);

//
//        if (is_array($this->genre)) {
//            $old_genre = ArrayHelper::map($this->genres, 'title', 'id');//набор данных до сохранения
//            foreach ($this->genre as $one_new_genre) {
//                if (isset($old_genre[$one_new_genre])) {//проверка существуют ли уже выбранные теги в нашем списке(поле)
//                    unset($old_genre[$one_new_genre]);//удаление совпавших значений
//                } else {
//                    if ($create = $this->createNewGenre($one_new_genre)) {//если создан новый жанр
//                        Yii::$app->session->setFlash('success', 'Добавлен новый жанр: ' . $one_new_genre);
//                    } else {
//                        Yii::$app->session->setFlash('error', 'Error! Новый жанр:' . $one_new_genre . ' не добавлен.');
//                    }
//                }
//            }
//            FilmAndGenre::deleteAll(['and', ['film_id' => $this->id], ['genre_id' => $old_genre]]);//удаление старых (не нужных жанров)
//        } else {
//            FilmAndGenre::deleteAll(['film_id' => $this->id]);//удаление записей со связуемой модели
//        }
    }

    /**
     * @param $new_genre
     * @return bool|int
     */
    private function createNewGenre($new_genre)
    {
        if (!$title = Genre::find()->andWhere(['title' => $new_genre])->one()) {
            $title = new Genre();
            $title->title = $new_genre;
            if ($title->save()) {
                $film_genre = new FilmAndGenre();
                $film_genre->film_id = $this->id;
                $film_genre->genre_id = $title->id;
                if ($film_genre->save()) {
                    return true;
                }
            } else {
                $title = null;
            }
        }
        if ($title instanceof Film) {
            $film_genre = new FilmAndGenre();
            $film_genre->film_id = $this->id;
            $film_genre->genre_id = $title->id;
            if ($film_genre->save()) {
                return $film_genre->id;
            }
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasMany(Comment::className(), ['id' => 'film_id']);
    }

    /**
     * @return string
     */
    public function getSmallImage()
    {
        return '/test/backend/web/upload/images/film/prefix' . $this->logo_img;
    }

    public function getGenresAsString()
    {
        $arr = ArrayHelper::map($this->genres, 'id', 'title');
        return implode(', ', $arr);
    }


}
