{* Purpose of this template: Display albums in html mailings *}
{*
<ul>
{foreach item='album' from=$items}
    <li>
        <a href="{modurl modname='MUImage' type='user' func='display' ot='album'  id=$$objectType.id fqurl=true}
        ">{$album->getTitleFromDisplayPattern()}
        </a>
    </li>
{foreachelse}
    <li>{gt text='No albums found.'}</li>
{/foreach}
</ul>
*}

{include file='contenttype/itemlist_album_display_description.tpl'}
