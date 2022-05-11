<?php

include __DIR__ . '/MoySkladICMLParserRUB.php';

// configure
$parserRUB = new MoySkladICMLParserRUB(
    'spasatelkotikov@lovelace',
    'cP7TrCrqTY',
    'Lovelace',
    array(
        'directory' => __DIR__,
        'file' => 'catalogMoySklad.xml',
    )
);

// generate
$parserRUB->generateICML();