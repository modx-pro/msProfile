<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

require_once MODX_CORE_PATH . 'components/msprofile/model/msprofile/msprofile.class.php';
/** @var msProfile $msProfile */
$msProfile = new msProfile($modx);

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $msProfile->config['corePath'] . 'processors/',
    'location' => '',
));