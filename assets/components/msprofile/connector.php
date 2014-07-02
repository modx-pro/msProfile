<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('msprofile_core_path', null, $modx->getOption('core_path') . 'components/msprofile/');
require_once $corePath . 'model/msprofile/msprofile.class.php';
$modx->msprofile = new msProfile($modx);

$modx->lexicon->load('msprofile:default');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->msprofile->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
	'processors_path' => $path,
	'location' => '',
));