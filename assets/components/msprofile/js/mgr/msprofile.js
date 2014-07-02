var msProfile = function(config) {
	config = config || {};
	msProfile.superclass.constructor.call(this,config);
};
Ext.extend(msProfile,Ext.Component,{
	page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('msprofile',msProfile);

msProfile = new msProfile();