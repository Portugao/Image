CKEDITOR.plugins.add('muimage', {
    requires: 'popup',
    lang: 'en,nl,de',
    init: function (editor) {
        editor.addCommand('insertMUImage', {
            exec: function (editor) {
                var url = Zikula.Config.baseURL + Zikula.Config.entrypoint + '?module=MUImage&type=external&func=finder&objectType=picture&editor=ckeditor&album=1';
                // call method in MUImage_finder.js and provide current editor
                MUImageFinderCKEditor(editor, url);
            }
        });
        editor.ui.addButton('muimage', {
            label: editor.lang.muimage.title,
            command: 'insertMUImage',
         // icon: this.path + 'images/ed_muimage.png'
            icon: '/modules/MUImage/images/muimage.png'
        });
    }
});
