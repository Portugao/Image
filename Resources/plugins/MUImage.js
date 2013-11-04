// MUImage plugin for Xinha
// developed by Michael Ueberschaer
//
// requires MUImage module (http://zikula.de)
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
        id : 'MUImage',
        tooltip : 'Insert MUImage image',
        image : _editor_url + 'plugins/MUImage/img/Editor_MUImage.gif',
        textMode : false,
        action : function (editor) {
            var url = Zikula.Config.baseURL + 'index.php'/*Zikula.Config.entrypoint*/ + '?module=MUImage&type=external&func=finderAlbum&editor=xinha';
            MUImageFinderXinha(editor, url);
        }
    });
    cfg.addToolbarElement('MUImage', 'insertimage', 1);
}

MUImage._pluginInfo = {
    name : 'MUImage for xinha',
    version : '1.2.0',
    developer : 'Michael Ueberschaer',
    developer_url : 'http://zikula.de',
    sponsor : 'ModuleStudio 0.6.0.',
    sponsor_url : 'http://modulestudio.de',
    license : 'htmlArea'
};