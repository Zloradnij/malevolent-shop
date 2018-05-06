<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $products \app\modules\catalog\models\Product[] */

$this->title = Yii::t('shop', 'Shop');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-default-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?php
    foreach ($products as $product) {

        $productArray = $product->toArray();

        print '
        <div>' . $product->title . ' ' . $product->price . '</div>';
    } ?>

    <?php Pjax::end(); ?>
</div>
