<?php

namespace app\modules\catalog\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\Product2category]].
 *
 * @see \app\modules\catalog\models\Product2category
 */
class Product2categoryQuery extends \yii\db\ActiveQuery
{
    /**
     * @param int $categoryID
     * @param int $productID
     *
     * @return $this
     */
    public function findUnique($categoryID, $productID)
    {
        return $this->andWhere(['category_id' => $categoryID, 'product_id' => $productID]);
    }
}
