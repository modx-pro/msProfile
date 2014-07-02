<?php

class msProfileOperationCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'msCustomerOperation';
	public $classKey = 'msCustomerOperation';
	public $languageTopics = array('msprofile','minishop2');
	public $permission = 'save';


	/** {@inheritDoc} */
	public function initialize() {
		if (!$this->modx->hasPermission($this->permission)) {
			return $this->modx->lexicon('access_denied');
		}

		return parent::initialize();
	}


	/** {@inheritDoc} */
	public function beforeSet() {
		if (!$this->getProperty('user_id')) {
			return $this->modx->lexicon('ms2_profile_err_operation_user_id');
		}
		elseif (!$this->getProperty('sum')) {
			return $this->modx->lexicon('ms2_profile_err_operation_sum');
		}

		return true;
	}


	public function beforeSave() {
		$this->object->set('createdon', date('Y-m-d H:i:s'));
		$this->object->set('status', 'new');

		return parent::beforeSave();
	}

}

return 'msProfileOperationCreateProcessor';