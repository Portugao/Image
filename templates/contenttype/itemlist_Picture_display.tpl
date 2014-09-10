{* Purpose of this template: Display pictures within an external context *}
{foreach item='picture' from=$items}
    <h3>{$picture->getTitleFromDisplayPattern()}</h3>
    <p><a href="{modurl modname='MUImage' type='user' ot='picture' func='display'  id=$$objectType.id}">{gt text='Read more'}</a>
    </p>
{/foreach}
