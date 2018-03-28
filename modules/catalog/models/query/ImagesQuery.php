<?php

namespace app\modules\catalog\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\Images]].
 *
 * @see \app\modules\catalog\models\Images
 */
class ImagesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\Images[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\catalog\models\Images|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
