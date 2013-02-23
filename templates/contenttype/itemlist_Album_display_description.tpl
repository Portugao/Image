{* Purpose of this template: Display albums within an external context *}

<dl>
{foreach item='item' from=$items}
    <dt>{$item.title}</dt>
{if $item.description}
    <dd>{$item.description|truncate:200:"..."}</dd>
{/if}
    <dd><a href="{modurl modname='MUImage' type='user' func='display' ot=$objectType id=$item.id}">{gt text='Read more'}</a></dd>
{foreachelse}
    <dt>{gt text='No entries found.'}</dt>
{/foreach}
</dl>
