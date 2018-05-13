<?php

namespace app\modules\shop\widgets;


use yii\base\Widget;

class PriceWidget extends Widget
{
    const EMPTY_VALUE_MESSAGE = 'Нет в наличии';
    const CLASS_SUCCESS = 'success';
    const CLASS_DANGER = 'danger';

    public $price = 0;
    public $class = '';

    public function init()
    {
        parent::init();

        $this->class = static::CLASS_DANGER;

        if ($this->price) {
            $this->class = static::CLASS_SUCCESS;
            $this->price = \Yii::$app->formatter->asCurrency($this->price);
        }
    }

    public function run()
    {
        $value = $this->price ? $this->price . " &#8381" : static::EMPTY_VALUE_MESSAGE; ?>

        <div class="text-center text-bold text-<?=$this->class?> ">
            <?= $value?>
        </div><?php

        parent::run();
    }
}