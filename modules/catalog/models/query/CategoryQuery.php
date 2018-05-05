<?php

namespace app\modules\catalog\models\query;

use app\modules\catalog\models\Category;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\Category]].
 *
 * @see \app\modules\catalog\models\Category
 */
class CategoryQuery extends BaseCatalogQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => Category::STATUS_ACTIVE]);
    }

    /**
     * @param int $level
     *
     * @return $this
     */
    public function getByLevel($level)
    {
        return $this->andWhere(['level' => (int)$level]);
    }

    /**
     * @param int $parentID
     *
     * @return $this
     */
    public function getByParent($parentID)
    {
        return $this->andWhere(['parent_id' => (int)$parentID]);
    }
}
