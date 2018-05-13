<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $products \app\modules\catalog\models\ProductVariant[] */
/* @var $images \app\modules\catalog\models\Images[] */
/* @var $category \app\modules\catalog\models\Category */
/* @var $categories object[] */
/* @var $breadcrumbs [] */

$this->title = $category->title;

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container-fluid col-xs-12 col-sm-8 col-md-9">
    <div class="row row-flex"><?php

        foreach ($products as $product) { ?>

            <div
                class="col-md-3 col-sm-6 padding-15-10 shop-product"
                data-id="<?= $product->id ?>"
                data-title="<?= $product->title ?>"
                data-alias="<?= $product->alias ?>"
                data-sort="<?= $product->sort ?>"
                data-status="<?= $product->status ?>"
                data-price="<?= $product->price ?>"
                data-descriptionShort="<?= $product->description_short ?>"
                data-description="<?= $product->description ?>"
                data-image="<?= !empty($images[$product->id]) ? $images[$product->id]->path : '' ?>"
                data-step="1"
                data-count="1"
            >
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
                    <?= \app\modules\shop\widgets\PriceWidget::widget([
                        'price' => $product->price,
                    ]) ?>
                    <hr/>
                    <?= \app\modules\shop\widgets\PayButtonWidget::widget([
                        'price' => $product->price,
                        'id'    => $product->id,
                    ]) ?>
                    <hr/>
                    <div><?php

                        if (!empty($images[$product->id])) {

                            $image = $images[$product->id];

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
