<?php

namespace app\modules\catalog\models;

use Yii;

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
