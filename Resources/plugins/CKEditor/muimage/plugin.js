CKEDITOR.plugins.add('muimage',
{
requires: 'dialog',
lang: 'en,de',
init: function( editor )
{
editor.addCommand( 'insertMUImage',
{
exec : function( editor )
{
                    var url = Zikula.Config.baseURL + Zikula.Config.entrypoint + '?module=MUImage&type=external&func=finderAlbum&editor=ckeditor';
                    // call method in MUImage_Finder.js and also give current editor
                    MUImageFinderCKEditor(editor, url);
}
});
editor.ui.addButton(
'muimage',
            {
                label: 'Insert MUImage image',
                command: 'insertMUImage',
                icon: this.path + 'images/Editor_MUImage.gif'
            }
        );
}
} );