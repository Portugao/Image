{* Purpose of this template: Display pictures within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<div style="width: 100%;">
{foreach item='item' from=$items}
<a style="width: 50px; height: 50px;" href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[thumbnails]"{/if}>
          {if $item.imageUploadMeta.isImage}
              <span style="float: left; width: 50px; height: 50px; margin: 0 5px 5px 0; background: url({$item.imageUploadFullPathURL}) no-repeat center center; background-size: cover;"></span>
          {else}
              {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
          {/if}
</a>
{/foreach}
<br style="clear: both;" />
</div>
