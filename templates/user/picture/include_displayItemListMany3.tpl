{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
{* <ul class="relatedItemList Picture"> *}
{foreach name='relLoop' item='item' from=$items}
{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
{if $item.imageUploadMeta.format eq 'landscape'}
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:300:225}" width="300" height="225" alt="{$item.title|replace:"\"":""}" />
{/if}
{if $item.imageUploadMeta.format eq 'portrait'}
    <img class='muimage_album_portrait' src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:225:300}" width="225" height="300" alt="{$item.title|replace:"\"":""}" />
{/if}
{/if}    
{/foreach}
{* </ul> *}
{/if}

