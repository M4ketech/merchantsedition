<?php
/**
 * Copyright (C) 2021 Merchant's Edition GbR
 * Copyright (C) 2017-2018 thirty bees
 * Copyright (C) 2007-2016 PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@merchantsedition.com so we can send you a copy immediately.
 *
 * @author    Merchant's Edition <contact@merchantsedition.com>
 * @author    thirty bees <contact@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2021 Merchant's Edition GbR
 * @copyright 2017-2018 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   Open Software License (OSL 3.0)
 * PrestaShop is an internationally registered trademark of PrestaShop SA.
 * thirty bees is an extension to the PrestaShop software by PrestaShop SA.
 */

/**
 * Class CustomizationFieldCore
 *
 * @since 1.0.0
 */
class CustomizationFieldCore extends ObjectModel
{
    // @codingStandardsIgnoreStart
    /** @var int */
    public $id_product;
    /** @var int Customization type (0 File, 1 Textfield) (See Product class) */
    public $type;
    /** @var bool Field is required */
    public $required;
    /** @var string Label for customized field */
    public $name;
    // @codingStandardsIgnoreEnd

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table'          => 'customization_field',
        'primary'        => 'id_customization_field',
        'multilang'      => true,
        'multilang_shop' => true,
        'fields'         => [
            /* Classic fields */
            'id_product' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true],
            'type'       => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true, 'dbType' => 'tinyint(1)'],
            'required'   => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true, 'dbType' => 'tinyint(1)'],

            /* Lang fields */
            'name'       => ['type' => self::TYPE_STRING, 'lang' => true, 'required' => true, 'size' => 255],
        ],
        'keys' => [
            'customization_field' => [
                'id_product' => ['type' => ObjectModel::KEY, 'columns' => ['id_product']],
            ],
        ],
    ];
    protected $webserviceParameters = [
        'fields' => [
            'id_product' => [
                'xlink_resource' => [
                    'resourceName' => 'products',
                ],
            ],
        ],
    ];
}
