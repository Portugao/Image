{* Purpose of this template: Display pictures in text mailings *}
{foreach item='item' from=$items}
        {$item.title}
        {modurl modname='MUImage' type='user' func='display' ot=$objectType id=$item.id fqurl=true}
-----
{foreachelse}
    {gt text='No pictures found.'}
{/foreach}
