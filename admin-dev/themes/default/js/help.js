/**
 * Copyright (C) 2021 Merchant's Edition GbR
 * Copyright (C) 2017-2019 thirty bees
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
 * @copyright 2017-2019 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   Open Software License (OSL 3.0)
 * PrestaShop is an internationally registered trademark of PrestaShop SA.
 * thirty bees is an extension to the PrestaShop software by PrestaShop SA.
 */

$(function () {

	var storage = false;

	if (typeof(getStorageAvailable) !== 'undefined') {
		storage = getStorageAvailable();
	}

	initHelp = function () {
		$('#main').addClass('helpOpen');
		//first time only
		if ($('#help-container').length === 0) {
			$('#main').after('<div id="help-container"></div>');
		}
		//init help (it use a global javascript variable to get actual controller)
		pushContent(help_class_name);
		$('#help-container').on('click', '.popup', function (e) {
			e.preventDefault();
			if (storage) {
				storage.setItem('helpOpen', false);
			}
			$('.toolbarBox a.btn-help').trigger('click');
			var helpWindow = window.open("index.php?controller=" + help_class_name + "?token=" + token + "&ajax=1&action=OpenHelp", "helpWindow", "width=450, height=650, scrollbars=yes");
		});
	};


	//init
	$('.toolbarBox a.btn-help').on('click', function (e) {
		e.preventDefault();
		if (!$('#main').hasClass('helpOpen') && document.body.clientWidth > 1200) {
			if (storage) {
				storage.setItem('helpOpen', true);
			}
			$('.toolbarBox a.btn-help i').removeClass('process-icon-help').addClass('process-icon-loading');
			initHelp();
		} else if (!$('#main').hasClass('helpOpen') && document.body.clientWidth < 1200) {
			var helpWindow = window.open("index.php?controller=" + help_class_name + "?token=" + token + "&ajax=1&action=OpenHelp", "helpWindow", "width=450, height=650, scrollbars=yes");
		} else {
			$('#main').removeClass('helpOpen');
			$('#help-container').html('');
			$('.toolbarBox a.btn-help i').removeClass('process-icon-close').addClass('process-icon-help');
			if (storage) {
				storage.setItem('helpOpen', false);
			}
		}
	});

	// Help persistency
	if (storage && storage.getItem('helpOpen') == "true") {
		$('a.btn-help').trigger('click');
	}

	// change help icon
	function iconCloseHelp() {
		$('.toolbarBox a.btn-help i').removeClass('process-icon-loading').addClass('process-icon-close');
	}

	window.addEventListener('message', function(e) {
		var message = e.data;
		if (typeof message.inlineHelpHeight !== 'undefined') {
			$('#helpFrame').css('height', parseInt(message.inlineHelpHeight, 10));
		}
	});

	//get content
	function getHelp(pageController) {
		$('<iframe style="width: 100%" src="https://docs.thirtybees.com/api/1.0/' + pageController + '" frameborder="0" scrolling="no" id="helpFrame"></iframe>').appendTo('#help-container');
	}

	//update content
	function pushContent(target) {
		$('#help-container').removeClass('openHelpNav').html('');
		getHelp(target);
		iconCloseHelp();
	}
});
