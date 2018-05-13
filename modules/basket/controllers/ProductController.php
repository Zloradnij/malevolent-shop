<?php

namespace app\modules\basket\controllers;

use app\modules\catalog\models\Category;
use app\modules\catalog\models\Images;
use app\modules\catalog\models\Product;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `shop` module
 */
class ProductController extends Controller
{
    public $layout = '@app/views/layouts/shopLayout';

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
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'pay'      => ['post'],
                    'exclude-pay' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionPay()
    {
        $post = \Yii::$app->request->post();

        print '<pre>';
        print_r($post);
        print '</pre>';

        return 'actionPay1';
    }

    /**
     * @return string
     */
    public function actionExcludePay()
    {
        $post = \Yii::$app->request->post();

        print '<pre>';
        print_r($post);
        print '</pre>';

        return 'actionDontPay1';
    }
}
