{* purpose of this template: inclusion template for display of related Pictures in user area *}
{pageaddvar name='javascript' value='modules/MUImage/javascript/Nivoslider/jquery.nivo.slider.pack.js'}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/Nivoslider/nivo-slider.css'}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/Nivoslider/themes/bar/bar.css'}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/Nivoslider/themes/default/default.css'}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/Nivoslider/themes/dark/dark.css'}
{pageaddvar name='stylesheet' value='modules/MUImage/javascript/Nivoslider/themes/light/light.css'}
{if isset($items) && $items ne null}
<div class="slider-wrapper {$modulevars.slide1theme}">
    <div id="slider" class="nivoSlider">
{foreach name='relLoop' item='item' from=$items}
    {if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
        <img src="{$item.imageUploadFullPathURL}" />
    {/if}    
{/foreach}
</div>
</div>
{/if}
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
    var MU = jQuery.noConflict();
        MU(window).load(function() {
    MU('#slider').nivoSlider({
        effect: '{{$modulevars.slide1effect}}', // Specify sets like: 'fold,fade,sliceDown'
        slices: {{$modulevars.slide1slices}}, // For slice animations
        boxCols: {{$modulevars.slide1boxCols}}, // For box animations
        boxRows: {{$modulevars.slide1boxRows}}, // For box animations
        animSpeed: {{$modulevars.slide1Speed}}, // Slide transition speed
        pauseTime: {{$modulevars.slide1Pausetime}}, // How long each slide will show
        startSlide: {{$modulevars.slide1StartSlide}}, // Set starting Slide (0 index)
        directionNav: {{if $modulevars.slide1directionNav eq 0}}false{{else}}true{{/if}}, // Next & Prev navigation
        controlNav: {{if $modulevars.slide1controlNav eq 0}}false{{else}}true{{/if}}, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        pauseOnHover: {{if $modulevars.slide1pauseOnHover eq 0}}false{{else}}true{{/if}}, // Stop animation while hovering
        manualAdvance: false, // Force manual transitions
        prevText: '{{$modulevars.slide1prevText}}', // Prev directionNav text
        nextText: '{{$modulevars.slide1nextText}}', // Next directionNav text
        randomStart: {{if $modulevars.slide1effect eq 0}}false{{else}}true{{/if}}, // Start on a random slide
        beforeChange: function(){}, // Triggers before a slide transition
        afterChange: function(){}, // Triggers after a slide transition
        slideshowEnd: function(){}, // Triggers after all slides have been shown
        lastSlide: function(){}, // Triggers when last slide is shown
        afterLoad: function(){} // Triggers when slider has loaded
        });
});

/* ]]> */
</script>