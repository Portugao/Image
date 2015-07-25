{* purpose of this template: footer for user area *}
{if !isset($smarty.get.theme) || $smarty.get.theme ne 'Printer'}
{elseif isset($smarty.get.func) && $smarty.get.func eq 'edit'}
    {pageaddvar name='stylesheet' value='style/core.css'}
    {pageaddvar name='stylesheet' value='modules/MUImage/style/style.css'}
    {pageaddvar name='stylesheet' value='system/Theme/style/form/style.css'}
    {pageaddvar name='stylesheet' value='themes/Andreas08/style/fluid960gs/reset.css'}
    {capture assign='pageStyles'}
    <style type="text/css">
        body {
            font-size: 70%;
        }
    </style>
    {/capture}
    {pageaddvar name='header' value=$pageStyles}
{/if}
{modgetvar module='MUImage' name='layout' assign='layout'}
{if $layout eq 'bootstrap'}
	{userloggedin assign="loggedin"}
	{if $loggedin eq true}
		<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
		<script src="modules/MUImage/Vendor/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
	{else}
		{pageaddvar name='stylesheet' value='modules/MUImage/Vendor/flexImages/jquery.flex-images.css'}
		{pageaddvar name='javascript' value='modules/MUImage/Vendor/flexImages/jquery.flex-images.js'}	
		<script>
		 jQuery.noConflict();
			 jQuery(document).ready(function(){
 
				// (Hier jQuery-Code)
 
					jQuery('.flex-images').flexImages({rowHeight: 200});
 
			 });
        </script>
	{/if}
{/if}		

