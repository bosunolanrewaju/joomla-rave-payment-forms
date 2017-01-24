<?php
/**
 * @copyright	Copyright © 2017 - All rights reserved.
 * @license		GNU General Public License v2.0
 */
defined('_JEXEC') or die;

include_once __DIR__ . '/helper.php';

$doc        = JFactory::getDocument();
$loadJquery = $params->get('loadJquery', 1);

// Load jQuery
if ($loadJquery == '1') {
  $doc->addScript('//code.jquery.com/jquery-latest.min.js');
}

// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_rave_payment_forms/assets/css/style.css");
$doc->addScript("//flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/flwpbf-inline.js");
$doc->addScript(JURI::root()."modules/mod_rave_payment_forms/assets/js/flw.js", 'text/javascript', true);

$country  = $params->get('country', "");
$currency = $params->get('currency', "");
$desc     = $params->get('modal_desc', "");
$format   = $params->get('format', 'json');
$logo     = $params->get('modal_logo', "");
$module_title = $module->title;
$public_key   = $params->get('public_key', false);
$title        = $params->get('modal_title', "");

$js = <<<JS
  flw_rave_options = {
    country   : '{$country}',
    currency  : '{$currency}',
    desc      : '{$desc}',
    logo      : '{$logo}',
    pbkey     : '{$public_key}',
    title     : '{$title}',
  };

  function saveResponse(data, cb) {
    // var objData = Object.assign({}, data, {module_title: $module_title})
    var request = {
            'data'   :  JSON.stringify(data),
            'format' : '{$format}',
            'module' : 'rave_payment_forms',
            'option' : 'com_ajax',
            'title'  : '{$module_title}',
          };

    jQuery.ajax({
      data   : request,
      type   : 'POST',
      success: function (response) {
        cb(response.data, null);
      },
      error: function(err) {
        cb(null, err);
      }
    });
  }
JS;

$doc->addScriptDeclaration($js);

require JModuleHelper::getLayoutPath('mod_rave_payment_forms', $params->get('layout', 'default'));
