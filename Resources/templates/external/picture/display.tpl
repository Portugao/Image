{* Purpose of this template: Display one certain picture within an external context *}
<div id="picture{$picture.id}" class="muimage-external-picture">
{if $displayMode eq 'link'}
    <p class="muimage-external-link">
    <a href="{modurl modname='MUImage' type='user' func='display' ot='picture'  id=$picture.id}" title="{$picture->getTitleFromDisplayPattern()|replace:"\"":""}">
    {$picture->getTitleFromDisplayPattern()|notifyfilters:'muimage.filter_hooks.pictures.filter'}
    </a>
    </p>
{/if}
{checkpermissionblock component='MUImage::' instance='::' level='ACCESS_EDIT'}
    {if $displayMode eq 'embed'}
        <p class="muimage-external-title">
            <strong>{$picture->getTitleFromDisplayPattern()|notifyfilters:'muimage.filter_hooks.pictures.filter'}</strong>
        </p>
    {/if}
{/checkpermissionblock}

{if $displayMode eq 'link'}
{elseif $displayMode eq 'embed'}
    <div class="muimage-external-snippet">
          <a href="{$picture.imageUploadFullPathURL}" title="{$picture->getTitleFromDisplayPattern()|replace:"\"":""}"{if $picture.imageUploadMeta.isImage} rel="imageviewer[picture]"{/if}>
          {if $picture.imageUploadMeta.isImage}
              {thumb image=$picture.imageUploadFullPath objectid="picture-`$picture.id`" preset=$pictureThumbPresetImageUpload tag=true img_alt=$picture->getTitleFromDisplayPattern()}
          {else}
              {gt text='Download'} ({$picture.imageUploadMeta.size|muimageGetFileSize:$picture.imageUploadFullPath:false:false})
          {/if}
          </a>
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
            {if $picture.description ne ''}{$picture.description}<br />{/if}
        </p>
    *}
{/if}
</div>
