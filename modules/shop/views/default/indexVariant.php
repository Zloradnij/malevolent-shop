<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $products \app\modules\catalog\models\Product[] */

$this->title = Yii::t('shop', 'Shop');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="shop-default-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid">
        <div class="row row-flex"><?php

            foreach ($products as $product) {

                $productArray = $product->toArray(); ?>

                <div class="col-md-2 col-sm-6 padding-15-10">
                    <div class="thumbnail img-responsive img-rounded full-height">

                        <div class="text-center height-3em"><?=

                            Html::a(
                                $product->title,
                                ['/shop/products', 'id' => $product->id],
                                [
                                    'title' => $product->title,
                                ]
                            ); ?>
                        </div>
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
                </div><?php

            } ?>
        </div>
    </div>

</div>
