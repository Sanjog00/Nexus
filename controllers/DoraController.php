<?php

namespace app\controllers;


use yii\web\Controller;
use Yii;


class DoraController extends Controller
{

    public $layout = 'dora';

    public function actionDora()
    {

        return $this->render('dora');
    }
}
