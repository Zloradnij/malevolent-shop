<?php

namespace app\modules\catalog\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property int $sort
 * @property int $status
 * @property string $description
 */
class Catalog extends \yii\db\ActiveRecord
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
        return 'catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'status'], 'required'],
            [['sort', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['title', 'alias'], 'string', 'max' => 200],
            ['status', 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_DELETE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('shop', 'ID'),
            'title'       => Yii::t('shop', 'Title'),
            'alias'       => Yii::t('shop', 'Alias'),
            'sort'        => Yii::t('shop', 'Sort'),
            'status'      => Yii::t('shop', 'Status'),
            'description' => Yii::t('shop', 'Description'),

            'created_at'  => Yii::t('shop', 'Created At'),
            'updated_at'  => Yii::t('shop', 'Updated At'),
            'created_by'  => Yii::t('shop', 'Created By'),
            'updated_by'  => Yii::t('shop', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\query\CatalogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\CatalogQuery(get_called_class());
    }

    public function getCategory()
    {
        return $this->hasMany(Category::class, ['catalog_id' => 'id']);
    }
}
