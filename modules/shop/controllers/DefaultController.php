<?php

namespace app\modules\shop\controllers;

use app\modules\catalog\models\CatalogSettings;
use app\modules\catalog\models\Product;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `shop` module
 */
class DefaultController extends Controller
{
    protected $payType;
    protected $payModel;

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
                        'allow' => TRUE,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        $this->payType = CatalogSettings::find()
            ->active()
            ->andWhere(['alias' => 'saleVariants'])
            ->select(['value'])
            ->column();

        $this->payModel = empty($this->payType) ? 'Product' : 'Variant';

        parent::init();
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $products = Product::find()
            ->limit(6)
            ->active()
            ->withPrice()
            ->orderBy(new Expression('rand()'))
            ->all();

        return $this->render('index' . $this->payModel, [
            'products' => $products,
        ]);
    }

    public function actionProducts($id)
    {
        $product = Product::find()
            ->byID((int)$id)
            ->active()
            ->one();

        return $this->render('product' . $this->payModel, [
            'product' => $product,
        ]);
    }
}