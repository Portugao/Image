CKEDITOR.plugins.add('muimagemodule', {
    requires: 'popup',
    lang: 'en,nl,de',
    init: function (editor) {
        editor.addCommand('insertMUImageModule', {
            exec: function (editor) {
                var url = Routing.generate('muimagemodule_external_finder', { objectType: 'album', editor: 'ckeditor' });
                // call method in MUImageModule.Finder.js and provide current editor
                MUImageModuleFinderCKEditor(editor, url);
            }
        });
        editor.ui.addButton('muimagemodule', {
            label: editor.lang.muimagemodule.title,
            command: 'insertMUImageModule',
            icon: this.path.replace('docs/scribite/plugins/CKEditor/vendor/ckeditor/plugins/muimagemodule', 'public/images') + 'admin.png'
        });
    }
});
