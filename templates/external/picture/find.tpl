        <div class="muimage-hook z-formrow">
        {if count($images) > 0}
            {foreach item='image' from=$images}
                <span class="muimage-editor-plugin-images" style="position: relative; margin: 0 5px 5px 0; float: left; width: 100px; height: 100px; background: url({$image.imageUploadFullPathURL}) center center no-repeat; background-size: cover;">
                    <span style="width: 100%; position: absolute; bottom: 0; left: 0; background: rgba(200,200,200,0.3)">
                        <a class="muimage-editor-plugin-image-slideshow" style="display: block; float: left; width: 10px; height: 10px; background: #ddd" href="{modurl modname='MUImage' type='external' func='setImage' id=$image.id kind='slideshow'}">&nbsp;</a>
                        <a class="muimage-editor-plugin-image-thumbnail" style="display: block; float: left; width: 10px; height: 10px; background: #eee" href="{modurl modname='MUImage' type='external' func='setImage' id=$image.id kind='thumbnail'}">&nbsp;</a>
                    </span>
                </span>
            {/foreach}
        {else}
        {gt text='No image found'}
        {/if}
    </div>  
