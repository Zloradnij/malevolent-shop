<?php

namespace app\modules\catalog\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

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
        return 'product_variant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'status', 'product_id'], 'required'],
            [['sort', 'product_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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

            'created_at'        => Yii::t('shop', 'Created At'),
            'updated_at'        => Yii::t('shop', 'Updated At'),
            'created_by'        => Yii::t('shop', 'Created By'),
            'updated_by'        => Yii::t('shop', 'Updated By'),
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

    public function getOptions()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Images::class, ['entity_id' => 'id'])->andWhere(['entity' => 'ProductVariant']);
    }
}
