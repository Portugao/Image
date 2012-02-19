{* purpose of this template: albums display view in user area *}
{include file='user/header.tpl'}
<div class="muimage-album muimage-display">
{gt text='Album' assign='templateTitle'}
{assign var='templateTitle' value=$album.title|default:$templateTitle}
{pagesetvar name='title' value=$templateTitle|@html_entity_decode}
<div class="z-frontendcontainer">
<div id="thisalbum">
    <h2>{gt text='Album'}: {$templateTitle|notifyfilters:'muimage.filter_hooks.albums.filter'}</h2>
</div>
<div id="album_header">
<div id="albumLeftBox">
    <dt>{gt text='Description'}</dt>
    <dd>{$album.description}</dd>
    {include file='user/include_categories_display.tpl' obj=$album}
</div>
{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
<div class="muimageRightBox">

{checkpermission component='MUImage::' instance='.*' level='ACCESS_ADMIN' assign='authAdmin'}
{* {if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
<p class="manageLink">
    {gt text='Create picture' assign='createTitle'}
    <a href="{modurl modname='MUImage' type='user' func='edit' ot='picture' album="`$album.id`" returnTo='userDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
        {$createTitle}
    </a>
</p>
{/if} *}
<h3>{gt text='Main Album'}</h3>

{if isset($album.parent) && $album.parent ne null}
    {include file='user/album/include_displayItemListOne.tpl' item=$album.parent}
{/if}

{if !isset($album.parent) || $album.parent eq null}
{checkpermission component='MUImage::' instance='.*' level='ACCESS_ADMIN' assign='authAdmin'}
{if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
<p class="manageLink">
    {gt text='Create album' assign='createTitle'}
    <a href="{modurl modname='MUImage' type='user' func='edit' ot='album' children="`$album.id`" returnTo='userDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
        {$createTitle}
    </a>
</p>
{/if}
{/if}
{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}


{* include display hooks *}
{notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' id=$album.id urlobject=$currentUrlObject assign='hooks'}
{foreach key='hookname' item='hook' from=$hooks}
    {$hook}
{/foreach}

<br style="clear: right" />
{/if}
</div>
{/if}
</div>

<div id="MUImage_body">
    <div id="muimage_body_header">
{if count($album._actions) gt 0}
    <p>{strip}
    {foreach item='option' from=$album._actions}
        <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">
            {$option.linkText|safetext}
        </a>
    {/foreach}
    {/strip}</p>
{/if}    
    </div>
    <div id="muimage_pictures">
    <div id="muimage_pictures_header">
    <div id="muimage_pictures_header_left">
    <h3>{gt text='Pictures'}</h3>
    </div>
    <div class="muimage_add_picture">
    {if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
    <p class="manageLink">
    {gt text='Create picture' assign='createTitle'}
    <a href="{modurl modname='MUImage' type='user' func='edit' ot='picture' album="`$album.id`" returnTo='userDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
        {$createTitle}
    </a>
    </p>
    {/if}
    </div>
    </div>
    <div id="muimage_pictures_content">
    {if isset($album.picture) && $album.picture ne null}
    {include file='user/picture/include_displayItemListMany.tpl' items=$album.picture}
    {/if}
    </div>
    </div>
    <div id="muimage_albums">
    <div id="muimage_albums_header">
    <div id="muimage_albums_header_left">
    <h3>{gt text='SubAlbums'}</h3> 
    </div>
    <div id="muimage_add_album">
    {if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
    <p class="manageLink">
    {gt text='Create subalbum' assign='createTitle'}
    <a href="{modurl modname='MUImage' type='user' func='edit' ot='album' children="`$album.id`" returnTo='userDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
        {$createTitle}
    </a>
    </p>
    {/if}
    </div>
    </div>   
    {if isset($album.children)}
    {foreach item='childAlbum' from=$album.children}
    <div class="muimage_album_container">
    <div class="muimage_album_title">
    <a href="{modurl modname='MUIMage' type='user' func='display' ot='album' id="`$childAlbum.id`"}">{$childAlbum.title}</a>
    </div>
    <div class="muimage_album_description">
    {$childAlbum.description}
    </div>
    <div class="muimage_album_image">
    {$childAlbum.id|muimageGetFirstAlbumImage:$childAlbum.id}
    </div>
    <div class="muimage_album_bottom">
    {$childAlbum.description}
    </div>
    </div>
    {/foreach}
    {else}
    {gt text='No SubAlbums'}
    {/if}
    
    </div>
    <div style="clear: both">
  {*  <dt>{gt text='Parent'}</dt>
    <dd>
    {if isset($album.Parent) && $album.Parent ne null}
      {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        <a href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$album.Parent.id}">
            {$album.Parent.title|default:""}
        </a>
        <a id="albumItem{$album.Parent.id}Display" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$album.Parent.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
            {icon type='view' size='extrasmall' __alt='Quick view'}
        </a>
        <script type="text/javascript" charset="utf-8">
        /* <![CDATA[ */
            document.observe('dom:loaded', function() {
                muimageInitInlineWindow($('albumItem{{$album.Parent.id}}Display'), '{{$album.Parent.title|replace:"'":""}}');
            });
        /* ]]> */
        </script>
      {else}
        {$album.Parent.title|default:""}
      {/if}
    {else}
        {gt text='No set.'}
    {/if}
    </dd> *}
    <div id="muimage_body_footer">
    <h6>{gt text='Total number of albums:'} {$numalbums} | {gt text='Total number of pictures:'} {$numpictures}</h6>   
    </div>
</div>
   {* {include file='user/include_standardfields_display.tpl' obj=$album} *}

{* {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
{if count($album._actions) gt 0}
    <p>{strip}
    {foreach item='option' from=$album._actions}
        <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">
            {$option.linkText|safetext}
        </a>
    {/foreach}
    {/strip}</p>
{/if} *}

{* include display hooks *}
{* {notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' id=$album.id urlobject=$currentUrlObject assign='hooks'}
{foreach key='hookname' item='hook' from=$hooks}
    {$hook}
{/foreach}

<br style="clear: right" />
{/if} *}

</div>
</div>
{include file='user/footer.tpl'}

