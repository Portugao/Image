{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
{* <ul class="relatedItemList Picture"> *}
{foreach name='relLoop' item='item' from=$items}
<div class="muimage_picture_view">
<div class="muimage_picture_view_header">
   {* <li> *}
    <a href="{modurl modname='MUImage' type='user' func='display' ot='picture' id=$item.id}" title="{gt text='Details'}">      
        {$item.title}
   </a>
   {* <a id="pictureItem{$item.id}Display" href="{modurl modname='MUImage' type='user' func='display' ot='picture' id=$item.id theme='Printer' forcelongurl=true}" title="{gt text='Open quick view window'}" style="display: none">
        {icon type='view' size='extrasmall' __alt='Quick view'}
    </a>
    <script type="text/javascript" charset="utf-8">
    /* <![CDATA[ */
        document.observe('dom:loaded', function() {
            muimageInitInlineWindow($('pictureItem{{$item.id}}Display'), '{{$item.title|replace:"'":""}}');
        });
    /* ]]> */
    </script> 
    <br /> *}
</div>
<div class="muimage_picture_view_content">
{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
    <a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:100:70}" width="100" height="70" alt="{$item.title|replace:"\"":""}" />
  </a>
{/if}

   {* </li> *}
</div>   
</div>   
{/foreach}
{* </ul> *}
{/if}

