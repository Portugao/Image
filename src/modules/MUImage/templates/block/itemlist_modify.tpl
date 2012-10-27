{* Purpose of this template: Edit block for generic item list *}

<div class="z-formrow">
    <label for="MUImage_objecttype">{gt text='Object type'}:</label>
    <select id="MUImage_objecttype" name="objecttype" size="1">
        <option value="album"{if $objectType eq 'album'} selected="selected"{/if}>{gt text='Albums'}</option>
        <option value="picture"{if $objectType eq 'picture'} selected="selected"{/if}>{gt text='Pictures'}</option>
    </select>
</div>

<div class="z-formrow">
    <label for="MUImage_sorting">{gt text='Sorting'}:</label>
    <select id="MUImage_sorting" name="sorting">
        <option value="random"{if $sorting eq 'random'} selected="selected"{/if}>{gt text='Random'}</option>
        <option value="newest"{if $sorting eq 'newest'} selected="selected"{/if}>{gt text='Newest'}</option>
        <option value="alpha"{if $sorting eq 'default' || ($sorting != 'random' && $sorting != 'newest')} selected="selected"{/if}>{gt text='Default'}</option>
    </select>
</div>

<div class="z-formrow">
    <label for="MUImage_amount">{gt text='Amount'}:</label>
    <input type="text" id="MUImage_amount" name="amount" size="10" value="{$amount|default:"5"}" />
</div>

<div class="z-formrow">
    <label for="MUImage_template">{gt text='Template File'}:</label>
    <select id="MUImage_template" name="template">
        <option value="itemlist_display.tpl"{if $template eq 'itemlist_display.tpl'} selected="selected"{/if}>{gt text='Only item titles'}</option>
        <option value="itemlist_display_description.tpl"{if $template eq 'itemlist_display_description.tpl'} selected="selected"{/if}>{gt text='With description'}</option>
        <option value="itemlist_Thumbs_display.tpl"{if $template eq 'itemlist_Thumbs_display.tpl'} selected="selected"{/if}>{gt text='Thumbnails'}</option>
 
    </select>
</div>

<div class="z-formrow">
    <label for="MUImage_filter">{gt text='Filter (expert option)'}:</label>
    <input type="text" id="MUImage_filter" name="filter" size="40" value="{$filterValue|default:""}" />
    <div class="z-formnote">({gt text='Syntax examples'}: <kbd>name:like:foobar</kbd> {gt text='or'} <kbd>status:ne:3</kbd>)</div>
</div>
