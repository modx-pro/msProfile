Ext.ComponentMgr.onAvailable('minishop2-orders-tabs', function () {
    this.on('beforerender', function () {
        this.add({
            title: _('msprofile'),
            id: 'msprofile-tab-profiles',
            layout: 'anchor',
            items: [{
                html: _('msprofile_intro_msg'),
                border: false,
                bodyCssClass: 'panel-desc'
            }, {
                xtype: 'msprofile-grid-profiles',
                cls: 'main-wrapper'
            }]
        });
    });
});