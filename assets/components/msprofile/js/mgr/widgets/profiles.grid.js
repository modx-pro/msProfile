msProfile.grid.Profiles = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		id: 'msprofile-grid-profiles'
		,url: msProfile.config.connector_url
		,baseParams: {
			action: 'mgr/profile/getlist'
		}
		,fields: ['id', 'account','spent', 'createdon', 'referrer_id', 'referrer_code', 'fullname', 'referrer_fullname', 'referrals']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,columns: this.getColumns(config)
		,tbar: ['->',
			{
				xtype: 'textfield'
				,name: 'query'
				,width: 200
				,id: 'msprofile-profiles-search'
				,emptyText: _('ms2_search')
				,listeners: {
					render: {fn:function(tf) {tf.getEl().addKeyListener(Ext.EventObject.ENTER,function() {this.FilterByQuery(tf);},this);},scope:this}
				}
			},{
				xtype: 'button'
				,id: 'msprofile-orders-clear'
				,text: '<i class="bicon-remove-sign"></i>'
				,listeners: {
					click: {fn: this.clearFilter, scope: this}
				}
			}
		]
		,listeners: {
			rowDblClick: function(grid, rowIndex, e) {
				var row = grid.store.getAt(rowIndex);
				this.update(grid, e, row);
			}
		}
	});
	msProfile.grid.Profiles.superclass.constructor.call(this,config);
};
Ext.extend(msProfile.grid.Profiles,MODx.grid.Grid,{

	getColumns: function(config) {
		var columns = {
			id: {width: 50, header: _('id')}
			,fullname: {width: 100, renderer: this._userLink}
			,account: {width: 50}
			,spent: {width: 50}
			,createdon: {width: 75, renderer: miniShop2.utils.formatDate}
			//,referrer_id: {width: 50}
			,referrer_fullname: {width: 100, renderer: this._referrerLink}
			//,referrer_code: {width: 50}
			,referrals: {width: 50}
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

	,_referrerLink: function(val,cell,row) {
		if (!val) {return '';}
		var action = MODx.action ? MODx.action['security/user/update'] : 'security/user/update';
		var url = 'index.php?a='+action+'&id='+row.data['referrer_id'];

		return '<a href="' + url + '" target="_blank" class="ms2-link">' + val + '</a>'
	}

	,FilterByQuery: function(tf, nv, ov) {
		var s = this.getStore();
		s.baseParams.query = tf.getValue();
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}

	,clearFilter: function(btn,e) {
		var s = this.getStore();
		s.baseParams.query = '';
		Ext.getCmp('msprofile-profiles-search').setValue('');
		this.getBottomToolbar().changePage(1);
		this.refresh();
	}

	,getMenu: function() {
		var m = [];
		m.push({
			text: _('msprofile_btn_update')
			,handler: this.update
		});
		this.addContextMenuItem(m);
	}

	,update: function(config, e, row) {
		if (typeof(row) != 'undefined') {this.menu.record = row.data;}

		var w = Ext.getCmp('msprofile-window-customer');
		if (w) {w.hide().getEl().remove();}
		w = MODx.load({
			xtype: 'msprofile-window-customer'
			,config: config
			,record: this.menu.record
			,mode: 'update'
			,listeners: {
				success: {fn:function() {this.refresh();},scope:this}
			}
		});
		w.reset();
		w.setValues(this.menu.record);
		w.show(e.target);
	}

});
Ext.reg('msprofile-grid-profiles',msProfile.grid.Profiles);




msProfile.window.Customer = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		title: /*_('ms2_profile_customer') + ' ' +*/ config.record.fullname
		,id: 'msprofile-window-customer'
		//,height: 200
		,width: 550
		,url: msProfile.config.connector_url
		,action: 'mgr/profile/update'
		,fields: {
			xtype: 'modx-tabs'
			,deferredRender: false
			,stateful: true
			,activeTab: 0
			,stateId: 'msprofile-window-customer'
			,stateEvents: ['tabchange']
			,getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};}
			,items: this.getTabs(config)
		}
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
		,resizable: false
		,collapsible: false
		,maximizable: false
		,allowDrop: false
	});
	msProfile.window.Customer.superclass.constructor.call(this,config);
};
Ext.extend(msProfile.window.Customer,MODx.Window, {

	getTabs: function(config) {
		return [{
			title: _('ms2_profile_customer')
			,layout: 'form'
			,hideMode: 'offsets'
			,bodyStyle: 'padding:10px 0 0 0;'
			,defaults: {msgTarget: 'under',border: false}
			,items: this.getCustomerFields(config)
		},{
			title: _('ms2_profile_referrals')
			,record: config.record
			,xtype: 'msprofile-grid-referrals'
			,referrer_id: config.record.id
		}];
	}

	,getCustomerFields: function(config) {
		var fields = {
			id: {xtype: 'hidden'}
			,referrer_code: {anchor: '99%'}
			,account: {xtype: 'numberfield', anchor: '25%'}
			,spent: {xtype: 'numberfield', anchor: '25%', disabled: true}
		};
		var res = [];
		for (var i in fields) {
			if (!fields.hasOwnProperty(i)) {continue;}
			Ext.applyIf(fields[i], {
				xtype: 'textfield'
				,fieldLabel: _('ms2_profile_' + i)
				,name: i
				,anchor: '99%'
			});
			res.push(fields[i]);
		}
		return res;
	}

});
Ext.reg('msprofile-window-customer',msProfile.window.Customer);