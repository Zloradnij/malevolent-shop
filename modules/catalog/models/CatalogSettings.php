<?php

namespace app\modules\catalog\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "catalog_settings".
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property string $value
 * @property string $description
 * @property int $status
 */
class CatalogSettings extends \yii\db\ActiveRecord
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
        return 'catalog_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'value', 'status'], 'required'],
            [['description'], 'string'],
            [['title', 'value'], 'string', 'max' => 250],
            [['alias'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 2],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
            'value'       => Yii::t('shop', 'Value'),
            'description' => Yii::t('shop', 'Description'),
            'status'      => Yii::t('shop', 'Status'),

            'created_at'  => Yii::t('shop', 'Created At'),
            'updated_at'  => Yii::t('shop', 'Updated At'),
            'created_by'  => Yii::t('shop', 'Created By'),
            'updated_by'  => Yii::t('shop', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\query\CatalogSettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\CatalogSettingsQuery(get_called_class());
    }
}
