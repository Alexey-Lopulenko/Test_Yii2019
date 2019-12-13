<?php

namespace backend\controllers;


require '/var/www/html/test/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Yii;
use app\models\Film;
use app\models\Order;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FilmController implements the CRUD actions for Film model.
 */
class FilmController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update', 'delete', 'create', 'import', 'delete-img', 'glide', 'export', 'get-excel'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * @return array
     */
    public function actions()
    {
        return [
            'glide' => 'trntv\glide\actions\GlideAction'
        ];
    }


    public function actionDeleteImg($img)
    {

        $film = Film::find()->where(['logo_img' => $img])->one();
        $film->logo_img = null;
        if (unlink(Yii::getAlias('@images') . '/' . $img)) {
            if ($film->save()) {
                return $this->redirect(['index']);
            }
        }
    }

    /**
     * @return \yii\console\Response|\yii\web\Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionGetExcel()
    {
        //        $film = Film::find()->asArray()->all();
        $film2 = Film::find()->all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Film title doc');
        $sheet->getColumnDimension('A')->setWidth(2);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(27);

        $sheet->getStyle('1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('128, 0, 0');

        $arrayData = [
            ['id', 'title', 'description',],
        ];
        foreach ($film2 as $item) {
            array_push($arrayData, [$item->id, $item->title, $item->description]);
        }


        $sheet->fromArray(
            $arrayData,
            NULL,
            'A1'
        );

//            header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
//            header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
//            header ( "Cache-Control: no-cache, must-revalidate");
//            header ( "Pragma: no-cache" );
//            header ( "Content-type: application/vnd.ms-excel" );
//            header ( "Content-Disposition: attachment; filename=matrix.xls" );

        $writer = new Xlsx($spreadsheet);
        $writer->save('uploads/files/film data.xlsx');


        return \Yii::$app->response->sendFile('uploads/files/film data.xlsx');
    }

    /**
     * Lists all Film models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Film::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Film model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Film model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Film();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->image = UploadedFile::getInstance($model, 'image');


            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Film model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $film_id = Film::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'film_id' => $film_id,
        ]);
    }

    /**
     * Deletes an existing Film model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $img = Film::find()->where(['id' => $id])->asArray()->all();
        unlink(Yii::getAlias('@images') . '/' . $img[0]['logo_img']);//delete file (logo)

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Film model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Film the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Film::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     */
    public function actionUpload()
    {
        $model = new Film();
        $this->enableCsrfValidation = false;

        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->upload()) {
                // file is uploaded successfully
                return 'file is uploaded successfully';
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionImport()
    {
        $inputFile = 'uploads/files/film_file.xlsx';

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);
        } catch (Exception $e) {
            die('Error');
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            $film = new Film();
            $film_id = $rowData[0][0];
            $film->title = $rowData[0][1];
            $film->description = $rowData[0][2];
            $film->save();

            print_r($film->getErrors());
        }
        die('okay');
    }
}
