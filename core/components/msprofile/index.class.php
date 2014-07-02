<?php

/**
 * Class msProfileMainController
 */
abstract class msProfileMainController extends modExtraManagerController {
	/** @var msProfile $msProfile */
	public $msProfile;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('msprofile_core_path', null, $this->modx->getOption('core_path') . 'components/msprofile/');
		require_once $corePath . 'model/msprofile/msprofile.class.php';

		$this->msProfile = new msProfile($this->modx);

		$this->addCss($this->msProfile->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->msProfile->config['jsUrl'] . 'mgr/msprofile.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			msProfile.config = ' . $this->modx->toJSON($this->msProfile->config) . ';
			msProfile.config.connector_url = "' . $this->msProfile->config['connectorUrl'] . '";
		});
		</script>');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('msprofile:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends msProfileMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}