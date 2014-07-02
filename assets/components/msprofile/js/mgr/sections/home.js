msProfile.page.Home = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		components: [{
			xtype: 'msprofile-panel-home'
			,renderTo: 'msprofile-panel-home-div'
		}]
	}); 
	msProfile.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(msProfile.page.Home,MODx.Component);
Ext.reg('msprofile-page-home',msProfile.page.Home);