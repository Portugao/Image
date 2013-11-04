{* purpose of this template: albums view view in user area *}
<div class="muimage-album muimage-view">
    {gt text='Album list' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    {include file='user/header.tpl'}
    <div class="z-frontendcontainer">
	{if isset($items)}
	    {foreach item='album' from=$items}
		{if $album.parent eq NULL}
		    <div class="muimage_view_album_container">
			<div class="muimage_view_album_title">
			<a title="{$album.title}" href="{modurl modname='MUImage' type='user' func='display' ot='album' id="`$album.id`"}">{$album.title|truncate:25}</a>
			    <div class="muimage_view_album_title_action">
			    {if count($album._actions) gt 0}
				{strip}
				{foreach item='option' from=$album._actions}
				    {if $option.url.func == 'edit' || $option.url.func eq 'delete'}
					{if $coredata.user.uid eq $album.createdUserId}
					    <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>
					    {icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}
					    </a>
					{/if}            
				   {else}
					<a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>
					{icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}
					</a>                    
				   {/if}

				{/foreach}
				{/strip}
			    {/if}
			    </div>
			</div>
			    <div class="muimage_view_album_description">
			    {useravatar uid=$album.createdUserId size=30}
			    {$album.description|safehtml|truncate:100}
			    </div>
			<div class="muimage_view_album_image">
			<a title="{$album.title}" href="{modurl modname='MUImage' type='user' func='display' ot='album' id="`$album.id`"}">{include file='user/picture/include_displayItemListMany3.tpl' items=$album.picture}</a>
			</div>

			{if isset($album.children) && $album.children ne null && count($album.children) > 0}
			    <div class="muimage_view_album_bottom">
			    {gt text='SubAlbums'}: {include file='user/album/include_displayItemListMany.tpl' items=$album.children}<br />
			    {gt text='Pictures'}: {$album.picture|@count}
			    </div>
			{/if}

		    </div>
		{/if}
	    {/foreach}
	{else}
	    {gt text='No SubAlbums'}
	{/if}

	<div style="clear: both">&nbsp;</div>

	{if !isset($showAllEntries) || $showAllEntries ne 1}
	    {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page'}
	{/if}

       {* {notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' urlobject=$currentUrlObject assign='hooks'} *}
	{foreach key='hookname' item='hook' from=$hooks}
	    {$hook}
	{/foreach} 
    </div>
</div>
{include file='user/footer.tpl'}

