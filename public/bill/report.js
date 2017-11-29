Ext.define("bill.report", {
    extend: 'Ext.panel.Panel',
    config: {token: null},
    border: 0,
    layout: 'border',
    initComponent: function () {
        var me = this;
        me.chartStore = Ext.create('Ext.data.Store', {
            fields: ['name', 'data'],
        });
        me.dataChart = Ext.create('Ext.chart.Chart', {
            width: 1000,
            height: 300,

            store: me.chartStore,
            axes: [
                {type: 'Numeric', position: 'left', fields: ['data'], title: 'recent 30 days',},
                {type: 'Category', position: 'bottom', fields: ['name'],}
            ],
            series: [{
                type: 'column',
                xField: 'name',
                yField: 'data',
                label: {display: 'outside', field: 'data',},
            }]
        });

        me.listStore = Ext.create("Ext.data.Store", {
            fields: ["name", "data"]
        });
        me.listGrid = Ext.create("Ext.grid.Panel", {
            forceFit: true,
            store: me.listStore,
            columns: [
                {menuDisabled: true,flex:0.3, header: 'name', dataIndex: 'name',},
                {menuDisabled: true,flex:0.7, header: 'data', dataIndex: 'data',},
            ]
        });

        Ext.apply(me, {
            items: [
                {items: [me.dataChart], region: 'south',},
                {items: [me.listGrid], region: 'center',},
            ],
        });
        me.callParent(arguments);
        me.getListData();
        me.getChartData();
    },
    getChartData: function () {
        var store = this.chartStore;
        store.removeAll();
        Ext.Ajax.request({
            url: 'api/chart',
            params: {_token: this.token},
            success: function (response) {
                var datas = Ext.JSON.decode(response.responseText);
                store.add(datas);
            }
        });
    },
    getListData: function () {
        var store = this.listStore;
        store.removeAll();
        Ext.Ajax.request({
            url: 'api/report',
            params: {_token: this.token},
            success: function (response) {
                var datas = Ext.JSON.decode(response.responseText);
                store.add(datas);
            }
        });
    },
});