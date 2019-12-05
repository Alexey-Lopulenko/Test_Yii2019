<?php

namespace backend\controllers;

use Yii;
use app\models\Ticket;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
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
                        'actions' => ['update', 'delete', 'create'],
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
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Ticket::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
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
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ticket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionRole()
    {

        /**
         * создание ролей
         */
        /*        $admin = Yii::$app->authManager->createRole('admin');
                $admin->description = 'Полубог(имеет власть над простыми смертными, но уязвим перед "разработчиками")';
                Yii::$app->authManager->add($admin);

                $content = Yii::$app->authManager->createRole('content');
                $content->description = 'Летописец';
                Yii::$app->authManager->add($content);

                $user = Yii::$app->authManager->createRole('user');
                $user->description = 'Простой смертный';
                Yii::$app->authManager->add($user);

                $ban = Yii::$app->authManager->createRole('banned');
                $ban->description = 'Узник Азкабана (за грехи лютые)';
                Yii::$app->authManager->add($ban);*/

        /**
         * создание прав для ролей
         */
        /* $permit = Yii::$app->authManager->createPermission('canAdmin');
         $permit->description = 'Право на вход в админку';
         Yii::$app->authManager->add($permit);*/
        /**
         * Наследования ролей и прав
         */
        /*$role_a = Yii::$app->authManager->getRole('admin');
        $role_c = Yii::$app->authManager->getRole('content');
        $permit = Yii::$app->authManager->getPermission('canAdmin');
        Yii::$app->authManager->addChild($role_a, $permit);
        Yii::$app->authManager->addChild($role_c, $permit);*/

        /**
         * Привязка ролей к пользователю
         */
        /* $userRole = Yii::$app->authManager->getRole('admin');
         Yii::$app->authManager->assign($userRole, Yii::$app->user->getId()); Yii::$app->user->getId()-id нужного пользователя*/

        return 1234567890;
    }
}
