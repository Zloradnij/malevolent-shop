<?php

namespace app\modules\control\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `control` module
 */
class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
//                        'actions' => ['adminka'],
                        'allow' => TRUE,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
