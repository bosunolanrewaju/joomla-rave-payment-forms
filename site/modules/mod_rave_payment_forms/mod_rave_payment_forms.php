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
$doc->addScript("//flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/flwpbf-inline.js");
$doc->addScript(JURI::root()."modules/mod_rave_payment_forms/assets/js/flw.js", 'text/javascript', true);

$rave_settings_params = JComponentHelper::getParams( 'com_ravepayments' );

if ( $rave_settings_params->get('disable_style') === "0" ) {
  $doc->addStyleSheet(JURI::root()."modules/mod_rave_payment_forms/assets/css/style.css");
}

$args = array(
  'amount'   => $params->get('amount', ''),
  'country'  => $rave_settings_params->get('country', ""),
  'currency' => $rave_settings_params->get('currency', ""),
  'desc'   => $rave_settings_params->get('modal_desc', ""),
  'module' => $module->title,
  'pbkey'  => $rave_settings_params->get('public_key', false),
  'title'  => $rave_settings_params->get('modal_title', ""),
);

$email = '';
$logo  = $rave_settings_params->get('modal_logo', "");

$use_user_email = $params->get('use_user_email');
if ($use_user_email === '1') {
  $user = JFactory::getUser();
  if (!$user->guest) {
    $email = $user->email;
  }
}

if ( ! empty($logo) ) {
  $logo = JURI::root() . $logo;
}

$args['email'] = $email;
$args['logo']  = $logo;

$data_attr = '';
foreach ($args as $att_key => $att_value) {
  $data_attr .= ' data-' . $att_key . '="' . $att_value . '"';
}

require JModuleHelper::getLayoutPath('mod_rave_payment_forms', $params->get('layout', 'default'));
