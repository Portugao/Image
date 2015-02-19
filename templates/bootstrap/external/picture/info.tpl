{* Purpose of this template: Display item information for previewing from other modules *}
<dl id="picture{$picture.id}">
<dt>{$picture->getTitleFromDisplayPattern()|notifyfilters:'muimage.filter_hooks.pictures.filter'|htmlentities}</dt>
<dd>  <a href="{$picture.imageUploadFullPathURL}" title="{$picture->getTitleFromDisplayPattern()|replace:"\"":""}"{if $picture.imageUploadMeta.isImage} rel="imageviewer[picture]"{/if}>
  {if $picture.imageUploadMeta.isImage}
      {thumb image=$picture.imageUploadFullPath objectid="picture-`$picture.id`" preset=$pictureThumbPresetImageUpload tag=true img_alt=$picture->getTitleFromDisplayPattern()}
  {else}
      {gt text='Download'} ({$picture.imageUploadMeta.size|muimageGetFileSize:$picture.imageUploadFullPath:false:false})
  {/if}
  </a>
</dd>
{if $picture.description ne ''}<dd>{$picture.description}</dd>{/if}
</dl>
