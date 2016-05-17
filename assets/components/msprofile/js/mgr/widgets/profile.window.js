msProfile.window.Customer = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: config.record.fullname,
        id: 'msprofile-window-customer',
        url: msProfile.config['connector_url'],
        baseParams: {
            action: 'mgr/profile/update'
        },
        width: 700,
        resizable: false,
        collapsible: false,
        maximizable: false,
        allowDrop: false
    });
    msProfile.window.Customer.superclass.constructor.call(this, config);
};
Ext.extend(msProfile.window.Customer, miniShop2.window.Default, {

    getFields: function (config) {
        return {
            xtype: 'modx-tabs',
            deferredRender: false,
            stateful: true,
            activeTab: 0,
            stateId: 'msprofile-window-customer',
            stateEvents: ['tabchange'],
            getState: function () {
                return {activeTab: this.items.indexOf(this.getActiveTab())};
            },
            items: [{
                title: _('ms2_profile_customer'),
                layout: 'form',
                hideMode: 'offsets',
                bodyStyle: 'padding:10px 0 0 0;',
                defaults: {msgTarget: 'under', border: false},
                items: this.getFormFields(config)
            }, {
                title: _('ms2_profile_referrals'),
                record: config.record,
                xtype: 'msprofile-grid-referrals',
                referrer_id: config.record.id
            }]
        }
    },

    getFormFields: function () {
        var fields = {
            id: {xtype: 'hidden'},
            referrer_code: {anchor: '99%'},
            account: {xtype: 'numberfield', anchor: '25%'},
            spent: {xtype: 'numberfield', anchor: '25%', disabled: true}
        };
        var res = [];
        for (var i in fields) {
            if (!fields.hasOwnProperty(i)) {
                continue;
            }
            Ext.applyIf(fields[i], {
                xtype: 'textfield',
                fieldLabel: _('ms2_profile_' + i),
                name: i,
                anchor: '99%'
            });
            res.push(fields[i]);
        }
        return res;
    }

});
Ext.reg('msprofile-window-customer', msProfile.window.Customer);