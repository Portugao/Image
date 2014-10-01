{* Purpose of this template: Display pictures within an external context *}
{pageaddvar name='javascript' value='jquery'}
{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='modules/MUImage/style/style.css'}
<div style="display: none">
{foreach item='item' from=$items}
          {if $item.imageUploadMeta.isImage}
              <div style="background:url({thumb image=$item.imageUploadFullPath width=$vars.width height=$vars.height}
       ) no-repeat center center"></div>
        {else}
              {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
          {/if}
{/foreach}
</div>
<div style="float: left; height: {$vars.height}px;" id="muimage-block-slideshow">
{foreach item='item' from=$items}
<div class="muimage-block-slideshow-pictures">
<a href="{modurl modname='MUImage' type='user' func='display' ot='album' id=$vars.selectalbum}" title="{gt text='Visit the album'}">
          {if $item.imageUploadMeta.isImage}
              <div style="float: left; width: {$vars.width}px; height: {$vars.height}px; background:url({$item.imageUploadFullPathURL}) no-repeat center center; background-size: contain"></div>
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
