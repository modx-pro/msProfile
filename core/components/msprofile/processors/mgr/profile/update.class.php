<?php

class msCustomerProfileUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'msCustomerProfile';
	public $classKey = 'msCustomerProfile';
	public $languageTopics = array('msprofile','minishop2');
	public $permission = 'save_user';


	/** {@inheritDoc} */
	public function initialize() {
		if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		}

		return parent::initialize();
	}

}

return 'msCustomerProfileUpdateProcessor';