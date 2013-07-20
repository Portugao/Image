{* purpose of this template: inclusion template for display of related Pictures in user area *}
{pageaddvar name='javascript' value='javascript/jquery-plugins/ResponsiveSlides/responsiveslides.js'}
{pageaddvar name='stylesheet' value='javascript/jquery-plugins/ResponsiveSlides/responsiveslides.css'}
{if isset($items) && $items ne null}
{* <ul class="relatedItemList Picture"> *}
<ul class="muimage-slideshow2" id="slider3"">
{foreach name='relLoop' item='item' from=$items}
    {if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
        <li><img src="{$item.imageUploadFullPathURL}" /></li>
    {/if}    
{/foreach}
</ul>
<!-- Slideshow 3 Pager -->
{* <ul id="slider3-pager">
    {foreach name='relLoop' item='item' from=$items}
        {if $item.imageUpload ne '' && isset($item.imageUploadFullPathURL)}
            <li><a href="#"><img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:40:30}" width="40" height="30" alt="{$item.title|replace:"\"":""}" /></a></li>
        {/if}
    {/foreach}
</ul> *}
{/if}
<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
    
    
    var MU = jQuery.noConflict();
    MU(document).ready( function() { 
      MU(".muimage-slideshow2").responsiveSlides({
      auto: true,             // Boolean: Animate automatically, true or false
      speed: 1000,            // Integer: Speed of the transition, in milliseconds
      timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
      pager: false,           // Boolean: Show pager, true or false
      nav: true,             // Boolean: Show navigation, true or false
      random: false,          // Boolean: Randomize the order of the slides, true or false
      pause: true,           // Boolean: Pause on hover, true or false
      pauseControls: true,    // Boolean: Pause when hovering controls, true or false
      prevText: "Previous",   // String: Text for the "previous" button
      nextText: "Next",       // String: Text for the "next" button
      maxwidth: 800,           // Integer: Max-width of the slideshow, in pixels
      navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
      manualControls: "",     // Selector: Declare custom pager navigation
      namespace: "rslides",   // String: Change the default namespace used
      before: function(){},   // Function: Before callback
      after: function(){}     // Function: After callback
});
    });

/* ]]> */
</script>
