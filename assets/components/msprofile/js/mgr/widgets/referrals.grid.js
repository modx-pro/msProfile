msProfile.grid.Referrals = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		id: 'msreferral-grid-referrals'
		,url: msProfile.config.connector_url
		,baseParams: {
			action: 'mgr/referral/getlist'
			,referrer_id: config.referrer_id
		}
		,fields: ['id', 'account','spent', 'createdon', 'fullname']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,columns: this.getColumns(config)
		,pageSize: 5
	});
	msProfile.grid.Referrals.superclass.constructor.call(this,config);
};
Ext.extend(msProfile.grid.Referrals,MODx.grid.Grid,{

	getColumns: function(config) {
		var columns = {
			id: {width: 50, header: _('id'), hidden: true}
			,fullname: {width: 100, renderer: this._userLink}
			,account: {width: 50}
			,spent: {width: 50}
			,createdon: {width: 75, renderer: miniShop2.utils.formatDate}
		};
		var res = [];
		for (var i in columns) {
			if (!columns.hasOwnProperty(i)) {continue;}
			Ext.applyIf(columns[i], {
				header: _('ms2_profile_' + i)
				,dataIndex: i
				,width: 100
				,sortable: true
			});
			res.push(columns[i]);
		}
		return res;
	}

	,_userLink: function(val,cell,row) {
		if (!val) {return '';}
		var action = MODx.action ? MODx.action['security/user/update'] : 'security/user/update';
		var url = 'index.php?a='+action+'&id='+row.data['id'];

		return '<a href="' + url + '" target="_blank" class="ms2-link">' + val + '</a>'
	}

});
Ext.reg('msprofile-grid-referrals',msProfile.grid.Referrals);