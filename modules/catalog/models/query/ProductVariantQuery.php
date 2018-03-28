<?php

namespace app\modules\catalog\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\ProductVariant]].
 *
 * @see \app\modules\catalog\models\ProductVariant
 */
class ProductVariantQuery extends BaseCatalogQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\ProductVariant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\ProductVariant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
