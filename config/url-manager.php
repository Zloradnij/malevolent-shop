<?php

return [
    '/shop/products' => '/shop/default/product',
    '/shop/<aliases:[\w_\/-]+>' => '/shop/default/category',
];