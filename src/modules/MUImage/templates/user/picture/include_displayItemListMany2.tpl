{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
{* <ul class="relatedItemList Picture"> *}
{foreach name='relLoop' item='item' from=$items}

{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:200:150}" width="200" height="150" alt="{$item.title|replace:"\"":""}" />
{/if}

   {* </li> *}

{/foreach}
{* </ul> *}
{else}
<h2>{gt text='No pictures'}</h2>
{/if}


