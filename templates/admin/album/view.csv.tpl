{* purpose of this template: albums view csv view in admin area *}
{muimageTemplateHeaders contentType='text/comma-separated-values; charset=iso-8859-15' asAttachment=true filename='Albums.csv'}
{strip}"{gt text='Title'}";"{gt text='Description'}";"{gt text='Parent_id'}";"{gt text='Not in frontend'}";"{gt text='Pos'}";"{gt text='Album access'}";"{gt text='My friends'}";"{gt text='Password access'}";"{gt text='Workflow state'}"
;"{gt text='Parent'}"
;"{gt text='Picture'}";"{gt text='Children'}"
{/strip}
{foreach item='album' from=$items}
{strip}
    "{$album.title}";"{$album.description}";"{$album.parent_id}";"{if !$album.notInFrontend}0{else}1{/if}";"{$album.pos}";"{$album.albumAccess|muimageGetListEntry:'album':'albumAccess'|safetext}";"{$album.myFriends}";"";"{$item.workflowState|muimageObjectState:false|lower}"
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
