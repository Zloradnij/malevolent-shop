<?php

namespace app\modules\catalog\models\query;


abstract class BaseCatalogQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => 10]);
    }
}
