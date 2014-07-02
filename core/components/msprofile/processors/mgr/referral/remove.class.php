<?php
/**
 * Remove an Item
 */
class msProfileItemRemoveProcessor extends modObjectRemoveProcessor {
	public $checkRemovePermission = true;
	public $objectType = 'msProfileItem';
	public $classKey = 'msProfileItem';
	public $languageTopics = array('msprofile');

}

return 'msProfileItemRemoveProcessor';