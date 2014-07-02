<?php

switch ($modx->event->name) {

	case 'OnManagerPageBeforeRender':
		/** @var modManagerController $controller */
		$controller->msProfile = $msProfile = $modx->getService('msprofile','msProfile', MODX_CORE_PATH . 'components/msprofile/model/msprofile/');
		$controller->addLexiconTopic('msprofile:default');

		$controller->addJavascript($msProfile->config['jsUrl'] . 'mgr/msprofile.js');
		$controller->addLastJavascript($msProfile->config['jsUrl'] . 'mgr/widgets/profiles.grid.js');
		$controller->addLastJavascript($msProfile->config['jsUrl'] . 'mgr/widgets/referrals.grid.js');
		$controller->addHtml('<script type="text/javascript">
		msProfile.config = '.$modx->toJSON($msProfile->config).';
		msProfile.config.connector_url = "'.$msProfile->config['connectorUrl'].'";
		Ext.ComponentMgr.onAvailable("minishop2-orders-tabs", function() {
			this.on("beforerender", function() {
				this.add({
					title: _("msprofile")
					,id: "msprofile-tab-profiles"
					,items: [{
						html: _("msprofile_intro_msg")
						,border: false
						,bodyCssClass: "panel-desc"
						,bodyStyle: "margin-bottom: 10px"
					},{
						xtype: "msprofile-grid-profiles"
						,preventRender: true
					}]
				});
			});
			Ext.apply(this, {
				activeTab: 0
				,stateful: true
				,stateId: "minishop2-orders-tabs"
				,stateEvents: ["tabchange"]
				,getState: function() {
					return {
						activeTab:this.items.indexOf(this.getActiveTab())
					};
				}
			});
		});
		</script>');
		break;

	case 'msOnChangeOrderStatus':
		if (empty($status) || $status != 2) {return;}
		/** @var msOrder $order */
		$properties = $order->get('properties');
		if (empty($properties['account_charge'])) {return;}
		/** @var modUser $user */
		elseif ($user = $order->getOne('User')) {
			/** @var msCustomerProfile $profile */
			if ($profile = $order->getOne('CustomerProfile')) {
				$profile->set('account', $profile->get('account') + $order->get('cost'));
				$profile->save();
			}
			unset($properties['account_charge']);
			$order->set('properties', $properties);
			$order->save();
		}
		break;

	case 'msOnBeforeCreateOrder':
		/** @var msOrder $msOrder */
		if ($payment = $msOrder->getOne('Payment')) {
			$class = $payment->get('class');
			if (preg_match('/^CustomerAccount/i', $class)) {
				/** @var msPayment $payment */
				$payment->loadHandler();
				if ($payment->handler instanceof CustomerAccount && !$payment->handler->check($msOrder)) {
					$modx->lexicon->load('msprofile:default');
					$modx->event->output($modx->lexicon('ms2_profile_err_balance'));
				}
			}
		}
		break;

}