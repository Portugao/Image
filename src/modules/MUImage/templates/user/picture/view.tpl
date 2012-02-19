{* purpose of this template: pictures view view in user area *}
<div class="muimage-picture muimage-view">
{include file='user/header.tpl'}
{gt text='Picture list' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>


    {checkpermissionblock component='MUImage::' instance='.*' level="ACCESS_ADD"}
        {gt text='Create picture' assign='createTitle'}
        <a href="{modurl modname='MUImage' type='user' func='edit' ot='picture'}" title="{$createTitle}" class="z-icon-es-add">
            {$createTitle}
        </a>
    {/checkpermissionblock}

    {assign var='all' value=0}
    {if isset($showAllEntries) && $showAllEntries eq 1}
        {gt text='Back to paginated view' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type='user' func='view' ot='picture'}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
        {assign var='all' value=1}
    {else}
        {gt text='Show all entries' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type='user' func='view' ot='picture' all=1}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
    {/if}

<table class="z-datatable">
    <colgroup>
        <col id="ctitle" />
        <col id="cdescription" />
        <col id="cshowtitle" />
        <col id="cshowdescription" />
        <col id="cimageupload" />
        <col id="cimageview" />
        <col id="calbum" />
        <col id="citemactions" />
    </colgroup>
    <thead>
    <tr>
        <th id="htitle" scope="col" class="z-left">
            {sortlink __linktext='Title' sort='title' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='picture'}
        </th>
        <th id="hdescription" scope="col" class="z-left">
            {sortlink __linktext='Description' sort='description' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='picture'}
        </th>
        <th id="hshowtitle" scope="col" class="z-center">
            {sortlink __linktext='Show title' sort='showTitle' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='picture'}
        </th>
        <th id="hshowdescription" scope="col" class="z-center">
            {sortlink __linktext='Show description' sort='showDescription' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='picture'}
        </th>
        <th id="himageupload" scope="col" class="z-left">
            {sortlink __linktext='Image upload' sort='imageUpload' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='picture'}
        </th>
        <th id="himageview" scope="col" class="z-right">
            {sortlink __linktext='Image view' sort='imageView' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='picture'}
        </th>
        <th id="halbum" scope="col" class="z-left">
            {sortlink __linktext='Album' sort='album' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='picture'}
        </th>
        <th id="hitemactions" scope="col" class="z-right z-order-unsorted">{gt text='Actions'}</th>
    </tr>
    </thead>
    <tbody>

    {foreach item='picture' from=$items}
    <tr class="{cycle values='z-odd, z-even'}">
        <td headers="htitle" class="z-left">
            {$picture.title|notifyfilters:'muimage.filterhook.pictures'}
        </td>
        <td headers="hdescription" class="z-left">
            {$picture.description}
        </td>
        <td headers="hshowtitle" class="z-center">
            {assign var='itemid' value=$picture.id}
            <a id="toggleshowtitle{$itemid}" href="javascript:void(0);" style="display: none">
            {if $picture.showTitle}
                {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title="This setting is enabled. Click here to disable it."}
                {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title="This setting is disabled. Click here to enable it." style="display: none;"}
            {else}
                {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowtitle_`$itemid`" __title="This setting is enabled. Click here to disable it." style="display: none;"}
                {icon type='cancel' size='extrasmall' __alt='No' id="noshowtitle_`$itemid`" __title="This setting is disabled. Click here to enable it."}
            {/if}
            </a>
            <noscript><div id="noscriptshowtitle{$itemid}">
                {$picture.showTitle|yesno:true}            </div></noscript>

        </td>
        <td headers="hshowdescription" class="z-center">
            {assign var='itemid' value=$picture.id}
            <a id="toggleshowdescription{$itemid}" href="javascript:void(0);" style="display: none">
            {if $picture.showDescription}
                {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title="This setting is enabled. Click here to disable it."}
                {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title="This setting is disabled. Click here to enable it." style="display: none;"}
            {else}
                {icon type='ok' size='extrasmall' __alt='Yes' id="yesshowdescription_`$itemid`" __title="This setting is enabled. Click here to disable it." style="display: none;"}
                {icon type='cancel' size='extrasmall' __alt='No' id="noshowdescription_`$itemid`" __title="This setting is disabled. Click here to enable it."}
            {/if}
            </a>
            <noscript><div id="noscriptshowdescription{$itemid}">
                {$picture.showDescription|yesno:true}            </div></noscript>

        </td>
        <td headers="himageupload" class="z-left">
              <a href="{$picture.imageUploadFullPathURL}" title="{$picture.title|replace:"\"":""}"{if $picture.imageUploadMeta.isImage} rel="imageviewer[picture]"{/if}>
              {if $picture.imageUploadMeta.isImage}
                  <img src="{$picture.imageUpload|muimageImageThumb:$picture.imageUploadFullPath:32:20}" width="32" height="20" alt="{$picture.title|replace:"\"":""}" />
              {else}
                  {gt text='Download'} ({$picture.imageUploadMeta.size|muimageGetFileSize:$picture.imageUploadFullPath:false:false})
              {/if}
              </a>

        </td>
        <td headers="himageview" class="z-right">
            {$picture.imageView}
        </td>
        <td headers="halbum" class="z-left">
            {if isset($picture.Album) && $picture.Album ne null}
                <a href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$picture.Album.id}">
                    {$picture.Album.title|default:""}
                </a>
                <a id="albumItem{$picture.id}_rel_{$picture.Album.id}Display" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$picture.Album.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
                    {icon type='view' size='extrasmall' __alt='Quick view'}
                </a>
                <script type="text/javascript" charset="utf-8">
                /* <![CDATA[ */
                    document.observe('dom:loaded', function() {
                        muimageInitInlineWindow($('albumItem{{$picture.id}}_rel_{{$picture.Album.id}}Display'), '{{$picture.Album.title|replace:"'":""}}');
                    });
                /* ]]> */
                </script>
            {else}
                {gt text='Not set.'}
            {/if}
        </td>
        <td headers="hitemactions" class="z-right z-nowrap z-w02">
            {if count($picture._actions) gt 0}
            {strip}
                {foreach item='option' from=$picture._actions}
                    <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>
                        {icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}
                    </a>
                {/foreach}
            {/strip}
            {/if}
        </td>
    </tr>
    {foreachelse}
        <tr class="z-datatableempty">
          <td class="z-left" colspan="7">
            {gt text='No pictures found.'}
          </td>
        </tr>
    {/foreach}

    </tbody>
</table>

    {if !isset($showAllEntries) || $showAllEntries ne 1}
        {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page'}
    {/if}

   {* {notifydisplayhooks eventname='muimage.ui_hooks.pictures.display_view' urlobject=$currentUrlObject assign='hooks'} *}
    {foreach key='hookname' item='hook' from=$hooks}
        {$hook}
    {/foreach}
</div>
</div>
{include file='user/footer.tpl'}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
    document.observe('dom:loaded', function() {
    {{foreach item='picture' from=$items}}
        {{assign var='itemid' value=$picture.id}}
        muimageInitToggle('picture', 'showTitle', '{{$itemid}}');
        muimageInitToggle('picture', 'showDescription', '{{$itemid}}');
    {{/foreach}}
    });
/* ]]> */
</script>
