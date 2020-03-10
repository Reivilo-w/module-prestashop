<?php


class TestProduct extends ObjectModel {
    public $id;
    public $product_id;
    public $commentary;
    public $is_enabled;

    public static $definition = [
        'table' => 'tacos_testproduct',
        'primary' => 'id_testproduct',
        'multishop' => false,
        'fields' => [
            'product_id' => [
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ],
            'commentary' => [
                'type' => self::TYPE_STRING,
                'validate' => 'isGenericName',
                'size' => 255,
                'required' => false
            ],
            'is_enabled' => [
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
                'required' => true
            ]
        ]
    ];
}