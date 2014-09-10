{* Purpose of this template: Display one certain album within an external context *}
<div id="album{$album.id}" class="muimage-external-album">
{if $displayMode eq 'link'}
    <p class="muimage-external-link">
    <a href="{modurl modname='MUImage' type='user' func='display' ot='album'  id=$album.id}" title="{$album->getTitleFromDisplayPattern()|replace:"\"":""}">
    {$album->getTitleFromDisplayPattern()|notifyfilters:'muimage.filter_hooks.albums.filter'}
    </a>
    </p>
{/if}
{checkpermissionblock component='MUImage::' instance='::' level='ACCESS_EDIT'}
    {if $displayMode eq 'embed'}
        <p class="muimage-external-title">
            <strong>{$album->getTitleFromDisplayPattern()|notifyfilters:'muimage.filter_hooks.albums.filter'}</strong>
        </p>
    {/if}
{/checkpermissionblock}

{if $displayMode eq 'link'}
{elseif $displayMode eq 'embed'}
    <div class="muimage-external-snippet">
        &nbsp;
    </div>

    {* you can distinguish the context like this: *}
    {*if $source eq 'contentType'}
        ...
    {elseif $source eq 'scribite'}
        ...
    {/if*}

    {* you can enable more details about the item: *}
    {*
        <p class="muimage-external-description">
            {if $album.description ne ''}{$album.description}<br />{/if}
            {assignedcategorieslist categories=$album.categories doctrine2=true}
        </p>
    *}
{/if}
</div>
