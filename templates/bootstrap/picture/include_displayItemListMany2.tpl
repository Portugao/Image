{* purpose of this template: inclusion template for display of related Pictures in user area *}

{if isset($items) && $items ne null}
	
<div class="flex-images">
{foreach item='picture' from=$items}
	{muimageImageMeta2 filePath=userdata/MUImage/pictures/imageupload/`$picture.imageUploadMeta.filename`_tmb.jpg assign='pictureMeta'}
    <div class="item" data-w="{$pictureMeta.width}" data-h="{$pictureMeta.height}"><a href="/userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_full.jpg" title="{$picture.title}"  rel="imageviewer[item]"><img src="/userdata/MUImage/pictures/imageupload/{$picture.imageUploadMeta.filename}_tmb.jpg"></a></div>
{/foreach}
</div>
{/if}


