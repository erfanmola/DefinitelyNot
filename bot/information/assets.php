<?php

use OpenSwoole\Table;

$tableJettons = new Table(config['TABLE_JETTONS_SIZE']);
$tableJettons->column('name', OpenSwoole\Table::TYPE_STRING, 64);
$tableJettons->column('symbol', OpenSwoole\Table::TYPE_STRING, 12);
$tableJettons->column('contract', OpenSwoole\Table::TYPE_STRING, 48);
$tableJettons->create();
