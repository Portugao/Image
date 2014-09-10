{* Purpose of this template: Display pictures in text mailings *}
{foreach item='picture' from=$items}
{$picture->getTitleFromDisplayPattern()}
{modurl modname='MUImage' type='user' func='display' ot='picture'  id=$$objectType.id fqurl=true}
-----
{foreachelse}
{gt text='No pictures found.'}
{/foreach}
