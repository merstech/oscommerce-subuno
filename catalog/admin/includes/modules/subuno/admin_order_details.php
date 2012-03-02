<?php

# Copyright 2012 MERS Technologies
# All rights reserved

# Made by Edmundo Carmona <eantoranz@gmail.com>

# This script will provide details provided by subuno about an order

# is there information in subuno's orders about this order?

$subuno_query = tep_db_query('select * from ' . TABLE_ORDERS_SUBUNO . " where order_id=" . $oID);

if (tep_db_num_rows($subuno_query) == 0) return; # no subuno information for this order

$subuno_values = tep_db_fetch_array($subuno_query);

?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><strong><?php echo SUBUNO_REF_ID; ?></strong></td>
            <td class="smallText" align="center"><strong><?php echo SUBUNO_STATUS; ?></strong></td>
          </tr>
          <tr>
            <td class="smallText" align="center">
<?php
if (! is_null($subuno_values['subuno_id']) and strlen($subuno_values['subuno_id']) > 0) {
?>
              <a target="_blank" href="https://app.subuno.com/transaction/<?php echo $subuno_values['subuno_id'] ?>"><?php echo $subuno_values['subuno_id'] ?></a>
<?php
}
?>
            </td>
            <td class="smallText" align="center">
<?php
switch (strtoupper($subuno_values['result'])) {
case 'ERROR':
	$subuno_image="error.jpg";
	$subuno_message="Error: " . $subuno_values['error_cause'];
	break;
case 'ACCEPT':
	$subuno_image="accept.jpg";
	$subuno_message="Accept";
	break;
case 'REJECT':
	$subuno_image="reject.jpg";
	$subuno_message="Reject";
	break;
case 'MANUAL_REVIEW':
	$subuno_image="manual_review.jpg";
	$subuno_message="Manual Review";
	break;
case 'REQUESTING':
	$subuno_image="requesting.jpg";
	$subuno_message="Requesting";
	break;
default:
	$subuno_image="unknown.jpg";
	$subuno_message="Unknown";
	break;
}

echo $subuno_message;

?>
            </td>
          </tr>
        </table></td>
      </tr>