<?php

namespace app\components;

use app\modules\catalog\models\CatalogSettings;
use app\modules\catalog\models\Product;
use app\modules\catalog\models\ProductVariant;
use app\modules\catalog\models\tree\CategoryTree;
use yii\base\BaseObject;

class Shop extends BaseObject
{
    protected $payType;
    protected $payModel;
    protected $categories = [];
    protected $payClass = '';
    protected $payEntity = '';

    public function init()
    {
        parent::init();

        $this->payType = CatalogSettings::find()
            ->active()
            ->andWhere(['alias' => 'saleVariants'])
            ->select(['value'])
            ->column();

        $this->payModel = empty($this->payType) ? 'Product' : 'Variant';
        $this->payClass = empty($this->payType) ? new Product() : new ProductVariant();
        $this->payEntity = empty($this->payType) ? 'Product' : 'ProductVariant';

        $this->categories = (new CategoryTree())->getTree();
    }

    public function getPayModel()
    {
        return $this->payModel;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getPayClass()
    {
        return $this->payClass;
    }

    public function getPayEntity()
    {
        return $this->payEntity;
    }
}
