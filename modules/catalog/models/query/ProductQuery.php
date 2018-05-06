<?php

namespace app\modules\catalog\models\query;

use app\modules\catalog\models\Product;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\Product]].
 *
 * @see \app\modules\catalog\models\Product
 */
class ProductQuery extends BaseCatalogQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => Product::STATUS_ACTIVE]);
    }

    /**
     * @param string $importPath
     *
     * @return $this
     */
    public function findByImportPath($importPath)
    {
        return $this->andWhere(['import_path' => (string)$importPath]);
    }

    /**
     * @param string $categoryID
     *
     * @return $this
     */
    public function findByCategory($categoryID)
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function withPrice()
    {
        return $this->andWhere(['>', 'price', 0]);
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function byID($id)
    {
        return $this->andWhere(['id' => (int)$id]);
    }
}
