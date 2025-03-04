<?php

use OpenSwoole\Table;

$tableNative = new Table(2);
$tableNative->column('price', Table::TYPE_FLOAT);
$tableNative->create();

$tableNative->set('TON', ['price' => (float)0]);
$tableNative->set('SOL', ['price' => (float)0]);

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

$predefinedJettons = new Table(config['TABLE_JETTONS_SIZE']);
$predefinedJettons->create();

$predefinedTokens = new Table(config['TABLE_JETTONS_SIZE']);
$predefinedTokens->create();
