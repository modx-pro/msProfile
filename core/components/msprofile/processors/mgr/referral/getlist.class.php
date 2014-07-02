<?php

class msCustomerReferralGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'msCustomerProfile';
	public $classKey = 'msCustomerProfile';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->where(array('referrer_id' => $this->getProperty('referrer_id')));

		$c->groupby($this->classKey.'.id');
		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));

		$c->innerJoin('modUser', 'User', $this->classKey . '.id = User.id');
		$c->select('User.username');
		$c->innerJoin('modUserProfile', 'UserProfile', $this->classKey . '.id = UserProfile.internalKey');
		$c->select('UserProfile.fullname');

		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();
		if (empty($array['fullname'])) {
			$array['fullname'] = $array['username'];
		}

		return $array;
	}

}

return 'msCustomerReferralGetListProcessor';