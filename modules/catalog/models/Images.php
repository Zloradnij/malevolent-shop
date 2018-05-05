<?php

namespace app\modules\catalog\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

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
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entity_id', 'status'], 'required'],
            [['entity_id', 'sort', 'created_at', 'updated_at', 'created_by', 'updated_by', 'general', 'status'], 'integer'],
            [['description'], 'string'],
            [['entity'], 'string', 'max' => 50],
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

            'created_at'  => Yii::t('shop', 'Created At'),
            'updated_at'  => Yii::t('shop', 'Updated At'),
            'created_by'  => Yii::t('shop', 'Created By'),
            'updated_by'  => Yii::t('shop', 'Updated By'),
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
