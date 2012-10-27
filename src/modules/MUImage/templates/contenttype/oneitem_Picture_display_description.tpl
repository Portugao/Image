{* Purpose of this template: Display pictures within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<h2>{$item.title}</h2>
<p>{$item.description}</p>
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    {if $item.imageUploadMeta.isImage}
    {if $item.imageUploadMeta.format eq 'landscape'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:200:150}" width="200" height="150" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {if $item.imageUploadMeta.format eq 'portrait'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:150:200}" width="150" height="200" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {else}
        {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
    {/if}
</a>

