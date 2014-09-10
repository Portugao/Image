{* purpose of this template: inclusion template for display of related album *}
{icon type='edit' size='extrasmall' assign='editImageArray'}
{assign var='editImage' value="<img src=\"`$editImageArray.src`\" width=\"16\" height=\"16\" alt=\"\" />"}
{icon type='delete' size='extrasmall' assign='removeImageArray'}
{assign var='removeImage' value="<img src=\"`$removeImageArray.src`\" width=\"16\" height=\"16\" alt=\"\" />"}

<input type="hidden" id="{$idPrefix}ItemList" name="{$idPrefix}ItemList" value="{if isset($item) && (is_array($item) || is_object($item)) && isset($item.id)}{$item.id}{/if}" />
<input type="hidden" id="{$idPrefix}Mode" name="{$idPrefix}Mode" value="1" />

<ul id="{$idPrefix}ReferenceList">
{if isset($item) && (is_array($item) || is_object($item)) && isset($item.id)}
{assign var='idPrefixItem' value="`$idPrefix`Reference_`$item.id`"}
<li id="{$idPrefixItem}">
    {$item->getTitleFromDisplayPattern()}
    <a id="{$idPrefixItem}Edit" href="{modurl modname='MUImage' type=$lct func='edit' ot='album'  id=$item.id forcelongurl=true}">{$editImage}</a>
     <a id="{$idPrefixItem}Remove" href="javascript:muimageRemoveRelatedItem('{$idPrefix}', '{$item.id}');">{$removeImage}</a>
</li>
{/if}
</ul>
