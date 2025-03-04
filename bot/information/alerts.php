<?php

use OpenSwoole\Table;

$tableAlerts = new Table(config['TABLE_ALERTS_SIZE']);
$tableAlerts->column('user_id', Table::TYPE_INT, 8);
$tableAlerts->column('type', Table::TYPE_INT, 1);
$tableAlerts->column('price', Table::TYPE_FLOAT);
$tableAlerts->column('blockchain', Table::TYPE_STRING, 3);
$tableAlerts->column('asset', Table::TYPE_STRING, 48);
$tableAlerts->create();
