{* Purpose of this template: Display albums in text mailings *}
{foreach item='album' from=$items}
{$album->getTitleFromDisplayPattern()}
{modurl modname='MUImage' type='user' func='display' ot='album'  id=$$objectType.id fqurl=true}
-----
{foreachelse}
{gt text='No albums found.'}
{/foreach}
