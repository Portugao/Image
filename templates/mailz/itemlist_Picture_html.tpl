{* Purpose of this template: Display pictures in html mailings *}
{*
<ul>
{foreach item='picture' from=$items}
    <li>
        <a href="{modurl modname='MUImage' type='user' func='display' ot='picture'  id=$$objectType.id fqurl=true}
        ">{$picture->getTitleFromDisplayPattern()}
        </a>
    </li>
{foreachelse}
    <li>{gt text='No pictures found.'}</li>
{/foreach}
</ul>
*}

{include file='contenttype/itemlist_picture_display_description.tpl'}
