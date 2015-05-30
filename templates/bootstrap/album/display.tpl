{* purpose of this template: albums display view in user area *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="bootstrap/`$lct`/header.tpl"}

<div class="container">
	<div class="row">
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
    </div>
    <div class="row">
	{if $lct eq 'user'}
	    {if isset($album.description) && $album.description ne null && count($album.description) > 0}
		{$album.description}<br /><br />
	    {/if}
	    {include file='bootstrap/helper/include_categories_display.tpl' obj=$album}
	    {muimageCheckGroupMember createdUserId=$album.createdUserId assign='groupMember'}
	    {if $album.createdUserId eq $coredata.user.uid || $groupMember eq 1}
			{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_ADD' assign='authAdmin'}
				<div id="action-for-albums" class="col-md-3">
				<div style="z-index: 5000;" class="btn-group">
  					<a class="btn btn-default" href="#"><i class="fa fa-user fa-fw"></i>{gt text='Actions for this album'}</a>
  					<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
    				<span class="fa fa-caret-down"></span></a>
  					<ul class="dropdown-menu">
  						<li><a href="{modurl modname='MUImage' type='user' func='edit' ot='album' id=$album.id}"><i class="fa fa-pencil fa-fw"></i> {gt text='Edit'}</a></li>
  						<li><a href="{modurl modname='MUImage' type='user' func='delete' ot='album' id=$album.id returnTo='userDisplayAlbum'}"><i class="fa fa-trash-o fa-fw"></i> {gt text='Delete'}</a></li>
  						{if $otherPictures eq true}
    						<li><a href="{modurl modname='MUImage' type='user' func='edit' ot='picture' album=$album.id returnTo='userDisplayAlbum'}"><i class="fa fa-upload fa-fw"></i> {gt text='Add'}</a></li>  				
    						<li><a href="{modurl modname='MUImage' type='user' func='multiUpload' ot='picture' album=$album.id returnTo='userDisplayAlbum'}"><i class="fa fa-upload fa-fw"></i> {gt text='Multi-Add'}</a></li>
    						<li><a href="{modurl modname='MUImage' type='user' func='zipUpload' ot='picture' album=$album.id returnTo='userDisplayAlbum'}"><i class="fa fa-file-archive-o fa-fw"></i> {gt text='Zip-Add'}</a></li>
  						{/if}
  					</ul>
				</div>
				</div>
			{/checkpermissionblock}
	    {/if}  
	    {if $modulevars.slideshow1 || $modulevars.slideshow2}
	    <div id="select-view-album" class="col-md-9">
		<form class="form-inline" style="display:inline" action="{modurl modname='MUImage' type='user' func='template' id=$album.id}" method="post">
		    <label>{gt text="View as:"}</label>
		    <select id="template" class="form-control" name="template">
			<option value="1"{if $template eq 1} selected{/if}>Normal</option>
			{if $modulevars.slideshow1}
			    <option value="2"{if $template eq 2} selected{/if}>Slideshow</option>
			{/if}
			{if $modulevars.slideshow2}
			    <option value="3">Slideshow2</option>
			{/if}
		    </select>
		    <button type="submit" class="btn btn-default">{gt text="Change view"}</button>
		</form>
		</div>
	    {/if}


	<div id="muimage-user-bootstrap-body" class="col-xs-12">
	
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="überschriftEins">
      <h4 class="panel-title">     
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseEins" aria-expanded="true" aria-controls="collapseEins">
          {gt text='Pictures'}
        </a>
        <span class="caret"></span> 
      </h4>
    </div>
    <div id="collapseEins" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="überschriftEins">
      <div id="muimage-pictures-content" class="collapse panel-body in">
		    {if isset($album.picture) && $album.picture ne null && count($album.picture) > 0}
		    {if $template eq 1}
		    {muimageCheckGroupMember createdUserId=$album.createdUserId assign='groupMember'}
		    {if $coredata.user.uid eq 2 || $coredata.user.uid eq $album.createdUserId || $groupMember eq 1}
                <form method="post" action="{modurl modname='MUImage' type='picture' func='savePosition'}">
            {/if}
		    {include file='bootstrap/picture/include_displayItemListMany.tpl' items=$album.picture}
		    
		    {if $coredata.user.uid eq 2 || $coredata.user.uid eq $album.createdUserId || $groupMember eq 1}
            	<br style="clear: both; "/> <button type="submit" class="btn btn-default">{gt text="Save positions"}</button>
     	        </form>
            {/if}
		    {/if}
		    {if $template eq 2}
		    {include file='bootstrap/picture/slideshow.tpl' items=$album.picture}
		    {/if}
		    {else}
		    {gt text='No pictures'}
		    {/if}      </div>
    </div>
  </div>
  {if isset($album.children) && count($album.children) > 0}  
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="überschriftZwei">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseZwei" aria-expanded="false" aria-controls"collapseZwei">
          {gt text='SubAlbums'}
        </a>
        <span class="caret"></span>
      </h4>
    </div>
    <div id="collapseZwei" class="panel-collapse collapse" role="tabpanel" aria-labelledby="überschriftZwei">
      <div class="panel-body">
		{if isset($album.children) && count($album.children) > 0}
			<ul>    
		    {foreach item='childAlbum' from=$album.children}
		    {muimageCheckAlbumAccess albumid=$childAlbum.id assign='accessThisAlbum'}
		    {if $accessThisAlbum eq 1}
		    	<li class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
		    	<div class="thumbnail">
				{muimageGiveImageOfAlbum albumid=$childAlbum.id assign='albumpicture'}
				{if $albumpicture}
					<a data-placement="top" data-toggle="tooltip" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$childAlbum.id}" title="{$childAlbum.title}{if $album.description ne ''} - {$album.description}{/if}">
        				<img src="{thumb image=$albumpicture.imageUploadFullPath width=200 height=125 mode='outset' extension='jpg'}" alt="">
    				</a>
    			{else}
    				<a data-placement="top" data-toggle="tooltip" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$childAlbum.id}" title="{$childAlbum.title}{if $album.description ne ''} - {$album.description}{/if}">	
    				<img src="modules/MUImage/images/placeholder.png" width="200" height="125" />
    			</a>
    		{/if}    		 		
    		<div class="caption">	
    		{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_EDIT'}
    		{muimageCheckGroupMember createdUserId=$album.createdUserId assign='groupMember'}
    		{if $coredata.user.uid eq $album.createdUserId || $groupMember eq 1}		
    			<a title="{gt text='Edit}" href="{modurl modname='MUImage' type='user' func='edit' ot='album' id=$childAlbum.id}">
    				<i class="fa fa-pencil-square-o fa-2x"></i>
    			</a>
    		{/if}
    		{/checkpermissionblock}
    		<p>
				{gt text='SubAlbums'}: {include file='album/include_displayItemListMany.tpl' items=$childAlbum.children}<br /> 
				{gt text='Pictures'}: {$childAlbum.id|muimageCountAlbumPictures}
			</p>				
    		</div>			
			</div>
		    </li>
			{/if}

		    {/foreach}
		    {foreach item='childAlbum' from=$album.children}
		    	{muimageCheckAlbumAccess albumid=$childAlbum.id assign='accessThisAlbum'}
				{if $accessThisAlbum eq 2}
					<li class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
						<div class="thumbnail">
						<span style="font-size: 0.85em;" style="width: 200px; heigt: 125px; background: url(modules/MUImage/images/placeholder.png) no-repeat center center; background-size: cover;">
		        		{usergetvar name='uname' uid=$childAlbum.createdUserId assign='username'}
		        		{gt text='This album is saved with a password by'}: {$username}<br /><br />
		        		{gt text=$childAlbum.id assign='albumid'}
                		{include file='bootstrap/album/enterPassword.tpl' id=$albumid}		
						</span>
   						</div>
   					</li>
				{/if}		    
		    {/foreach}
		    </ul>
		{/if}
	    </div>
     </div>
    </div>
  </div>
</div>
{/if}

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
	    {include file='helper/include_categories_display.tpl' obj=$album}
	    {include file='helper/include_standardfields_display.tpl' obj=$album}
	    
	    </div>
	{/if}
    </div>
</div>
{include file="bootstrap/`$lct`/footer.tpl"}
