<?php

namespace App\Constants;

class Common
{
    // 商品を増減
    const PRODUCT_ADD    = "1";
    const PRODUCT_REDUCE = "2";
    const PRODUCT_LIST = [
        'add'    => self::PRODUCT_ADD,
        'reduce' => self::PRODUCT_REDUCE,
    ];

    // 商品の並び替え
    const ORDER_RECOMMEND = "0";
    const ORDER_HIGHER    = "1";
    const ORDER_LOWER     = "2";
    const ORDER_LATER     = "3";
    const ORDER_ORDER     = "4";
    const SORT_ORDER = [
        'recommend'   => self::ORDER_RECOMMEND,
        'higherPrice' => self::ORDER_HIGHER,
        'lowerPrice'  => self::ORDER_LOWER,
        'later'       => self::ORDER_LATER,
        'order'       => self::ORDER_ORDER,
    ];
}