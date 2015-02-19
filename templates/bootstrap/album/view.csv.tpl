{* purpose of this template: albums view csv view *}
{muimageTemplateHeaders contentType='text/comma-separated-values; charset=iso-8859-15' asAttachment=true filename='Albums.csv'}
{strip}"{gt text='Title'}";"{gt text='Description'}";"{gt text='Parent_id'}";"{gt text='Album access'}";"{gt text='Password access'}";"{gt text='My friends'}";"{gt text='Not in frontend'}";"{gt text='Workflow state'}"
;"{gt text='Parent'}"
;"{gt text='Picture'}";"{gt text='Children'}"
{/strip}
{foreach item='album' from=$items}
{strip}
    "{$album.title}";"{$album.description}";"{$album.parent_id}";"{$album.albumAccess|muimageGetListEntry:'album':'albumAccess'|safetext}";"";"{$album.myFriends}";"{if !$album.notInFrontend}0{else}1{/if}";"{$item.workflowState|muimageObjectState:false|lower}"
    ;"{if isset($album.Parent) && $album.Parent ne null}{$album.Parent->getTitleFromDisplayPattern()|default:''}{/if}"
    ;"
        {if isset($album.Picture) && $album.Picture ne null}
            {foreach name='relationLoop' item='relatedItem' from=$album.Picture}
            {$relatedItem->getTitleFromDisplayPattern()|default:''}{if !$smarty.foreach.relationLoop.last}, {/if}
            {/foreach}
        {/if}
    ";"
        {if isset($album.Children) && $album.Children ne null}
            {foreach name='relationLoop' item='relatedItem' from=$album.Children}
            {$relatedItem->getTitleFromDisplayPattern()|default:''}{if !$smarty.foreach.relationLoop.last}, {/if}
            {/foreach}
        {/if}
    "
{/strip}
{/foreach}
