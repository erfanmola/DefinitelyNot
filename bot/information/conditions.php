<?php

use OpenSwoole\Table;

$tableConditions = new Table(config['TABLE_CONDITIONS_SIZE']);
$tableConditions->column('user_id', Table::TYPE_INT, 8);
$tableConditions->column('wallet_id', Table::TYPE_INT, 8);
$tableConditions->column('type', Table::TYPE_INT, 1);
$tableConditions->column('price', Table::TYPE_FLOAT);
$tableConditions->column('amount', Table::TYPE_FLOAT);
$tableConditions->column('blockchain', Table::TYPE_STRING, 3);
$tableConditions->column('asset', Table::TYPE_STRING, 48);
$tableConditions->create();
