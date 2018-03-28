<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $catalog_id
 * @property string $title
 * @property string $alias
 * @property int $sort
 * @property int $status
 * @property double $price
 * @property string $description_short
 * @property string $description
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DELETE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'sort', 'status'], 'integer'],
            [['title', 'alias', 'status'], 'required'],
            [['price'], 'number'],
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
            'price'             => Yii::t('shop', 'Price'),
            'description_short' => Yii::t('shop', 'Description Short'),
            'description'       => Yii::t('shop', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\ProductQuery(get_called_class());
    }

    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }

    public function getProduct2Category()
    {
        return $this->hasMany(Product2category::class, ['product_id' => 'id']);
    }

    public function getCategories()
    {
        return $this
            ->hasMany(Category::class, ['id' => 'category_id'])
            ->via('product2Category');
    }

    public function getVariants()
    {
        return $this->hasMany(ProductVariant::class, ['product_id' => 'id']);
    }
}
