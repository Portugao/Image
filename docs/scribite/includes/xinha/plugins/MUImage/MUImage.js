// MUImage plugin for Xinha
// developed by Michael Ueberschaer
//
// requires MUImage module (http://www.webdesign-in-bremen.com)
//
// Distributed under the same terms as xinha itself.
// This notice MUST stay intact for use (see license.txt).

'use strict';

function MUImage(editor) {
    var cfg, self;

    this.editor = editor;
    cfg = editor.config;
    self = this;

    cfg.registerButton({
        id       : 'MUImage',
        tooltip  : 'Insert MUImage object',
     // image    : _editor_url + 'plugins/MUImage/img/ed_MUImage.gif',
        image    : '/modules/MUImage/images/muimage.png',
        textMode : false,
        action   : function (editor) {
            var url = Zikula.Config.baseURL + 'index.php'/*Zikula.Config.entrypoint*/ + '?module=MUImage&type=external&func=finder&editor=xinha';
            MUImageFinderXinha(editor, url);
        }
    });
    cfg.addToolbarElement('MUImage', 'insertimage', 1);
}

MUImage._pluginInfo = {
    name          : 'MUImage for xinha',
    version       : '1.3.0',
    developer     : 'Michael Ueberschaer',
    developer_url : 'http://www.webdesign-in-bremen.com',
    sponsor       : 'ModuleStudio 0.6.2',
    sponsor_url   : 'http://modulestudio.de',
    license       : 'htmlArea'
};
