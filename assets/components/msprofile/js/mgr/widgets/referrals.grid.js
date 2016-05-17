msProfile.grid.Referrals = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'msreferral-grid-referrals',
        url: msProfile.config['connector_url'],
        cls: '',
        baseParams: {
            action: 'mgr/referral/getlist',
            referrer_id: config.referrer_id
        },
        pageSize: 5
    });
    msProfile.grid.Referrals.superclass.constructor.call(this, config);
};
Ext.extend(msProfile.grid.Referrals, miniShop2.grid.Default, {

    getFields: function () {
        return ['id', 'account', 'spent', 'createdon', 'fullname'];
    },

    getColumns: function () {
        var columns = {
            id: {width: 50, header: _('id'), hidden: true},
            fullname: {width: 100, renderer: miniShop2.utils.userLink},
            account: {width: 50},
            spent: {width: 50},
            createdon: {width: 75, renderer: miniShop2.utils.formatDate}
        };
        var res = [];
        for (var i in columns) {
            if (!columns.hasOwnProperty(i)) {
                continue;
            }
            Ext.applyIf(columns[i], {
                header: _('ms2_profile_' + i),
                dataIndex: i,
                width: 100,
                sortable: true
            });
            res.push(columns[i]);
        }
        return res;
    },

    getTopBar: function () {
        return [];
    }

});
Ext.reg('msprofile-grid-referrals', msProfile.grid.Referrals);