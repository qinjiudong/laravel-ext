Ext.define("bill.indexs", {
    extend: 'Ext.grid.Panel',
    config: {token: null},
    initComponent: function () {
        var me = this;
        me.data = Ext.create("Ext.data.Store", {
            fields: ["id", "year", "month", "date", "out", "cate", "remark"]
        });
        Ext.apply(me, {
            border: 0,
            layout: "fit",
            forceFit: true,
            store: me.data,
            tbar: [{text: 'add', handler: me.addRecords, scope: me}],
            columns: [
                {menuDisabled: true, flex: 0.2, header: 'ID', dataIndex: 'id',},
                {menuDisabled: true, flex: 0.2, header: 'YEAR', dataIndex: 'year',},
                {menuDisabled: true, flex: 0.1, header: 'MONTH', dataIndex: 'month',},
                {menuDisabled: true, flex: 0.4, header: 'DATE', dataIndex: 'date',},
                {menuDisabled: true, flex: 0.2, header: 'OUT', dataIndex: 'out',},
                {menuDisabled: true, flex: 0.1, header: 'CATE', dataIndex: 'cate',},
                {menuDisabled: true, flex: 0.8, header: 'REMARK', dataIndex: 'remark',},
            ]
        });
        me.callParent(arguments);
        me.refreshList();
    },
    addRecords: function () {
        var win = Ext.create('bill.addrecords', {parentForm: this});
        win.show();
    },
    refreshList: function () {
        var me = this;
        var store = me.data;
        store.removeAll();
        Ext.Ajax.request({
            url: 'api/list',
            params: {_token: me.token},
            success: function (response) {
                var datas = Ext.JSON.decode(response.responseText);
                store.add(datas);
            }
        });
    },
});