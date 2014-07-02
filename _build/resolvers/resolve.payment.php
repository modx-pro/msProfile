<?php

if ($object->xpdo) {
	/** @var modX $modx */
	/** @var msPayment $payment */
	$modx =& $object->xpdo;
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:
			if (!$payment = $modx->getObject('msPayment', array('class' => 'CustomerAccount'))) {
				$payment = $modx->newObject('msPayment');
				$payment->fromArray(array(
					'name' => 'CustomerAccount',
					'active' => false,
					'class' => 'CustomerAccount',
					'description' => 'Method of payment orders from the customer`s account',
				));
				$payment->save();
			}
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			if ($payment = $modx->getObject('msPayment', array('name' => 'CustomerAccount'))) {
				$payment->remove();
			}
			break;
	}
}
return true;