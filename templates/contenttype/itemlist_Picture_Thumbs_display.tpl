{* Purpose of this template: Display pictures within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<div style="width: 100%;">
{foreach item='item' from=$items}
<div style="background: #bbb; width: 60px; height: 60px; float: left; padding: 0px; margin: 3px; border: #333 1px solid; background-size: cover;">
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[block]"{/if}>
          {if $item.imageUploadMeta.isImage}
              {thumb image=$item.imageUploadFullPath objectid="picture-`$item.id`" preset=$itemThumbPresetImageUpload tag=true img_alt=$item->getTitleFromDisplayPattern()}
          {else}
              {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
          {/if}
</a>
</div>
{/foreach}
<br style="clear: both;" />
</div>
