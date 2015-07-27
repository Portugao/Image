{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
	
<div id="photos">
{foreach item='picture' from=$items}
	{muimageImageMeta2 filePath=userdata/MUImage/pictures/imageupload/`$picture.imageUploadMeta.filename`_tmb.jpg assign='pictureMeta'}
	<a href="/userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_full.jpg" title="{$picture.title}"  rel="imageviewer[item]"><img src="/userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_tmb.jpg"></a>
{/foreach}
</div>
{/if}


