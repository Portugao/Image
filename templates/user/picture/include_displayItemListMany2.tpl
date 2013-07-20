{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
{* <ul class="relatedItemList Picture"> *}
{foreach name='relLoop' item='item' from=$items}
{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
{if $item.imageUploadMeta.format eq 'landscape'}
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:200:150}" width="200" height="150" alt="{$item.title|replace:"\"":""}" />
{/if}
{if $item.imageUploadMeta.format eq 'portrait'}
    <img class="muimage_album_image_portrait" src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:113:150}" width="113" height="150" alt="{$item.title|replace:"\"":""}" />
{/if}
{/if}

   {* </li> *}

{/foreach}
{* </ul> *}
{else}
<h2>{gt text='No pictures'}</h2>
{/if}


