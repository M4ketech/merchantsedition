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

include('../config/config.inc.php');
header('content-type: application/x-javascript');

$jquery_folder = dirname(__FILE__).'/jquery/';
$plugins_folder = $jquery_folder.'plugins/';

$plugins = [
                'ajaxfileupload.js' =>
                    ['new_file' => $plugins_folder.'ajaxfileupload/jquery.ajaxfileupload.js', 'name' => 'ajaxfileupload'],
                'jquery-colorpicker.js' =>
                    ['new_file' => $plugins_folder.'jquery.colorpicker.js', 'name' => 'colorpicker'],
                'jquery.cluetip.js' =>
                    ['new_file' => $plugins_folder.'cluetip/jquery.cluetip.js', 'name' => 'cluetip'],
                'jquery-fieldselection.js' =>
                    ['new_file' => $plugins_folder.'jquery.fieldselection.js', 'name' => 'fieldselection'],
                'jquery.dimensions.js' =>
                    ['new_file' => $plugins_folder.'jquery.dimensions.js', 'name' => 'dimensions'],
                'jquery.idTabs.modified.js' =>
                    ['new_file' => $plugins_folder.'jquery.idTabs.js', 'name' => 'idTabs'],
                'jquery.pngFix.pack.js' =>
                    ['new_file' => $plugins_folder.'jquery.pngFix.js', 'name' => 'pngFix'],
                'thickbox-modified.js' =>
                    ['new_file' => $plugins_folder.'thickbox/jquery.thickbox.js', 'name' => 'thickbox'],
                'excanvas.min.js' =>
                    ['new_file' => $plugins_folder.'jquery.excanvas.js', 'name' => 'excanvas'],
                'jquery-typewatch.pack.js' =>
                    ['new_file' => $plugins_folder.'jquery.typewatch.js', 'name' => 'typewatch'],
                'jquery.easing.1.3.js' =>
                    ['new_file' => $plugins_folder.'jquery.easing.js', 'name' => 'easing'],
                'jquery.jgrowl-1.2.1.min.js' =>
                    ['new_file' => $plugins_folder.'jquery.jgrowl.js', 'name' => 'jgrowl'],
                'jquery.scrollTo-1.4.2-min.js' =>
                    ['new_file' => $plugins_folder.'jquery.scrollTo.js', 'name' => 'scrollTo'],
                'jqminmax-compressed.js' =>
                    ['new_file' => $plugins_folder.'jquery.jqminmax.js', 'name' => 'jqminmax'],
                'jquery.fancybox-1.3.4.js' =>
                    ['new_file' => $plugins_folder.'fancybox/jquery.fancybox.js', 'name' => 'fancybox'],
                'jquery.jqzoom.js' =>
                    ['new_file' => $plugins_folder.'jquery.jqzoom.js', 'name' => 'jqzoom'],
                'jquery.serialScroll-1.2.2-min.js' =>
                    ['new_file' => $plugins_folder.'jquery.serialScroll.js', 'name' => 'serialScroll'],
                'ifxtransfer.js' =>
                    ['new_file' => $plugins_folder.'jquery.ifxtransfer.js', 'name' => 'ifxtransfer'],
                'jquery.autocomplete.js' =>
                    ['new_file' => $plugins_folder.'autocomplete/jquery.autocomplete.js', 'name' => 'autocomplete'],
                'jquery.flot.min.js' =>
                    ['new_file' => $plugins_folder.'jquery.flot.js', 'name' => 'flot'],
                'jquery.tablednd_0_5.js' =>
                    ['new_file' => $plugins_folder.'jquery.tablednd.js', 'name' => 'tablednd'],
                'jquery.hoverIntent.minified.js' =>
                    ['new_file' => $plugins_folder.'jquery.hoverIntent.js', 'name' => 'hoverIntent'],
                'jquery-ui-1.8.10.custom.min.js' =>
                    ['new_file' => $jquery_folder.'ui/jquery.ui.core.min.js', 'name' => ''],
                'jquery.treeview.async.js' =>
                    ['new_file' => $plugins_folder.'treeview-categories/jquery.treeview-categories.async.js', 'name' => 'treeview-categories.async'],
                'jquery.treeview.edit.js' =>
                    ['new_file' => $plugins_folder.'treeview-categories/jquery.treeview-categories.edit.js', 'name' => 'treeview-categories.edit'],
                'jquery.treeview.js' =>
                    ['new_file' => $plugins_folder.'treeview-categories/jquery.treeview-categories.js', 'name' => 'treeview-categories'],
                'jquery.treeview.sortable.js' =>
                    ['new_file' => $plugins_folder.'treeview-categories/jquery.treeview-categories.sortable.js', 'name' => 'treeview-categories.sortable'],
                'tabpane.js' =>
                    ['new_file' => $plugins_folder.'tabpane/jquery.tabpane.js', 'name' => 'tabpane'],
                'admin-themes.js' =>
                    ['new_file' => 'admin/themes.js', 'name' => 'themes'],
                'admin-dashboard.js' =>
                    ['new_file' => 'admin/dashboard.js', 'name' => 'dashboard'],
                'admin-products.js' =>
                    ['new_file' => 'admin/products.js', 'name' => 'products'],
                'adminImport.js' =>
                    ['new_file' => 'admin/import.js', 'name' => 'import'],
                'admin_carrier_wizard.js' =>
                    ['new_file' => 'admin/carrier_wizard.js', 'name' => 'carrier_wizard'],
                'admin_order.js' =>
                    ['new_file' => 'admin/orders.js', 'name' => 'orders'],
                'attributesBack.js' =>
                    ['new_file' => 'admin/attributes.js', 'name' => 'attributes'],
                'admin-scene-cropping.js' =>
                    ['new_file' => 'admin/scenes.js', 'name' => 'scenes'],
                'admin-dnd.js' =>
                    ['new_file' => 'admin/dnd.js', 'name' => 'dnd'],
                'login.js' =>
                    ['new_file' => 'admin/login.js', 'name' => 'login'],
                'notifications.js' =>
                    ['new_file' => 'admin/notifications.js', 'name' => 'login'],
                'price.js' =>
                    ['new_file' => 'admin/price.js', 'name' => 'login'],
                'tinymce.inc.js' =>
                    ['new_file' => 'admin/tinymce.inc.js', 'name' => 'tinymce'],
];


$file = $_GET['file'];
if (!array_key_exists($file, $plugins)) {
    //check if file is a real prestashop native JS
    die('file_not_found');
} elseif ($file == 'jquery-ui-1.8.10.custom.min.js') {
    //jquery-ui cannot be call directly, now to include query UI, use Media::addJqueryUI('component_name');
    $html = '$(document).ready( function () {
	'.(_PS_MODE_DEV_ ? 'if (!$.browser.msie)console.log(\'MODE DEV : This file : "jquery-ui-1.8.10.custom.min.js" cannot be call directly please use Media::addJqueryUI("component_name")  \')' : '').'
	});';
    $html .= file_get_contents($plugins[$file]['new_file']);
} else {
    $html = '$(document).ready( function () {
		'.(_PS_MODE_DEV_ ? 'if (!$.browser.msie)console.log(\'MODE DEV : This file : "'.$file.'" has been moved to this folder '.$plugins[$file]['new_file'].'  To include this plugin use Media::addJqueryPlugin("'.$plugins[$file]['name'].'")\')' : '').'
	});';
    $html .= file_get_contents($plugins[$file]['new_file']);
}
echo $html ;
