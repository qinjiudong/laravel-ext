Ext.define('bill.addrecords', {
    extend: "Ext.window.Window",
    config: {parentForm: null},
    resetForm: function () {
        this.form.getForm().reset();
    },
    saveForm: function () {
        var me = this;
        var form = me.form;
        if (form.isValid()) {
            form.submit({
                success: function (form, action) {
                    form.reset();
                    me.parentForm.refreshList();
                },
                failure: function (form, action) {
                    Ext.Msg.alert('error', action.result.msg);
                }
            });
        }
    },
    initComponent: function () {
        var me = this;
        me.form = Ext.create('Ext.form.Panel', {
            bodyPadding: 10,
            defaultType: 'textfield',
            url: 'api/add',
            buttons: [
                {text: '重置', scope: me, handler: me.resetForm,},
                {text: '保存', scope: me, handler: me.saveForm, formBind: true,}
            ],
            items: [
                {
                    xtype: 'datefield',
                    fieldLabel: '日期',
                    name: 'day',
                    format: 'Y-m-d',
                    allowBlank: false,
                },
                {
                    xtype: 'timefield',
                    fieldLabel: '时间',
                    name: 'time',
                    format: 'H:i:s',
                    allowBlank: false,
                }, {
                    xtype: 'numberfield',
                    fieldLabel: '金额',
                    name: 'out',
                    allowBlank: false,
                }, {
                    xtype: 'combo',
                    fieldLabel: '类型',
                    store: Ext.create('Ext.data.Store', {
                        fields: ['id', 'name'],
                        proxy: {
                            type: 'ajax',
                            url: 'api/cate',
                            getMethod: function () {
                                return 'POST';
                            },
                            extraParams: {_token: me.parentForm.token},
                        },
                        autoLoad: true
                    }),

                    value: 1,
                    editable: false,
                    queryMode: 'local',
                    displayField: 'name',
                    valueField: 'id',
                    name: 'cate',
                }, {
                    xtype: 'textfield',
                    fieldLabel: '备注',
                    name: 'remark',
                }, {
                    xtype: "hidden",
                    name: "_token",
                    value: me.parentForm.token
                }
            ]
        });
        Ext.apply(me, {
            title: 'add',
            modal: true,
            items: [me.form]
        });
        me.callParent(arguments);
    },
});            