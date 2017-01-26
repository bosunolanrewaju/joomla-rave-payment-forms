<?php
/**
 * @copyright Copyright © 2017 - All rights reserved.
 * @license   GNU General Public License v2.0
 * @generator http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

class modRavePaymentFormsHelper
{

  public static function getAjax()
  {
    $input = JFactory::getApplication()->input;
    $data  = $input->get('data', '', 'raw');
    $response = json_decode($data);

    return self::saveTransactionInfo($response);
  }

  public static function saveTransactionInfo($txData)
  {
    // Create and populate an object.
    $status_code = $txData->paymentType === 'account' ? $txData->acctvalrespcode : $txData->vbvrespcode;
    $status = $status_code === '00' ? 'successful' : 'failed';
    $redirect_key = $status === 'successful' ? 'success_url' : 'failed_url';
    $redirect_url = self::getParams($redirect_key);

    $tx = new stdClass();
    $tx->tx_ref = $txData->txRef;
    $tx->customer_email = $txData->customer->email;
    $tx->amount = $txData->amount;
    $tx->status = $txData->status;
    $tx->module = JFactory::getApplication()->input->get('title', null, 'raw');
    $tx->date = JFactory::getDate()->format('Y-m-d H:i:s');

    // Insert the object into the user profile table.
    $result = ($tx->tx_ref) ? JFactory::getDbo()->insertObject('#__ravepayments_records', $tx) : null;
    $resData = array('result' => $result, 'status' => $status, 'redirect_url' => $redirect_url );
    return $resData;
  }

  public static function getParams($key)
  {
    $rave_settings_params = JComponentHelper::getParams( 'com_ravepayments' );
    return $rave_settings_params->get($key, '');
  }

}
