{* purpose of this template: albums display view in user area *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="bootstrap/`$lct`/header.tpl"}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
<div class="muimage-album muimage-display">
    {gt text='Album' assign='templateTitle'}
    {assign var='templateTitle' value=$album.title|default:$templateTitle}
    {pagesetvar name='title' value=$templateTitle|@html_entity_decode}
    {if $lct eq 'admin'}
        <div class="z-admin-content-pagetitle">
            {icon type='display' size='small' __alt='Details'}
            <h3>{$templateTitle|notifyfilters:'muimage.filter_hooks.albums.filter'}{icon id="itemActions`$album.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
            </h3>
        </div>
    {else}
        <h2>{$templateTitle|notifyfilters:'muimage.filter_hooks.albums.filter'}{icon id="itemActions`$album.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
        </h2>
    {/if}
    <div class="z-frontendcontainer">
	{if $lct eq 'user'}
	<div id="album_header">
	    {if isset($album.description) && $album.description ne null && count($album.description) > 0}
		{$album.description}<br /><br />
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
				<a title="{gt text='Load up a zip file with Pictures'}" href="{modurl modname='MUImage' type='user' func='zipUpload' ot='picture' album=$album.id returnTo='userDisplayAlbum'}"><img src="images/icons/extrasmall/folder_new.png" />{gt text='Zip-Add'}</a>
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
		    {if $coredata.user.uid eq 2 || $coredata.user.uid eq $album.createdUserId}
                <form method="post" action="{modurl modname='MUImage' type='picture' func='savePosition'}">
            {/if}
		    {include file='bootstrap/picture/include_displayItemListMany.tpl' items=$album.picture}
		    {if $coredata.user.uid eq 2 || $coredata.user.uid eq $album.createdUserId}
            <br style="clear: both; "/><input type="submit" value='{gt text="Save positions"}' />
            </form>
            {/if}
		    {/if}
		    {if $template eq 2}
		    {include file='bootstrap/picture/slideshow.tpl' items=$album.picture}
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
		        {gt text='This album is saved with a password by'}: {$username}<br /><br />
		        {gt text=$childAlbum.id assign='albumid'}
                {include file='bootstrap/album/enterPassword.tpl' id=$albumid}
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
	{/if}
	{if $lct eq 'admin'}
	    <div id=''>
            <div class="muimageRightBox">
                <h3>{gt text='Pictures'}</h3>

                {if isset($album.picture) && $album.picture ne null}
                    {include file='bootstrap/picture/include_admindisplayItemListMany.tpl' items=$album.picture}
                {/if}

                {* {checkpermission component='MUImage::' instance='.*' level='ACCESS_ADMIN' assign='authAdmin'}
                {if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
                <p class="manageLink">
                    {gt text='Create picture' assign='createTitle'}
                        <a href="{modurl modname='MUImage' type='admin' func='edit' ot='picture' album="`$album.id`" returnTo='adminDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
                            {$createTitle}
                        </a>
                     </p>
                {/if} *}
                <h3>{gt text='Album'}</h3>

                {if isset($album.parent) && $album.parent ne null}
                    {include file='bootstrap/album/include_displayItemListOne.tpl' item=$album.parent}
                {/if}

                {* {if !isset($album.parent) || $album.parent eq null}
                {checkpermission component='MUImage::' instance='.*' level='ACCESS_ADMIN' assign='authAdmin'}
                {if $authAdmin || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
                    <p class="manageLink">
                    {gt text='Create album' assign='createTitle'}
                    <a href="{modurl modname='MUImage' type='admin' func='edit' ot='album' children="`$album.id`" returnTo='adminDisplayAlbum'}" title="{$createTitle}" class="z-icon-es-add">
                        {$createTitle}
                    </a>
                    </p>
                {/if}
           {/if}*}
        </div>
	    <dl>
	        <dt>{gt text='Description'}</dt>
	        <dd>{$album.description}</dd>
	    </dl>
	    {include file='bootstrap/helper/include_categories_display.tpl' obj=$album}
	    {include file='bootstrap/helper/include_standardfields_display.tpl' obj=$album}
	    
	    </div>
	{/if}
    </div>
</div>
{include file="`$lct`/footer.tpl"}
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */

var accordion = new Zikula.UI.Accordion('basic_accordion');

        document.observe('dom:loaded', function() {
            {{assign var='itemid' value=$album.id}}
            muimageInitToggle('album', 'showTitle', '{{$itemid}}');
            muimageInitToggle('album', 'showDescription', '{{$itemid}}');
        });

/* ]]> */
</script>
