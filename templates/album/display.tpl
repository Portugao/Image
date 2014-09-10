{* purpose of this template: albums display view *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="`$lct`/header.tpl"}
<div class="muimage-album muimage-display with-rightbox">
    {gt text='Album' assign='templateTitle'}
    {assign var='templateTitle' value=$album->getTitleFromDisplayPattern()|default:$templateTitle}
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

    {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        <div class="muimage-rightbox">
            {if $lct eq 'admin'}
                <h4>{gt text='Pictures'}</h4>
            {else}
                <h3>{gt text='Pictures'}</h3>
            {/if}
            
            {if isset($album.picture) && $album.picture ne null}
                {include file='picture/include_displayItemListMany.tpl' items=$album.picture}
            {/if}
            
            {assign var='permLevel' value='ACCESS_EDIT'}
            {if $lct eq 'admin'}
                {assign var='permLevel' value='ACCESS_ADMIN'}
            {/if}
            {checkpermission component='MUImage:Album:' instance="`$album.id`::" level=$permLevel assign='mayManage'}
            {if $mayManage || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
            <p class="managelink">
                {gt text='Create picture' assign='createTitle'}
                <a href="{modurl modname='MUImage' type=$lct func='edit' ot='picture' album="`$album.id`" returnTo="`$lct`DisplayAlbum"'}" title="{$createTitle}" class="z-icon-es-add">{$createTitle}</a>
            </p>
            {/if}
            {if $lct eq 'admin'}
                <h4>{gt text='Albums'}</h4>
            {else}
                <h3>{gt text='Albums'}</h3>
            {/if}
            
            {if isset($album.children) && $album.children ne null}
                {include file='album/include_displayItemListMany.tpl' items=$album.children}
            {/if}
            
            {assign var='permLevel' value='ACCESS_EDIT'}
            {if $lct eq 'admin'}
                {assign var='permLevel' value='ACCESS_ADMIN'}
            {/if}
            {checkpermission component='MUImage:Album:' instance="`$album.id`::" level=$permLevel assign='mayManage'}
            {if $mayManage || (isset($uid) && isset($album.createdUserId) && $album.createdUserId eq $uid)}
            <p class="managelink">
                {gt text='Create album' assign='createTitle'}
                <a href="{modurl modname='MUImage' type=$lct func='edit' ot='album' parent="`$album.id`" returnTo="`$lct`DisplayAlbum"'}" title="{$createTitle}" class="z-icon-es-add">{$createTitle}</a>
            </p>
            {/if}
        </div>
    {/if}

    <dl>
        <dt>{gt text='Title'}</dt>
        <dd>{$album.title}</dd>
        <dt>{gt text='Description'}</dt>
        <dd>{$album.description}</dd>
        <dt>{gt text='Parent_id'}</dt>
        <dd>{$album.parent_id}</dd>
        <dt>{gt text='Album access'}</dt>
        <dd>{$album.albumAccess|muimageGetListEntry:'album':'albumAccess'|safetext}</dd>
        <dt>{gt text='My friends'}</dt>
        <dd>{$album.myFriends}</dd>
        <dt>{gt text='Password access'}</dt>
        <dd></dd>
        <dt>{gt text='Not in frontend'}</dt>
        <dd>{$album.notInFrontend|yesno:true}</dd>
        <dt>{gt text='Parent'}</dt>
        <dd>
        {if isset($album.Parent) && $album.Parent ne null}
          {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
          <a href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$album.Parent.id}">{strip}
            {$album.Parent->getTitleFromDisplayPattern()|default:""}
          {/strip}</a>
          <a id="albumItem{$album.Parent.id}Display" href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$album.Parent.id' theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" class="z-hide">{icon type='view' size='extrasmall' __alt='Quick view'}</a>
          <script type="text/javascript">
          /* <![CDATA[ */
              document.observe('dom:loaded', function() {
                  muimageInitInlineWindow($('albumItem{{$album.Parent.id}}Display'), '{{$album.Parent->getTitleFromDisplayPattern()|replace:"'":""}}');
              });
          /* ]]> */
          </script>
          {else}
            {$album.Parent->getTitleFromDisplayPattern()|default:""}
          {/if}
        {else}
            {gt text='Not set.'}
        {/if}
        </dd>
        
    </dl>
    {include file='helper/include_categories_display.tpl' obj=$album}
    {include file='helper/include_standardfields_display.tpl' obj=$album}

    {if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
        {* include display hooks *}
        {notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' id=$album.id urlobject=$currentUrlObject assign='hooks'}
        {foreach name='hookLoop' key='providerArea' item='hook' from=$hooks}
            {$hook}
        {/foreach}
        {if count($album._actions) gt 0}
            <p id="itemActions{$album.id}">
                {foreach item='option' from=$album._actions}
                    <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}" class="z-icon-es-{$option.icon}">{$option.linkText|safetext}</a>
                {/foreach}
            </p>
        
            <script type="text/javascript">
            /* <![CDATA[ */
                document.observe('dom:loaded', function() {
                    muimageInitItemActions('album', 'display', 'itemActions{{$album.id}}');
                });
            /* ]]> */
            </script>
        {/if}
        <br style="clear: right" />
    {/if}
</div>
{include file="`$lct`/footer.tpl"}
