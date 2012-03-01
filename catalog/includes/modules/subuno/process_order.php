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

?>
