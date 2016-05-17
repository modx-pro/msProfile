<?php
/** @var array $scriptProperties */
/** @var msProfile $msProfile */
$msProfile = $modx->getService('msprofile', 'msProfile', MODX_CORE_PATH . 'components/msprofile/model/msprofile/',
    $scriptProperties
);
if (!($msProfile instanceof msProfile)) {
    return '';
}
if (!$modx->user->isAuthenticated($modx->context->key)) {
    return $modx->lexicon('ms2_profile_err_auth');
}
/** @var pdoFetch $pdoFetch */
$pdoFetch = $modx->getService('pdoFetch');
$pdoFetch->setConfig($scriptProperties);

if (empty($id)) {
    $id = $modx->user->get('id');
}

if ($profile = $modx->getObject('msCustomerProfile', $id)) {
    return empty($tpl)
        ? '<pre>' . $pdoFetch->getChunk('', $profile->toArray()) . '</pre>'
        : $pdoFetch->getChunk($tpl, $profile->toArray());
}