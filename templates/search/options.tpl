{* Purpose of this template: Display search options *}
<input type="hidden" id="mUImageActive" name="active[MUImage]" value="1" checked="checked" />
<div>
    <input type="checkbox" id="active_mUImageAlbums" name="mUImageSearchTypes[]" value="album"{if $active_album} checked="checked"{/if} />
    <label for="active_mUImageAlbums">{gt text='Albums' domain='module_muimage'}</label>
</div>
<div>
    <input type="checkbox" id="active_mUImagePictures" name="mUImageSearchTypes[]" value="picture"{if $active_picture} checked="checked"{/if} />
    <label for="active_mUImagePictures">{gt text='Pictures' domain='module_muimage'}</label>
</div>
