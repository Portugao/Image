{* Purpose of this template: Display item information for previewing from other modules *}
<dl id="album{$album.id}">
<dt>{$album->getTitleFromDisplayPattern()|notifyfilters:'muimage.filter_hooks.albums.filter'|htmlentities}</dt>
{if $album.description ne ''}<dd>{$album.description}</dd>{/if}
<dd>{assignedcategorieslist categories=$album.categories doctrine2=true}</dd>
</dl>
