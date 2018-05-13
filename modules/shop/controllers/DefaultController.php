<?php

namespace app\modules\shop\controllers;

use app\modules\catalog\models\Category;
use app\modules\catalog\models\Images;
use app\modules\catalog\models\Product;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `shop` module
 */
class DefaultController extends Controller
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
        ];
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        $products = Product::find()
            ->limit(4)
            ->active()
            ->withPrice()
            ->orderBy(new Expression('rand()'))
            ->all();

        return $this->render('index' . \Yii::$app->shop->getPayModel(), [
            'products'   => $products,
            'categories' => \Yii::$app->shop->getCategories(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function actionProduct($id)
    {
        $product = Product::find()
            ->byID((int)$id)
            ->active()
            ->one();

        return $this->render('product' . \Yii::$app->shop->getPayModel(), [
            'product'    => $product,
            'categories' => \Yii::$app->shop->getCategories(),
        ]);
    }

    /**
     * @param string $aliases
     *
     * @return string
     */
    public function actionCategory($aliases)
    {
        $aliases = trim($aliases, '/');
        $aliases = explode('/', $aliases);
        $level = count($aliases);
        $alias = end($aliases);
        array_pop($aliases);

        $category = Category::find()->getByLevel($level)->getByAlias($alias)->one();

        /** @var  $payClass */
        $payClass = \Yii::$app->shop->getPayClass();
        $products = $payClass::find()->active()->findByCategory($category->id)->all();

        $images = empty($products) ? [] : Images::find()
            ->indexBy('entity_id')
            ->active()
            ->findByEntity(\Yii::$app->shop->getPayEntity())
            ->findByEntityIDs(array_keys($products))
            ->all();

        $this->setBreadcrumbs($aliases);

        return $this->render('category' . \Yii::$app->shop->getPayModel(), [
            'breadcrumbs' => $aliases,
            'products'    => $products,
            'images'      => $images,
            'category'    => $category,
            'categories'  => \Yii::$app->shop->getCategories(),
        ]);
    }

    /**
     * @param array $aliases
     */
    protected function setBreadcrumbs($aliases)
    {
        $categoryItems = \Yii::$app->shop->getCategories();

        foreach ($aliases as $alias) {
            foreach ($categoryItems as $categoryItem) {
                if ($categoryItem['alias'] == $alias) {
                    $this->view->params['breadcrumbs'][] = [
                        'label' => $categoryItem['title'],
                        'url'   => $categoryItem['url'],
                    ];
                    $categoryItems = $categoryItem['items'];
                }
            }
        }
    }
}
