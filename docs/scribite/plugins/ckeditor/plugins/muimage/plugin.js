CKEDITOR.plugins.add('MUImage', {
    requires: 'popup',
    lang: 'en,nl,de',
    init: function (editor) {
        editor.addCommand('insertMUImage', {
            exec: function (editor) {
                var url = Zikula.Config.baseURL + Zikula.Config.entrypoint + '?module=MUImage&type=external&func=finder&editor=ckeditor';
                // call method in MUImage_finder.js and provide current editor
                MUImageFinderCKEditor(editor, url);
            }
        });
        editor.ui.addButton('muimage', {
            label: editor.lang.MUImage.title,
            command: 'insertMUImage',
         // icon: this.path + 'images/ed_muimage.png'
            icon: '/modules/MUImage/images/muimage.png'
        });
    }
});
