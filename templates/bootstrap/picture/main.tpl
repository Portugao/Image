{* purpose of this template: pictures main view *}
{assign var='lct' value='user'}
{if isset($smarty.get.lct) && $smarty.get.lct eq 'admin'}
    {assign var='lct' value='admin'}
{/if}
{include file="`$lct`/header.tpl"}
<p>{gt text='Welcome to the picture section of the M u image application.'}</p>
{include file="`$lct`/footer.tpl"}
