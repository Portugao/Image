{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
<ul id="sortable">
{foreach name='relLoop' item='item' from=$items}
<li class="ui-state-default">
<div class="muimage_picture_view">
 {muimageCheckGroupMember createdUserId=$item.createdUserId assign='groupMember'}
{if $coredata.user.uid eq 2 || $coredata.user.uid eq $album.createdUserId || $groupMember eq 1}
{gt text='movecursor' assign='cursor'}
{else}
{gt text='' assign='cursor'}
{/if}
<div class="muimage_picture_view_header {$cursor}">
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
    {muimageCheckGroupMember createdUserId=$item.createdUserId assign='groupMember'}
    {if $authEdit && ($item.createdUserId eq $coredata.user.uid || $groupMember eq 1)}
    <a title="Edit {$item.title}" class="muimage_picture_view_header_right" href="{modurl modname='MUImage' type='user' func='edit' ot='picture' id=$item.id}"><img src="images/icons/extrasmall/xedit.png" /></a>
    {/if}
</div>

<div class="muimage_picture_view_content">

{if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
    <a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    <span style="display: block; width: 100px; height: 70px; background: url({thumb image=$item.imageUploadFullPath width=200 height=200 mode='inset' extension='jpg'}) center center; background-size: cover;"></span>
    </a>
{/if}
{if $item.imageUploadMeta.format eq ''}
    <span class="muimage-valid">{gt text='No valid file'}</span>
{/if}  

</div>
<div class="muimage_picture_view_bottom">
<input name="pictures[]" type="hidden" value={$item.id} />
{modgetvar module='MUImage' name='countImageView' assign='imageView'}
{if $imageView eq 1}
{gt text='Invocations'}: {$item.imageView}
{/if}
{gt text='Rotate picture to left' assign='leftRotate'}
{gt text='Rotate picture to right' assign='rightRotate'}
{if $coredata.user.uid eq $item.createdUserId}
<span class="rotateButtonLeft"><a title={$leftRotate} href="{modurl modname='MUImage' type='picture' func='rotateLeft' id=$item.id}"><img src="images/icons/extrasmall/tab_left.png"></a></span>
<span class="rotateButtonRight"><a title={$rightRotate} href="{modurl modname='MUImage' type='picture' func='rotateRight' id=$item.id}"><img src="images/icons/extrasmall/tab_right.png"></a></span>
{/if}
</div>   
</div>
</li>   
{/foreach}
</ul>
{/if}

<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */

    var MU = jQuery.noConflict();

	{{muimageCheckGroupMember createdUserId=$album.createdUserId assign='groupMember'}}
    {{if $coredata.user.uid eq 2 || $coredata.user.uid eq $item.createdUserId || $groupMember eq 1}}
        MU(function() {
            MU( "#sortable" ).sortable();
        });
    {{/if}}
    
   /* MU(".muimage_picture_view_bottom").hover(
        function() {
            MU(this > .rotateButtonLeft).css("display", "block");
        },
        function() {
            MU(this > .rotateButtonLeft).css("display", "none");
        }
    );*/
    /* ]]> */
</script>