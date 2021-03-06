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

{extends file="helpers/view/view.tpl"}

{block name="override_tpl"}
<div class="panel">
	<h3><i class="icon-cog"></i> {l s='SQL query result'}</h3>
	{if isset($view['error'])}
		<div class="alert alert-warning">{l s='This SQL query has no result.'}</div>
	{else}
		<table class="table" id="viewRequestSql">
			<thead>
				<tr>
					{foreach $view['key'] AS $key}
					<th><span class="title_box">{$key}</span></th>
					{/foreach}
				</tr>
			</thead>
			<tbody>
			{foreach $view['results'] AS $result}
				<tr>
					{foreach $view['key'] AS $name}
						{if isset($view['attributes'][$name])}
							<td>{$view['attributes'][$name]|escape:'html':'UTF-8'}</td>
						{else}
							<td>{$result[$name]|escape:'html':'UTF-8'}</td>
						{/if}
					{/foreach}
				</tr>
			{/foreach}
			</tbody>
		</table>

		<script type="text/javascript">
			$(function(){
				var width = $('#viewRequestSql').width();
				if (width > 990){
					$('#viewRequestSql').css('display','block').css('overflow-x', 'scroll');
				}
			});
		</script>
	{/if}
	<div class="panel-footer">
		<button class="btn btn-default" type="submit" onclick="window.history.back();return false;">
			<i class="process-icon-back"></i> {l s='Go back'}
		</button>
	</div>
</div>
{/block}
