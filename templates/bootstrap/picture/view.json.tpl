{* purpose of this template: pictures view json view *}
{muimageTemplateHeaders contentType='application/json'}
[
{foreach item='item' from=$items name='pictures'}
    {if not $smarty.foreach.pictures.first},{/if}
    {$item->toJson()}
{/foreach}
]
