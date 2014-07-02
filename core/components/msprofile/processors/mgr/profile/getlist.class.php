<?php

class msCustomerProfileGetListProcessor extends modObjectGetListProcessor {
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
		$c->groupby($this->classKey.'.id');
		$c->select($this->modx->getSelectColumns($this->classKey, $this->classKey));

		$c->innerJoin('modUser', 'User', $this->classKey . '.id = User.id');
		$c->select('User.username');
		$c->innerJoin('modUserProfile', 'UserProfile', $this->classKey . '.id = UserProfile.internalKey');
		$c->select('UserProfile.fullname');
		$c->leftJoin('modUser', 'Referrer', $this->classKey . '.referrer_id = Referrer.id');
		$c->select('Referrer.username as referrer_username');
		$c->leftJoin('modUserProfile', 'ReferrerProfile', $this->classKey . '.referrer_id = ReferrerProfile.internalKey');
		$c->select('ReferrerProfile.fullname as referrer_fullname');

		$c->leftJoin($this->classKey, 'Referrals', $this->classKey.'.id = Referrals.referrer_id');
		$c->select('COUNT(Referrals.id) as referrals');

		if ($query = $this->getProperty('query')) {
			$c->where(array(
				'User.username:LIKE' => "%{$query}%",
				'OR:UserProfile.fullname:LIKE' => "%{$query}%",
				//'OR:Referrer.username:LIKE' => "%{$query}%",
				//'OR:ReferrerProfile.fullname:LIKE' => "%{$query}%",
			));
		}

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
		if (empty($array['referrer_fullname'])) {
			$array['referrer_fullname'] = $array['referrer_username'];
		}

		return $array;
	}

}

return 'msCustomerProfileGetListProcessor';