<?php

namespace app\modules\catalog\models;

use Yii;

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
            [['sort', 'status'], 'integer'],
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
