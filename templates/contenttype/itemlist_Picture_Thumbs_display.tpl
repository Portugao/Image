{* Purpose of this template: Display pictures within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<div style="width: 100%;">
{foreach item='item' from=$items}
<div style="background: #bbb; width: 60px; height: 60px; float: left; padding: 0px; margin: 3px; border: #333 1px solid;">
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[block]"{/if}>
    {if $item.imageUploadMeta.isImage}
    {if $item.imageUploadMeta.format eq 'landscape'}
        <img style="padding: 7px 0 0 0;" src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:60:45}" width="60" height="45" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {if $item.imageUploadMeta.format eq 'portrait'}
        <img style="padding: 0 0 0 7px;" src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:45:60}" width="45" height="60" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {else}
        {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
    {/if}
</a>
</div>
{/foreach}
<br style="clear: both;" />
</div>
