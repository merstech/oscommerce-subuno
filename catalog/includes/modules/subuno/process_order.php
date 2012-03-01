<?php

# Copyright 2012 MERS Technologies
# All rights reserved

# Made by Edmundo Carmona <eantoranz@gmail.com>

# this script is called when a new order has been placed
# so that we could send a request to subuno about it

# almost all information about the order is in $order
# order id is in $insert_id

require(DIR_WS_MODULES . "subuno/subuno.php");

# let's make a request about information for this order
$subuno_order_info = array(
	't_id' => $insert_id,
	'ip_addr' => $_SERVER['REMOTE_ADDR'],
	'customer_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
	'phone' => $order->customer['telephone'],
	'email' => $order->customer['email_address'],
	'price' => $order->info['currency_value'], # @TODO Consider currencies!!!!
	'iin' => '', # @TODO first digits of the credit card
	'bill_street1' => $order->billing['street_address'],
	'bill_city' => $order->billing['city'],
	'bill_state' => $order->billing['state'],
	'bill_country' => $order->billing['country']['title'],
	'bill_zip' => $order->billing['postcode'], # @TODO is it the right field?
	'ship_street1' => $order->delivery['street_address'],
	'ship_city' => $order->delivery['city'],
	'ship_state' => $order->delivery['state'],
	'ship_country' => $order->delivery['country']['title']
	# @TODO no shipping zip?
);

try {
	# let's try to do the request
	$subuno_response = $subuno->run($subuno_order_info);
	# it ran successfully
	# let's save the results on the DB
} catch (Exception $e) {
	# it failed miserably, let's save the results on the DB
	
}
?>
