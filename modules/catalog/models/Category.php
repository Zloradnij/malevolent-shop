<?php

namespace app\modules\catalog\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $catalog_id
 * @property string $title
 * @property string $alias
 * @property string $relation_path
 * @property int $sort
 * @property int $status
 * @property int $parent_id
 * @property int $level
 * @property string $description_short
 * @property string $description
 *
 * @property \app\modules\catalog\models\Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DELETE = 0;

    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            TimestampBehavior::class,
        ];
    }

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
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'status'], 'required'],
            [['description_short', 'description'], 'string'],
            [['title', 'alias', 'relation_path'], 'string', 'max' => 250],
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
            'relation_path'     => Yii::t('shop', 'Relation Path'),
            'sort'              => Yii::t('shop', 'Sort'),
            'status'            => Yii::t('shop', 'Status'),
            'parent_id'         => Yii::t('shop', 'Parent ID'),
            'level'             => Yii::t('shop', 'Level'),
            'description_short' => Yii::t('shop', 'Description Short'),
            'description'       => Yii::t('shop', 'Description'),

            'created_at'        => Yii::t('shop', 'Created At'),
            'updated_at'        => Yii::t('shop', 'Updated At'),
            'created_by'        => Yii::t('shop', 'Created By'),
            'updated_by'        => Yii::t('shop', 'Updated By'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct2Category()
    {
        return $this->hasMany(Product2category::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'product_id'])
            ->via('product2Category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveProducts()
    {
        return $this
            ->hasMany(Product::class, ['id' => 'product_id'])
            ->where(['status' => Product::STATUS_ACTIVE])
            ->via('product2Category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }
}
