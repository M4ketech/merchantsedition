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

class AdminConfigurationPagesCest
{
    private $adminPages = [
        'AdminDashboard' => [],
        'AdminCatalog' => [
            'AdminProducts',
            'AdminCategories',
            'AdminTracking',
            'AdminAttributesGroups',
            'AdminFeatures',
            'AdminManufacturers',
            'AdminSuppliers',
            'AdminTags',
            'AdminAttachments',
        ],
        'AdminParentOrders' => [
            'AdminOrders',
            'AdminInvoices',
            'AdminReturn',
            'AdminDeliverySlip',
            'AdminSlip',
            'AdminStatuses',
            'AdminOrderMessage',
        ],
        'AdminParentCustomer' => [
            'AdminCustomers',
            'AdminAddresses',
            'AdminGroups',
            'AdminCarts',
            'AdminCustomerThreads',
            'AdminContacts',
            'AdminGenders',
        ],
        'AdminPriceRule' => [
            'AdminCartRules',
            'AdminSpecificPriceRule',
        ],
        'AdminParentModules' => [
            'AdminModules',
            'AdminAddonsCatalog',
            'AdminModulesPositions',
            'AdminPayment',
        ],
        'AdminParentShipping' => [
            'AdminCarriers',
            'AdminShipping',
        ],
        'AdminParentLocalization' => [
            'AdminLocalization',
            'AdminLanguages',
            'AdminZones',
            'AdminCountries',
            'AdminStates',
            'AdminCurrencies',
            'AdminTaxes',
            'AdminTaxRulesGroup',
            'AdminTranslations',
        ],
        'AdminParentPreferences' => [
            'AdminPreferences',
            'AdminOrderPreferences',
            'AdminPPreferences',
            'AdminCustomerPreferences',
            'AdminThemes',
            'AdminMeta',
            'AdminCmsContent',
            'AdminImages',
            'AdminStores',
            'AdminSearchConf',
            'AdminMaintenance',
            'AdminGeolocation',
            'AdminCustomCode',
        ],
        'AdminTools' => [
            'AdminInformation',
            'AdminPerformance',
            'AdminEmails',
            'AdminImport',
            'AdminBackup',
            'AdminRequestSql',
            'AdminLogs',
            'AdminWebservice',
        ],
        'AdminAdmin' => [
            'AdminAdminPreferences',
            'AdminQuickAccesses',
            'AdminEmployees',
            'AdminProfiles',
            'AdminAccess',
            'AdminTabs',
        ],
        'AdminParentStats' => [
            'AdminStats',
            'AdminSearchEngines',
            'AdminReferrers',
        ],
    ];

    public function _before(AcceptanceTester $I)
    {
        $I->resizeWindow(1920, 1080);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    private function login(AcceptanceTester $I)
    {
        $I->amOnPage('/admin-dev/index.php');
        $I->waitForElementVisible(['css' => '#email']);

        $I->fillField(['css' => '#email'], 'test@thirty.bees');
        $I->fillField(['css' => '#passwd'], 'thirtybees');
        $I->click('Log in');
    }

    private function checkAdminPage(AcceptanceTester $I, $child)
    {
        $childElement = ['css' => "#subtab-{$child} a"];

        $I->seeElementInDOM($childElement);
        $I->waitForElementVisible($childElement, 30);
        $I->click($childElement);

        $I->see('Quick Access');
        $I->withoutErrors();
    }

    public function testAdminPages(AcceptanceTester $I)
    {
        $this->login($I);

        foreach ($this->adminPages as $parent => $children) {
            $parentElement = ['css' => "#maintab-{$parent}"];

            $I->waitForElementVisible($parentElement, 30);
            $I->click($parentElement);

            $I->see('Quick Access');
            foreach ($children as $child) {
                // Move mouse out and back in to make the submenu visible.
                $I->moveMouseOver(null, 0, 0);
                $I->moveMouseOver($parentElement);

                $this->checkAdminPage($I, $child);
            }
        }
    }
}
