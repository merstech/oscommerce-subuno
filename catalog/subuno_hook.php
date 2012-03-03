<?php

# Copyright 2012 MERS technologies
# All rights reserved

# Made by Edmundo Carmona <eantoranz@gmail.com>

# This script will receive calls from subuno servers when a user
# has accepted/rejected a manual revision request

include('includes/application_top.php');

# Security Stuff
# @TODO will have to filter requests by IP so that requests can't be sent from other places

# what is the subuno transaction ID and the result?

$subuno_id=$_GET['ref_code'];
if (is_null($subuno_id) or strlen($subuno_id) == 0) {
	# request is not valid
	die("Empty ID");
}
# does the transaction exist?
$order_values_query=tep_db_query("select * from " . TABLE_ORDERS_SUBUNO . " where subuno_id='" . mysql_escape_string($subuno_id) . "'");
if(tep_db_num_rows($order_values_query) == 0) {
	die("Order doesn't exist");
}

# is the order in manual_review mode?
$order_values = tep_db_fetch_array($order_values_query);
if (strtoupper($order_values['result']) != "MANUAL_REVIEW") {
	die("Order is not in review!");
}

$result = strtoupper($_GET['action']);
if (is_null($result) or strlen($result) == 0) {
	die("Invalid Action");
}

if (!($result=="ACCEPT" or $result=="REJECT")) {
	die("Invalid Action");
}

# everything seems to be fine. Let's update the order
$order_values=array('result' => $result);
tep_db_perform(TABLE_ORDERS_SUBUNO, $order_values, 'update', "subuno_id='" . mysql_escape_string($subuno_id) . "'");

echo "OK";