{* purpose of this template: albums xml inclusion template in admin area *}
<album id="{$item.id}" createdon="{$item.createdDate|dateformat}" updatedon="{$item.updatedDate|dateformat}">
    <id>{$item.id}</id>
    <title><![CDATA[{$item.title}]]></title>
    <description><![CDATA[{$item.description}]]></description>
    <parent_id>{$item.parent_id}</parent_id>
    <notInFrontend>{if !$item.notInFrontend}0{else}1{/if}</notInFrontend>
    <pos>{$item.pos}</pos>
    <albumAccess>{$item.albumAccess|muimageGetListEntry:'album':'albumAccess'|safetext}</albumAccess>
    <myFriends>{$item.myFriends}</myFriends>
    <passwordAccess><![CDATA[]]></passwordAccess>
    <workflowState>{$item.workflowState|muimageObjectState:false|lower}</workflowState>
    <parent>{if isset($item.Parent) && $item.Parent ne null}{$item.Parent->getTitleFromDisplayPattern()|default:''}{/if}</parent>
    <picture>
    {if isset($item.Picture) && $item.Picture ne null}
        {foreach name='relationLoop' item='relatedItem' from=$item.Picture}
        <picture>{$relatedItem->getTitleFromDisplayPattern()|default:''}</picture>
        {/foreach}
    {/if}
    </picture>
    <children>
    {if isset($item.Children) && $item.Children ne null}
        {foreach name='relationLoop' item='relatedItem' from=$item.Children}
        <album>{$relatedItem->getTitleFromDisplayPattern()|default:''}</album>
        {/foreach}
    {/if}
    </children>
</album>
