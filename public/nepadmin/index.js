layui.extend({admin:'lay/modules/admin'}).define(['admin','conf'],function(exports){
    //解决 IE8 不支持console
    window.console = window.console || (function () {
        var c = {}; c.log = c.warn = c.debug = c.info = c.error = c.time = c.dir = c.profile
        = c.clear = c.exception = c.trace = c.assert = function () { };
        return c;
    })();
    layui.admin.initPage();
    exports('index',{});
});


if(_config.autoRefresh) {
                     _config.elem.find('div.layui-tab-content > div').eq(tabIndex).children('iframe')[0].contentWindow.location = data.href;
                    /*_config.elem.find('div.layui-tab-content > div').eq(tabIndex).children('iframe')[0].contentWindow.location.reload();*/
                }