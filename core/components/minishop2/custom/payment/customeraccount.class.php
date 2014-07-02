<?php

if (!class_exists('msPaymentInterface')) {
	require_once dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
}

class CustomerAccount extends msPaymentHandler implements msPaymentInterface {
	public $config;


	public function check(msOrder $order) {
		if ($user = $order->getOne('CustomerProfile')) {
			return $user->get('account') - $order->get('cost') >= 0;
		}

		return false;
	}


	/** @inheritdoc} */
	public function send(msOrder $order) {
		if ($order->get('status') > 1) {
			return $this->error('ms2_err_status_wrong');
		}
		if ($user = $order->getOne('CustomerProfile')) {
			if ($user->get('account') - $order->get('cost') >= 0) {
				$this->receive($order);

				return $this->success('', array('msorder' => $order->get('id')));
			}
		}
		return $this->error('ms2_profile_err_user');
	}


	public function getPaymentLink(msOrder $order) {
		return '';
	}


	/** @inheritdoc} */
	public function receive(msOrder $order, $params = array()) {
		if ($user = $order->getOne('CustomerProfile')) {
			$user->set('account', $user->get('account') - $order->get('cost'));
			if ($user->save()) {
				$order->set('type', 1);
				$order->save();
				/** @var miniShop2 $miniShop2 */
				$miniShop2 = $this->modx->getService('miniShop2');
				$miniShop2->changeOrderStatus($order->get('id'), 2);

				return true;
			}
		}
		return false;
	}

}