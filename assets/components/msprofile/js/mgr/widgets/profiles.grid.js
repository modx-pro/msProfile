msProfile.grid.Profiles = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'msprofile-grid-profiles',
        url: msProfile.config['connector_url'],
        baseParams: {
            action: 'mgr/profile/getlist'
        }
    });
    msProfile.grid.Profiles.superclass.constructor.call(this, config);
};
Ext.extend(msProfile.grid.Profiles, miniShop2.grid.Default, {

    getFields: function () {
        return [
            'id', 'account', 'spent', 'createdon', 'referrer_id', 'fullname',
            'referrer_code', 'referrer_fullname', 'referrals', 'actions'
        ];
    },

    getColumns: function (config) {
        var columns = {
            id: {width: 35, header: _('id')},
            fullname: {
                width: 100, renderer: function (val, cell, row) {
                    return miniShop2.utils.userLink(val, row.data['id'], true);
                }
            },
            account: {width: 50},
            spent: {width: 50},
            createdon: {width: 75, renderer: miniShop2.utils.formatDate},
            referrer_fullname: {
                width: 100, renderer: function (val, cell, row) {
                    return miniShop2.utils.userLink(val, row.data['referrer_id'], true);
                }
            },
            referrals: {width: 50},
            actions: {width: 35, id: 'actions', renderer: miniShop2.utils.renderActions, sortable: false}
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

    getListeners: function () {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateProfile(grid, e, row);
            }
        };
    },

    updateProfile: function (config, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }

        var w = Ext.getCmp('msprofile-window-customer');
        if (w) {
            w.close();
        }
        w = MODx.load({
            xtype: 'msprofile-window-customer',
            id: 'msprofile-window-customer',
            config: config,
            record: this.menu.record,
            mode: 'update',
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.setValues(this.menu.record);
        w.show(e.target);
    }

});
Ext.reg('msprofile-grid-profiles', msProfile.grid.Profiles);