{* Purpose of this template: Display pictures within an external context *}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
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
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[block]"{/if}>
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
                 setTimeout(fn.loop, 3000);
             },
             blend: function() {                
                 var current = img.filter(".current")
                                  .fadeOut(3000)
                                  .removeClass("current");
                 current = (current.next().length) ?
                         current.next() : img.first();
                 current.fadeIn(3000).addClass("current");
                         
        }
        }
        img.first().addClass("current").fadeIn(4000, function() {
             setTimeout(fn.loop, 5000);    
        });        
        }
    
    MU(document).ready( function() { 
        slideshow( MU("#muimage-block-slideshow .muimage-block-slideshow-pictures "));
        }); 

    /* ]]> */
</script>
