<?php

namespace app\controllers;

use app\models\Foodcourt;
use app\models\News;
use app\models\ProgramItem;
use app\models\Zone;
use app\modules\admin\forms\DocForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yiidreamteam\upload\ImageUploadBehavior;

class IndexController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
            return $this->redirect('admin');
    }

    public function actionLogin()
    {
        return $this->render('login');
    }
}