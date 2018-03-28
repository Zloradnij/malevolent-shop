<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\ProductVariant */

$this->title = Yii::t('shop', 'Create Product Variant');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Product Variants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-variant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
