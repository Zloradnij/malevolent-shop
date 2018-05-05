<?php

namespace app\modules\catalog\models\query;

use app\modules\catalog\models\ProductVariant;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\ProductOptions]].
 *
 * @see \app\modules\catalog\models\ProductOptions
 */
class ProductOptionsQuery extends BaseCatalogQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => ProductVariant::STATUS_ACTIVE]);
    }

    /**
     * @param int $variantID
     *
     * @return $this
     */
    public function findByVariant($variantID)
    {
        return $this->andWhere(['variant_id' => $variantID]);
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function findByAlias($alias)
    {
        return $this->andWhere(['alias' => $alias]);
    }
}
