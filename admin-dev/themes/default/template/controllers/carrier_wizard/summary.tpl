{**
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
 *}

<script type="text/javascript">
	var summary_translation_undefined = '{l s='[undefined]' js=1}';
	var summary_translation_meta_informations = '{l s='This carrier is <strong>@s1</strong> and the delivery announced is: <strong>@s2</strong>.' js=1}';
	var summary_translation_free = '<strong>{l s='free' js=1}</strong>';
	var summary_translation_paid = '<strong>{l s='not free' js=1}</strong>';
	var summary_translation_range = '<span class="is_free">{l s='This carrier can deliver orders from <strong>@s1</strong> to <strong>@s2</strong>.' js=1}</span>';
	var summary_translation_range_limit = '{l s='If the order is out of range, the behavior is to <strong>@s3</strong>.' js=1}';
	var summary_translation_shipping_cost = '{l s='The shipping cost is calculated @s1 and the tax rule <strong>@s2</strong> will be applied.' js=1}';
	var summary_translation_price = '<strong>{l s='according to the price' js=1}</strong>';
	var summary_translation_weight = '<strong>{l s='according to the weight' js=1}</strong>';
</script>

<div class="defaultForm">
	<div class="panel">
		<div class="panel-heading">{l s='Carrier name:'} <strong id="summary_name"></strong></div>
		<div class="panel-body">
			<p id="summary_meta_informations"></p>
			<p id="summary_shipping_cost"></p>
			<p id="summary_range"></p>
			<div>
			{l s='This carrier will be proposed for those delivery zones:'}
				<ul id="summary_zones"></ul>
			</div>
			<div>
				{l s='And it will be proposed for those client groups:'}
				<ul id="summary_groups"></ul>
			</div>
			{if $is_multishop}
			<div>
				{l s='Finally, this carrier will be proposed in those shops:'}
				<ul id="summary_shops"></ul>
			</div>
			{/if}
		</div>
	</div>
	{$active_form}
</div>
