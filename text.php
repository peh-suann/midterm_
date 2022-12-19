<?php

$price_low = '500';
$price_high = '1000';

$a = ['501', '200', '350', '700', '999', '1001'];


foreach ($a as $v) {
    if ($v > $price_low and $v < $price_high) {
        echo json_encode($v, JSON_UNESCAPED_UNICODE);
    }
}