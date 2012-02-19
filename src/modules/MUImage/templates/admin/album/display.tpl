{* purpose of this template: albums display view in admin area *}
{include file='admin/header.tpl'}
<div class="muimage-album muimage-display">
{gt text='Album' assign='templateTitle'}
{assign var='templateTitle' value=$album.title|default:$templateTitle}
{pagesetvar name='title' value=$templateTitle|@html_entity_decode}
<div class="z-admin-content-pagetitle">
    {icon type='display' size='small' __alt='Details'}
    <h3>{$templateTitle|notifyfilters:'muimage.filter_hooks.albums.filter'}</h3>
</div>

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
<div class="muimageRightBox">
<h3>{gt text='Pictures'}</h3>

{if isset($album.picture) && $album.picture ne null}
    {include file='admin/picture/include_displayItemListMany.tpl' items=$album.picture}
{/if}

{checkpermission component='MUImage::' instance='.*' level='ACCESS_ADMIN' assign='authAdmin'}
{if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
<p class="manageLink">
    {gt text='Create picture' assign='createTitle'}
    <a href="{modurl modname='MUImage' type='admin' func='edit' ot='picture' album="`$album.id`" returnTo='adminDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
        {$createTitle}
    </a>
</p>
{/if}
<h3>{gt text='Album'}</h3>

{if isset($album.parent) && $album.parent ne null}
    {include file='admin/album/include_displayItemListOne.tpl' item=$album.parent}
{/if}

{if !isset($album.parent) || $album.parent eq null}
{checkpermission component='MUImage::' instance='.*' level='ACCESS_ADMIN' assign='authAdmin'}
{if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
<p class="manageLink">
    {gt text='Create album' assign='createTitle'}
    <a href="{modurl modname='MUImage' type='admin' func='edit' ot='album' children="`$album.id`" returnTo='adminDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
        {$createTitle}
    </a>
</p>
{/if}
{/if}
</div>
{/if}

<dl id="MUImage_body">

    <dt>{gt text='Description'}</dt>
    <dd>{$album.description}</dd>
    
    {foreach item='childAlbum' from=$album.children}
    <div class="album_container">
    ID {$childAlbum.id}<br />
    </div>
    {/foreach}
    <dt>{gt text='Parent_id'}</dt>
    <dd>{$album.parent_id}</dd>
    <dt>{gt text='Parent'}</dt>
    <dd>
    {if isset($album.Parent) && $album.Parent ne null}
      {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        <a href="{modurl modname='MUImage' type='admin' func='display' ot='album' id=$album.Parent.id}">
            {$album.Parent.title|default:""}
        </a>
        <a id="albumItem{$album.Parent.id}Display" href="{modurl modname='MUImage' type='admin' func='display' ot='album' id=$album.Parent.id theme='Printer'}" title="{gt text='Open quick view window'}" style="display: none">
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
    </dd>
</dl>
    {include file='admin/include_categories_display.tpl' obj=$album}
    {include file='admin/include_standardfields_display.tpl' obj=$album}

{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
{if count($album._actions) gt 0}
    <p>{strip}
    {foreach item='option' from=$album._actions}
        <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">
            {$option.linkText|safetext}
        </a>
    {/foreach}
    {/strip}</p>
{/if}

{* include display hooks *}
{notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' id=$album.id urlobject=$currentUrlObject assign='hooks'}
{foreach key='hookname' item='hook' from=$hooks}
    {$hook}
{/foreach}

<br style="clear: right" />
{/if}

</div>
{include file='admin/footer.tpl'}

