<?php

use OpenSwoole\Table;

$tableJettons = new Table(config['TABLE_JETTONS_SIZE']);
$tableJettons->column('name', Table::TYPE_STRING, 64);
$tableJettons->column('symbol', Table::TYPE_STRING, 12);
$tableJettons->column('address', Table::TYPE_STRING, 48);
$tableJettons->column('price', Table::TYPE_FLOAT);
$tableJettons->column('active', Table::TYPE_INT, 1);
$tableJettons->create();

$tableTokens = new Table(config['TABLE_TOKENS_SIZE']);
$tableTokens->column('name', Table::TYPE_STRING, 64);
$tableTokens->column('symbol', Table::TYPE_STRING, 12);
$tableTokens->column('address', Table::TYPE_STRING, 48);
$tableTokens->column('price', Table::TYPE_FLOAT);
$tableTokens->column('active', Table::TYPE_INT, 1);
$tableTokens->create();
