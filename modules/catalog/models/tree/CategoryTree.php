<?php

namespace app\modules\catalog\models\tree;

use app\modules\catalog\models\Category;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 */
class CategoryTree
{
    public static $tree = [];

    /**
     * @return array
     */
    public function getTree()
    {
        if (empty(static::$tree)) {
            static::$tree = $this->createTree();
        }

        return static::$tree;
    }

    public function createTree()
    {
        $categories = Category::find()->active()->asMenu()->asArray()->all();

        foreach ($categories as $i => $category) {
            $path = \Yii::$app->params['shopRootPath'] . $this->getUrl($category, $categories);

            $category['url'] = Url::toRoute($path);
            $category['items'] = $this->getChildren($category, $categories);
            $category['label'] = $category['title'];

            $categories[$i] = $category;
        }

        return $this->getFirstLevel($categories);
    }

    public function getFirstLevel($categories)
    {
        $firstLevel = [];

        foreach ($categories as $category) {
            if ($category['level'] == 1) {
                $firstLevel[] = $category;
            }
        }

        return $firstLevel;
    }

    public function getUrl($element, $categories)
    {
        $parents = $this->getParentCategories($element, $categories);
        $parents[] = $element;

        $url = implode('/', array_column($parents, 'alias'));

        return $url;
    }

    public function getParentCategories($element, $categories)
    {
        $parents = [];
        $level = $element['level'];
        $parentID = $element['parent_id'];

        while ($level > 1) {
            $parents[$level] = $categories[$parentID];
            $parentID = $categories[$parentID]['parent_id'];

            $level--;
        }

        sort($parents);

        return $parents;
    }

    /**
     * @param array $element
     * @param array $categories
     *
     * @return array
     */
    public function getChildren($element, &$categories)
    {
        $children = [];

        foreach ($categories as $i => $category) {
            if ($category['parent_id'] == $element['id']) {
                $children[] = $category;
            }
        }

        return $children;
    }
}
