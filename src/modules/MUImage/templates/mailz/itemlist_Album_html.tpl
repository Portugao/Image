{* Purpose of this template: Display albums in html mailings *}
{*
<ul>
{foreach item='item' from=$items}
    <li>
        <a href="{modurl modname='MUImage' type='user' func='display' ot=$objectType id=$item.id fqurl=true}
">{$item.title}
</a>
    </li>
{foreachelse}
    <li>{gt text='No albums found.'}</li>
{/foreach}
</ul>
*}

{include file='contenttype/itemlist_Album_display_description.tpl'}
