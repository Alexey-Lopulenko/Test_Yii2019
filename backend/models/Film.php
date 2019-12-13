<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
            'description' => 'Description',
            'image' => 'Image',
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


    public function getSmallImage()
    {
//        $dir = str_replace('admin','',Url::home(true).'upload/images/film');
        return '/test/backend/web/upload/images/film/prefix' . $this->logo_img;
    }

}
