<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $catalog_id
 * @property string $title
 * @property string $alias
 * @property int $sort
 * @property int $status
 * @property int $parent_id
 * @property int $level
 * @property string $description_short
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DELETE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'sort', 'status', 'parent_id', 'level'], 'integer'],
            [['title', 'alias', 'status'], 'required'],
            [['description_short', 'description'], 'string'],
            [['title', 'alias'], 'string', 'max' => 250],
            ['status', 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_DELETE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('shop', 'ID'),
            'catalog_id'        => Yii::t('shop', 'Catalog ID'),
            'title'             => Yii::t('shop', 'Title'),
            'alias'             => Yii::t('shop', 'Alias'),
            'sort'              => Yii::t('shop', 'Sort'),
            'status'            => Yii::t('shop', 'Status'),
            'parent_id'         => Yii::t('shop', 'Parent ID'),
            'level'             => Yii::t('shop', 'Level'),
            'description_short' => Yii::t('shop', 'Description Short'),
            'description'       => Yii::t('shop', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\CategoryQuery(get_called_class());
    }

    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }

    public function getProduct2Category()
    {
        return $this->hasMany(Product2category::class, ['category_id' => 'id']);
    }

    public function getProducts()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'product_id'])
            ->via('product2Category');
    }

    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }
}
