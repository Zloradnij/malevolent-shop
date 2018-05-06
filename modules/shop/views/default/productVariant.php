<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $product \app\modules\catalog\models\Product */

$this->title = $product->title;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="shop-default-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid">
        <div class="row row-flex"><?php

            $productArray = $product->toArray(); ?>

            <div class="text-center text-bold text-green"><?=
                \Yii::$app->formatter->asCurrency($product->price) ?> &#8381
            </div>
            <hr />
            <div class="text-center text-green"><?=
                Html::button(
                    Yii::t('shop', 'Pay'),
                    [
                        'class' => 'btn btn-info',
                    ]
                ); ?>
            </div>
            <hr />
            <div><?php

                if (
                    !empty($product->variants)
                    && !empty($product->variants[0])
                    && !empty($product->variants[0]->images)
                ) {

                    $image = $product->variants[0]->images[0];

                    echo Html::a(
                        Html::img(
                            $image->path,
                            [
                                'title' => $image->title,
                                'alt'   => $image->title,
                                'class' => 'img-responsive img-rounded',
                            ]
                        ),
                        $image->path,
                        [
                            'class' => 'fancybox',
                            'rel'   => 'ligthbox',
                            'title' => $image->title,
                        ]
                    );

                } ?>

            </div>

        </div>
    </div>

</div>
