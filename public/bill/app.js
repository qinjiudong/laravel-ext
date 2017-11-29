Ext.define("bill.app", {
    constructor: function () {
        this.createMainUI();
    },
    createMainUI: function () {
        this.vp = Ext.create("Ext.container.Viewport", {
            layout: "fit",
            padding: '1',
            items: [{
                id: 'main',
                title: 'application',
                xtype: "panel",
                layout: "fit",
                tbar: [
                    {handler: this.menuClick, text: 'index', goto: '/',},
                    {handler: this.menuClick, text: 'report', goto: 'report',},
                ]
            }]
        });
    },
    menuClick: function () {
        location.replace(this.goto);
    },
    addComp: function (comp) {
        Ext.getCmp('main').add(comp);
    },
});