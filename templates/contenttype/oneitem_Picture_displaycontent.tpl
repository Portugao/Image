{* Purpose of this template: Display movies within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    {if $item.imageUploadMeta.isImage}
        {thumb image=$item.imageUploadFullPath objectid="picture-`$item.id`" preset=$itemThumbPresetImageUpload tag=true img_alt=$formattedEntityTitle}
    {else}
        {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
    {/if}
</a>
