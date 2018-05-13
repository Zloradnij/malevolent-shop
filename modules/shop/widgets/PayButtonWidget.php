<?php

namespace app\modules\shop\widgets;


use yii\base\Widget;
use yii\helpers\Html;

class PayButtonWidget extends Widget
{
    const DANGER_MESSAGE = 'Under The Order';
    const SUCCESS_MESSAGE = 'Pay';
    const CLASS_SUCCESS = 'info';
    const CLASS_DANGER = 'danger';
    const ACTION_SUCCESS = 'pay';
    const ACTION_DANGER = 'under-order';

    public $id = 0;
    public $price = 0;
    public $count = 1;
    public $class = '';
    public $text = '';
    public $action;

    public function init()
    {
        parent::init();

        $this->class = static::CLASS_DANGER;
        $this->text = static::DANGER_MESSAGE;
        $this->action = static::ACTION_DANGER;

        if ($this->price) {
            $this->class = static::CLASS_SUCCESS;
            $this->text = static::SUCCESS_MESSAGE;
            $this->action = static::ACTION_SUCCESS;
        }
    }

    public function run()
    { ?>
        <div class="text-center text-green"><?=
            Html::button(
                \Yii::t('shop', $this->text),
                [
                    'class' => 'pay-button btn btn-' . $this->class,
                    'data' => [
                        'price' => $this->price,
                        'count' => $this->count,
                        'action' => $this->action,
                        'product-id' => $this->id,
                    ],
                ]
            ); ?>
        </div><?php

        parent::run();
    }
}