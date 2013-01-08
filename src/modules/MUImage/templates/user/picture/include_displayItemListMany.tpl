{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
{* <ul class="relatedItemList Picture"> *}
{foreach name='relLoop' item='item' from=$items}
<div class="muimage_picture_view">
<div class="muimage_picture_view_header">
   {* <li> *}
    <a class="muimage_picture_view_header_left" href="{modurl modname='MUImage' type='user' func='display' ot='picture' id=$item.id}" title="{gt text='Details'}">      
   {if $item.title ne ''}
        {$item.title}
   {else}
   {gt text='No title'}
   {/if}
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
    {checkpermission component='MUImage:Picture:' instance='.*' level='ACCESS_EDIT' assign='authEdit'}
    {if $authEdit && $item.createdUserId eq $coredata.user.uid}
    <a title="Edit {$item.title}" class="muimage_picture_view_header_right" href="{modurl modname='MUImage' type='user' func='edit' ot='picture' id=$item.id}"><img src="images/icons/extrasmall/xedit.png" /></a>
    {/if}
</div>
{if $item.imageUploadMeta.format eq 'landscape' || $item.imageUploadMeta.format eq ''}
<div class="muimage_picture_view_content">
{/if}
{if $item.imageUploadMeta.format eq 'portrait'}
<div class="muimage_picture_view_content_portrait">
{/if}
{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
    <a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    {if $item.imageUploadMeta.format eq 'landscape'}
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:100:70}" width="100" height="70" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {if $item.imageUploadMeta.format eq 'portrait'}
    <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:52:70}" width="52" height="70" alt="{$item.title|replace:"\"":""}" />
    {/if} 

  </a>
{/if}
    {if $item.imageUploadMeta.format eq ''}
        <span class="muimage-valid">{gt text='No valid file'}</span>
    {/if}  

   {* </li> *}
</div>
<div class="muimage_picture_view_bottom">
{modgetvar module='MUImage' name='countImageView' assign='imageView'}
{if $imageView eq 1}
{gt text='Invocations:'} {$item.imageView}
{/if}
</div>   
</div>   
{/foreach}
{* </ul> *}
{/if}

