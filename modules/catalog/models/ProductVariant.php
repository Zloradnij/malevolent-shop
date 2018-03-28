<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "product_variant".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property int $sort
 * @property int $status
 * @property int $product_id
 * @property double $price
 * @property string $description_short
 * @property string $description
 */
class ProductVariant extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DELETE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_variant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'status', 'product_id'], 'required'],
            [['sort', 'product_id', 'status'], 'integer'],
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
            'title'             => Yii::t('shop', 'Title'),
            'alias'             => Yii::t('shop', 'Alias'),
            'sort'              => Yii::t('shop', 'Sort'),
            'status'            => Yii::t('shop', 'Status'),
            'product_id'        => Yii::t('shop', 'Product ID'),
            'price'             => Yii::t('shop', 'Price'),
            'description_short' => Yii::t('shop', 'Description Short'),
            'description'       => Yii::t('shop', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\query\ProductVariantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\ProductVariantQuery(get_called_class());
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
