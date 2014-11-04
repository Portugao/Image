{* purpose of this template: albums display view in user area *}
{include file='user/header.tpl'}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
<div class="muimage-album muimage-display">
    {gt text='Album' assign='templateTitle'}
    {assign var='templateTitle' value=$album.title|default:$templateTitle}
    {pagesetvar name='title' value=$templateTitle|@html_entity_decode}
    <div class="z-frontendcontainer">
	<div id="thisalbum">
	    <h3>{$templateTitle|notifyfilters:'muimage.filter_hooks.albums.filter'}</h3>
	</div>
	<div id="album_header">
	    {if isset($album.description) && $album.description ne null && count($album.description) > 0}
		{$album.description}<br />
	    {/if}
	    {include file='helper/include_categories_display.tpl' obj=$album}
	    {if $album.createdUserId eq $coredata.user.uid}
		{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_ADD' assign='authAdmin'}
		    {if count($album._actions) gt 0}
			{strip}
			    {foreach item='option' from=$album._actions}
				{if $option.icon ne 'display'}
				    <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">
					{$option.linkText|safetext}
				    </a>&nbsp;
				{/if}
			    {/foreach}
			{/strip}
			{if $otherPictures eq true}    
			    <a title="{gt text='Load up a Picture'}" href="{modurl modname='MUImage' type='user' func='edit' ot='picture' album=$album.id returnTo='userDisplayAlbum'}"><img src="images/icons/extrasmall/edit_add.png" />{gt text='Add'}</a>
			    <a title="{gt text='Load up few Pictures'}" href="{modurl modname='MUImage' type='user' func='multiUpload' ot='picture' album=$album.id returnTo='userDisplayAlbum'}"><img src="images/icons/extrasmall/edit_add.png" /><img src="images/icons/extrasmall/edit_add.png" />{gt text='Multi-Add'}</a>
			{/if}
			&nbsp;|&nbsp;
		    {/if} 
		{/checkpermissionblock}
	    {/if}  
	    {if $modulevars.slideshow1 || $modulevars.slideshow2}
		<form class="form-inline" style="display:inline" action="{modurl modname='MUImage' type='user' func='template' id=$album.id}" method="post">
		    <label>{gt text="View as:"}</label>
		    <select id="template" name="template">
			<option value="1"{if $template eq 1} selected{/if}>Normal</option>
			{if $modulevars.slideshow1}
			    <option value="2"{if $template eq 2} selected{/if}>Slideshow</option>
			{/if}
			{if $modulevars.slideshow2}
			    <option value="3">Slideshow2</option>
			{/if}
		    </select>
		    <input type='submit' value='{gt text="Change view"}' />
		</form>
	    {/if}

	</div>
	<div id="MUImage_body">

	    <div id="basic_accordion">
		<h3 class="z-acc-header">{gt text='Pictures'}</h3>
		<div id="muimage_pictures" class="z-acc-content">
		    <div id="muimage_pictures_content">
		    {if isset($album.picture) && $album.picture ne null && count($album.picture) > 0}
		    {if $template eq 1}
		    {include file='picture/include_displayItemListMany.tpl' items=$album.picture}
		    {/if}
		    {if $template eq 2}
		    {include file='picture/slideshow.tpl' items=$album.picture}
		    {/if}
		    {else}
		    {gt text='No pictures'}
		    {/if}
		    </div>
		</div>
		{if isset($album.children) && count($album.children) > 0}    
		<h3 class="z-acc-header">{gt text='SubAlbums'}</h3> 
		<div id="muimage_albums" class="z-acc-content">
		    {foreach item='childAlbum' from=$album.children}
		    {muimageCheckAlbumAccess albumid=$childAlbum.id assign='accessThisAlbum'}
		    {if $accessThisAlbum eq 1}
			<div class="muimage_album_container">
			    <div class="muimage_album_title">
				<a title="{$childAlbum.title}" href="{modurl modname='MUImage' type='user' func='display' ot='album' id="`$childAlbum.id`"}">{$childAlbum.title|truncate:30}</a>
				<div class="muimage_display_album_title_action">
				    {if count($childAlbum._actions) gt 0}
					{strip}
					{foreach item='option' from=$childAlbum._actions}
					    {if $option.url.func == 'edit' || $option.url.func eq 'delete'}
						{if $coredata.user.uid eq $childAlbum.createdUserId}
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
			    <div class="muimage_album_description">
				{useravatar uid=$childAlbum.createdUserId size=30}
				{if $childAlbum.description}
				{$childAlbum.description}
				{else}
				{gt text='No description'}
				{/if}
			    </div>
			    {muimageGiveImageOfAlbum albumid=$childAlbum.id assign='picture'}
			    <div class="muimage_album_image" style="background: url({$picture.imageUploadFullPathURL}) no-repeat center center; background-size: cover">
			    </div>
			    <div class="muimage_album_bottom">
				{gt text='SubAlbums'}: {include file='album/include_displayItemListMany.tpl' items=$childAlbum.children}<br /> 
				{gt text='Pictures'}: {$childAlbum.id|muimageCountAlbumPictures}
			    </div>
			</div>
			{/if}
			{if $accessThisAlbum eq 2}
			<div class="muimage_album_container">
			<div class="muimage_album_title">
			    {$childAlbum.title|truncate:30}
			</div>
			<div class="muimage_album_description">
			</div>
		    <div class="muimage_album_container_form">
		        {usergetvar name='uname' uid=$childAlbum.createdUserId assign='username'}
		        <span>{gt text='This album is saved with a password by'}: {$username}<br /><br /></span>
		        {gt text=$childAlbum.id assign='albumid'}
                {include file='album/enterPassword.tpl' id=$albumid}
		    </div>
		</div>
		{/if}
		    {/foreach}
		</div>
		{/if}
	    </div>
	    <div style="clear: both"></div>

	    <div id="muimage-user-album-hooks">
		{* include display hooks *}
		{notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' id=$album.id urlobject=$currentUrlObject assign='hooks'}
		{foreach key='hookname' item='hook' from=$hooks}
		    {$hook}
		{/foreach}
	    </div>

	</div>
    </div>
</div>
{include file='user/footer.tpl'}
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */

var accordion = new Zikula.UI.Accordion('basic_accordion');

/* ]]> */
</script>
