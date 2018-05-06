<?php

namespace app\modules\catalog\models\query;

use app\modules\catalog\models\CatalogSettings;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\CatalogSettings]].
 *
 * @see \app\modules\catalog\models\CatalogSettings
 */
class CatalogSettingsQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => CatalogSettings::STATUS_ACTIVE]);
    }

//    /**
//     * @inheritdoc
//     * @return \app\modules\catalog\models\CatalogSettings[]|array
//     */
//    public function all($db = null)
//    {
//        return parent::all($db);
//    }
//
//    /**
//     * @inheritdoc
//     * @return \app\modules\catalog\models\CatalogSettings|array|null
//     */
//    public function one($db = null)
//    {
//        return parent::one($db);
//    }
}
