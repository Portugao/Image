{* purpose of this template: pictures view csv view *}
{muimageTemplateHeaders contentType='text/comma-separated-values; charset=iso-8859-15' asAttachment=true filename='Pictures.csv'}
{strip}"{gt text='Title'}";"{gt text='Description'}";"{gt text='Show title'}";"{gt text='Show description'}";"{gt text='Image upload'}";"{gt text='Image view'}";"{gt text='Album image'}";"{gt text='Pos'}";"{gt text='Workflow state'}"
;"{gt text='Album'}"
{/strip}
{foreach item='picture' from=$items}
{strip}
    "{$picture.title}";"{$picture.description}";"{if !$picture.showTitle}0{else}1{/if}";"{if !$picture.showDescription}0{else}1{/if}";"{$picture.imageUpload}";"{$picture.imageView}";"{if !$picture.albumImage}0{else}1{/if}";"{$picture.pos}";"{$item.workflowState|muimageObjectState:false|lower}"
    ;"{if isset($picture.Album) && $picture.Album ne null}{$picture.Album->getTitleFromDisplayPattern()|default:''}{/if}"
{/strip}
{/foreach}
