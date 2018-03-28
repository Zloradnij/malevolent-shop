<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\CatalogSettings */

$this->title = Yii::t('shop', 'Create Catalog Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Catalog Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
