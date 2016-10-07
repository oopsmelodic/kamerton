var Ext = Ext || {};

Ext.application({
    name: 'HelloExt',
    launch: function() {
        Ext.define('Melodic',{
            config: {
                name: 'Диман',
                surname: '123'
            },
             constructor:function (config){
                this.initConfig(config);
            }
        });
        var cls = Ext.create('Melodic');
        Ext.define('Melodic.Panel', {
            alias: 'widget.melodicpanel',
            extend: 'Ext.panel.Panel',
            title: 'Персональная панель',
            html : 'Новая панель '
        });
        Ext.create('Ext.container.Viewport', {
            layout: 'fit',
            items: [
                {
                    xtype: 'melodicpanel'
                }
            ]
        });

    }
});