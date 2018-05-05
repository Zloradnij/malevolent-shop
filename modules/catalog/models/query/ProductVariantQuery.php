<?php

namespace app\modules\catalog\models\query;

use app\modules\catalog\models\ProductVariant;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\ProductVariant]].
 *
 * @see \app\modules\catalog\models\ProductVariant
 */
class ProductVariantQuery extends BaseCatalogQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => ProductVariant::STATUS_ACTIVE]);
    }

    /**
     * @param $productID
     *
     * @return $this
     */
    public function findByProduct($productID)
    {
        return $this->andWhere(['product_id' => $productID]);
    }
}
