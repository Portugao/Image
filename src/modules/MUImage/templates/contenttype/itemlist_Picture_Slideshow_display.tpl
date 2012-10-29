{* Purpose of this template: Display pictures within an external context *}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='modules/MUImage/style/style.css'}
<div style="display: none">
{foreach item='item' from=$items}
    {if $item.imageUploadMeta.isImage}
    {if $item.imageUploadMeta.format eq 'landscape'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:160:120}" width="160px" height="120px" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {if $item.imageUploadMeta.format eq 'portrait'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:120:160}" width="120px" height="160px" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {else}
        {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
    {/if}
{/foreach}
</div>
<div id="muimage-block-slideshow">
{foreach item='item' from=$items}
<div class="muimage-block-slideshow-pictures">
<a href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$vars.selectalbum}" title="{gt text='Visit the album'}">
    {if $item.imageUploadMeta.isImage}
    {if $item.imageUploadMeta.format eq 'landscape'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:160:120}" width="160px" height="120px" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {if $item.imageUploadMeta.format eq 'portrait'}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:120:160}" width="120px" height="160px" alt="{$item.title|replace:"\"":""}" />
    {/if}
    {else}
        {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
    {/if}
</a>
</div>
{/foreach}
</div>
<script type="text/javascript" charset="utf-8">
    /* <![CDATA[ */

    var MU = jQuery.noConflict();
    function slideshow(img) {
        if (!img.length) return;
        if (img.length == 1) {
            img.first().show();
            return;
        }
        img.hide();
        var fn = {
             loop: function() {
                 fn.blend();
                 setTimeout(fn.loop, 4000);
             },
             blend: function() {                
                 var current = img.filter(".current")
                                  .fadeOut(4000)
                                  .removeClass("current");
                 current = (current.next().length) ?
                         current.next() : img.first();
                 current.fadeIn(4000).addClass("current");
                         
        }
        }
        img.first().addClass("current").fadeIn(4000, function() {
             setTimeout(fn.loop, 4000);    
        });        
        }
    
    MU(document).ready( function() { 
        slideshow( MU(".muimage-block-slideshow-pictures "));
        }); 

    /* ]]> */
</script>
