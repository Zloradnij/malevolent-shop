<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],

            Yii::$app->user->isGuest ?
                ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                ['label'       => 'Sign out (' . Yii::$app->user->identity->username . ')',
                 'url'         => ['/user/security/logout'],
                 'linkOptions' => ['data-method' => 'post']],
            ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="shop-default-index">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="col-xs-12 col-sm-4 col-md-3 padding-15-0">
                <?php
                NavBar::begin([
                    'innerContainerOptions' => [
                        'class' => 'catalog-menu',
                    ],
                ]);

                echo Nav::widget([
                    'activateParents' => true,
                    'encodeLabels'    => false,
                    'options'         => [
                        'class' => 'nav nav-pills nav-stacked',
                    ],
                    'items'           => \Yii::$app->shop->getCategories(),
                ]);
                NavBar::end();
                ?>
            </div>

            <?= $content ?>

        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
