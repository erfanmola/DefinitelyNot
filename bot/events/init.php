<?php

// Initialize jettons table with predefined jettons that we support
foreach ($result['jettons'] as $jetton) {
	$tableJettons->set($jetton['contract'], $jetton);
}
