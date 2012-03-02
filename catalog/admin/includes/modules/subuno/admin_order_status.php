<?php

# copyright 2012 MERS technologies
# all rights reserved

# made by Edmundo Carmona <eantoranz@gmail.com>

# this will display the subuno status if there is info about the order in the subuno table

?>
<td class="dataTableContent" align="right">
<?php

# do we have information in the subuno table about this order?

$subuno_query = tep_db_query('select * from ' . TABLE_ORDERS_SUBUNO . " where order_id=" . $orders['orders_id']);

if (tep_db_num_rows($subuno_query) > 0) {
	# there is subuno info about this order
	$subuno_values = tep_db_fetch_array($subuno_query);
	$subuno_message = "";
	$subuno_image = "";
	switch (strtoupper($subuno_values['result'])) {
	case 'ERROR':
		$subuno_image="error.jpg";
		$subuno_message="Error";
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

	# let's show message for user
	echo $subuno_message;

	# how about the link?
	if (! is_null($subuno_values['subuno_id']) and strlen($subuno_values['subuno_id']) > 0) {
		echo ' <a target="_blank" href="https://app.subuno.com/transaction/' . $subuno_values['subuno_id'] . '">Details</a>';
	}
}
?>
</td>