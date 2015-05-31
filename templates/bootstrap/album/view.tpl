{* purpose of this template: albums list view *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="bootstrap/`$lct`/header.tpl"}
{if $lct eq 'admin'}
<div class="muimage-album muimage-view">
    {gt text='Album list' assign='templateTitle'}
    {pagesetvar name='title' value=$templateTitle}
    {if $lct eq 'admin'}
        <div class="z-admin-content-pagetitle">
            {icon type='view' size='small' alt=$templateTitle}
            <h3>{$templateTitle}</h3>
        </div>
    {else}
        <h2>{$templateTitle}</h2>
    {/if}

    {if $canBeCreated}
        {checkpermissionblock component='MUImage:Album:' instance='::' level='ACCESS_EDIT'}
            {gt text='Create album' assign='createTitle'}
            <a href="{modurl modname='MUImage' type=$lct func='edit' ot='album'}" title="{$createTitle}" class="z-icon-es-add">{$createTitle}</a>
        {/checkpermissionblock}
    {/if}
    {assign var='own' value=0}
    {if isset($showOwnEntries) && $showOwnEntries eq 1}
        {assign var='own' value=1}
    {/if}
    {assign var='all' value=0}
    {if isset($showAllEntries) && $showAllEntries eq 1}
        {gt text='Back to paginated view' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type=$lct func='view' ot='album'}" title="{$linkTitle}" class="z-icon-es-view">{$linkTitle}</a>
        {assign var='all' value=1}
    {else}
        {gt text='Show all entries' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type=$lct func='view' ot='album' all=1}" title="{$linkTitle}" class="z-icon-es-view">{$linkTitle}</a>
    {/if}

    {include file='album/view_quickNav.tpl' all=$all own=$own workflowStateFilter=false}{* see template file for available options *}

    {if $lct eq 'admin'}
    <form action="{modurl modname='MUImage' type='album' func='handleSelectedEntries' lct=$lct}" method="post" id="albumsViewForm" class="z-form">
        <div>
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
    {/if}
        <table class="z-datatable">
            <colgroup>
                {if $lct eq 'admin'}
                    <col id="cSelect" />
                {/if}
                <col id="cTitle" />
                <col id="cDescription" />
               {* <col id="cParent_id" /> *}
                <col id="cAlbumAccess" />
               {* <col id="cPasswordAccess" /> *}
                <col id="cNotInFrontend" />
                <col id="cParent" />
                <col id="cItemActions" />
            </colgroup>
            <thead>
            <tr>
                {assign var='catIdListMainString' value=','|implode:$catIdList.Main}
                {if $lct eq 'admin'}
                    <th id="hSelect" scope="col" align="center" valign="middle">
                        <input type="checkbox" id="toggleAlbums" />
                    </th>
                {/if}
                <th id="hTitle" scope="col" class="z-left">
                    {sortlink __linktext='Title' currentsort=$sort modname='MUImage' type=$lct func='view' sort='title' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString parent=$parent workflowState=$workflowState albumAccess=$albumAccess searchterm=$searchterm pageSize=$pageSize notInFrontend=$notInFrontend ot='album'}
                </th>
                <th id="hDescription" scope="col" class="z-left">
                    {sortlink __linktext='Description' currentsort=$sort modname='MUImage' type=$lct func='view' sort='description' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString parent=$parent workflowState=$workflowState albumAccess=$albumAccess searchterm=$searchterm pageSize=$pageSize notInFrontend=$notInFrontend ot='album'}
                </th>
               {* <th id="hParent_id" scope="col" class="z-right">
                    {sortlink __linktext='Parent_id' currentsort=$sort modname='MUImage' type=$lct func='view' sort='parent_id' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString parent=$parent workflowState=$workflowState albumAccess=$albumAccess searchterm=$searchterm pageSize=$pageSize notInFrontend=$notInFrontend ot='album'}
                </th> *}
                <th id="hAlbumAccess" scope="col" class="z-left">
                    {sortlink __linktext='Album access' currentsort=$sort modname='MUImage' type=$lct func='view' sort='albumAccess' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString parent=$parent workflowState=$workflowState albumAccess=$albumAccess searchterm=$searchterm pageSize=$pageSize notInFrontend=$notInFrontend ot='album'}
                </th>
               {* <th id="hPasswordAccess" scope="col" class="z-left">
                    {sortlink __linktext='Password access' currentsort=$sort modname='MUImage' type=$lct func='view' sort='passwordAccess' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString parent=$parent workflowState=$workflowState albumAccess=$albumAccess searchterm=$searchterm pageSize=$pageSize notInFrontend=$notInFrontend ot='album'}
                </th> *}
                <th id="hNotInFrontend" scope="col" class="z-center">
                    {sortlink __linktext='Not in frontend' currentsort=$sort modname='MUImage' type=$lct func='view' sort='notInFrontend' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString parent=$parent workflowState=$workflowState albumAccess=$albumAccess searchterm=$searchterm pageSize=$pageSize notInFrontend=$notInFrontend ot='album'}
                </th>
                <th id="hParent" scope="col" class="z-left">
                    {sortlink __linktext='Parent' currentsort=$sort modname='MUImage' type=$lct func='view' sort='parent' sortdir=$sdir all=$all own=$own catidMain=$catIdListMainString parent=$parent workflowState=$workflowState albumAccess=$albumAccess searchterm=$searchterm pageSize=$pageSize notInFrontend=$notInFrontend ot='album'}
                </th>
                <th id="hItemActions" scope="col" class="z-right z-order-unsorted">{gt text='Actions'}</th>
            </tr>
            </thead>
            <tbody>
        
        {foreach item='album' from=$items}
            <tr class="{cycle values='z-odd, z-even'}">
                {if $lct eq 'admin'}
                    <td headers="hselect" align="center" valign="top">
                        <input type="checkbox" name="items[]" value="{$album.id}" class="albums-checkbox" />
                    </td>
                {/if}
                <td headers="hTitle" class="z-left">
                    <a href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$album.id}" title="{gt text='View detail page'}">{$album.title|notifyfilters:'muimage.filterhook.albums'}</a>
                </td>
                <td headers="hDescription" class="z-left">
                    {if $album.description ne ''}
                        {$album.description}
                    {else}
                        {gt text='No description'}
                    {/if}
                </td>
               {* <td headers="hParent_id" class="z-right">
                    {$album.parent_id}
                </td> *}
                <td headers="hAlbumAccess" class="z-left">
                    {$album.albumAccess|muimageGetListEntry:'album':'albumAccess'|safetext}
                </td>
               {* <td headers="hPasswordAccess" class="z-left">
                    {$album.passwordAccess}
                </td> *}
                <td headers="hNotInFrontend" class="z-center">
                    {$album.notInFrontend|yesno:true}
                </td>
                <td headers="hParent" class="z-left">
                    {if isset($album.Parent) && $album.Parent ne null}
                        <a href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$album.Parent.id}">{strip}
                          {$album.Parent->getTitleFromDisplayPattern()|default:""}
                        {/strip}</a>
                        <a id="albumItem{$album.id}_rel_{$album.Parent.id}Display" href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$album.Parent.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" class="z-hide">{icon type='view' size='extrasmall' __alt='Quick view'}</a>
                        <script type="text/javascript">
                        /* <![CDATA[ */
                            document.observe('dom:loaded', function() {
                                muimageInitInlineWindow($('albumItem{{$album.id}}_rel_{{$album.Parent.id}}Display'), '{{$album.Parent->getTitleFromDisplayPattern()|replace:"'":""}}');
                            });
                        /* ]]> */
                        </script>
                    {else}
                        {gt text='Not set.'}
                    {/if}
                </td>
                <td id="itemActions{$album.id}" headers="hItemActions" class="z-right z-nowrap z-w02">
                    {if count($album._actions) gt 0}
                        {icon id="itemActions`$album.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
                        {foreach item='option' from=$album._actions}
                            <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>{icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}</a>
                        {/foreach}
                    
                        <script type="text/javascript">
                        /* <![CDATA[ */
                            document.observe('dom:loaded', function() {
                                muimageInitItemActions('album', 'view', 'itemActions{{$album.id}}');
                            });
                        /* ]]> */
                        </script>
                    {/if}
                </td>
            </tr>
        {foreachelse}
            <tr class="z-{if $lct eq 'admin'}admin{else}data{/if}tableempty">
              <td class="z-left" colspan="{if $lct eq 'admin'}8{else}7{/if}">
            {gt text='No albums found.'}
              </td>
            </tr>
        {/foreach}
        
            </tbody>
        </table>
        
        {if !isset($showAllEntries) || $showAllEntries ne 1}
            {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page' modname='MUImage' type=$lct func='view' ot='album' lct=$lct}
        {/if}
    {if $lct eq 'admin'}
            <fieldset>
                <label for="mUImageAction">{gt text='With selected albums'}</label>
                <select id="mUImageAction" name="action">
                    <option value="">{gt text='Choose action'}</option>
                    <option value="delete" title="{gt text='Delete content permanently.'}">{gt text='Delete'}</option>
                </select>
                <input type="submit" value="{gt text='Submit'}" />
            </fieldset>
        </div>
    </form>
    {/if}

    
    {if $lct ne 'admin'}
        {notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' urlobject=$currentUrlObject assign='hooks'}
        {foreach key='providerArea' item='hook' from=$hooks}
            {$hook}
        {/foreach}
    {/if}
</div>
{include file="`$lct`/footer.tpl"}

<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        {{if $lct eq 'admin'}}
            {{* init the "toggle all" functionality *}}
            if ($('toggleAlbums') != undefined) {
                $('toggleAlbums').observe('click', function (e) {
                    Zikula.toggleInput('albumsViewForm');
                    e.stop()
                });
            }
        {{/if}}
    });
/* ]]> */
</script>
{/if}

{if $lct eq 'user'}
    <div class="container-fluid album-bootstrap-view">
	{if isset($items)}
	    <ul class="row">
	    {foreach item='album' from=$items}
		{if $album.parent eq NULL}
		    {muimageCheckAlbumAccess albumid=$album.id assign='accessThisAlbum'}
		    {if $accessThisAlbum eq 1}
		    <li class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
		    <div class="thumbnail">
			{muimageGiveImageOfAlbum albumid=$album.id assign='albumpicture'}
			{if $albumpicture}

			<a data-placement="top" data-toggle="tooltip" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$album.id}" title="{$album.title}{if $album.description ne ''} - {$album.description}{/if}">
        		<img src="{thumb image=$albumpicture.imageUploadFullPath width=300 height=200 mode='outset' extension='jpg'}" alt="">
    		</a>
    		{else}
    		<a data-placement="top" data-toggle="tooltip" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$album.id}" title="{$album.title}{if $album.description ne ''} - {$album.description}{/if}">	
    			<img src="modules/MUImage/images/placeholder.png" width="300" height="200" />
    		</a>
    		{/if}    		 		
    			<div class="caption">	
    			{checkpermissionblock component='MUImage::' instance='.*' level='ACCESS_EDIT'}
    			{muimageCheckGroupMember createdUserId=$album.createdUserId assign='groupMember'}
    				{if $coredata.user.uid eq $album.createdUserId || $groupMember eq 1}		
    					<a title="{gt text='Edit}" href="{modurl modname='MUImage' type='user' func='edit' ot='album' id=$album.id}">
    						<i class="fa fa-pencil-square-o fa-2x"></i>
    					</a>
    				{/if}
    			{/checkpermissionblock}	
    			<div style="min-height: 30px; max-height: 30px; overflow: auto;">		
				{if isset($album.children) && $album.children ne null && count($album.children) > 0}			    
			    	{gt text='SubAlbums'}: {include file='bootstrap/album/include_displayItemListMany.tpl' items=$album.children}    
				{else}
					{gt text='No SubAlbums'}
				{/if}
				</div>
				<p>
				{gt text='Pictures'}: {$album.picture|@count}
            	</p>			
    			</div>			
			</div>
		    </li>
		{/if}

		{/if}
	    {/foreach}
	    {foreach item='album' from=$items}
	    {muimageCheckAlbumAccess albumid=$album.id assign='accessThisAlbum'}
		{if $accessThisAlbum eq 2}
		<li class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
		<div class="thumbnail">
		<span style="width: 300px; heigt: 200px; background: url(modules/MUImage/images/placeholder.png) no-repeat center center; background-size: cover;">
		        {usergetvar name='uname' uid=$album.createdUserId assign='username'}
		        {gt text='This album is saved with a password by'}: {$username}<br /><br />
		        {gt text=$album.id assign='albumid'}
                {include file='bootstrap/album/enterPassword.tpl' id=$albumid}		
		</span>
   		</div>
   		</li>
		{/if}	    
	    {/foreach}
	    </ul>
	{else}
	    {gt text='No SubAlbums'}
	{/if}
	</div>
	<div style="clear: both">&nbsp;</div>

	{if !isset($showAllEntries) || $showAllEntries ne 1}
	    {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page'}
	{/if}

       {* {notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' urlobject=$currentUrlObject assign='hooks'} *}
	{foreach key='hookname' item='hook' from=$hooks}
	    {$hook}
	{/foreach} 
    </div>

{include file='bootstrap/user/footer.tpl'}
{/if}
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */

    var MU = jQuery.noConflict();
	MU(document).ready(function(MU) {	
    {{if $coredata.user.uid eq 2 || $coredata.user.uid eq $item.createdUserId}}
        MU(function() {
            MU( "#sortable" ).sortable();
        });
    {{/if}}
    
    	MU(function () {
			MU('[data-toggle="tooltip"]').tooltip()
		})
		});
    /* ]]> */
</script>
