{* Purpose of this template: Display movies within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<h2>{$item.title}</h2>
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
          {if $item.imageUploadMeta.isImage}
              {thumb image=$item.imageUploadFullPath width=$vars.width height=$vars.height mode='inset' tag=true extension='jpg' alt=$item->getTitleFromDisplayPattern()}
          {else}
              {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
          {/if}
</a>