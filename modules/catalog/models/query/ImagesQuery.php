<?php

namespace app\modules\catalog\models\query;

use app\modules\catalog\models\Images;

/**
 * This is the ActiveQuery class for [[\app\modules\catalog\models\Images]].
 *
 * @see \app\modules\catalog\models\Images
 */
class ImagesQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => Images::STATUS_ACTIVE]);
    }

    /**
     * @return $this
     */
    public function findByGeneral()
    {
        return $this->andWhere(['general' => 1]);
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function findByPath($path)
    {
        return $this->andWhere(['path' => $path]);
    }

    /**
     * @param int $variantID
     *
     * @return $this
     */
    public function findByVariant($variantID)
    {
        return $this->andWhere(['entity_id' => $variantID])->andWhere(['entity' => 'ProductVariant']);
    }
}
