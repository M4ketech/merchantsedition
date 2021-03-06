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
 * Class OrderFollowControllerCore
 *
 * @since 1.0.0
 */
class OrderFollowControllerCore extends FrontController
{
    // @codingStandardsIgnoreStart
    /** @var bool $auth */
    public $auth = true;
    /** @var string $php_self */
    public $php_self = 'order-follow';
    /** @var string $authRedirection */
    public $authRedirection = 'order-follow';
    /** @var bool $ssl */
    public $ssl = true;
    // @codingStandardsIgnoreEnd

    /**
     * Start forms process
     *
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        if (Tools::isSubmit('submitReturnMerchandise')) {
            $customizationQtyInput = Tools::getValue('customization_qty_input');
            $orderQteInput = Tools::getValue('order_qte_input');
            $customizationIds = Tools::getValue('customization_ids');

            if (!$idOrder = (int) Tools::getValue('id_order')) {
                Tools::redirect('index.php?controller=history');
            }
            if (!$orderQteInput && !$customizationQtyInput && !$customizationIds) {
                Tools::redirect('index.php?controller=order-follow&errorDetail1');
            }
            if (!$customizationIds && !$idsOrderDetail = Tools::getValue('ids_order_detail')) {
                Tools::redirect('index.php?controller=order-follow&errorDetail2');
            }
            if (!isset($idsOrderDetail)) {
                Tools::redirect('index.php?controller=order-follow&errorDetail2');

                return;
            }

            $order = new Order((int) $idOrder);
            if (!$order->isReturnable()) {
                Tools::redirect('index.php?controller=order-follow&errorNotReturnable');
            }
            if ($order->id_customer != $this->context->customer->id) {
                die(Tools::displayError());
            }
            $orderReturn = new OrderReturn();
            $orderReturn->id_customer = (int) $this->context->customer->id;
            $orderReturn->id_order = $idOrder;
            $orderReturn->question = htmlspecialchars(Tools::getValue('returnText'));
            if (empty($orderReturn->question)) {
                Tools::redirect(
                    'index.php?controller=order-follow&errorMsg&'.http_build_query(
                        [
                            'ids_order_detail' => $idsOrderDetail,
                            'order_qte_input'  => $orderQteInput,
                            'id_order'         => Tools::getValue('id_order'),
                        ]
                    )
                );
            }

            if (!$orderReturn->checkEnoughProduct($idsOrderDetail, $orderQteInput, $customizationIds, $customizationQtyInput)) {
                Tools::redirect('index.php?controller=order-follow&errorQuantity');
            }

            $orderReturn->state = 1;
            $orderReturn->add();
            $orderReturn->addReturnDetail($idsOrderDetail, $orderQteInput, $customizationIds, $customizationQtyInput);
            Hook::exec('actionOrderReturn', ['orderReturn' => $orderReturn]);
            Tools::redirect('index.php?controller=order-follow');
        }
    }

    /**
     * Assign template vars related to page content
     *
     * @see FrontController::initContent()
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function initContent()
    {
        parent::initContent();

        $ordersReturn = OrderReturn::getOrdersReturn($this->context->customer->id);
        if (Tools::isSubmit('errorQuantity')) {
            $this->context->smarty->assign('errorQuantity', true);
        } elseif (Tools::isSubmit('errorMsg')) {
            $this->context->smarty->assign(
                [
                    'errorMsg'         => true,
                    'ids_order_detail' => Tools::getValue('ids_order_detail', []),
                    'order_qte_input'  => Tools::getValue('order_qte_input', []),
                    'id_order'         => (int) Tools::getValue('id_order'),
                ]
            );
        } elseif (Tools::isSubmit('errorDetail1')) {
            $this->context->smarty->assign('errorDetail1', true);
        } elseif (Tools::isSubmit('errorDetail2')) {
            $this->context->smarty->assign('errorDetail2', true);
        } elseif (Tools::isSubmit('errorNotReturnable')) {
            $this->context->smarty->assign('errorNotReturnable', true);
        }

        $this->context->smarty->assign(array(
            'PS_RETURN_PREFIX' => Configuration::get('PS_RETURN_PREFIX', $this->context->language->id),
            'ordersReturn' => $ordersReturn
        ));


        $this->setTemplate(_PS_THEME_DIR_.'order-follow.tpl');
    }

    /**
     * Set media
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS([_THEME_CSS_DIR_.'history.css', _THEME_CSS_DIR_.'addresses.css']);
        $this->addJqueryPlugin('scrollTo');
        $this->addJS(
            [
                _THEME_JS_DIR_.'history.js',
                _THEME_JS_DIR_.'tools.js',
            ] // retro compat themes 1.5
        );
        $this->addjqueryPlugin('footable');
        $this->addJqueryPlugin('footable-sort');
    }
}
