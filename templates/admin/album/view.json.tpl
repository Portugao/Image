{* purpose of this template: albums view json view in admin area *}
{muimageTemplateHeaders contentType='application/json'}
[
{foreach item='item' from=$items name='albums'}
    {if not $smarty.foreach.albums.first},{/if}
    {$item->toJson()}
{/foreach}
]
