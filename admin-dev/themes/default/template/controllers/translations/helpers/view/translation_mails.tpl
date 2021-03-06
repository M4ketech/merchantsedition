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
  {$tinyMCE}
  {if $mod_security_warning}
    <div class="alert alert-warning">
      {l s='Apache mod_security is activated on your server. This could result in some Bad Request errors'}
    </div>
  {/if}
  <form method="post" id="{$table}_form" action="{$url_submit|escape:'html':'UTF-8'}" class="form-horizontal">
    <div class="panel">
      <input type="hidden" name="lang" value="{$lang}" />
      <input type="hidden" name="type" value="{$type}" />
      <input type="hidden" name="theme" value="{$theme}" />
      <script type="text/javascript">
        $(document).ready(function(){
          $('a.useSpecialSyntax').click(function(){
            var syntax = $(this).find('img').attr('alt');
            $('#BoxUseSpecialSyntax .syntax span').html(syntax+".");
          });
        });
      </script>
      <div id="BoxUseSpecialSyntax">
        <div class="alert alert-warning">
          <p>
            {l s='Some of these expressions use this special syntax: %s.' sprintf='%d'}
            <br />
            {l s='You MUST use this syntax in your translations. Here are several examples:'}
          </p>
          <ul>
            <li>"{l s='There are [1]%d[/1] products' tags=['<strong>']}": {l s='"%s" will be replaced by a number.' sprintf='%d'}</li>
            <li>"{l s='List of pages in [1]%s[/1]' tags=['<strong>']}": {l s='"%s" will be replaced by a string.' sprintf='%s'}</li>
            <li>"{l s='Feature: [1]%1$s[/1] ([1]%2$d[/1] values)' tags=['<strong>']}": {l s='The numbers enable you to reorder the variables when necessary.'}</li>
          </ul>
        </div>
      </div>
      <div id="translation_mails-control-actions" class="panel-footer">
        <a name="submitTranslations{$type|ucfirst}" href="{$cancel_url}" class="btn btn-default">
          <i class="process-icon-cancel"></i> {l s='Cancel'}
        </a>
        {*$toggle_button*}
        <button type="submit" id="{$table}_form_submit_btn" name="submitTranslations{$type|ucfirst}" class="btn btn-default pull-right">
          <i class="process-icon-save"></i>
          {l s='Save'}
        </button>
        <button type="submit" id="{$table}_form_submit_btn" name="submitTranslations{$type|ucfirst}AndStay" class="btn btn-default pull-right">
          <i class="process-icon-save"></i>
          {l s='Save and stay'}
        </button>
      </div>
    </div>
    <div class="panel">
      <h3>
        <i class="icon-envelope"></i>
        {l s='Core emails'}
        <span class="badge">
          <i class="icon-folder"></i>
          mails/{$lang|strtolower}/
        </span>
      </h3>
      {$mail_content}
      {literal}
      <script type="text/javascript">
      //<![CDATA[
        $(document).ready(function () {
          $('.mails_field').on('shown.bs.collapse', function () {
            // get active email
            var active_email = $(this).find('.email-collapse.in');
            // get iframe container for active email
            var frame = active_email.find('.email-html-frame');
            // get source url for active email
            var src = frame.data('email-src');
            // get rte container for active email
            var rte_mail_selector = active_email.find('textarea.rte-mail').data('rte');
            // create special config
            var rte_mail_config = {};
            rte_mail_config['editor_selector'] = 'rte-mail-' + rte_mail_selector;
            rte_mail_config['height'] = '500px';
            // We want the default plugins + 'fullpage' plugin for HTML emails
            rte_mail_config['plugins'] = "colorpicker link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor anchor fullpage";
            // move controls to active panel
            $('#translation_mails-control-actions').appendTo($(this).find('.panel-collapse.in'));
            // when user first open email
            if (frame.find('iframe.email-frame').length == 0) {
              // load iframe
              frame.append('<iframe class="email-frame" />');
              $.ajax({
                url:'ajax.php',
                type: 'POST',
                dataType: 'html',
                data: {
                  getEmailHTML : true,
                  email : src
                },
                success: function(result)
                {
                  var doc = frame.find('iframe')[0].contentWindow.document;
                  doc.open();
                  doc.write(result);
                  doc.close();
                  tinySetup(rte_mail_config);
                  // init tinyMCE with special config
                }
              });

            }
          });
        })
      //]]>
      </script>
      {/literal}
    </div>
    <div class="panel">
      <h3>
        <i class="icon-puzzle-piece"></i>
        {l s='Module emails'}
        <span class="badge">
          <i class="icon-folder"></i>
          modules/name_of_module/mails/{$lang|strtolower}/
        </span>
      </h3>
      {foreach $module_mails as $module_name => $mails}
        {$mails['display']}
      {/foreach}
    </div>
  </form>
{/block}
