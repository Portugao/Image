{* purpose of this template: pictures list view *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="`$lct`/header.tpl"}
<div class="muimage-picture muimage-view">
    {gt text='Picture list' assign='templateTitle'}
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
        {checkpermissionblock component='MUImage:Picture:' instance='::' level='ACCESS_EDIT'}
            {gt text='Create picture' assign='createTitle'}
            <a href="{modurl modname='MUImage' type=$lct func='edit' ot='picture'}" title="{$createTitle}" class="z-icon-es-add">{$createTitle}</a>
        {/checkpermissionblock}
    {/if}
    {assign var='own' value=0}
    {if isset($showOwnEntries) && $showOwnEntries eq 1}
        {assign var='own' value=1}
    {/if}
    {assign var='all' value=0}
    {if isset($showAllEntries) && $showAllEntries eq 1}
        {gt text='Back to paginated view' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type=$lct func='view' ot='picture'}" title="{$linkTitle}" class="z-icon-es-view">{$linkTitle}</a>
        {assign var='all' value=1}
    {else}
        {gt text='Show all entries' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type=$lct func='view' ot='picture' all=1}" title="{$linkTitle}" class="z-icon-es-view">{$linkTitle}</a>
    {/if}

    {include file='picture/view_quickNav.tpl' all=$all own=$own workflowStateFilter=false}{* see template file for available options *}

    {if $lct eq 'admin'}
    <form action="{modurl modname='MUImage' type='picture' func='handleSelectedEntries' lct=$lct}" method="post" id="picturesViewForm" class="z-form">
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
                <col id="cShowTitle" />
                <col id="cShowDescription" />
                <col id="cImageUpload" />
                <col id="cImageView" />
                <col id="cAlbumImage" />
                <col id="cPos" />
                <col id="cAlbum" />
                <col id="cItemActions" />
            </colgroup>
            <thead>
            <tr>
                {if $lct eq 'admin'}
                    <th id="hSelect" scope="col" align="center" valign="middle">
                        <input type="checkbox" id="togglePictures" />
                    </th>
                {/if}
                <th id="hTitle" scope="col" class="z-left">
                    {sortlink __linktext='Title' currentsort=$sort modname='MUImage' type=$lct func='view' sort='title' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hDescription" scope="col" class="z-left">
                    {sortlink __linktext='Description' currentsort=$sort modname='MUImage' type=$lct func='view' sort='description' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hShowTitle" scope="col" class="z-center">
                    {sortlink __linktext='Show title' currentsort=$sort modname='MUImage' type=$lct func='view' sort='showTitle' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hShowDescription" scope="col" class="z-center">
                    {sortlink __linktext='Show description' currentsort=$sort modname='MUImage' type=$lct func='view' sort='showDescription' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hImageUpload" scope="col" class="z-left">
                    {sortlink __linktext='Image upload' currentsort=$sort modname='MUImage' type=$lct func='view' sort='imageUpload' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hImageView" scope="col" class="z-right">
                    {sortlink __linktext='Image view' currentsort=$sort modname='MUImage' type=$lct func='view' sort='imageView' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hAlbumImage" scope="col" class="z-center">
                    {sortlink __linktext='Album image' currentsort=$sort modname='MUImage' type=$lct func='view' sort='albumImage' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hPos" scope="col" class="z-right">
                    {sortlink __linktext='Pos' currentsort=$sort modname='MUImage' type=$lct func='view' sort='pos' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hAlbum" scope="col" class="z-left">
                    {sortlink __linktext='Album' currentsort=$sort modname='MUImage' type=$lct func='view' sort='album' sortdir=$sdir all=$all own=$own album=$album workflowState=$workflowState searchterm=$searchterm pageSize=$pageSize showTitle=$showTitle showDescription=$showDescription albumImage=$albumImage ot='picture'}
                </th>
                <th id="hItemActions" scope="col" class="z-right z-order-unsorted">{gt text='Actions'}</th>
            </tr>
            </thead>
            <tbody>
        
        {foreach item='picture' from=$items}
            <tr class="{cycle values='z-odd, z-even'}">
                {if $lct eq 'admin'}
                    <td headers="hselect" align="center" valign="top">
                        <input type="checkbox" name="items[]" value="{$picture.id}" class="pictures-checkbox" />
                    </td>
                {/if}
                <td headers="hTitle" class="z-left">
                    <a href="{modurl modname='MUImage' type=$lct func='display' ot='picture'  id=$picture.id}" title="{gt text='View detail page'}">{$picture.title|notifyfilters:'muimage.filterhook.pictures'}</a>
                </td>
                <td headers="hDescription" class="z-left">
                    {$picture.description}
                </td>
                <td headers="hShowTitle" class="z-center">
                    {assign var='itemid' value=$picture.id}
                    <a id="toggleShowTitle{$itemid}" href="javascript:void(0);" class="z-hide">
                    {if $picture.showTitle}
                        {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title='This setting is enabled. Click here to disable it.'}
                        {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title='This setting is disabled. Click here to enable it.' class='z-hide'}
                    {else}
                        {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title='This setting is enabled. Click here to disable it.' class='z-hide'}
                        {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title='This setting is disabled. Click here to enable it.'}
                    {/if}
                    </a>
                    <noscript><div id="noscriptShowTitle{$itemid}">
                        {$picture.showTitle|yesno:true}
                    </div></noscript>
                </td>
                <td headers="hShowDescription" class="z-center">
                    {assign var='itemid' value=$picture.id}
                    <a id="toggleShowDescription{$itemid}" href="javascript:void(0);" class="z-hide">
                    {if $picture.showDescription}
                        {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title='This setting is enabled. Click here to disable it.'}
                        {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title='This setting is disabled. Click here to enable it.' class='z-hide'}
                    {else}
                        {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title='This setting is enabled. Click here to disable it.' class='z-hide'}
                        {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title='This setting is disabled. Click here to enable it.'}
                    {/if}
                    </a>
                    <noscript><div id="noscriptShowDescription{$itemid}">
                        {$picture.showDescription|yesno:true}
                    </div></noscript>
                </td>
                <td headers="hImageUpload" class="z-left">
                      <a href="{$picture.imageUploadFullPathURL}" title="{$picture->getTitleFromDisplayPattern()|replace:"\"":""}"{if $picture.imageUploadMeta.isImage} rel="imageviewer[picture]"{/if}>
                      {if $picture.imageUploadMeta.isImage}
                          {thumb image=$picture.imageUploadFullPath objectid="picture-`$picture.id`" preset=$pictureThumbPresetImageUpload tag=true img_alt=$picture->getTitleFromDisplayPattern()}
                      {else}
                          {gt text='Download'} ({$picture.imageUploadMeta.size|muimageGetFileSize:$picture.imageUploadFullPath:false:false})
                      {/if}
                      </a>
                </td>
                <td headers="hImageView" class="z-right">
                    {$picture.imageView}
                </td>
                <td headers="hAlbumImage" class="z-center">
                    {$picture.albumImage|yesno:true}
                </td>
                <td headers="hPos" class="z-right">
                    {$picture.pos}
                </td>
                <td headers="hAlbum" class="z-left">
                    {if isset($picture.Album) && $picture.Album ne null}
                        <a href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$picture.Album.id}">{strip}
                          {$picture.Album->getTitleFromDisplayPattern()|default:""}
                        {/strip}</a>
                        <a id="albumItem{$picture.id}_rel_{$picture.Album.id}Display" href="{modurl modname='MUImage' type=$lct func='display' ot='album'  id=$picture.Album.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" class="z-hide">{icon type='view' size='extrasmall' __alt='Quick view'}</a>
                        <script type="text/javascript">
                        /* <![CDATA[ */
                            document.observe('dom:loaded', function() {
                                muimageInitInlineWindow($('albumItem{{$picture.id}}_rel_{{$picture.Album.id}}Display'), '{{$picture.Album->getTitleFromDisplayPattern()|replace:"'":""}}');
                            });
                        /* ]]> */
                        </script>
                    {else}
                        {gt text='Not set.'}
                    {/if}
                </td>
                <td id="itemActions{$picture.id}" headers="hItemActions" class="z-right z-nowrap z-w02">
                    {if count($picture._actions) gt 0}
                        {icon id="itemActions`$picture.id`Trigger" type='options' size='extrasmall' __alt='Actions' class='z-pointer z-hide'}
                        {foreach item='option' from=$picture._actions}
                            <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>{icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}</a>
                        {/foreach}
                    
                        <script type="text/javascript">
                        /* <![CDATA[ */
                            document.observe('dom:loaded', function() {
                                muimageInitItemActions('picture', 'view', 'itemActions{{$picture.id}}');
                            });
                        /* ]]> */
                        </script>
                    {/if}
                </td>
            </tr>
        {foreachelse}
            <tr class="z-{if $lct eq 'admin'}admin{else}data{/if}tableempty">
              <td class="z-left" colspan="{if $lct eq 'admin'}11{else}10{/if}">
            {gt text='No pictures found.'}
              </td>
            </tr>
        {/foreach}
        
            </tbody>
        </table>
        
        {if !isset($showAllEntries) || $showAllEntries ne 1}
            {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page' modname='MUImage' type=$lct func='view' ot='picture' lct=$lct}
        {/if}
    {if $lct eq 'admin'}
            <fieldset>
                <label for="mUImageAction">{gt text='With selected pictures'}</label>
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
        {notifydisplayhooks eventname='muimage.ui_hooks.pictures.display_view' urlobject=$currentUrlObject assign='hooks'}
        {foreach key='providerArea' item='hook' from=$hooks}
            {$hook}
        {/foreach}
    {/if}
</div>
{include file="`$lct`/footer.tpl"}

<script type="text/javascript">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
        {{foreach item='picture' from=$items}}
            {{assign var='itemid' value=$picture.id}}
            muimageInitToggle('picture', 'showTitle', '{{$itemid}}');
            muimageInitToggle('picture', 'showDescription', '{{$itemid}}');
        {{/foreach}}
        {{if $lct eq 'admin'}}
            {{* init the "toggle all" functionality *}}
            if ($('togglePictures') != undefined) {
                $('togglePictures').observe('click', function (e) {
                    Zikula.toggleInput('picturesViewForm');
                    e.stop()
                });
            }
        {{/if}}
    });
/* ]]> */
</script>
