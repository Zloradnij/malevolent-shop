<?php

namespace app\modules\catalog\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_options".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property int $sort
 * @property int $status
 * @property int $variant_id
 * @property string $value
 * @property string $description_short
 * @property string $description
 */
class ProductOptions extends \yii\db\ActiveRecord
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
        return 'product_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'status', 'variant_id'], 'required'],
            [['sort', 'variant_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description_short', 'description'], 'string'],
            [['title', 'alias', 'value'], 'string', 'max' => 250],
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
            'variant_id'        => Yii::t('shop', 'Variant ID'),
            'value'             => Yii::t('shop', 'Value'),
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
     * @return \app\modules\catalog\models\query\ProductOptionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\ProductOptionsQuery(get_called_class());
    }

    public function getVariant()
    {
        return $this->hasOne(ProductVariant::class, ['id' => 'variant_id']);
    }
}
