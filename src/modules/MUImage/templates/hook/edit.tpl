<fieldset>
    <legend>{gt text="Create MUImage Album"}</legend>
    <div class="muimage-hook z-formrow">
        <label for="muimage-albumyes">{gt text='Create Album and add the uploaded pictures?'}</label>
        <input type="checkbox" id="muimage-albumyes" name="muimage-albumyes" />
    </div>
        <div class="muimage-hook z-formrow">
        <label for="muimage-album">{gt text='Add pictures to main album:'}</label>
        <select id="muimage-album" name="muimage-album">
            <option value="">{gt text='Select a main album'}</option>
            {foreach item='album' from=$albums}
                <option value={$album.id}>{$album.title}</option>
            {/foreach}
        </select>
    </div>  
        <div class="muimage-hook z-formrow">
        <label for="muimage-subalbum">{gt text='Add pictures to sub album:'}</label>
        <select id="muimage-subalbum" name="muimage-subalbum">
            <option value="">{gt text='Select a sub album'}</option>
            {foreach item='subalbum' from=$subalbums}
                <option value={$subalbum.id}>{$subalbum.title}</option>
            {/foreach}
        </select>
    </div> 
</fieldset>
