<form id="getAlbums" action="index.php?module=MUImage&type=external&func=finderImages&editor=xinha">
    <div class="z-formrow">
        <label for="muimage-album">{gt text='Please select a main album:'}</label>
            {if count($albums) > 0}
                <select id="muimage-album" name="muimage-album">
                    <option value="">{gt text='Select a main album'}</option>
                    {foreach item='album' from=$albums}
                        <option value={$album.id}>{$album.title}</option>
                    {/foreach}
                </select>
            {else}
                {gt text='No albums found'}
            {/if}
    </div>  
    <div class="z-formrow">
        <label for="muimage-subalbum">{gt text='Please select a sub album:'}</label>
            {if count($subalbums) > 0}
                <select id="muimage-subalbum" name="muimage-subalbum">
                    <option value="">{gt text='Select a sub album'}</option>
                    {foreach item='subalbum' from=$subalbums}
                        <option value={$subalbum.id}>{$subalbum.title}</option>
                    {/foreach}
                </select>
            {else}
                {gt text='No subalbums found'}
            {/if}
    </div>
</form>