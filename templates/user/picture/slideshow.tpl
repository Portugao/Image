{* purpose of this template: inclusion template for display of related Pictures in user area *}
{* {pageaddvar name='javascript' value='modules/MUImage/javascript/Gallery/js/blueimp-gallery.min.js'}*}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/Gallery/css/blueimp-gallery.css'}
 
{if isset($items) && $items ne null}
<!-- The Gallery as inline carousel, can be positioned anywhere on the page -->
<div id="blueimp-gallery-carousel" class="blueimp-gallery blueimp-gallery-carousel">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<div id="links">
{foreach name='relLoop' item='item' from=$items}
    {if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
        <a title="{$item.title}" href="{$item.imageUploadFullPathURL}" /></a>
    {/if}    
{/foreach}
</div>
{/if}

<script src="modules/MUImage/javascript/Gallery/js/blueimp-gallery.min.js"></script>

<script>
blueimp.Gallery(
    document.getElementById('links').getElementsByTagName('a'),
    {
        container: '#blueimp-gallery-carousel',
        carousel: true
    }
);
</script>



