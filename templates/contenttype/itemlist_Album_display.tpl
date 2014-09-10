{* Purpose of this template: Display albums within an external context *}
{foreach item='album' from=$items}
    <h3>{$album->getTitleFromDisplayPattern()}</h3>
    <p><a href="{modurl modname='MUImage' type='user' ot='album' func='display'  id=$$objectType.id}">{gt text='Read more'}</a>
    </p>
{/foreach}
