<?php

class msCustomerOperationGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'msCustomerOperation';
	public $classKey = 'msCustomerOperation';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->where(array('user_id' => $this->getProperty('user_id')));

		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));
		$c->leftJoin('msPayment', 'Payment');
		$c->select('Payment.name as payment_name');

		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		if (empty($array['payment_name'])) {
			$array['payment_name'] = $this->modx->lexicon('no');
		}

		return $array;
	}

}

return 'msCustomerOperationGetListProcessor';