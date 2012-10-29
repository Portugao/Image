{* Purpose of this template: Display movies within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<h2>{$item.title}</h2>
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    {if $item.imageUploadMeta.isImage}
    {if $item.imageUploadMeta.format eq 'landscape'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:$vars.width:$vars.height}" width={$vars.width} height={$vars.height} alt="{$item.title|replace:"\"":""}" />
    {/if}
    {if $item.imageUploadMeta.format eq 'portrait'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:$vars.height:$vars.width}" width={$vars.height} height={$vars.width} alt="{$item.title|replace:"\"":""}" />
    {/if}
    {if $item.imageUploadMeta.format eq 'square'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:$vars.width:$vars.width}" width={$vars.width} height={$vars.width} alt="{$item.title|replace:"\"":""}" />
    {/if}
    {else}
        {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
    {/if}
</a>