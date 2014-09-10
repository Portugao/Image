{* Purpose of this template: Display pictures within an external context *}
<dl>
    {foreach item='picture' from=$items}
        <dt>{$picture->getTitleFromDisplayPattern()}</dt>
        {if $picture.description}
            <dd>{$picture.description|strip_tags|truncate:200:'&hellip;'}</dd>
        {/if}
        <dd><a href="{modurl modname='MUImage' type='user' ot='picture' func='display'  id=$$objectType.id}">{gt text='Read more'}</a>
        </dd>
    {foreachelse}
        <dt>{gt text='No entries found.'}</dt>
    {/foreach}
</dl>
