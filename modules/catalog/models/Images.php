<?php

namespace app\modules\catalog\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $entity
 * @property int $entity_id
 * @property int $general
 * @property int $sort
 * @property int $status
 * @property string $path
 * @property string $title
 * @property string $description
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entity_id', 'status'], 'required'],
            [['entity_id', 'sort'], 'integer'],
            [['description'], 'string'],
            [['entity'], 'string', 'max' => 50],
            [['general'], 'string', 'max' => 1],
            [['status'], 'string', 'max' => 2],
            [['path', 'title'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('shop', 'ID'),
            'entity'      => Yii::t('shop', 'Entity'),
            'entity_id'   => Yii::t('shop', 'Entity ID'),
            'general'     => Yii::t('shop', 'General'),
            'sort'        => Yii::t('shop', 'Sort'),
            'status'      => Yii::t('shop', 'Status'),
            'path'        => Yii::t('shop', 'Path'),
            'title'       => Yii::t('shop', 'Title'),
            'description' => Yii::t('shop', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\query\ImagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\catalog\models\query\ImagesQuery(get_called_class());
    }
}
