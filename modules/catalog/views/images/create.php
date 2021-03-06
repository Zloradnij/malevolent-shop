<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalog\models\Images */

$this->title = Yii::t('shop', 'Create Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop', 'Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
