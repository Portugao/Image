CKEDITOR.plugins.add('muimagemodule', {
    requires: 'popup',
    init: function (editor) {
        editor.addCommand('insertMUImageModule', {
            exec: function (editor) {
                MUImageModuleFinderOpenPopup(editor, 'ckeditor');
            }
        });
        editor.ui.addButton('muimagemodule', {
            label: 'Image',
            command: 'insertMUImageModule',
            icon: this.path.replace('scribite/CKEditor/muimagemodule', 'images') + 'admin.png'
        });
    }
});
