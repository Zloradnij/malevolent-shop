<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('shop', 'Control Module');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="control-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h3><?= Yii::t('shop', 'User Control') ?></h3><?php

            echo \yii\bootstrap\Nav::widget([
                'items' => [
                    ['label' => Yii::t('shop', 'Index'), 'url' => ['/user/admin/index']],
                    ['label' => Yii::t('shop', 'Profile'), 'url' => ['/user/settings/profile']],
                    ['label' => Yii::t('shop', 'Account'), 'url' => ['/user/settings/account']],
                    ['label' => Yii::t('shop', 'Networks'), 'url' => ['/user/settings/networks']],
                    ['label' => Yii::t('shop', 'Show'), 'url' => ['/user/profile/show']],
                ],
            ]); ?>
        </div>
        <div class="col-xs-12 col-md-6">

        </div>
    </div>


</div>
