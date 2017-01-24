<?php
  /**
   * @copyright Copyright © 2017 - All rights reserved.
   * @license   GNU General Public License v2.0
   */

  defined('_JEXEC') or die;
  $form_id = bin2hex( openssl_random_pseudo_bytes( 2 ) );
  $btntext = $params->get('button_text', 'PAY NOW');
?>

<div>
  <form id="<?php echo $form_id ?>" class="flw-simple-pay-now-form">
    <div id="notice"></div>

      <label class="pay-now">Email</label>
      <input class="flw-form-input-text" id="flw-customer-email" type="email" placeholder="Email" required /><br>

      <label class="pay-now">Amount</label>
      <input class="flw-form-input-text" id="flw-amount" type="text" placeholder="Amount" required /><br>

    <button value="submit" class='flw-pay-now-button' href='#'><?php echo $btntext; ?></button>
  </form>
</div>
