CKEDITOR.plugins.add('MUImage', {
    requires: 'popup',
    lang: 'en,nl,de',
    init: function (editor) {
        editor.addCommand('insertMUImage', {
            exec: function (editor) {
                var url = Zikula.Config.baseURL + Zikula.Config.entrypoint + '?module=MUImage&type=external&func=finder&editor=ckeditor&album=0';
                // call method in MUImage_Finder.js and also give current editor
                MUImageFinderCKEditor(editor, url);
            }
        });
        editor.ui.addButton('muimage', {
            label: 'Insert MUImage object',
            command: 'insertMUImage',
         // icon: this.path + 'images/ed_muimage.png'
            icon: '/images/icons/extrasmall/favorites.png'
        });
    }
});
