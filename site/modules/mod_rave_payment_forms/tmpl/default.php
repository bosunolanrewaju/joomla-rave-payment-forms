<?php
  /**
   * @copyright Copyright © 2017 - All rights reserved.
   * @license   GNU General Public License v2.0
   */

  defined('_JEXEC') or die;
  $form_id = bin2hex( openssl_random_pseudo_bytes( 2 ) );
  $btntext = $params->get('button_text', 'PAY NOW');
  if ( ! $args['pbkey'] ) return;
?>

<div>
  <form id="<?php echo $form_id ?>" class="flw-simple-pay-now-form" <?php echo $data_attr; ?>>
    <div id="notice"></div>

      <?php if ( empty($args['email']) ) : ?>

        <label class="pay-now">Email</label>
        <input class="flw-form-input-text" id="flw-customer-email" type="email" placeholder="Email" required /><br>

      <?php endif; ?>
      <?php if ( empty($args['amount']) ) : ?>

        <label class="pay-now">Amount</label>
        <input class="flw-form-input-text" id="flw-amount" type="text" placeholder="Amount" required /><br>

      <?php endif; ?>

    <button value="submit" class='flw-pay-now-button' href='#'><?php echo $btntext; ?></button>
  </form>
</div>
