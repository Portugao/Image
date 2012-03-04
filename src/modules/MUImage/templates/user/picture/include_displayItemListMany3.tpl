{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
{* <ul class="relatedItemList Picture"> *}
{foreach name='relLoop' item='item' from=$items}
{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:300:225}" width="300" height="225" alt="{$item.title|replace:"\"":""}" />
{/if}    
{/foreach}
{* </ul> *}
{/if}

