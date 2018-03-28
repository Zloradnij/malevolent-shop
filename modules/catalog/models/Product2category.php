<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "product2category".
 *
 * @property int $id
 * @property int $category_id
 * @property int $product_id
 * @property int $sort
 */
class Product2category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product2category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'product_id'], 'required'],
            [['category_id', 'product_id', 'sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('shop', 'ID'),
            'category_id' => Yii::t('shop', 'Category ID'),
            'product_id'  => Yii::t('shop', 'Product ID'),
            'sort'        => Yii::t('shop', 'Sort'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\query\Product2categoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\Product2categoryQuery(get_called_class());
    }
}
