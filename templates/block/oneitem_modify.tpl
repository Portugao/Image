{* Purpose of this template: Edit block for generic item list *}

<div class="z-formrow">
    <label for="MUImage_objecttype">{gt text='Object type'}:</label>
    <select id="MUImage_objecttype" name="objecttype" size="1">
        <option value="picture"{if $objectType eq 'picture'} selected="selected"{/if}>{gt text='Pictures'}</option>
    </select>
</div>

<div class="z-formrow">
    <label for="MUImage_id">{gt text='Id'}:</label>
    <select id="MUImage_id" name="id">
        {$pictureids}
    </select>
</div>

<div class="z-formrow">
    <label for="MUImage_width">{gt text='Width'}:</label>
    <input type="text" id="MUImage_width" name="width" size="10" value="{$width}" />
</div>

<div class="z-formrow">
    <label for="MUImage_height">{gt text='Height'}:</label>
    <input type="text" id="MUImage_height" name="height" size="10" value="{$height}" />
</div>

<div class="z-formrow">
    <label for="MUImage_showtitle">{gt text='Diplay default block title?'}:</label>
    <input type="checkbox" id="MUImage_showtitle" name="showtitle" value="1"{if $showtitle eq 1} checked="checked"{/if} />
</div>

<div class="z-formrow">
    <label for="MUImage_template">{gt text='Template File'}:</label>
    <select id="MUImage_template" name="template">
        <option value="oneitem_displaycontent.tpl"{if $template eq 'oneitem_displaycontent.tpl'} selected="selected"{/if}>{gt text='Only the picture'}</option>
        <option value="oneitem_display.tpl"{if $template eq 'oneitem_display.tpl'} selected="selected"{/if}>{gt text='Only item titles'}</option>
        <option value="oneitem_display_description.tpl"{if $template eq 'oneitem_display_description.tpl'} selected="selected"{/if}>{gt text='With description'}</option>
    </select>
</div>


