<?php

/**
 * The base class for msProfile.
 */
class msProfile {
	/** @var modX $modx */
	public $modx;
	/** @var miniShop2 $ms2 */
	public $ms2;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('msprofile_core_path', $config, $this->modx->getOption('core_path') . 'components/msprofile/');
		$assetsUrl = $this->modx->getOption('msprofile_assets_url', $config, $this->modx->getOption('assets_url') . 'components/msprofile/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
				'assetsUrl' => $assetsUrl,
				'cssUrl' => $assetsUrl . 'css/',
				'jsUrl' => $assetsUrl . 'js/',
				'imagesUrl' => $assetsUrl . 'images/',
				'connectorUrl' => $connectorUrl,

				'corePath' => $corePath,
				'modelPath' => $corePath . 'model/',
				'chunksPath' => $corePath . 'elements/chunks/',
				'templatesPath' => $corePath . 'elements/templates/',
				'chunkSuffix' => '.chunk.tpl',
				'snippetsPath' => $corePath . 'elements/snippets/',
				'processorsPath' => $corePath . 'processors/'
			), $config
		);

		$this->modx->addPackage('msprofile', $this->config['modelPath']);
		$this->modx->lexicon->load('msprofile:default');

		if ($this->ms2 = $modx->getService('miniShop2')) {
			$this->ms2->initialize($this->modx->context->key);
		}
		else {
			$this->modx->log(modX::LOG_LEVEL_ERROR, 'msProfile requires installed miniShop2.');
		}
	}


	/**
	 * @param array $data
	 *
	 * @return array|string
	 */
	public function createPayment(array $data) {
		if (!$this->modx->user->isAuthenticated($this->modx->context->key)) {
			return $this->ms2->error($this->modx->lexicon('ms2_profile_err_auth'));
		}
		// Call system event
		$response = $this->ms2->invokeEvent('msOnSubmitOrder', array(
				'data' => $data,
				'order' => $this->ms2->order
			)
		);
		if (!$response['success']) {
			return $this->ms2->error($response['message']);
		}
		if (!empty($response['data']['data'])) {
			$data = array_merge($data, $response['data']['data']);
			$this->ms2->order->set($data);
		}
		// Check required fields
		$errors = array();
		if (empty($data['sum']) || $data['sum'] < $this->config['minSum']) {
			$errors['sum'] = $this->modx->lexicon('ms2_profile_err_min_sum', array('min_sum' => $this->config['minSum']));
		}
		elseif (!empty($maxSum) && $data['sum'] > $this->config['maxSum']) {
			$errors['sum'] = $this->modx->lexicon('ms2_profile_err_max_sum', array('max_sum' => $this->config['maxSum']));
		}
		if (empty($data['payment'])) {
			$errors['payment'] = $this->modx->lexicon('ms2_profile_err_payment', array('min_sum' => $this->config['minSum']));
		}
		if (!empty($errors)) {
			return $this->ms2->error($this->modx->lexicon('ms2_profile_err_form'), $errors);
		}

		// Create new order
		/** @var msOrder $order */
		$order = $this->modx->newObject('msOrder', array(
				'user_id' => $this->modx->user->id,
				'createdon' => date('Y-m-d H:i:s'),
				'num' => $this->ms2->order->getnum(),
				'delivery' => 0,
				'payment' => $data['payment'],
				'cart_cost' => $data['sum'],
				'weight' => 0,
				'delivery_cost' => 0,
				'cost' => $data['sum'],
				'status' => 0,
				'context' => $this->ms2->config['ctx'],
				'properties' => array('account_charge' => true)
			)
		);

		$products = array(
			$this->modx->newObject('msOrderProduct', array(
					'product_id' => 0,
					'name' => $this->modx->lexicon('ms2_profile_charge'),
					'price' => $data['sum'],
					'cost' => $data['sum'],
				)
			)
		);
		$order->addMany($products);

		$response = $this->ms2->invokeEvent('msOnBeforeCreateOrder', array(
				'msOrder' => $order,
				'order' => $this->ms2->order
			)
		);
		if (!$response['success']) {
			return $this->ms2->error($response['message']);
		}

		if ($order->save()) {
			$response = $this->ms2->invokeEvent('msOnCreateOrder', array(
					'msOrder' => $order,
					'order' => $this->ms2->order
				)
			);
			if (!$response['success']) {
				return $this->ms2->error($response['message']);
			}

			if (empty($_SESSION['minishop2']['orders'])) {
				$_SESSION['minishop2']['orders'] = array();
			}
			$_SESSION['minishop2']['orders'][] = $order->get('id');

			// Trying to set status "new"
			$response = $this->ms2->changeOrderStatus($order->get('id'), 1);
			if ($response !== true) {
				return $this->ms2->error($response, array('msorder' => $order->get('id')));
			}
			/* @var msPayment $payment */
			elseif ($payment = $this->modx->getObject('msPayment', array('id' => $order->get('payment')))) {
				$response = $payment->send($order);
				if (!empty($response['data']['redirect'])) {
					$this->modx->sendRedirect($response['data']['redirect']);
				}
				elseif (!empty($response['data']['msorder'])) {
					$this->modx->sendRedirect($this->modx->context->makeUrl($this->modx->resource->id, array('msorder' => $response['data']['msorder'])));
				}
				else {
					$this->modx->sendRedirect($this->modx->context->makeUrl($this->modx->resource->id));
				}
			}
			else {
				$this->modx->sendRedirect($this->modx->context->makeUrl($this->modx->resource->id, array('msorder' => $response['data']['msorder'])));
			}
		}
	}

}