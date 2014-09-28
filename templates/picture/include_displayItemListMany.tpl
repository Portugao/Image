{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}

<form method="post" action="{modurl modname='MUImage' type='picture' func='savePosition'}">
<ul id="sortable">
{foreach name='relLoop' item='item' from=$items}
<li class="ui-state-default">
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

<div class="muimage_picture_view_content">

{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
  <a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    {thumb image=$item.imageUploadFullPath objectid="picture-`$item.id`" preset=$relationThumbPreset tag=true img_alt=$item->getTitleFromDisplayPattern()}
  </a>
{/if}
    {if $item.imageUploadMeta.format eq ''}
        <span class="muimage-valid">{gt text='No valid file'}</span>
    {/if}  

   {* </li> *}
</div>
<div class="muimage_picture_view_bottom">
<input name="pictures[]" type="hidden" value={$item.id} />
{modgetvar module='MUImage' name='countImageView' assign='imageView'}
{if $imageView eq 1}
{gt text='Invocations:'} {$item.imageView}
{/if}
</div>   
</div>
</li>   
{/foreach}
</ul>

{if $coredata.user.uid eq 2 || $coredata.user.uid eq $item.createdUserId }
<br style="clear: both; "/><input type="submit" value="Save positions" />
</form>
{/if}
{/if}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */

    var MU = jQuery.noConflict();

    MU(function() {
        MU( "#sortable" ).sortable();

    });
    
    /* ]]> */
</script>