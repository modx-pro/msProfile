<?php
/**
 * The home manager controller for msProfile.
 *
 */
class msProfileHomeManagerController extends msProfileMainController {
	/* @var msProfile $msProfile */
	public $msProfile;


	/**
	 * @param array $scriptProperties
	 */
	public function process(array $scriptProperties = array()) {
	}


	/**
	 * @return null|string
	 */
	public function getPageTitle() {
		return $this->modx->lexicon('msprofile');
	}


	/**
	 * @return void
	 */
	public function loadCustomCssJs() {
		$this->addJavascript($this->msProfile->config['jsUrl'] . 'mgr/widgets/items.grid.js');
		$this->addJavascript($this->msProfile->config['jsUrl'] . 'mgr/widgets/home.panel.js');
		$this->addJavascript($this->msProfile->config['jsUrl'] . 'mgr/sections/home.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			MODx.load({ xtype: "msprofile-page-home"});
		});
		</script>');
	}


	/**
	 * @return string
	 */
	public function getTemplateFile() {
		return $this->msProfile->config['templatesPath'] . 'home.tpl';
	}
}