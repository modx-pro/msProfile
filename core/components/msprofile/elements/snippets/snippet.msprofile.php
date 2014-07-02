<?php
/** @var array $scriptProperties */
/** @var msProfile $msProfile */
$msProfile = $modx->getService('msprofile','msProfile', MODX_CORE_PATH . 'components/msprofile/model/msprofile/', $scriptProperties);
if (!($msProfile instanceof msProfile)) return '';
if (!$modx->user->isAuthenticated($modx->context->key)) {
	return $modx->lexicon('ms2_profile_err_auth');
}
/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
if ($pdoClass = $modx->loadClass($fqn, '', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
elseif ($pdoClass = $modx->loadClass($fqn, MODX_CORE_PATH . 'components/pdotools/model/', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
else {
	$modx->log(modX::LOG_LEVEL_ERROR, 'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".');
	return false;
}

if (empty($id)) {
	$id = $modx->user->get('id');
}

if ($profile = $modx->getObject('msCustomerProfile', $id)) {
	return empty($tpl)
		? '<pre>'.$pdoFetch->getChunk('', $profile->toArray()).'</pre>'
		: $pdoFetch->getChunk($tpl, $profile->toArray());
}