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
     * @param string $alias
     *
     * @return $this
     */
    public function getByAlias($alias)
    {
        return $this->andWhere(['alias' => (string)$alias]);
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

    public function asMenu()
    {
        return $this
            ->orderBy(['level' => SORT_DESC])
            ->indexBy('id')
            ->select([
                'id',
                'title',
                'alias',
                'parent_id',
                'level',
            ]);
    }
}
