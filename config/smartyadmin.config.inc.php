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

global $smarty;
$smarty->debugging = false;
$smarty->debugging_ctrl = 'NONE';

// Let user choose to force compilation
$smarty->force_compile = (Configuration::get('PS_SMARTY_FORCE_COMPILE') == _PS_SMARTY_FORCE_COMPILE_) ? true : false;
// But force compile_check since the performance impact is small and it is better for debugging
$smarty->compile_check = true;

function smartyTranslate($params, $smarty)
{
    $htmlentities = !isset($params['js']);
    $pdf = isset($params['pdf']);
    $addslashes = (isset($params['slashes']) || isset($params['js']));
    $sprintf = isset($params['sprintf']) ? $params['sprintf'] : null;

    if ($pdf) {
        return Translate::smartyPostProcessTranslation(Translate::getPdfTranslation($params['s'], $sprintf), $params);
    }

    $filename = ((!isset($smarty->compiler_object) || !is_object($smarty->compiler_object->template)) ? $smarty->template_resource : $smarty->compiler_object->template->getTemplateFilepath());

    // If the template is part of a module
    if (!empty($params['mod'])) {
        return Translate::smartyPostProcessTranslation(Translate::getModuleTranslation($params['mod'], $params['s'], basename($filename, '.tpl'), $sprintf, isset($params['js'])), $params);
    }

    // If the tpl is at the root of the template folder
    if (dirname($filename) == '.') {
        $class = 'index';
    }

    if (!empty(Context::getContext()->override_controller_name_for_translations)) {
        $class = Context::getContext()->override_controller_name_for_translations;
    } elseif (isset(Context::getContext()->controller)) {
        $className = get_class(Context::getContext()->controller);
        $class = substr($className, 0, strpos(strtolower($className), 'controller'));
    } else {
        // Split by \ and / to get the folder tree for the file
        $folderTree = preg_split('#[/\\\]#', $filename);
        $key = array_search('controllers', $folderTree);

        // If there was a match, construct the class name using the child folder name
        // Eg. xxx/controllers/customers/xxx => AdminCustomers
        if ($key !== false) {
            $class = 'Admin'.Tools::toCamelCase($folderTree[$key + 1], true);
        } elseif (isset($folderTree[0])) {
            $class = 'Admin'.Tools::toCamelCase($folderTree[0], true);
        }
    }

    return Translate::smartyPostProcessTranslation(Translate::getAdminTranslation($params['s'], $class, $addslashes, $htmlentities, $sprintf), $params);
}
