{* Purpose of this template: Display albums in text mailings *}
{foreach item='item' from=$items}
        {$item.title}
        {modurl modname='MUImage' type='user' func='display' ot=$objectType id=$item.id fqurl=true}
-----
{foreachelse}
    {gt text='No albums found.'}
{/foreach}
