<?php
/**
 * Copyright (C) 2021 Merchant's Edition GbR
 * Copyright (C) 2017-2018 thirty bees
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
 * @copyright 2021 Merchant's Edition GbR
 * @copyright 2017-2018 thirty bees
 * @license   Open Software License (OSL 3.0)
 */

// These should work with or without installation.
require_once(dirname(__FILE__).'/../config/defines.inc.php');
require_once(_PS_ROOT_DIR_.'/config/autoload.php');

if (!defined('_PS_ADMIN_DIR_')) {
  // Find admin dir even on non-developer installations.
  $adminDir = null;
  $rootDir = dir(_PS_ROOT_DIR_);
  while (($entry = $rootDir->read())) {
    $found = strpos($entry, 'admin');
    if ($found !== false && $found === 0) {
      $adminDir = $rootDir->path.DIRECTORY_SEPARATOR.$entry;
      break;
    }
  }
  $rootDir->close();
  define('_PS_ADMIN_DIR_', $adminDir);
}

AdminInformationControllerCore::generateMd5List();
