<?php


namespace backend\controllers;


use yii\web\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }
}