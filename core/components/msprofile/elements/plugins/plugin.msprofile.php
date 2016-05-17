<?php

switch ($modx->event->name) {

    case 'OnManagerPageBeforeRender':
        if ($_GET['a'] == 'mgr/orders' && $_GET['namespace'] == 'minishop2') {
            /** @var msProfile $msProfile */
            $msProfile = $modx->getService('msprofile', 'msProfile',
                MODX_CORE_PATH . 'components/msprofile/model/msprofile/'
            );
            $msProfile->loadManagerFiles($modx->controller);
        }
        break;

    case 'msOnChangeOrderStatus':
        if (empty($status) || $status != 2) {
            return;
        }
        /** @var msOrder $order */
        $properties = $order->get('properties');
        if (empty($properties['account_charge'])) {
            return;
        } /** @var modUser $user */
        elseif ($user = $order->getOne('User')) {
            /** @var msCustomerProfile $profile */
            if ($profile = $order->getOne('CustomerProfile')) {
                $profile->set('account', $profile->get('account') + $order->get('cost'));
                $profile->save();
            }
            unset($properties['account_charge']);
            $order->set('properties', $properties);
            $order->save();
        }
        break;

    case 'msOnBeforeCreateOrder':
        /** @var msOrder $msOrder */
        if ($payment = $msOrder->getOne('Payment')) {
            $class = $payment->get('class');
            if (preg_match('/^CustomerAccount/i', $class)) {
                /** @var msPayment $payment */
                $payment->loadHandler();
                if ($payment->handler instanceof CustomerAccount && !$payment->handler->check($msOrder)) {
                    $modx->lexicon->load('msprofile:default');
                    $modx->event->output($modx->lexicon('ms2_profile_err_balance'));
                }
            }
        }
        break;

}