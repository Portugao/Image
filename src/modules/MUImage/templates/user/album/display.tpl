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
	{if isset($album.description) && $album.description ne null && count($album.description) > 0}
		<dt>{gt text='Description'}</dt>
		<dd>{$album.description}</dd>
	{else}
		<!-- {gt text='No description available'} -->
	{/if}
	
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

{if isset($album.parent) && $album.parent ne null && count($album.parent) > 0}
<h3>{gt text='Main Album'}</h3>
    {include file='user/album/include_displayItemListOne.tpl' item=$album.parent}
{else}
<!-- {gt text='No main album'} -->
{/if}

{* {if !isset($album.parent) || $album.parent eq null}
{checkpermission component='MUImage::' instance='.*' level='ACCESS_ADD' assign='authAdmin'}
{if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
<p class="manageLink">
    {gt text='Create album' assign='createTitle'}
    <a href="{modurl modname='MUImage' type='user' func='edit' ot='album' returnTo='userDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
        {$createTitle}
    </a>
</p>
{/if}
{/if} *}
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
    {if $album.createdUserId eq $coredata.user.uid}
    {checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_ADD' assign='authAdmin'}
    <div id="muimage_body_header">
        {if count($album._actions) gt 0}
            <p>{strip}
        {foreach item='option' from=$album._actions}
        {if $option.icon ne 'display'}
        <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">
            {$option.linkText|safetext}
        </a>
        {/if}
        {/foreach}
            {/strip}</p>
        {/if}    
    </div>
    {/checkpermissionblock} 
    {/if}    
    <div id="basic_accordion">
    <h3 class="z-acc-header">{gt text='Pictures'}</h3>
    <div id="muimage_pictures" class="z-acc-content">
   <div id="muimage_pictures_header">
    <div id="muimage_pictures_header_left">

    </div>
    </div>
  
    <div id="muimage_pictures_content">
    {if isset($album.picture) && $album.picture ne null && count($album.picture) > 0}
    {include file='user/picture/include_displayItemListMany.tpl' items=$album.picture}
    {else}
    {gt text='No pictures'}
    {/if}
    </div>
    </div>
    {if isset($album.children) && count($album.children) > 0}    
    <h3 class="z-acc-header">{gt text='SubAlbums'}</h3> 
    <div id="muimage_albums" class="z-acc-content">
    <div id="muimage_albums_header">
    <div id="muimage_albums_header_left">
    </div>

    </div>   

    {foreach item='childAlbum' from=$album.children}
    <div class="muimage_album_container">
    <div class="muimage_album_title">
    <a title="{$childAlbum.title}" href="{modurl modname='MUIMage' type='user' func='display' ot='album' id="`$childAlbum.id`"}">{$childAlbum.title|truncate:30}</a>
    <div class="muimage_display_album_title_action">
    {if $childAlbum.createdUserId eq $coredata.user.uid}
    {if count($childAlbum._actions) gt 0}
        {strip}
        {foreach item='option' from=$childAlbum._actions}
        <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>
              {icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}
        </a>
        {/foreach}
        {/strip}
    {/if}
    {/if}
    </div>
    </div>
    <div class="muimage_album_description">
    {$childAlbum.description}
    </div>
    <div class="muimage_album_image">
    {if isset($childAlbum.picture)}
    {include file='user/picture/include_displayItemListMany2.tpl' items=$childAlbum.picture}
    {else}
    <h2>{gt text='No pictures'}</h2>
    {/if}
    </div>
    <div class="muimage_album_bottom">
    {gt text='SubAlbums'}: {include file='user/album/include_displayItemListMany.tpl' items=$childAlbum.children}
    </div>
    </div>
    {/foreach}
    </div>
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
    {gt text='Total number of albums:'} {$numalbums} | {gt text='Total number of pictures:'} {$numpictures}  
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
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */

var accordion = new Zikula.UI.Accordion('basic_accordion');

/* ]]> */
</script>
