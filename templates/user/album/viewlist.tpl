{* purpose of this template: albums view view in user area *}
<div class="muimage-album muimage-view">
{include file='user/header.tpl'}
{gt text='Album list' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>


    {checkpermissionblock component='MUImage::' instance='.*' level="ACCESS_ADD"}
        {gt text='Create album' assign='createTitle'}
        <a href="{modurl modname='MUImage' type='user' func='edit' ot='album'}" title="{$createTitle}" class="z-icon-es-add">
            {$createTitle}
        </a>
    {/checkpermissionblock}

    {assign var='all' value=0}
    {if isset($showAllEntries) && $showAllEntries eq 1}
        {gt text='Back to paginated view' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type='user' func='view' ot='album'}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
        {assign var='all' value=1}
    {else}
        {gt text='Show all entries' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type='user' func='view' ot='album' all=1}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
    {/if}

<table class="z-datatable">
    <colgroup>
        <col id="ctitle" />
        <col id="cdescription" />
        <col id="cparent_id" />
        <col id="cparent" />
        <col id="citemactions" />
    </colgroup>
    <thead>
    <tr>
        <th id="htitle" scope="col" class="z-left">
            {sortlink __linktext='Title' sort='title' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='album'}
        </th>
        <th id="hdescription" scope="col" class="z-left">
            {sortlink __linktext='Description' sort='description' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='album'}
        </th>
        <th id="hparent_id" scope="col" class="z-right">
            {sortlink __linktext='Parent_id' sort='parent_id' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='album'}
        </th>
        <th id="hparent" scope="col" class="z-left">
            {sortlink __linktext='Parent' sort='parent' currentsort=$sort sortdir=$sdir all=$all modname='MUImage' type='user' func='view' ot='album'}
        </th>
        <th id="hitemactions" scope="col" class="z-right z-order-unsorted">{gt text='Actions'}</th>
    </tr>
    </thead>
    <tbody>

    {foreach item='album' from=$items}
    <tr class="{cycle values='z-odd, z-even'}">
        <td headers="htitle" class="z-left">
            {$album.title|notifyfilters:'muimage.filterhook.albums'}
        </td>
        <td headers="hdescription" class="z-left">
            {$album.description}
        </td>
        <td headers="hparent_id" class="z-right">
            {$album.parent_id}
        </td>
        <td headers="hparent" class="z-left">
            {if isset($album.Parent) && $album.Parent ne null}
                <a href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$album.Parent.id}">
                    {$album.Parent.title|default:""}
                </a>
                <a id="albumItem{$album.id}_rel_{$album.Parent.id}Display" href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$album.Parent.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
                    {icon type='view' size='extrasmall' __alt='Quick view'}
                </a>
                <script type="text/javascript" charset="utf-8">
                /* <![CDATA[ */
                    document.observe('dom:loaded', function() {
                        muimageInitInlineWindow($('albumItem{{$album.id}}_rel_{{$album.Parent.id}}Display'), '{{$album.Parent.title|replace:"'":""}}');
                    });
                /* ]]> */
                </script>
            {else}
                {gt text='Not set.'}
            {/if}
        </td>
        <td headers="hitemactions" class="z-right z-nowrap z-w02">
            {if count($album._actions) gt 0}
            {strip}
                {foreach item='option' from=$album._actions}
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
          <td class="z-left" colspan="4">
            {gt text='No albums found.'}
          </td>
        </tr>
    {/foreach}

    </tbody>
</table>

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

