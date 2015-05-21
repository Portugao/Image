{* purpose of this template: header for user area *}
{pageaddvar name='javascript' value='prototype'}
{pageaddvar name='javascript' value='validation'}
{pageaddvar name='javascript' value='zikula'}
{pageaddvar name='javascript' value='livepipe'}
{pageaddvar name='javascript' value='zikula.ui'}
{pageaddvar name='javascript' value='zikula.imageviewer'}
{pageaddvar name='javascript' value='modules/MUImage/javascript/MUImage.js'}
{modgetvar module='MUImage' name='layout' assign='layout'}
{if $layout eq 'normal'}
	{pageaddvar name='stylesheet' value='modules/MUImage/style/bootstrap_boxsizing.css'}
{else}
	{if $layout eq 'bootstrap'}
	{pageaddvar name='stylesheet' value='modules/MUImage/style/bootstrap.css'}
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="modules/MUImage/Vendor/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">	
	{/if}		
{/if}
{* initialise additional gettext domain for translations within javascript *}
{pageaddvar name='jsgettext' value='module_muimage_js:MUImage'}

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
<div class="container">
<div class="row">
	<h2>{modgetinfo info='displayname'}{if $templateTitle}: {$templateTitle}{/if}</h2>
	{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_ADMIN'}
	<a href="{modurl modname='MUImage' type='admin' func='main'}" class="btn btn-warning btn-sm" role="button"><i class="fa fa-wrench"></i>
	 {gt text='Backend'}</a>
	{/checkpermissionblock}
	<a href="{modurl modname='MUImage' type='user' func='main'}" class="btn btn-primary btn-sm" role="button">{gt text='Albums'}</a>
	{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_ADMIN'}
	<a href="{modurl modname='MUImage' type='user' func='edit' ot='album'}" class="btn btn-success btn-sm" role="button">{gt text='Create Album'}</a>
	{/checkpermissionblock}
	{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_ADMIN'}
		{if $func eq 'display'}
			<a href="{modurl modname='MUImage' type='user' func='edit' ot='album' parent=$album.id returnTo='userDisplayAlbum'}" class="btn btn-success btn-sm" role="button">{gt text='Create SubAlbum'}</a>
		{/if}
	{/checkpermissionblock}
</div>
</div>
{/if}

{insert name='getstatusmsg'}
