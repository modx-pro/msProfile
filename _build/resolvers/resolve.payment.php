<?php
/** @var xPDOObject $object */
/** @var array $options */
if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;
    /** @var miniShop2 $miniShop2 */
    if (!$miniShop2 = $modx->getService('miniShop2')) {
        $modx->log(modX::LOG_LEVEL_ERROR, '[msProfile] Could not create msProfile payment method for miniShop2');

        return false;
    }
    if (!property_exists($miniShop2, 'version') || version_compare($miniShop2->version, '2.4.0-beta2', '<')) {
        $modx->log(modX::LOG_LEVEL_ERROR, '[msProfile] You need to upgrade miniShop2 at least to version 2.4.2-beta2');

        return false;
    }
    /** @var msPayment $payment */
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            if (!$payment = $modx->getObject('msPayment', array('class' => 'CustomerAccount'))) {
                $payment = $modx->newObject('msPayment');
                $payment->fromArray(array(
                    'name' => 'CustomerAccount',
                    'active' => false,
                    'class' => 'CustomerAccount',
                    'description' => 'Method of payment orders from the account of the buyer',
                ));
                $payment->save();
            }
            $miniShop2->addService('payment', 'CustomerAccount',
                '[[+core_path]]components/msprofile/model/msprofile/customeraccount.class.php'
            );
            // Remove class from old versions
            @unlink(MODX_CORE_PATH . 'components/minishop2/custom/payment/customeraccount.class.php');
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            $modx->removeCollection('msPayment', array('name' => 'CustomerAccount'));
            $miniShop2->removeService('payment', 'CustomerAccount');
            break;
    }
}
return true;